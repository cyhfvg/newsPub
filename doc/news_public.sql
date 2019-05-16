/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 100119
Source Host           : localhost:3306
Source Database       : news_public

Target Server Type    : MYSQL
Target Server Version : 100119
File Encoding         : 65001

Date: 2019-05-16 20:34:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tb_news
-- ----------------------------
DROP TABLE IF EXISTS `tb_news`;
CREATE TABLE `tb_news` (
  `news_id` int(3) NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL,
  `body` text NOT NULL,
  `pub_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_n_rev
-- ----------------------------
DROP TABLE IF EXISTS `tb_n_rev`;
CREATE TABLE `tb_n_rev` (
  `news_id` int(3) NOT NULL,
  `review_id` int(4) NOT NULL,
  PRIMARY KEY (`news_id`,`review_id`),
  KEY `tb_n_rev_news_review_id` (`review_id`),
  CONSTRAINT `tb_n_rev_news_id` FOREIGN KEY (`news_id`) REFERENCES `tb_news` (`news_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_n_rev_news_review_id` FOREIGN KEY (`review_id`) REFERENCES `tb_review` (`review_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_review
-- ----------------------------
DROP TABLE IF EXISTS `tb_review`;
CREATE TABLE `tb_review` (
  `review_id` int(4) NOT NULL AUTO_INCREMENT,
  `review_body` varchar(255) NOT NULL,
  `review_pub_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`review_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_role
-- ----------------------------
DROP TABLE IF EXISTS `tb_role`;
CREATE TABLE `tb_role` (
  `role_id` int(1) NOT NULL,
  `role_type` varchar(10) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_user
-- ----------------------------
DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE `tb_user` (
  `user_name` varchar(10) NOT NULL,
  `password` varchar(16) NOT NULL,
  `sex` varchar(2) NOT NULL,
  `age` int(3) NOT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `job` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_u_n
-- ----------------------------
DROP TABLE IF EXISTS `tb_u_n`;
CREATE TABLE `tb_u_n` (
  `user_name` varchar(10) NOT NULL,
  `news_id` int(3) NOT NULL,
  PRIMARY KEY (`user_name`,`news_id`),
  KEY `u_n_newsid` (`news_id`),
  CONSTRAINT `u_n_name` FOREIGN KEY (`user_name`) REFERENCES `tb_user` (`user_name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `u_n_newsid` FOREIGN KEY (`news_id`) REFERENCES `tb_news` (`news_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_u_r
-- ----------------------------
DROP TABLE IF EXISTS `tb_u_r`;
CREATE TABLE `tb_u_r` (
  `user_name` varchar(10) NOT NULL,
  `role_id` int(1) NOT NULL,
  PRIMARY KEY (`user_name`,`role_id`),
  KEY `u_r_f_id` (`role_id`),
  CONSTRAINT `u_r_f_id` FOREIGN KEY (`role_id`) REFERENCES `tb_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `u_r_f_name` FOREIGN KEY (`user_name`) REFERENCES `tb_user` (`user_name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
DROP TRIGGER IF EXISTS `simple_user`;
DELIMITER ;;
CREATE TRIGGER `simple_user` AFTER INSERT ON `tb_user` FOR EACH ROW insert into tb_u_r(user_name, role_id) values(new.user_name, 1)
;;
DELIMITER ;
