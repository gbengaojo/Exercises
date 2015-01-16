-- SQL Tasks

-- 1
CREATE DATABASE petshop;
USE petshop;
CREATE TABLE pet (id INT PRIMARY KEY NOT NULL AUTO_INCREMENT, name VARCHAR(200) NOT NULL);
-- statement from examining table:
CREATE TABLE `pet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1

-- 2
INSERT INTO `pet` VALUES ('Garfield');
INSERT INTO `pet` VALUES ('Rufus');
INSERT INTO `pet` VALUES ('Sarah');
-- or --
INSERT INTO pet(name) VALUES ('Garfield'), ('Rufus'), ('Sarah');
