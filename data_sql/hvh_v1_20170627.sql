/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : hvh_v1

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-06-27 15:39:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for city
-- ----------------------------
DROP TABLE IF EXISTS `city`;
CREATE TABLE `city` (
  `ID` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of city
-- ----------------------------

-- ----------------------------
-- Table structure for doctor
-- ----------------------------
DROP TABLE IF EXISTS `doctor`;
CREATE TABLE `doctor` (
  `ID` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `MobileNum` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `Gender` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'X',
  `BirthDate` date DEFAULT NULL,
  `RegTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `HospitalID` char(36) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`) USING BTREE,
  UNIQUE KEY `MobileNum` (`MobileNum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of doctor
-- ----------------------------

-- ----------------------------
-- Table structure for easemob_audio
-- ----------------------------
DROP TABLE IF EXISTS `easemob_audio`;
CREATE TABLE `easemob_audio` (
  `ID` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT '文件的hash(md5 | sha1)码',
  `Ext` varchar(4) COLLATE utf8_unicode_ci NOT NULL COMMENT '扩展名',
  `ReferenceCount` int(10) NOT NULL COMMENT '引用计数',
  `CreateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CreatedBy` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of easemob_audio
-- ----------------------------

-- ----------------------------
-- Table structure for easemob_chat_record
-- ----------------------------
DROP TABLE IF EXISTS `easemob_chat_record`;
CREATE TABLE `easemob_chat_record` (
  `msg_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  `direction` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `to` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `from` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `chat_type` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `payload_ext` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `payload_from` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `payload_to` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `bodies_type` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `bodies_txt_msg` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `bodies_file_length` int(11) NOT NULL,
  `bodies_filename` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `bodies_secret` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `bodies_size_height` int(11) NOT NULL,
  `bodies_size_width` int(11) NOT NULL,
  `bodies_url` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `bodies_loc_addr` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `bodies_loc_lat` double NOT NULL,
  `bodies_loc_lng` double NOT NULL,
  `bodies_av_length` int(11) NOT NULL,
  `bodies_video_thumb` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `bodies_video_thumb_secret` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `file_hashcode` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`msg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of easemob_chat_record
-- ----------------------------
INSERT INTO `easemob_chat_record` VALUES ('3378208092', '1496219836476', 'outgoing', 'hj002', 'hj001', 'chat', '', 'hj001', 'hj002', 'img', '', '1239545', 'IMG_20170531_162006.jpg', 'WcAOmkXcEeezCpuYDqKwh6V7V4wwvZOGTLsBk9a6o2OJj2P_', '3264', '2448', 'https://a1.easemob.com/1122170524178152/mktest/chatfiles/59c00e90-45dc-11e7-bb7f-37a9707a7445', '', '0', '0', '0', '', '', null, '1');
INSERT INTO `easemob_chat_record` VALUES ('3378208295', '1496219841188', 'outgoing', 'hj002', 'hj001', 'chat', '', 'hj001', 'hj002', 'txt', '哈哈', '0', '', '', '0', '0', '', '', '0', '0', '0', '', '', null, '1');
INSERT INTO `easemob_chat_record` VALUES ('3378210037', '1496219881753', 'outgoing', 'hj002', 'hj001', 'chat', '', 'hj001', 'hj002', 'txt', '和哈哈哈哈', '0', '', '', '0', '0', '', '', '0', '0', '0', '', '', null, '1');
INSERT INTO `easemob_chat_record` VALUES ('3378210551', '1496219893720', 'outgoing', 'hj002', 'hj001', 'chat', '', 'hj001', 'hj002', 'img', '', '1239545', 'IMG_20170531_162006.jpg', 'e-B6CkXcEeebqYW7YRhMTaTVx2d8zPGsj_Epfh55R59y0L42', '3264', '2448', 'https://a1.easemob.com/1122170524178152/mktest/chatfiles/7be07a00-45dc-11e7-88e8-e59ff86da9fa', '', '0', '0', '0', '', '', null, '1');
INSERT INTO `easemob_chat_record` VALUES ('3378260585', '1496221058673', 'outgoing', 'hj002', 'admin@easemob.com', 'chat', '', 'admin', 'hj002', 'txt', 'test', '0', '', '', '0', '0', '', '', '0', '0', '0', '', '', null, '1');
INSERT INTO `easemob_chat_record` VALUES ('3382035550', '1496308951424', 'outgoing', 'jt001', 'admin@easemob.com', 'chat', '', 'admin', 'jt001', 'img', '', '0', 'C:fakepathSC001.png', '01NnqkarEeezALmF21-WQNpOpMm6eSYMMRUMC5LTKqMoYQs4', '0', '0', 'https://a1.easemob.com/1122170524178152/mktest/chatfiles/d35367a0-46ab-11e7-b580-510658551ab5', '', '0', '0', '0', '', '', null, '1');
INSERT INTO `easemob_chat_record` VALUES ('3385761790', '1496395709717', 'outgoing', 'jt001', 'admin@easemob.com', 'chat', '', 'admin', 'jt001', 'txt', 'ニュース速報や芸能ゴシップ、ネットで話題のおもしろ情報をいち早くお届け！', '0', '', '', '0', '0', '', '', '0', '0', '0', '', '', null, '1');
INSERT INTO `easemob_chat_record` VALUES ('3385764231', '1496395766552', 'outgoing', 'jt001', 'admin@easemob.com', 'chat', '', 'admin', 'jt001', 'img', '', '0', 'C:fakepath641.jpg', '939Lukd1Eee1F8l--Kq22_QMhmhF-t0RjFAbnDuz0IDE2_Qq', '0', '0', 'https://a1.easemob.com/1122170524178152/mktest/chatfiles/f77f4bb0-4775-11e7-a1ba-95cac8a6d1fd', '', '0', '0', '0', '', '', null, '1');
INSERT INTO `easemob_chat_record` VALUES ('3395664516', '1496626275512', 'outgoing', 'hj002', 'hj001', 'chat', '', 'hj001', 'hj002', 'img', '', '1239545', 'IMG_20170531_162006.jpg', 'qkEBKkmOEeeEK00qjDaFSErEO5_SBj4XYH4GyrnoIN6iF5Ic', '3264', '2448', 'https://a1.easemob.com/1122170524178152/mktest/chatfiles/aa410120-498e-11e7-9dff-99844b2cd144', '', '0', '0', '0', '', '', null, '1');
INSERT INTO `easemob_chat_record` VALUES ('3395670606', '1496626417312', 'outgoing', 'hj002', 'hj001', 'chat', '', 'hj001', 'hj002', 'img', '', '1239545', 'IMG_20170531_162006.jpg', '_s-UmkmOEeeb8ONT0ic5Dxlci2ePWskOhsr4_S2PPbjXBt9N', '3264', '2448', 'https://a1.easemob.com/1122170524178152/mktest/chatfiles/fecf9490-498e-11e7-839c-7505987837b1', '', '0', '0', '0', '', '', null, '1');
INSERT INTO `easemob_chat_record` VALUES ('3395672973', '1496626472425', 'outgoing', 'hj002', 'hj001', 'chat', '', 'hj001', 'hj002', 'img', '', '1239545', 'IMG_20170531_162006.jpg', 'H69pukmPEeeQGHUgtDH5H_YgWFcIzQ2LdHU1VDY7ZypP16lw', '3264', '2448', 'https://a1.easemob.com/1122170524178152/mktest/chatfiles/1faf69b0-498f-11e7-9760-536b4bba6e5d', '', '0', '0', '0', '', '', null, '1');
INSERT INTO `easemob_chat_record` VALUES ('3395697544', '1496627044513', 'outgoing', 'hj002', 'hj001', 'chat', '', 'hj001', 'hj002', 'audio', '', '2150', '4898cf34-32b5-4e30-899e-cf639ac2d6e0.amr', 'dPuyakmQEeebn8MLOY57rioVoAvHDF0NSGKj-o_cV9SowDkC', '0', '0', 'https://a1.easemob.com/1122170524178152/mktest/chatfiles/74fbb260-4990-11e7-95ed-1963002f4c0e', '', '0', '0', '1', '', '', null, '1');
INSERT INTO `easemob_chat_record` VALUES ('3395734873', '1496627913652', 'outgoing', 'hj002', 'hj001', 'chat', '', 'hj001', 'hj002', 'img', '', '1239545', 'IMG_20170531_162006.jpg', 'erCA2kmSEeeUEtUdSC_fNQb6VbYLDdxz--Z0P9_9dWltfERg', '3264', '2448', 'https://a1.easemob.com/1122170524178152/mktest/chatfiles/7ab080d0-4992-11e7-9694-174fc0a21cbb', '', '0', '0', '0', '', '', null, '1');
INSERT INTO `easemob_chat_record` VALUES ('339686527149810808', '1496654232776', 'outgoing', 'jt001', 'admin@easemob.com', 'chat', '', 'admin', 'jt001', 'txt', '明天测试', '0', '', '', '0', '0', '', '', '0', '0', '0', '', '', null, '1');
INSERT INTO `easemob_chat_record` VALUES ('339686583617721436', '1496654245926', 'outgoing', 'jt001', 'admin@easemob.com', 'chat', '', 'admin', 'jt001', 'img', '', '0', 'C:fakepath641.jpg', 'yKyRaknPEee7ShuABlpdho7-UEHo5vPMVM4SCaRmXmlSzl9V', '0', '0', 'https://a1.easemob.com/1122170524178152/mktest/chatfiles/c8ac9160-49cf-11e7-b967-93eeee8085bc', '', '0', '0', '0', '', '', '6e54d15d6739020716b23b348ff66a76', '1');
INSERT INTO `easemob_chat_record` VALUES ('343648103103992960', '1497576609038', 'outgoing', 'jt001', 'admin@easemob.com', 'chat', '', 'admin', 'jt001', 'txt', 'Let Me Hear', '0', '', '', '0', '0', '', '', '0', '0', '0', '', '', null, '1');
INSERT INTO `easemob_chat_record` VALUES ('343648103150130304', '1497576609049', 'outgoing', 'jt003', 'admin@easemob.com', 'chat', '', 'admin', 'jt003', 'txt', 'Let Me Hear', '0', '', '', '0', '0', '', '', '0', '0', '0', '', '', null, '1');
INSERT INTO `easemob_chat_record` VALUES ('343648103187879040', '1497576609058', 'outgoing', 'jt002', 'admin@easemob.com', 'chat', '', 'admin', 'jt002', 'txt', 'Let Me Hear', '0', '', '', '0', '0', '', '', '0', '0', '0', '', '', null, '1');
INSERT INTO `easemob_chat_record` VALUES ('343648207655408732', '1497576633389', 'outgoing', 'jt001', 'admin@easemob.com', 'chat', '', 'admin', 'jt001', 'img', '', '0', 'C:fakepath641.jpg', 'YrDnqlIzEeefVNkSijhMznWBrInNCuSgMY55HBsWit5UGozL', '0', '0', 'https://a1.easemob.com/1129170523178885/testapp20170523/chatfiles/62b0e7a0-5233-11e7-8569-a77a154aae0a', '', '0', '0', '0', '', '', '6e54d15d6739020716b23b348ff66a76', '1');
INSERT INTO `easemob_chat_record` VALUES ('343648207760262236', '1497576633413', 'outgoing', 'jt003', 'admin@easemob.com', 'chat', '', 'admin', 'jt003', 'img', '', '0', 'C:fakepath641.jpg', 'YrDnqlIzEeefVNkSijhMznWBrInNCuSgMY55HBsWit5UGozL', '0', '0', 'https://a1.easemob.com/1129170523178885/testapp20170523/chatfiles/62b0e7a0-5233-11e7-8569-a77a154aae0a', '', '0', '0', '0', '', '', '6e54d15d6739020716b23b348ff66a76', '1');
INSERT INTO `easemob_chat_record` VALUES ('343648207802205276', '1497576633423', 'outgoing', 'jt002', 'admin@easemob.com', 'chat', '', 'admin', 'jt002', 'img', '', '0', 'C:fakepath641.jpg', 'YrDnqlIzEeefVNkSijhMznWBrInNCuSgMY55HBsWit5UGozL', '0', '0', 'https://a1.easemob.com/1129170523178885/testapp20170523/chatfiles/62b0e7a0-5233-11e7-8569-a77a154aae0a', '', '0', '0', '0', '', '', '6e54d15d6739020716b23b348ff66a76', '1');

-- ----------------------------
-- Table structure for easemob_image
-- ----------------------------
DROP TABLE IF EXISTS `easemob_image`;
CREATE TABLE `easemob_image` (
  `ID` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT '文件的hash(md5 | sha1)码',
  `Ext` varchar(4) COLLATE utf8_unicode_ci NOT NULL COMMENT '扩展名',
  `ReferenceCount` int(10) NOT NULL COMMENT '引用计数',
  `CreateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CreatedBy` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of easemob_image
-- ----------------------------
INSERT INTO `easemob_image` VALUES ('6e54d15d6739020716b23b348ff66a76', 'jpg', '1', '2017-06-06 15:33:25', 'Easemob_chatlogger', '1');

-- ----------------------------
-- Table structure for easemob_other
-- ----------------------------
DROP TABLE IF EXISTS `easemob_other`;
CREATE TABLE `easemob_other` (
  `ID` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT '文件的hash(md5 | sha1)码',
  `Ext` varchar(4) COLLATE utf8_unicode_ci NOT NULL COMMENT '扩展名',
  `ReferenceCount` int(10) NOT NULL COMMENT '引用计数',
  `CreateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CreatedBy` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of easemob_other
-- ----------------------------

-- ----------------------------
-- Table structure for easemob_video
-- ----------------------------
DROP TABLE IF EXISTS `easemob_video`;
CREATE TABLE `easemob_video` (
  `ID` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT '文件的hash(md5 | sha1)码',
  `Ext` varchar(4) COLLATE utf8_unicode_ci NOT NULL COMMENT '扩展名',
  `ReferenceCount` int(10) NOT NULL COMMENT '引用计数',
  `CreateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CreatedBy` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of easemob_video
-- ----------------------------

-- ----------------------------
-- Table structure for health_record
-- ----------------------------
DROP TABLE IF EXISTS `health_record`;
CREATE TABLE `health_record` (
  `ID` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `UserID` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `DoctorID` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `Description` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of health_record
-- ----------------------------

-- ----------------------------
-- Table structure for history_order
-- ----------------------------
DROP TABLE IF EXISTS `history_order`;
CREATE TABLE `history_order` (
  `ID` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `UserID` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `CreateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Description` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `Fee` decimal(8,2) NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of history_order
-- ----------------------------

-- ----------------------------
-- Table structure for hospital
-- ----------------------------
DROP TABLE IF EXISTS `hospital`;
CREATE TABLE `hospital` (
  `ID` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `Rank` char(8) COLLATE utf8_unicode_ci NOT NULL,
  `Type` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CityID` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `Address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `BriefIntro` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Departments` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CreateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `SortKey1` int(10) NOT NULL AUTO_INCREMENT,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`) USING BTREE,
  UNIQUE KEY `SORT_KEY_INT` (`SortKey1`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of hospital
-- ----------------------------
INSERT INTO `hospital` VALUES ('017abd6e-2bd5-e5cd-d3b1-c707590954e2', '测试医院61', '三级甲等', null, '01', '医院地址61', '医院简介61', '科目A:科目B:科目C', '2017-05-12 11:12:37', '61', '1');
INSERT INTO `hospital` VALUES ('0214a835-e7d5-c917-0a55-c707590954e2', '测试医院27', '三级甲等', null, '01', '医院地址27', '医院简介27', '科目A:科目B:科目C', '2017-05-12 11:12:37', '27', '1');
INSERT INTO `hospital` VALUES ('07bfb5ca-97ce-7092-d339-c707590954e2', '测试医院64', '三级甲等', null, '01', '医院地址64', '医院简介64', '科目A:科目B:科目C', '2017-05-12 11:12:37', '64', '1');
INSERT INTO `hospital` VALUES ('07cb6712-6451-80d9-aeb6-c707590954e2', '测试医院35', '三级甲等', null, '01', '医院地址35', '医院简介35', '科目A:科目B:科目C', '2017-05-12 11:12:37', '35', '1');
INSERT INTO `hospital` VALUES ('0b1d47b0-ffb5-4f62-9494-c707590954e2', '测试医院59', '三级甲等', null, '01', '医院地址59', '医院简介59', '科目A:科目B:科目C', '2017-05-12 11:12:37', '59', '1');
INSERT INTO `hospital` VALUES ('0cb9d057-29c6-ce91-a839-c707590954e2', '测试医院21', '三级甲等', null, '01', '医院地址21', '医院简介21', '科目A:科目B:科目C', '2017-05-12 11:12:37', '21', '1');
INSERT INTO `hospital` VALUES ('1295aeb2-a35f-6eac-6715-c707590954e2', '测试医院13', '三级甲等', null, '01', '医院地址13', '医院简介13', '科目A:科目B:科目C', '2017-05-12 11:12:37', '13', '1');
INSERT INTO `hospital` VALUES ('15cd7bda-c969-a2e7-71f4-c707590954e2', '测试医院6', '三级甲等', null, '01', '医院地址6', '医院简介6', '科目A:科目B:科目C', '2017-05-12 11:12:37', '6', '1');
INSERT INTO `hospital` VALUES ('18de68ab-e12e-8ed0-8c5b-c707590954e2', '测试医院69', '三级甲等', null, '01', '医院地址69', '医院简介69', '科目A:科目B:科目C', '2017-05-12 11:12:37', '69', '1');
INSERT INTO `hospital` VALUES ('1efd3775-3411-6c09-639a-c707590954e2', '测试医院39', '三级甲等', null, '01', '医院地址39', '医院简介39', '科目A:科目B:科目C', '2017-05-12 11:12:37', '39', '1');
INSERT INTO `hospital` VALUES ('24372f6e-5338-a427-a205-c707590954e2', '测试医院37', '三级甲等', null, '01', '医院地址37', '医院简介37', '科目A:科目B:科目C', '2017-05-12 11:12:37', '37', '1');
INSERT INTO `hospital` VALUES ('25f0cf1a-6c53-cbd8-3472-c707590954e2', '测试医院44', '三级甲等', null, '01', '医院地址44', '医院简介44', '科目A:科目B:科目C', '2017-05-12 11:12:37', '44', '1');
INSERT INTO `hospital` VALUES ('277c7e4e-61f5-a2c1-a0be-c707590954e2', '测试医院23', '三级甲等', null, '01', '医院地址23', '医院简介23', '科目A:科目B:科目C', '2017-05-12 11:12:37', '23', '1');
INSERT INTO `hospital` VALUES ('27b8353e-52b2-2c77-a587-c707590954e2', '测试医院3', '三级甲等', null, '01', '医院地址3', '医院简介3', '科目A:科目B:科目C', '2017-05-12 11:12:37', '3', '1');
INSERT INTO `hospital` VALUES ('2acf4628-6f69-12fc-f6bf-c707590954e2', '测试医院58', '三级甲等', null, '01', '医院地址58', '医院简介58', '科目A:科目B:科目C', '2017-05-12 11:12:37', '58', '1');
INSERT INTO `hospital` VALUES ('2d09da47-b043-e03c-c5ee-c707590954e2', '测试医院43', '三级甲等', null, '01', '医院地址43', '医院简介43', '科目A:科目B:科目C', '2017-05-12 11:12:37', '43', '1');
INSERT INTO `hospital` VALUES ('2df45262-ade6-bad2-83f7-c707590954e2', '测试医院20', '三级甲等', null, '01', '医院地址20', '医院简介20', '科目A:科目B:科目C', '2017-05-12 11:12:37', '20', '1');
INSERT INTO `hospital` VALUES ('3153dc1c-a51e-3841-9936-c707590954e2', '测试医院22', '三级甲等', null, '01', '医院地址22', '医院简介22', '科目A:科目B:科目C', '2017-05-12 11:12:37', '22', '1');
INSERT INTO `hospital` VALUES ('32b2482f-f50f-c608-bb2d-c707590954e2', '测试医院65', '三级甲等', null, '01', '医院地址65', '医院简介65', '科目A:科目B:科目C', '2017-05-12 11:12:37', '65', '1');
INSERT INTO `hospital` VALUES ('354654b4-1306-287f-e84a-c707590954e2', '测试医院34', '三级甲等', null, '01', '医院地址34', '医院简介34', '科目A:科目B:科目C', '2017-05-12 11:12:37', '34', '1');
INSERT INTO `hospital` VALUES ('404417ae-48c2-a5c5-2285-c707590954e2', '测试医院57', '三级甲等', null, '01', '医院地址57', '医院简介57', '科目A:科目B:科目C', '2017-05-12 11:12:37', '57', '1');
INSERT INTO `hospital` VALUES ('40bf0e68-828c-e88a-cc23-c707590954e2', '测试医院67', '三级甲等', null, '01', '医院地址67', '医院简介67', '科目A:科目B:科目C', '2017-05-12 11:12:37', '67', '1');
INSERT INTO `hospital` VALUES ('4259a5aa-fa9f-cbc5-92f3-c707590954e2', '测试医院25', '三级甲等', null, '01', '医院地址25', '医院简介25', '科目A:科目B:科目C', '2017-05-12 11:12:37', '25', '1');
INSERT INTO `hospital` VALUES ('42feaf8f-2614-c49e-5590-c707590954e2', '测试医院63', '三级甲等', null, '01', '医院地址63', '医院简介63', '科目A:科目B:科目C', '2017-05-12 11:12:37', '63', '1');
INSERT INTO `hospital` VALUES ('45fff613-1e78-2e69-9c75-c707590954e2', '测试医院49', '三级甲等', null, '01', '医院地址49', '医院简介49', '科目A:科目B:科目C', '2017-05-12 11:12:37', '49', '1');
INSERT INTO `hospital` VALUES ('46313195-d95b-f4b6-6e4e-c707590954e2', '测试医院78', '三级甲等', null, '01', '医院地址78', '医院简介78', '科目A:科目B:科目C', '2017-05-12 11:12:37', '78', '1');
INSERT INTO `hospital` VALUES ('481079f8-43fb-3d23-7689-c707590954e2', '测试医院9', '三级甲等', null, '01', '医院地址9', '医院简介9', '科目A:科目B:科目C', '2017-05-12 11:12:37', '9', '1');
INSERT INTO `hospital` VALUES ('486869eb-8d88-bbd8-4bd9-c707590954e2', '测试医院33', '三级甲等', null, '01', '医院地址33', '医院简介33', '科目A:科目B:科目C', '2017-05-12 11:12:37', '33', '1');
INSERT INTO `hospital` VALUES ('4b78bc35-2557-94ad-da1b-c707590954e2', '测试医院55', '三级甲等', null, '01', '医院地址55', '医院简介55', '科目A:科目B:科目C', '2017-05-12 11:12:37', '55', '1');
INSERT INTO `hospital` VALUES ('54416f23-5f69-9e2c-3075-c707590954e2', '测试医院62', '三级甲等', null, '01', '医院地址62', '医院简介62', '科目A:科目B:科目C', '2017-05-12 11:12:37', '62', '1');
INSERT INTO `hospital` VALUES ('5f091e2b-5bf8-a221-9384-c707590954e2', '测试医院31', '三级甲等', null, '01', '医院地址31', '医院简介31', '科目A:科目B:科目C', '2017-05-12 11:12:37', '31', '1');
INSERT INTO `hospital` VALUES ('66420108-8650-4819-3a74-c707590954e2', '测试医院70', '三级甲等', null, '01', '医院地址70', '医院简介70', '科目A:科目B:科目C', '2017-05-12 11:12:37', '70', '1');
INSERT INTO `hospital` VALUES ('75096a3c-f6a8-c1cc-7695-c707590954e2', '测试医院66', '三级甲等', null, '01', '医院地址66', '医院简介66', '科目A:科目B:科目C', '2017-05-12 11:12:37', '66', '1');
INSERT INTO `hospital` VALUES ('76e4cfef-65b7-4c76-3710-c707590954e2', '测试医院75', '三级甲等', null, '01', '医院地址75', '医院简介75', '科目A:科目B:科目C', '2017-05-12 11:12:37', '75', '1');
INSERT INTO `hospital` VALUES ('7755013d-6f2c-3c50-84c8-c707590954e2', '测试医院17', '三级甲等', null, '01', '医院地址17', '医院简介17', '科目A:科目B:科目C', '2017-05-12 11:12:37', '17', '1');
INSERT INTO `hospital` VALUES ('77c52d8b-2c96-0bba-a0ee-c707590954e2', '测试医院77', '三级甲等', null, '01', '医院地址77', '医院简介77', '科目A:科目B:科目C', '2017-05-12 11:12:37', '77', '1');
INSERT INTO `hospital` VALUES ('7c46572d-176e-89dd-0aaf-c707590954e2', '测试医院32', '三级甲等', null, '01', '医院地址32', '医院简介32', '科目A:科目B:科目C', '2017-05-12 11:12:37', '32', '1');
INSERT INTO `hospital` VALUES ('7c8a4770-35c4-e90d-0581-c707590954e2', '测试医院41', '三级甲等', null, '01', '医院地址41', '医院简介41', '科目A:科目B:科目C', '2017-05-12 11:12:37', '41', '1');
INSERT INTO `hospital` VALUES ('853cafd6-8cfd-36f9-7813-c707590954e2', '测试医院73', '三级甲等', null, '01', '医院地址73', '医院简介73', '科目A:科目B:科目C', '2017-05-12 11:12:37', '73', '1');
INSERT INTO `hospital` VALUES ('86cb3b92-02c4-be2b-a11b-c707590954e2', '测试医院53', '三级甲等', null, '01', '医院地址53', '医院简介53', '科目A:科目B:科目C', '2017-05-12 11:12:37', '53', '1');
INSERT INTO `hospital` VALUES ('87bf151c-58df-d020-73f2-c707590954e2', '测试医院72', '三级甲等', null, '01', '医院地址72', '医院简介72', '科目A:科目B:科目C', '2017-05-12 11:12:37', '72', '1');
INSERT INTO `hospital` VALUES ('8a40e48a-e03d-ded3-0902-c707590954e2', '测试医院11', '三级甲等', null, '01', '医院地址11', '医院简介11', '科目A:科目B:科目C', '2017-05-12 11:12:37', '11', '1');
INSERT INTO `hospital` VALUES ('8e9a78ff-6d9e-5ae4-a42e-c707590954e2', '测试医院71', '三级甲等', null, '01', '医院地址71', '医院简介71', '科目A:科目B:科目C', '2017-05-12 11:12:37', '71', '1');
INSERT INTO `hospital` VALUES ('9543bdf3-3d9e-5832-3ea5-c707590954e2', '测试医院48', '三级甲等', null, '01', '医院地址48', '医院简介48', '科目A:科目B:科目C', '2017-05-12 11:12:37', '48', '1');
INSERT INTO `hospital` VALUES ('98020f15-d674-2331-58a4-c707590954e2', '测试医院54', '三级甲等', null, '01', '医院地址54', '医院简介54', '科目A:科目B:科目C', '2017-05-12 11:12:37', '54', '1');
INSERT INTO `hospital` VALUES ('9d93ec5e-ca9c-0311-58b0-c707590954e2', '测试医院15', '三级甲等', null, '01', '医院地址15', '医院简介15', '科目A:科目B:科目C', '2017-05-12 11:12:37', '15', '1');
INSERT INTO `hospital` VALUES ('9e91cf3c-33ef-b36e-329c-c707590954e2', '测试医院30', '三级甲等', null, '01', '医院地址30', '医院简介30', '科目A:科目B:科目C', '2017-05-12 11:12:37', '30', '1');
INSERT INTO `hospital` VALUES ('a0f14d52-c56a-3070-f9bd-c707590954e2', '测试医院12', '三级甲等', null, '01', '医院地址12', '医院简介12', '科目A:科目B:科目C', '2017-05-12 11:12:37', '12', '1');
INSERT INTO `hospital` VALUES ('a1fb2853-68cf-8e14-5e3e-c707590954e2', '测试医院5', '三级甲等', null, '01', '医院地址5', '医院简介5', '科目A:科目B:科目C', '2017-05-12 11:12:37', '5', '1');
INSERT INTO `hospital` VALUES ('a2f845f9-f638-8209-c163-c707590954e2', '测试医院76', '三级甲等', null, '01', '医院地址76', '医院简介76', '科目A:科目B:科目C', '2017-05-12 11:12:37', '76', '1');
INSERT INTO `hospital` VALUES ('a48c50f5-77ed-8d9e-3b66-c707590954e2', '测试医院14', '三级甲等', null, '01', '医院地址14', '医院简介14', '科目A:科目B:科目C', '2017-05-12 11:12:37', '14', '1');
INSERT INTO `hospital` VALUES ('a687e5dc-4836-c5a9-cbc5-c707590954e2', '测试医院24', '三级甲等', null, '01', '医院地址24', '医院简介24', '科目A:科目B:科目C', '2017-05-12 11:12:37', '24', '1');
INSERT INTO `hospital` VALUES ('b23aca0f-f044-e9c0-6ca5-c707590954e2', '测试医院42', '三级甲等', null, '01', '医院地址42', '医院简介42', '科目A:科目B:科目C', '2017-05-12 11:12:37', '42', '1');
INSERT INTO `hospital` VALUES ('bb6186a6-34cf-19ff-868c-c707590954e2', '测试医院16', '三级甲等', null, '01', '医院地址16', '医院简介16', '科目A:科目B:科目C', '2017-05-12 11:12:37', '16', '1');
INSERT INTO `hospital` VALUES ('c18c1681-0e85-e487-8254-c707590954e2', '测试医院7', '三级甲等', null, '01', '医院地址7', '医院简介7', '科目A:科目B:科目C', '2017-05-12 11:12:37', '7', '1');
INSERT INTO `hospital` VALUES ('c754bd33-5585-ecaf-8df5-c707590954e2', '测试医院50', '三级甲等', null, '01', '医院地址50', '医院简介50', '科目A:科目B:科目C', '2017-05-12 11:12:37', '50', '1');
INSERT INTO `hospital` VALUES ('cd3fbd11-47b1-04ee-326f-c707590954e2', '测试医院74', '三级甲等', null, '01', '医院地址74', '医院简介74', '科目A:科目B:科目C', '2017-05-12 11:12:37', '74', '1');
INSERT INTO `hospital` VALUES ('cdf590d6-5a74-2a88-3371-c707590954e2', '测试医院56', '三级甲等', null, '01', '医院地址56', '医院简介56', '科目A:科目B:科目C', '2017-05-12 11:12:37', '56', '1');
INSERT INTO `hospital` VALUES ('d2db66d6-bea6-cc01-d0f7-c707590954e2', '测试医院52', '三级甲等', null, '01', '医院地址52', '医院简介52', '科目A:科目B:科目C', '2017-05-12 11:12:37', '52', '1');
INSERT INTO `hospital` VALUES ('dc59faa3-acf2-c686-a063-c707590954e2', '测试医院68', '三级甲等', null, '01', '医院地址68', '医院简介68', '科目A:科目B:科目C', '2017-05-12 11:12:37', '68', '1');
INSERT INTO `hospital` VALUES ('dd9368e2-a97b-4ac1-50ae-c707590954e2', '测试医院60', '三级甲等', null, '01', '医院地址60', '医院简介60', '科目A:科目B:科目C', '2017-05-12 11:12:37', '60', '1');
INSERT INTO `hospital` VALUES ('debff028-24a0-bce2-8665-c707590954e2', '测试医院10', '三级甲等', null, '01', '医院地址10', '医院简介10', '科目A:科目B:科目C', '2017-05-12 11:12:37', '10', '1');
INSERT INTO `hospital` VALUES ('df6210cb-c700-ac0b-bc08-c707590954e2', '测试医院51', '三级甲等', null, '01', '医院地址51', '医院简介51', '科目A:科目B:科目C', '2017-05-12 11:12:37', '51', '1');
INSERT INTO `hospital` VALUES ('e0f4c963-4838-a044-350b-c707590954e2', '测试医院8', '三级甲等', null, '01', '医院地址8', '医院简介8', '科目A:科目B:科目C', '2017-05-12 11:12:37', '8', '1');
INSERT INTO `hospital` VALUES ('e397d00d-0b65-5c8a-6a1d-c707590954e2', '测试医院26', '三级甲等', null, '01', '医院地址26', '医院简介26', '科目A:科目B:科目C', '2017-05-12 11:12:37', '26', '1');
INSERT INTO `hospital` VALUES ('e55c768d-6c4e-041e-2ee9-c707590954e2', '测试医院18', '三级甲等', null, '01', '医院地址18', '医院简介18', '科目A:科目B:科目C', '2017-05-12 11:12:37', '18', '1');
INSERT INTO `hospital` VALUES ('e6d06091-2e53-9042-0194-c707590954e2', '测试医院36', '三级甲等', null, '01', '医院地址36', '医院简介36', '科目A:科目B:科目C', '2017-05-12 11:12:37', '36', '1');
INSERT INTO `hospital` VALUES ('f0f0bff5-8b67-95ac-97ee-c707590954e2', '测试医院40', '三级甲等', null, '01', '医院地址40', '医院简介40', '科目A:科目B:科目C', '2017-05-12 11:12:37', '40', '1');
INSERT INTO `hospital` VALUES ('f1eef009-d03c-6ed6-a4e4-c707590954e2', '测试医院45', '三级甲等', null, '01', '医院地址45', '医院简介45', '科目A:科目B:科目C', '2017-05-12 11:12:37', '45', '1');
INSERT INTO `hospital` VALUES ('f413a2ce-7d01-9343-cba2-c707590954e2', '测试医院29', '三级甲等', null, '01', '医院地址29', '医院简介29', '科目A:科目B:科目C', '2017-05-12 11:12:37', '29', '1');
INSERT INTO `hospital` VALUES ('f4f1b47a-a6b4-f855-bd74-c707590954e2', '测试医院4', '三级甲等', null, '01', '医院地址4', '医院简介4', '科目A:科目B:科目C', '2017-05-12 11:12:37', '4', '1');
INSERT INTO `hospital` VALUES ('f6149f85-0f1e-c922-1fce-c707590954e2', '测试医院19', '三级甲等', null, '01', '医院地址19', '医院简介19', '科目A:科目B:科目C', '2017-05-12 11:12:37', '19', '1');
INSERT INTO `hospital` VALUES ('f76f95fb-99f2-3ecd-7f23-c707590954e2', '测试医院46', '三级甲等', null, '01', '医院地址46', '医院简介46', '科目A:科目B:科目C', '2017-05-12 11:12:37', '46', '1');
INSERT INTO `hospital` VALUES ('f795f8e0-5e3d-4ba4-bd92-c707590954e2', '测试医院2', '三级甲等', null, '01', '医院地址2', '医院简介2', '科目A:科目B:科目C', '2017-05-12 11:12:37', '2', '1');
INSERT INTO `hospital` VALUES ('f84603da-0ef8-9f61-1d74-c707590954e2', '测试医院1', '三级甲等', null, '01', '医院地址1', '医院简介1', '科目A:科目B:科目C', '2017-05-12 11:12:37', '1', '1');
INSERT INTO `hospital` VALUES ('faf4f119-8515-da94-6e02-c707590954e2', '测试医院38', '三级甲等', null, '01', '医院地址38', '医院简介38', '科目A:科目B:科目C', '2017-05-12 11:12:37', '38', '1');
INSERT INTO `hospital` VALUES ('fba48218-fdba-a457-1d58-c707590954e2', '测试医院47', '三级甲等', null, '01', '医院地址47', '医院简介47', '科目A:科目B:科目C', '2017-05-12 11:12:37', '47', '1');
INSERT INTO `hospital` VALUES ('fe792e18-4341-1069-47ef-c707590954e2', '测试医院28', '三级甲等', null, '01', '医院地址28', '医院简介28', '科目A:科目B:科目C', '2017-05-12 11:12:37', '28', '1');

-- ----------------------------
-- Table structure for image_md5
-- ----------------------------
DROP TABLE IF EXISTS `image_md5`;
CREATE TABLE `image_md5` (
  `ID` char(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '文件的md5码',
  `Ext` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `ReferenceCount` int(10) NOT NULL,
  `CreateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CreatedBy` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of image_md5
-- ----------------------------
INSERT INTO `image_md5` VALUES ('1c95ca00b4ede83f63610ad9e8f1011c', 'png', '2', '2017-06-14 09:53:07', '0000', '1');
INSERT INTO `image_md5` VALUES ('2120ef74ef47f4b7e7eb021e2517ccba', 'jpg', '1', '2017-06-06 15:32:21', 'wxapp', '1');
INSERT INTO `image_md5` VALUES ('35bc1e8d5c5fd423ad54ee858193e9e0', 'jpg', '1', '2017-06-06 15:32:21', 'wxapp', '1');
INSERT INTO `image_md5` VALUES ('597c569cde2967bcbc9e8992030fe9c8', 'jpg', '1', '2017-06-06 15:32:21', 'wxapp', '1');
INSERT INTO `image_md5` VALUES ('6e54d15d6739020716b23b348ff66a76', 'jpg', '0', '2017-06-12 10:54:00', 'wxapp', '0');
INSERT INTO `image_md5` VALUES ('8aaf1fa20ebea0dd510fe3ac32223a92', 'jpg', '1', '2017-06-06 15:32:21', 'wxapp', '1');
INSERT INTO `image_md5` VALUES ('a248a720eb3013b819560f8c6dc479e3', 'jpg', '1', '2017-06-06 15:32:21', 'wxapp', '1');
INSERT INTO `image_md5` VALUES ('d94b3cf6f5d0f413185ea7bdb090d6a3', 'png', '1', '2017-06-06 15:32:21', 'wxapp', '1');
INSERT INTO `image_md5` VALUES ('f1586f725b96de39c719f99e5c9e4cf6', 'jpg', '1', '2017-06-06 15:32:21', 'wxapp', '1');

-- ----------------------------
-- Table structure for image_sha1
-- ----------------------------
DROP TABLE IF EXISTS `image_sha1`;
CREATE TABLE `image_sha1` (
  `ID` char(40) COLLATE utf8_unicode_ci NOT NULL COMMENT '文件的sha1码',
  `ext` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `ReferenceCount` int(10) NOT NULL,
  `CreateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CreatedBy` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of image_sha1
-- ----------------------------

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `ID` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `UserID` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `CreateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Description` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `Fee` decimal(8,2) NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of order
-- ----------------------------

-- ----------------------------
-- Table structure for paid_service
-- ----------------------------
DROP TABLE IF EXISTS `paid_service`;
CREATE TABLE `paid_service` (
  `ID` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `Description` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of paid_service
-- ----------------------------

-- ----------------------------
-- Table structure for silk2amr
-- ----------------------------
DROP TABLE IF EXISTS `silk2amr`;
CREATE TABLE `silk2amr` (
  `ID` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT '文件的hash(md5 | sha1)码',
  `Ext` varchar(4) COLLATE utf8_unicode_ci NOT NULL COMMENT '扩展名',
  `ReferenceCount` int(10) NOT NULL COMMENT '引用计数',
  `CreateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CreatedBy` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of silk2amr
-- ----------------------------
INSERT INTO `silk2amr` VALUES ('09e68a417c9fed652f2e9a31301db1c2', 'silk', '1', '2017-06-13 15:31:29', '0000', '1');
INSERT INTO `silk2amr` VALUES ('0c5f5b7b51106ee0b21ce2839f592002', 'silk', '1', '2017-06-13 15:27:39', '0000', '1');
INSERT INTO `silk2amr` VALUES ('24d0683d084c5ba3be2cf01e5caef640', 'silk', '1', '2017-06-13 16:22:59', '0000', '1');
INSERT INTO `silk2amr` VALUES ('33991efce087b484bacc88fee7ecb8f8', 'silk', '1', '2017-06-13 15:36:27', '0000', '1');
INSERT INTO `silk2amr` VALUES ('35dbf476fef34ec4c25d87d739aa1d81', 'silk', '1', '2017-06-13 15:43:40', '0000', '1');
INSERT INTO `silk2amr` VALUES ('404b4490a845fb781038bc1480e98f77', 'silk', '1', '2017-06-13 16:21:14', '0000', '1');
INSERT INTO `silk2amr` VALUES ('41b28045addf14129a8905a6d50ccdf6', 'silk', '1', '2017-06-13 15:27:57', '0000', '1');
INSERT INTO `silk2amr` VALUES ('46f9899b4d555962533f9d4b8a90f2cd', 'silk', '1', '2017-06-13 15:38:18', '0000', '1');
INSERT INTO `silk2amr` VALUES ('4a09ee2756e7b221b941a6e01645c159', 'silk', '1', '2017-06-14 09:32:56', '0000', '1');
INSERT INTO `silk2amr` VALUES ('4cb1c098f431ee27ea4ef3c8ea9a3ba7', 'silk', '1', '2017-06-13 15:24:13', '0000', '1');
INSERT INTO `silk2amr` VALUES ('565367c446edcbb3e2f38cd7aca73d8e', 'silk', '1', '2017-06-13 15:40:24', '0000', '1');
INSERT INTO `silk2amr` VALUES ('5856d0be42e2426baf4b5b037721af8e', 'silk', '1', '2017-06-13 15:29:58', '0000', '1');
INSERT INTO `silk2amr` VALUES ('5c7bd0c537bf3ace7fd68a7be252aeda', 'silk', '1', '2017-06-13 16:20:00', '0000', '1');
INSERT INTO `silk2amr` VALUES ('6fa999dcafb93ced465a5f2b4fd95004', 'silk', '1', '2017-06-13 15:34:24', '0000', '1');
INSERT INTO `silk2amr` VALUES ('7797e3990f96fe18844fe11c1e052b72', 'silk', '1', '2017-06-13 15:32:47', '0000', '1');
INSERT INTO `silk2amr` VALUES ('98baec94f87ea554beb5e21c4ac284c0', 'silk', '21', '2017-06-13 11:51:32', '0000', '1');
INSERT INTO `silk2amr` VALUES ('e83797688dff1923b242649939922a25', 'silk', '1', '2017-06-13 15:36:54', '0000', '1');
INSERT INTO `silk2amr` VALUES ('f33f9c178993109bb72b9f6d212e2cef', 'silk', '1', '2017-06-13 16:05:40', '0000', '1');
INSERT INTO `silk2amr` VALUES ('f4ff0ddac0ba641a34f51ec1c454f9b4', 'silk', '1', '2017-06-13 15:40:30', '0000', '1');
INSERT INTO `silk2amr` VALUES ('f72f4b0441acad8c755561e2ef567703', 'silk', '1', '2017-06-13 15:44:54', '0000', '1');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `ID` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `MobileNum` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `Nickname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `Gender` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'X',
  `BirthDate` date DEFAULT NULL,
  `Age` tinyint(4) DEFAULT NULL,
  `RegTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `PaidMembership` tinyint(1) NOT NULL DEFAULT '0',
  `BloodType` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Height` tinyint(4) DEFAULT NULL,
  `Weight` decimal(5,2) DEFAULT NULL,
  `PortraitID` char(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `RegisteredToEasemob` tinyint(1) NOT NULL DEFAULT '0',
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`) USING BTREE,
  UNIQUE KEY `MobileNum` (`MobileNum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('19d1cd32-b09c-4fe1-ee52-c7825950783f', '13683514098', 'jt002', '航行4098', 'X', null, null, '2017-06-26 10:58:07', '1234', '0', null, null, null, '1c95ca00b4ede83f63610ad9e8f1011c', '0', '1');
INSERT INTO `user` VALUES ('66e882b7-568e-6b1c-32ee-c7825950783a', '13683514097', 'jt001', '海洋4097', 'X', null, null, '2017-06-26 10:58:02', '1234', '0', null, null, null, '1c95ca00b4ede83f63610ad9e8f1011c', '0', '1');
INSERT INTO `user` VALUES ('8109b6cb-5c73-1950-ec53-c7765940d843', '13121361262', '1262-8109b6cb', '1262-8109b6cb', 'M', null, null, '2017-06-14 14:31:31', 'Mk123456', '0', null, null, null, '1c95ca00b4ede83f63610ad9e8f1011c', '1', '1');
INSERT INTO `user` VALUES ('c3b77748-80b7-ab29-6d71-c77e594b2e76', '13683514096', '4096-c3b77748', '天空', 'M', null, null, '2017-06-22 10:41:58', '1234', '0', null, null, null, '1c95ca00b4ede83f63610ad9e8f1011c', '0', '1');
INSERT INTO `user` VALUES ('c532097d-4a6e-fa11-2c96-c6ae58f08adf', '13426014388', '4388-c532097d', 'Amber', 'M', null, null, '2017-04-14 16:39:59', '1234', '0', null, null, null, '1c95ca00b4ede83f63610ad9e8f1011c', '1', '1');
