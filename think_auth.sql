/*
Navicat MySQL Data Transfer

Source Server         : 昌维
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : think_auth

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-04-24 21:47:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for think_auth_perm
-- ----------------------------
DROP TABLE IF EXISTS `think_auth_perm`;
CREATE TABLE `think_auth_perm` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `perm_name` varchar(255) NOT NULL COMMENT '权限名字',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `module` varchar(255) NOT NULL COMMENT '模块',
  `controller` varchar(255) NOT NULL COMMENT '控制器',
  `action` varchar(255) NOT NULL COMMENT '操作',
  `parameter` varchar(255) NOT NULL COMMENT '参数',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限表';

-- ----------------------------
-- Table structure for think_auth_role
-- ----------------------------
DROP TABLE IF EXISTS `think_auth_role`;
CREATE TABLE `think_auth_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL COMMENT '角色名字',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `create_time` datetime NOT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Table structure for think_auth_role_perm
-- ----------------------------
DROP TABLE IF EXISTS `think_auth_role_perm`;
CREATE TABLE `think_auth_role_perm` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `perm_id` int(10) unsigned NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限关联表';

-- ----------------------------
-- Table structure for think_auth_user
-- ----------------------------
DROP TABLE IF EXISTS `think_auth_user`;
CREATE TABLE `think_auth_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Table structure for think_auth_user_role
-- ----------------------------
DROP TABLE IF EXISTS `think_auth_user_role`;
CREATE TABLE `think_auth_user_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户角色关系表';
