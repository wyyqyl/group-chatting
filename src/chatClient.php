<?php
include_once('database.php');
session_start();
if(!isset($_SESSION['id'])){
	header("Location:login.php");
}
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>G1T6 SECA</title>
<link type="text/css"
	href="css/custom-theme/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<link type="text/css" href="css/style.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="js/aes.js"></script>
<!-- RSA signature -->
<script type="text/javascript" src="js/jsbn.js"></script>
<script type="text/javascript" src="js/jsbn2.js"></script>
<script type="text/javascript" src="js/prng4.js"></script>
<script type="text/javascript" src="js/rng.js"></script>
<script type="text/javascript" src="js/rsa.js"></script>
<script type="text/javascript" src="js/rsa2.js"></script>
<script type="text/javascript" src="js/sha1.js"></script>
<script type="text/javascript" src="js/rsa-pem.js"></script>
<script type="text/javascript" src="js/rsa-sign.js"></script>
<script type="text/javascript" src="js/base64.js"></script>
<script type="text/javascript" src="js/asn1hex.js"></script>
<script type="text/javascript" src="js/x509.js"></script>
<script type="text/javascript">

var pubkey = "";
var prikey = "";
function handleFileSelect(files, key) {
	var file = files[0]; // FileList object

	var reader = new FileReader();

    // Closure to capture the file information.
    reader.onload = (function(theFile) {
        return function(e) {
            if(key == "prikey"){
                prikey = e.target.result;
            }else if(key == "pubkey"){
            	pubkey = e.target.result;
            }
            if(prikey != "" && pubkey != ""){
        		document.getElementById("curtain").style.display = "none";
        	}
        };
    })(file);
	
    // Read in the file as a data URL.
    reader.readAsText(file);
}

function dosign(msg, prikey){
	var rsa = new RSAKey();
	rsa.readPrivateKeyFromPEMString(prikey);
	return rsa.signString(msg, "sha1");
}

function doverify(msg, pubkey, signature){
	var x509 = new X509();
	x509.readCertPEM(pubkey);
	return x509.subjectPublicKeyRSA.verifyString(msg, signature);
}

$(function(){
  $("a").click(function(){
    window.onbeforeunload = null;
  });
});


window.onbeforeunload = confirmExit;
function confirmExit(){
	return "";
}

var key = null;
$(function(){			
	// Chat List
	$("#chatList").accordion({ 
		'header': "h3",
		'fillSpace': true,
		'autoHeight': true,
		'clearStyle': true
	});			
	// Chat Log
	$('#chatLog').tabs();
	// Chat Box
	$('#chatBox').tabs();
	// Initialize AES encryption and decryption
	var userKey = "<?php echo $_SESSION['key']; ?>";
	key = new Array(32);
	for (var i = 0; i < 32; ++i){
		key[i] = userKey.substr(2 * i, 2);
	}
	
	AES_Init();
	AES_ExpandKey(key);
});

$(document).ready(function(){
	timestamp = 0;
	updateMsg();
	updateOnlineUsers();
	$("form#chatform").submit(function(){
		if(pubkey == "" || prikey == ""){
			alert("Please choose your RSA key pairs!!!");
			return false;
		}
		
		var msg = $("#msg").val();
		var signature = dosign(msg, prikey);

		var mlen = msg.length;
		var slen = signature.length;
		var plen = pubkey.length;
		
		var block = new Array(mlen + slen + plen + 2);
		for (var i = 0; i < mlen; ++i){
			block[i] = msg.charCodeAt(i);
		}
		block[i] = 1;
		for (var i = 0; i < slen; ++i){
			block[mlen + i + 1] = signature.charCodeAt(i);
		}
		block[mlen + i + 1] = 1;
		for (var i = 0; i < plen; ++i){
			block[mlen + slen + i + 2] = pubkey.charCodeAt(i);
		}
		AES_Encrypt(block, key);
		msg = dec2hex(block);
		$.post("backend.php",{
					msg: msg,
					action: "postMsg",
					time: timestamp
				}, function(xml) {
					document.getElementById("msg").value="";
					addMessages(xml);
				});
		return false;
	});
	$("#chatList").accordion("resize");
	$("#chatList").accordion("activate", 1);
	setTimeout("$('#chatList').accordion('activate', 0)",1000);
	$("#chatList").accordion("activate", 0);
});


function updateOnlineUsers() {
	$.post("backend.php",{ action: "updateOnlineUsers" }, function(users) {
		document.getElementById("onlineUsers").innerHTML = users;
	});
	$("#chatList").accordion("resize");
	setTimeout('updateOnlineUsers()', 10000);
}

function updateMsg() {
	$.post("backend.php",{ action: "updateMsg", time: timestamp }, function(xml) {
		addMessages(xml);
	});
	setTimeout('updateMsg()', 4000);
}

