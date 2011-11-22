/*CREATE DATABASE group_chatting;*/
USE group_chatting;

DROP TABLE IF EXISTS `membersinfo`;
CREATE TABLE `membersinfo`(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(65)  UNIQUE NOT NULL DEFAULT '',
  `password` char(128) NOT NULL DEFAULT '',
  `salt` char(128) NOT NULL DEFAULT '',
  `role` varchar(65) NOT NULL DEFAULT '',
  `login` char(1) NOT NULL DEFAULT '0',
  `time` timestamp ON UPDATE CURRENT_TIMESTAMP,
  `allow` char(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `chatlog`;
CREATE TABLE `chatlog` (
`mid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`sid` VARCHAR(65) NOT NULL ,
`message` longtext NOT NULL ,
`time` int(11) NOT NULL
);
