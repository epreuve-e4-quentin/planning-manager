-- Adminer 4.7.8 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `planning-v2`;
CREATE DATABASE `planning-test` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `planning-test`;

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee` (
  `person_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adress` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_phone` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `internal` tinyint(1) NOT NULL DEFAULT 0,
  `enter_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`person_id`),
  CONSTRAINT `employee_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DELIMITER ;;
CREATE TRIGGER `insert_scheduleplanning` AFTER INSERT ON `employee` FOR EACH ROW
begin 
	declare currentyear int ;
    declare countyear int ; 
    declare endyear int ; 
	declare currentdate int ; 
	select YEAR(NOW()) into currentyear  ;
	select YEAR(NOW()) into countyear  ;
	select YEAR(NOW()) + 10  into endyear  ;
	select DATE_FORMAT( (NOW() ),"%Y%m%d") into currentdate ; 

	label1: while countyear <= endyear DO 
		INSERT INTO `planning` (`date`, `employee_id`,`schedule_id`,`vehicle_id`) VALUES (currentdate, NEW.person_id ,1,NULL) ;
		select DATE_FORMAT(DATE_ADD(currentdate, INTERVAL 1 DAY),"%Y%m%d") into currentdate ; 
		select left(DATE_FORMAT(currentdate,"%Y%m%d"),4) into countyear ; 
		
	END WHILE label1;
end;;

DELIMITER ;