function addMessages(xml) {
	 
	 if($("status",xml).text() == "2")
		 return;
	 
	 timestamp = $("time",xml).text();
	 
	 $("message",xml).each(function(id) {
		 message = $("message",xml).get(id);
		 text = hex2dec($("text",message).text());
		 AES_Decrypt(text, key);

		 var msg = "";
		 var signature = "";
		 var pubkey = "";
		 for(var i = 0; i < text.length && text[i] != 1; ++i){
			 msg += String.fromCharCode(text[i]);
		 }
		 
		 for(var j = i + 1; j < text.length && text[j] != 1; ++j){
			 signature += String.fromCharCode(text[j]);
		 }
		 //signature += "12";
		 for(var k = j + 1; k < text.length && text[k] != 1; ++k){
			 pubkey += String.fromCharCode(text[k]);
		 }
		 
		 var result = doverify(msg, pubkey, signature);
		 if(result){
			 $("#chatLog_Content").append("<b>"+ $("name",message).text()+
						"</b>: "+ msg +"<br />");
		 }else{
			 $("#chatLog_Content").append("<i>(Wrong Signature) </i><b>"+ $("name",message).text()+
						"</b>: "+ msg +"<br />");
		 }

		 document.getElementById("chatLog").scrollTop = document.getElementById("chatLog").scrollHeight;
		 var myDiv = $("#chatLog");
	 });
}

function logout(){
window.location = "logout.php";
}


</script>
</head>
<body>
	<div id="curtain" style="width:100%;height:100%;z-index:9999;position:absolute;top:0px;left:0px;background-color:black;opacity:0.8;filter:alpha(opacity=80);">
		<div style="width:500px;height:800px;position:absolute;top:50%;left:50%;margin-top:-150px;margin-left:-150px;">
			<b>Please upload your given set of keys below:</b><br/>
			<div class="ui-state-default ui-corner-all" style="width:200px;height:60px;padding:0; margin:0;cursor:pointer;">
				<b>Private Key:</b> <input type="file" id="prikey" name="prikey" />
			</div><br/>
			<div class="ui-state-default ui-corner-all" style="width:200px;height:60px;padding:0; margin:0;cursor:pointer;">
				<b>Public Key: </b> <input type="file" id="pubkey" name="pubkey" />
			</div>			
		</div>
			<div class="ui-state-default ui-corner-all" style="width:70px;height:15px;padding:0; margin:0;position:absolute;top:7px;right:7px;cursor:pointer;" onclick="logout();">
				<center><b>Logout</b></center>
			</div>		
	</div>
	<div id="header">
		<span>SECA - <?php echo $username ?>
		</span>
	</div>
	<div id="bodyContainer">
		<!-- Chat List -->
		<div id="chatList"
			style="width: 20%; height: 500px; position: absolute; top: 0px; left: 0px;">
			<div>
				<h3>
					<a href="#">Marketing Meeting</a>
				</h3>
				<span style="padding: 0px; margin: 0px; height: 400px;">
					<ul id="onlineUsers">
						<li>
						No online users
						</li>
					</ul>
				</span>
			</div>
			<div>
				<h3>
					<a href="#">Minimize</a>
				</h3>
			</div>
		</div>
		<!-- Chat Log -->
		<div id="chatLog"
			style="width: 78%; height: 400px; position: absolute; top: 0px; left: 21%; overflow: auto; white-space: nowrap;">
			<div class="ui-state-default ui-corner-all" style="width:70px;height:15px;padding:0; margin:0;position:absolute;top:7px;right:7px;cursor:pointer;" onclick="logout();">
				<center><b>Logout</b></center>
			</div>
				
			<ul>
				<li><a href="#tabs-1">Chat Log</a>
				</li>
			</ul>
			<div id="tabs-1">
				<span id="chatLog_Content"
					style="display: inline-block; white-space: normal;"></span>
			</div>
		</div>

		<!-- Chat Box -->
		<div id="chatBox"
			style="width: 78%; height: 95px; position: absolute; top: 410px; left: 21%;">
			<ul>
				<li><a href="#tabs-1">Chat Box</a>
				</li>
			</ul>
			<div id="tabs-1">
				<form id="chatform">
					<input type="text" id="msg" style="width: 90%; height: 20px"/>
					<input type="submit" value="OK" />
				</form>
			</div>

		</div>
	</div>
	<script type="text/javascript">
		document.getElementById('prikey').addEventListener('change', function(){handleFileSelect(this.files, "prikey");}, false);
		document.getElementById('pubkey').addEventListener('change', function(){handleFileSelect(this.files, "pubkey");}, false);
	</script>
</body>
</html>