-- MySQL dump 10.13  Distrib 8.0.20, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: yii_erik_admin
-- ------------------------------------------------------
-- Server version	8.0.20

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `erik_admin`
--

DROP TABLE IF EXISTS `erik_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `erik_admin` (
  `id` bigint NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户名',
  `nick_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '昵称',
  `hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '校验hash',
  `password` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT '密码',
  `phone` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '手机',
  `email` varchar(60) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0=开启 1=禁止',
  `access_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `token_hash` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `authority` tinyint NOT NULL DEFAULT '1' COMMENT '是否超级管理员 0=是 1=否',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ad_like_IDX` (`name`,`nick_name`,`phone`,`email`) USING BTREE,
  KEY `ad_status_IDX` (`status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='用户';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `erik_admin`
--

LOCK TABLES `erik_admin` WRITE;
/*!40000 ALTER TABLE `erik_admin` DISABLE KEYS */;
INSERT INTO `erik_admin` VALUES (6770338174544642049,'zgl','张','$2y$13$Rd7Hv.j5VB6GRk53NE7eZuccH814/Lsr78R3yXrz6iSfMXjtLi2r6','123133w','13567894561','as@c.com',0,NULL,NULL,1),(6770339464288927745,'哪吒','娜扎','$2y$13$jxBPD2wwlGLY6phf5TG/NevGa/btpTvdNdzxTWBoTldTRquJp2wmm','123123','13567894562','sds@w.com',0,'GAxR9dvYs5BfwC37YAY9RmR90FQbbYcg2O1dbeID41hdmq9diDF7X2UcYIJ491INnCHEw2luAfcwrw3PDpJA5a3g','$2y$10$UADS.VkwWbjsnyRdWcN/9uOEhwJlv7ODYIXl0KRiFZ1U8H6PgQgca',1),(6770375661681901569,'张胜男q','shengz','$2y$13$R31jEJXK.0ERB.SXGBGsh.mEAtM6CYYL91qdP1nP/fFTTq9/ehV1S','123456','13567894563','sdwe@d.com',0,NULL,NULL,1),(6772517604436213761,'erik','erik','$2y$13$6VSI9aErAf86Ei.tnfcPWOaVLC3ED8PvC9x.kIYyb3d/ZnMT444.S','123456','13567894564','swerw@dd.com',1,'YWNhMjIwYTY2ZTdiMzFkZmZiNTM2NjljYjc4NmQwZTZiMDc2N2QzYTJjODBlZGQwMGU2MTQ1NGQ4YzVmMTYzNmQyNTQwMjhhMjc4ZWM3MGY2MzRhY2ZlNzBhNTA5YWE5MGFlZGY0NDFiMmNkMWIwNWY2Njc2ZTRlMzEyNTBkNGM0NWFlN2JiYTNjMDg3Y2QyYjZhM2Y4Y2M2Yzk1MzZjNWM1MDg4OTA2ODBkNDVhZWEwYzQ3NWUzYjY3MmRmZjhhNTQzZDEwYWVmZTBlNjRhODYwYzUxMmVhMGY0NmJkOWM4NDNjNTE5MzhkYTMxM2Y5ZjM4MDg5OTBhNzgxYmY2NTE2MTYyMDI2OTI3NQ==','$2y$10$Rfgg1DCof5U89AiESX0uxeQDl4d.V7D48Bfdp9k5yuZ9dr2EDPgKm',0),(6785151491628859393,'lufei1','路飞','$2y$13$YVWcdb0P/.rt8G1VujqdhuEKzoaGKoTGuKoPZqSmlTUVH1zj353IS','123123','13567894565','ewrw@df.com',1,NULL,NULL,1),(6785175969754775553,'sun_wu','吴天','$2y$13$TQINnOx/.KJg6GATdURL6u7ZWNP3ptna.A.lpybnomIrh5KUJMeH.','123123','13567894567','dsfs@dd.com',0,'MWE2MWNhMWZiM2I1NTc2NjU5OGQzMGQ4YmMxZjQ4YmI=','1231232',1),(6790121106809290753,'ad123','苏三','$2y$10$53Sz0af8ptACJdHR/sFX2.xuAd930isz9SRtKeDi2pxbXG.6acjn6','$2y$10$z3gJA1rFzCytSyKhEeDAbuWosZCNhaz4UAwEihmiu2rfKwXr8BBGi','',NULL,1,NULL,NULL,1);
/*!40000 ALTER TABLE `erik_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `erik_admin_authority`
--

DROP TABLE IF EXISTS `erik_admin_authority`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `erik_admin_authority` (
  `id` bigint NOT NULL,
  `parent_id` bigint NOT NULL DEFAULT '0' COMMENT '父级  0=顶级',
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '编码',
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT '名称',
  `show` tinyint NOT NULL DEFAULT '0' COMMENT '是否显示 0=显示 1=隐藏',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态 0=开启 1=禁止',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='权限表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `erik_admin_authority`
--

LOCK TABLES `erik_admin_authority` WRITE;
/*!40000 ALTER TABLE `erik_admin_authority` DISABLE KEYS */;
INSERT INTO `erik_admin_authority` VALUES (6778326059675811841,0,'order_list','订单管理',0,0),(6778326059675811842,0,'order_lists','订单过期',0,0),(6778326700091506689,0,'sdasd','用户列表',0,0),(6783347249670782977,6778326700091506689,'user_add','新增用户',1,1),(6812603737937281025,0,'active_center','活动中心',0,0);
/*!40000 ALTER TABLE `erik_admin_authority` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `erik_admin_info`
--

DROP TABLE IF EXISTS `erik_admin_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `erik_admin_info` (
  `id` bigint NOT NULL,
  `real_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '姓名',
  `sex` tinyint NOT NULL DEFAULT '1' COMMENT '性别 0=女 1=男',
  `age` int NOT NULL DEFAULT '0' COMMENT '年龄',
  `year` int NOT NULL DEFAULT '1989' COMMENT '年',
  `month` int NOT NULL DEFAULT '1' COMMENT '月',
  `day` int NOT NULL DEFAULT '1' COMMENT '日',
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '头像',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='用户详情';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `erik_admin_info`
--

LOCK TABLES `erik_admin_info` WRITE;
/*!40000 ALTER TABLE `erik_admin_info` DISABLE KEYS */;
INSERT INTO `erik_admin_info` VALUES (6770338174544642049,'',1,33,1989,9,21,'','2021-02-24 13:46:48','2021-02-24 13:46:48'),(6770339464288927745,'',1,0,1989,1,1,'','2021-02-24 13:51:55','2021-02-24 13:51:55'),(6770375661681901569,'朱湖',1,0,1989,1,1,'','2021-02-24 16:15:45','2021-02-24 16:15:45'),(6772517604436213761,'李飞',1,0,1989,1,1,'','2021-03-02 14:07:04','2021-03-02 14:07:04'),(6785151491628859393,'路飞',0,0,1989,1,1,'','2021-04-06 10:49:38','2021-04-06 10:49:38'),(6785175969754775553,'孙吴',1,0,1989,1,1,'','2021-04-06 12:26:54','2021-04-06 12:26:54'),(6790121106809290753,'掌声',1,0,1989,1,1,'','2021-04-20 03:57:06','2021-04-20 03:57:06');
/*!40000 ALTER TABLE `erik_admin_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `erik_admin_role`
--

DROP TABLE IF EXISTS `erik_admin_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `erik_admin_role` (
  `admin_id` bigint NOT NULL COMMENT '用户id',
  `role_id` bigint NOT NULL COMMENT '角色id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='用户角色关系';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `erik_admin_role`
--

LOCK TABLES `erik_admin_role` WRITE;
/*!40000 ALTER TABLE `erik_admin_role` DISABLE KEYS */;
INSERT INTO `erik_admin_role` VALUES (6770339464288927745,6783291724690096129),(6770339464288927745,6785130231465246721);
/*!40000 ALTER TABLE `erik_admin_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `erik_admin_role_authority`
--

DROP TABLE IF EXISTS `erik_admin_role_authority`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `erik_admin_role_authority` (
  `role_id` bigint NOT NULL COMMENT '角色id',
  `authority_id` bigint NOT NULL COMMENT '权限id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='角色权限关系表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `erik_admin_role_authority`
--

LOCK TABLES `erik_admin_role_authority` WRITE;
/*!40000 ALTER TABLE `erik_admin_role_authority` DISABLE KEYS */;
INSERT INTO `erik_admin_role_authority` VALUES (6785130231465246721,6778326059675811841),(6785130231465246721,6778326700091506689),(6785130231465246721,6783347249670782977),(6783291724690096129,6778326059675811841);
/*!40000 ALTER TABLE `erik_admin_role_authority` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `erik_admin_role_info`
--

DROP TABLE IF EXISTS `erik_admin_role_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `erik_admin_role_info` (
  `id` bigint NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT '角色名称',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '角色状态 0=开启 1=禁止',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='角色';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `erik_admin_role_info`
--

LOCK TABLES `erik_admin_role_info` WRITE;
/*!40000 ALTER TABLE `erik_admin_role_info` DISABLE KEYS */;
INSERT INTO `erik_admin_role_info` VALUES (6783291724690096129,'经理',0,'2021-04-01 07:39:34'),(6785130231465246721,'业务员',1,'2021-04-06 09:25:08'),(6785177338695909377,'学生',1,'2021-04-06 12:32:20'),(6812636035848077313,'北京分公司',0,'2021-06-21 07:03:23');
/*!40000 ALTER TABLE `erik_admin_role_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `erik_config`
--

DROP TABLE IF EXISTS `erik_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `erik_config` (
  `id` bigint NOT NULL,
  `code` varchar(60) COLLATE utf8mb4_general_ci NOT NULL COMMENT '编码',
  `name` varchar(80) COLLATE utf8mb4_general_ci NOT NULL COMMENT '名称',
  `info` json NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='基础配置';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `erik_config`
--

LOCK TABLES `erik_config` WRITE;
/*!40000 ALTER TABLE `erik_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `erik_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'yii_erik_admin'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-06-30 18:58:58
