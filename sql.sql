CREATE DATABASE group_chatting;

USE group_chatting;

CREATE TABLE IF NOT EXISTS `membersinfo` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `username` varchar(65) NOT NULL DEFAULT '',
  `password` varchar(65) NOT NULL DEFAULT '',
  `role`	varchar(65)	NOT NULL	DEFAULT '',
  PRIMARY KEY (`id`)
);

INSERT INTO membersinfo (username, password, role) VALUES ('Steven Miller', 'q1w2e3r4', 'CEO');
INSERT INTO membersinfo (username, password, role) VALUES ('Ding Xuhua', 'a5s6d7f8', 'Marketing Manager');
INSERT INTO membersinfo (username, password, role) VALUES ('Li Yingjiu', 'z9x1c2v3', 'Marketing Manager');


CREATE TABLE IF NOT EXISTS `onlineusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `uid` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS `chatlog` (
`mid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`sid` VARCHAR( 65 ) NOT NULL ,
`message` VARCHAR( 100 ) NOT NULL ,
`time` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL
);