DROP TABLE IF EXISTS `person`;
CREATE TABLE `person` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `last_update_at` datetime DEFAULT current_timestamp(),
  `last_update_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `planning`;
CREATE TABLE `planning` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `employee_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `last_update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_update_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `planning_ibfk_2` (`schedule_id`),
  KEY `planning_ibfk_3` (`vehicle_id`),
  KEY `planning_ibfk_4` (`last_update_user_id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `planning_ibfk_2` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`id`),
  CONSTRAINT `planning_ibfk_3` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`),
  CONSTRAINT `planning_ibfk_5` FOREIGN KEY (`last_update_user_id`) REFERENCES `user` (`person_id`),
  CONSTRAINT `planning_ibfk_6` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=264952 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE `schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `last_update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_update_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_schedule_name` (`name`),
  KEY `schedule_ibfk_1` (`last_update_user_id`),
  CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`last_update_user_id`) REFERENCES `user` (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `person_id` int(11) NOT NULL,
  `roles_json` text NOT NULL,
  `password` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  KEY `person_id` (`person_id`),
  CONSTRAINT `user_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `vehicle`;
CREATE TABLE `vehicle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `immat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `last_update_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_update_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniqueimat` (`immat`),
  KEY `idx_vehicle_name` (`name`),
  KEY `idx_vehicle_immat` (`immat`),
  KEY `vehicle_ibfk_1` (`last_update_user_id`),
  CONSTRAINT `vehicle_ibfk_1` FOREIGN KEY (`last_update_user_id`) REFERENCES `person` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 2021-04-23 12:26:32 -------------------------------


INSERT INTO `employee` (`person_id`, `name`, `firstname`, `adress`, `zipcode`, `city`, `phone`, `mobile_phone`, `internal`, `enter_date`, `end_date`) VALUES
(11,	'Bigot',	'Andréa',	'89 rue par la',	'97480',	'saint-joseph',	'06898568',	'64845486',	0,	'2021-04-23',	NULL),
(12,	'Hoareau',	'Quentin',	'10 rue machin truc',	'97480',	'Saint-Joseph',	'0262382425',	'0692186498',	1,	'2021-09-12',	'2016-01-01'),
(13,	'Ramin',	'Emmanuel',	'39 rue des la tête de turc',	'97429',	'Petit-Ile',	'0262382425',	'0692896498',	0,	'2020-09-12',	NULL),
(14,	'Bigot',	'Andréa',	'26 avenue des champs',	'97410',	'Vincendo',	'0262382425',	'0692286498',	1,	'2021-06-08',	NULL);


INSERT INTO `person` (`id`, `email`, `create_at`, `last_update_at`, `last_update_user_id`) VALUES
(1,	'quentin.h@gmail.com',	'2021-02-27 11:36:55',	'2021-02-27 11:36:55',	2),
(2,	'ramin.e@gmail.com',	'2021-02-27 11:36:55',	'2021-02-27 11:36:55',	2),
(3,	'simon@simon.fr',	'2021-03-06 04:20:49',	'2021-03-06 04:20:49',	12),
(11,	'tutu@tutu.fr',	'2021-03-05 12:42:47',	'2021-03-06 05:06:09',	12),
(12,	'emmanuel.ramin@lavarun.re',	'2021-03-06 03:11:47',	'2021-03-06 03:11:47',	NULL),
(13,	'test@test.fr',	'2021-03-06 03:29:44',	'2021-03-06 05:33:53',	12),
(14,	'tu@tu.tu',	'2021-03-06 04:19:00',	'2021-03-06 04:19:00',	12);

INSERT INTO `schedule` (`id`, `name`, `create_at`, `last_update_at`, `last_update_user_id`) VALUES
(1,	'Service',	'2021-02-27 11:36:55',	'2021-04-23 13:49:39',	1),
(8,	'Congé',	'2021-03-07 06:40:47',	'2021-04-23 13:25:58',	1),
(9,	'Maladie',	'2021-03-07 06:41:07',	'2021-04-23 13:25:58',	1),
(10,	'Repos',	'2021-03-07 06:43:16',	'2021-04-23 13:25:58',	1);


INSERT INTO `user` (`person_id`, `roles_json`, `password`, `username`) VALUES
(1,	'[\"ROLE_ADMIN\"]',	'$2y$13$hC0E8XtRw0R/ZFhLoXvkoOsrU4ZZPQFt0nLjmMFa/OMKjO3QNRveC',	'Quentin');

INSERT INTO `vehicle` (`id`, `name`, `immat`, `create_at`, `last_update_at`, `last_update_user_id`) VALUES
(1,	'Vehicule Default',	'XX-XXX-XX',	'2021-02-27 11:36:55',	'2021-02-27 11:36:55',	2),
(7,	'Ambulance Manu 2',	'BZ-966-AP',	'2021-02-28 16:48:17',	'2021-03-11 11:40:56',	13),
(8,	'WAZAA',	'BZ-966-',	'2021-02-28 17:05:32',	'2021-02-28 22:21:24',	NULL),
(12,	'Ambulance Manu',	'az-111-fr23',	'2021-02-28 21:26:46',	'2021-03-11 11:40:01',	13),
(14,	'sdsdsdsdsd',	'dfdfdfdfdf',	'2021-02-28 21:53:14',	'2021-02-28 17:53:14',	NULL),
(16,	'rererer V2',	'sdzaezet',	'2021-02-28 21:53:29',	'2021-03-02 03:57:40',	NULL),
(17,	'erererererer',	'ererererererererererer',	'2021-02-28 21:53:34',	'2021-03-06 05:38:21',	13),
(19,	'vcbvbx',	'xvcbxvbvcbvcb',	'2021-02-28 21:54:17',	'2021-02-28 17:54:17',	NULL),
(21,	'lklkljkl',	'kjlyioyiojkhj',	'2021-02-28 22:20:49',	'2021-02-28 18:20:49',	NULL),
(23,	'vbbvnvbnvbn',	'sdfrtykjg,nvn,',	'2021-03-02 03:57:57',	'2021-03-01 23:57:57',	1),
(24,	'Toto va a la peche',	'25 ZEP 86',	'2021-03-02 03:58:38',	'2021-03-01 23:58:38',	1),
(25,	'La voiture de Manu',	'fgfgfgfgfgrttrtrtrttr',	'2021-03-06 05:23:34',	'2021-03-06 05:34:29',	13),
(26,	'Vehicule Martial',	'BI-145-AZ',	'2021-03-08 12:09:18',	'2021-03-08 12:09:18',	13),
(27,	'Vehicule Manu25',	'BZ-AP966-',	'2021-03-11 11:28:37',	'2021-03-11 11:28:37',	13);
