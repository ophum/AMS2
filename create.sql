CREATE DATABASE AMS2;
USE AMS2;

CREATE TABLE `users` (
  `num` int(11) NOT NULL AUTO_INCREMENT,
  `id` varchar(32) NOT NULL,
  `password` varchar(128) NOT NULL,
  PRIMARY KEY (`num`)
);

CREATE TABLE `ips` (
  `num` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(32) NOT NULL,
  `cnt` int(11) DEFAULT NULL,
  PRIMARY KEY (`num`)
);
