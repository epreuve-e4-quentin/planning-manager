@ -0,0 +1,268 @@

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `roles_json` tinytext NOT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, -- le datetime de creation ne doit pas être modifié à chaque creation 
  `last_update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_update_user_id` int NOT NULL ,
  PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

ALTER TABLE user ADD INDEX idx_user_username (`username`);


DROP TABLE IF EXISTS `schedule`;
CREATE TABLE `schedule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `default_amplitude` time NOT NULL,
  `amplitude_coeff` DOUBLE PRECISION NOT NULL,
  `default_forced` tinyint(1) NOT NULL,
  `amplitude_start_extra` time DEFAULT NULL,
  `time_work` time NOT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, -- le datetime de creation ne doit pas être modifié à chaque creation 
  `last_update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_update_user_id` int NOT NULL ,
  PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

ALTER TABLE schedule ADD INDEX idx_schedule_name (`name`);
ALTER TABLE schedule ADD CONSTRAINT schedule_ibfk_1    FOREIGN KEY (`last_update_user_id`) REFERENCES user (`id`);



DROP TABLE IF EXISTS `vehicle`;
CREATE TABLE `vehicle` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `immat` varchar(255) DEFAULT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, -- le datetime de creation ne doit pas être modifié à chaque creation 
  `last_update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_update_user_id` int NOT NULL ,
  PRIMARY KEY (`id`), UNIQUE `uniqueimat` (`immat`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

ALTER TABLE vehicle ADD INDEX idx_vehicle_name (`name`);
ALTER TABLE vehicle ADD INDEX idx_vehicle_immat (`immat`);
ALTER TABLE vehicle ADD CONSTRAINT vehicle_ibfk_1    FOREIGN KEY (`last_update_user_id`) REFERENCES user (`id`);



DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `firstname` varchar(255)  DEFAULT NULL,
  `adress` varchar(255)  DEFAULT NULL,
  `zipcode` varchar(255)  DEFAULT NULL,
  `city` varchar(255)  DEFAULT NULL,
  `phone` varchar(25)  DEFAULT NULL,
  `mobile_phone` varchar(25)  DEFAULT NULL,
  `email` varchar(255)  DEFAULT NULL,
  `internal` boolean not null default 0,
  `enter_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, -- le datetime de creation ne doit pas être modifié à chaque creation 
  `last_update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_update_user_id` int NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

ALTER TABLE employee ADD INDEX idx_employee_name (`name`);
ALTER TABLE employee ADD CONSTRAINT employee_ibfk_1    FOREIGN KEY (`last_update_user_id`) REFERENCES user (`id`);




DROP TABLE IF EXISTS `planning`;
CREATE TABLE `planning` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_schedule` date NOT NULL,
  `employee_id` int NOT NULL,
  `schedule_id` int NOT NULL,
  `amplitude_start` time DEFAULT NULL,
  `amplitude_end` time DEFAULT NULL,
  `amplitude` time DEFAULT NULL,
  `extra_hour` time DEFAULT NULL,
  `work_time` time DEFAULT NULL,
  `vehicle_id` int NOT NULL,
  `first_break_place` varchar(255)  DEFAULT NULL,
  `first_break_start` time DEFAULT NULL,
  `first_break_end` time DEFAULT NULL,
  `second_break_place` varchar(255)  DEFAULT NULL,
  `second_break_start` time DEFAULT NULL,
  `second_break_end` time DEFAULT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP , -- le datetime de creation ne doit pas être modifié à chaque creation 
  `last_update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_update_user_id` int NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;



ALTER TABLE planning ADD CONSTRAINT planning_ibfk_1    FOREIGN KEY (`employee_id`) REFERENCES employee (`id`);
ALTER TABLE planning ADD CONSTRAINT planning_ibfk_2     FOREIGN KEY (`schedule_id`) REFERENCES schedule (`id`);
ALTER TABLE planning ADD CONSTRAINT planning_ibfk_3     FOREIGN KEY (`vehicle_id`) REFERENCES vehicle (`id`);
ALTER TABLE planning ADD CONSTRAINT planning_ibfk_4    FOREIGN KEY (`last_update_user_id`) REFERENCES user (`id`);

ALTER TABLE planning ADD INDEX idx_scheduleplanning_dateschedule (`employee_id`,`date_schedule`);

-- Triger sur la table employee pour créer toutes les lignes de calendrier pour les 10 prochaines années 
delimiter $$
create trigger insert_scheduleplanning
AFTER insert on employee 
for each row 
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
		INSERT INTO `planning` (`date_schedule`, `employee_id`,`schedule_id`,`vehicle_id`,`last_update_user_id`) VALUES (currentdate, NEW.id ,1,1,2) ;
		select DATE_FORMAT(DATE_ADD(currentdate, INTERVAL 1 DAY),"%Y%m%d") into currentdate ; 
		select left(DATE_FORMAT(currentdate,"%Y%m%d"),4) into countyear ; 
		
	END WHILE label1;
end$$
delimiter ;


-- Insertion de valeur par defaut ils devront être ignorés en production dans les affichages 

INSERT INTO `user` (`email`, `username`, `password`, `roles_json`,`last_update_user_id`) VALUES
('quentin.h@gmail.com',	'Quentin',	'$2y$13$uk.YQ78OfRz4i/RLU2YZR.e28m33ezLM84ex6o3j95YqWZbr4gmXG',	'[\"ROLE_TEST\" ,\"ROLE_ADMIN\"]',2),
('ramin.e@gmail.com',	'Ramin',	'$2y$13$uk.YQ78OfRz4i/RLU2YZR.e28m33ezLM84ex6o3j95YqWZbr4gmXG',	'[\"ROLE_ADMIN\"]',2) ;

INSERT INTO `schedule` (`name`, `default_amplitude`, `amplitude_coeff`, `default_forced`, `amplitude_start_extra`, `time_work`,`last_update_user_id`) VALUES
('Horaire DEFAULT',	'00:00:00',	1,	1,'00:00:00','00:00:00',2	);

INSERT INTO `vehicle` (`name`, `immat`,`last_update_user_id`) VALUES
('Vehicule Default',	'XX-XXX-XX',2);