

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adress` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_phone` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `internal` tinyint(1) DEFAULT 0,
  `enter_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `create_at` datetime DEFAULT current_timestamp(),
  `last_update_at` datetime DEFAULT current_timestamp(),
  `last_update_user_id` int(11) DEFAULT NULL,
  `check_End_Date` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_employee_name` (`name`),
  KEY `employee_ibfk_1` (`last_update_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `employee`
--


--
-- Déclencheurs `employee`
--
DROP TRIGGER IF EXISTS `insert_scheduleplanning`;
DELIMITER $$
CREATE TRIGGER `insert_scheduleplanning` AFTER INSERT ON `employee` FOR EACH ROW begin 
	declare currentyear int ;
    declare countyear int ; 
    declare endyear int ; 
	declare currentdate int ; 
	select YEAR(NOW()) into currentyear  ;
	select YEAR(NOW()) into countyear  ;
	select YEAR(NOW()) + 10  into endyear  ;
	select DATE_FORMAT( (NOW() ),"%Y%m%d") into currentdate ; 

	label1: while countyear <= endyear DO 
		INSERT INTO `planning` (`date_schedule`, `employee_id`,`schedule_id`,`vehicle_id`,`last_update_user_id`) VALUES (currentdate, NEW.id ,1,1,2) ;
		select DATE_FORMAT(DATE_ADD(currentdate, INTERVAL 1 DAY),"%Y%m%d") into currentdate ; 
		select left(DATE_FORMAT(currentdate,"%Y%m%d"),4) into countyear ; 
		
	END WHILE label1;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `planning`
--

DROP TABLE IF EXISTS `planning`;
CREATE TABLE IF NOT EXISTS `planning` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_schedule` date NOT NULL,
  `employee_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `amplitude_start` time DEFAULT NULL,
  `amplitude_end` time DEFAULT NULL,
  `amplitude` time DEFAULT NULL,
  `extra_hour` time DEFAULT NULL,
  `time_work` time DEFAULT NULL,
  `vehicle_id` int(11) NOT NULL,
  `first_break_place` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_break_start` time DEFAULT NULL,
  `first_break_end` time DEFAULT NULL,
  `second_break_place` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `second_break_start` time DEFAULT NULL,
  `second_break_end` time DEFAULT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `last_update_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_update_user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `planning_ibfk_2` (`schedule_id`),
  KEY `planning_ibfk_3` (`vehicle_id`),
  KEY `planning_ibfk_4` (`last_update_user_id`),
  KEY `idx_scheduleplanning_dateschedule` (`employee_id`,`date_schedule`)
) ENGINE=InnoDB AUTO_INCREMENT=245427 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `planning`
--

-- --------------------------------------------------------

--
-- Structure de la table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_amplitude` time NOT NULL,
  `amplitude_coeff` double NOT NULL,
  `default_forced` tinyint(1) NOT NULL,
  `amplitude_start_extra` time DEFAULT NULL,
  `time_work` time NOT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `last_update_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_update_user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_schedule_name` (`name`),
  KEY `schedule_ibfk_1` (`last_update_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `schedule`
--


INSERT INTO `employee` (`id`, `name`, `firstname`, `adress`, `zipcode`, `city`, `phone`, `mobile_phone`, `email`, `internal`, `enter_date`, `end_date`, `create_at`, `last_update_at`, `last_update_user_id`, `check_End_Date`) VALUES
(1, 'USER1', 'EMMANUEL', '39 rue des la tête de turc', '97480', 'Vincendo', '02/62/32/24/25', '06 93 55 64 94', 'laurent.payet@gmail.com', 1, '2021-09-12', '2016-01-01', '2021-02-27 11:37:13', '2021-02-27 11:59:37', 2, 0),
(2, 'USER2', 'EMMANUEL', '39 rue des la tête de turc', '97480', 'Vincendo', '02/62/32/24/25', '06 93 55 64 94', 'laurent.payet@gmail.com', 1, '2021-09-12', NULL, '2021-02-27 11:37:54', '2021-02-27 11:37:54', 2, 0),
(3, 'USER3', 'EMMANUEL', '39 rue des la tête de turc', '97480', 'Vincendo', '02/62/32/24/25', '06 93 55 64 94', 'laurent.payet@gmail.com', 1, '2021-09-12', NULL, '2021-02-27 11:37:54', '2021-02-27 11:37:54', 2, 0),
(4, 'USER4', 'EMMANUEL', '39 rue des la tête de turc', '97480', 'Vincendo', '02/62/32/24/25', '06 93 55 64 94', 'laurent.payet@gmail.com', 1, '2021-09-12', NULL, '2021-02-27 11:37:55', '2021-02-27 11:37:55', 2, 0) ;



INSERT INTO `schedule` (`id`, `name`, `default_amplitude`, `amplitude_coeff`, `default_forced`, `amplitude_start_extra`, `time_work`, `create_at`, `last_update_at`, `last_update_user_id`) VALUES
(1, 'Horaire par défaut', '00:00:00', 1, 0, '00:00:00', '00:00:00', '2021-02-27 11:36:55', '2021-03-07 06:36:15', 2),
(6, 'Service', '08:00:00', 0.9, 0, '08:00:00', '07:12:00', '2021-03-07 06:26:06', '2021-03-07 06:40:07', 13),
(7, 'Permanence', '12:00:00', 0.9, 0, '12:00:00', '10:48:00', '2021-03-07 06:40:00', '2021-03-07 06:42:35', 13),
(8, 'Congé', '07:00:00', 1, 1, '07:00:00', '00:00:00', '2021-03-07 06:40:47', '2021-03-07 06:40:47', 13),
(9, 'Maladie', '00:00:00', 1, 1, '00:00:00', '00:00:00', '2021-03-07 06:41:07', '2021-03-07 06:41:07', 13),
(10, 'Repos', '00:00:00', 1, 1, '00:00:00', '00:00:00', '2021-03-07 06:43:16', '2021-03-07 06:43:16', 13);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--


CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles_json` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `last_update_at` datetime NOT NULL DEFAULT current_timestamp(),
  `last_update_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_user_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `username`, `password`, `roles_json`, `create_at`, `last_update_at`, `last_update_user_id`) VALUES
(1, 'quentin.h@gmail.com', 'Quentin', '$2y$13$uk.YQ78OfRz4i/RLU2YZR.e28m33ezLM84ex6o3j95YqWZbr4gmXG', '[\"ROLE_USER\" ,\"ROLE_ADMIN\"]', '2021-02-27 11:36:55', '2021-02-27 11:36:55', 2),
(2, 'ramin.e@gmail.com', 'Ramin', '$2y$13$uk.YQ78OfRz4i/RLU2YZR.e28m33ezLM84ex6o3j95YqWZbr4gmXG', '[\"ROLE_ADMIN\"]', '2021-02-27 11:36:55', '2021-02-27 11:36:55', 2),
(11, 'tutu@tutu.fr', 'tutu', '$2y$13$ovRY54ZPK7F7Kap/M9jg5OkwQ7hmiLgYI3LuLbElT1lYTCf92pOOq', '[\"ROLE_USER\"]', '2021-03-05 12:42:47', '2021-03-06 05:06:09', 12),
(12, 'emmanuel.ramin@lavarun.re', 'LAVARUN', '', '[\"ROLE_USER\" ,\"ROLE_ADMIN\"]', '2021-03-06 03:11:47', '2021-03-06 03:11:47', NULL),
(13, 'test@test.fr', 'test2', '$2y$13$10xVTnA.v8V/dwGDH9w1kOE.8EUfIVZ/KG/F0iCxT5NrXSsfRQD3C', '[\"ROLE_USER\" ,\"ROLE_ADMIN\"]', '2021-03-06 03:29:44', '2021-03-06 05:33:53', 12),
(14, 'tu@tu.tu', 'zze', '$2y$13$WC02cKVZVEbWp7/At/CPRuRtzoR2tBfOns/yD13yEysRhLbWtZFne', '[\"ROLE_USER\"]', '2021-03-06 04:19:00', '2021-03-06 04:19:00', 12),
(15, 'simon@simon.fr', 'simon', '$2y$13$hC0E8XtRw0R/ZFhLoXvkoOsrU4ZZPQFt0nLjmMFa/OMKjO3QNRveC', '[\"ROLE_USER\"]', '2021-03-06 04:20:49', '2021-03-06 04:20:49', 12);

-- --------------------------------------------------------

--
-- Structure de la table `vehicle`
--

DROP TABLE IF EXISTS `vehicle`;
CREATE TABLE IF NOT EXISTS `vehicle` (
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
  KEY `vehicle_ibfk_1` (`last_update_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `vehicle`
--

INSERT INTO `vehicle` (`id`, `name`, `immat`, `create_at`, `last_update_at`, `last_update_user_id`) VALUES
(1, 'Vehicule Default', 'XX-XXX-XX', '2021-02-27 11:36:55', '2021-02-27 11:36:55', 2),
(7, 'Ambulance Manu 2', 'BZ-966-AP', '2021-02-28 16:48:17', '2021-03-11 11:40:56', 13),
(8, 'WAZAA', 'BZ-966-', '2021-02-28 17:05:32', '2021-02-28 22:21:24', NULL),
(12, 'Ambulance Manu', 'az-111-fr23', '2021-02-28 21:26:46', '2021-03-11 11:40:01', 13),
(14, 'sdsdsdsdsd', 'dfdfdfdfdf', '2021-02-28 21:53:14', '2021-02-28 17:53:14', NULL),
(16, 'rererer V2', 'sdzaezet', '2021-02-28 21:53:29', '2021-03-02 03:57:40', NULL),
(17, 'erererererer', 'ererererererererererer', '2021-02-28 21:53:34', '2021-03-06 05:38:21', 13),
(19, 'vcbvbx', 'xvcbxvbvcbvcb', '2021-02-28 21:54:17', '2021-02-28 17:54:17', NULL),
(21, 'lklkljkl', 'kjlyioyiojkhj', '2021-02-28 22:20:49', '2021-02-28 18:20:49', NULL),
(23, 'vbbvnvbnvbn', 'sdfrtykjg,nvn,', '2021-03-02 03:57:57', '2021-03-01 23:57:57', 1),
(24, 'Toto va a la peche', '25 ZEP 86', '2021-03-02 03:58:38', '2021-03-01 23:58:38', 1),
(25, 'La voiture de Manu', 'fgfgfgfgfgrttrtrtrttr', '2021-03-06 05:23:34', '2021-03-06 05:34:29', 13),
(26, 'Vehicule Martial', 'BI-145-AZ', '2021-03-08 12:09:18', '2021-03-08 12:09:18', 13),
(27, 'Vehicule Manu25', 'BZ-AP966-', '2021-03-11 11:28:37', '2021-03-11 11:28:37', 13);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`last_update_user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `planning`
--
ALTER TABLE `planning`
  ADD CONSTRAINT `planning_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`),
  ADD CONSTRAINT `planning_ibfk_2` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`id`),
  ADD CONSTRAINT `planning_ibfk_3` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`),
  ADD CONSTRAINT `planning_ibfk_4` FOREIGN KEY (`last_update_user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`last_update_user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `vehicle`
--
ALTER TABLE `vehicle`
  ADD CONSTRAINT `vehicle_ibfk_1` FOREIGN KEY (`last_update_user_id`) REFERENCES `user` (`id`);
COMMIT;


