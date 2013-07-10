DROP TABLE IF EXISTS `province`;
CREATE  TABLE `machineBill`.`province` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `provinceName` VARCHAR(45)  NOT NULL ,
  `serverPlanNumber` SMALLINT UNSIGNED NOT NULL ,
  `serverActualNumber` SMALLINT UNSIGNED NOT NULL ,
  `remarks` VARCHAR(10000) NOT NULL ,
  PRIMARY KEY (`id`, `provinceName`),
  UNIQUE INDEX `provinceName_UNIQUE` (`provinceName` ASC))
DEFAULT CHARACTER SET = utf8;

DROP TABLE IF EXISTS `serverMachine`;
CREATE  TABLE `machineBill`.`serverMachine` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `serverNumber` SMALLINT UNSIGNED NOT NULL ,
  `area` VARCHAR(300) NOT NULL ,
  `ip` VARCHAR(45) NOT NULL ,
  `ping` TINYINT(1)  NOT NULL ,
  `login` TINYINT(1)  NOT NULL ,
  `proxylogin` TINYINT(1)  NOT NULL ,
  `eth` VARCHAR(10000) NOT NULL ,
  `remarks` VARCHAR(10000) NOT NULL ,
  `provinceID` INT NOT NULL ,
  PRIMARY KEY (`id`) )
DEFAULT CHARACTER SET = utf8;

DROP TABLE IF EXISTS `history`;
CREATE  TABLE `machineBill`.`history` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `time` DATETIME default '0000-00-00 00:00:00',
  `nickname` VARCHAR(45) NOT NULL ,
  `operate` VARCHAR(10000) NOT NULL ,
  PRIMARY KEY (`id`) )
DEFAULT CHARACTER SET = utf8;


DROP TABLE IF EXISTS `users`;
CREATE  TABLE `machineBill`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `userName` VARCHAR(100) NOT NULL ,
  `userPassword` VARCHAR(100) NOT NULL ,
  `nickname` VARCHAR(45) NOT NULL ,
  `lastlogin` datetime default '0000-00-00 00:00:00',
   PRIMARY KEY (`id`),
   UNIQUE INDEX `userName_UNIQUE` (`userName` ASC))
DEFAULT CHARACTER SET = utf8;


LOCK TABLES `users` WRITE;
INSERT INTO `machineBill`.`users` (`userName`, `userPassword`, `nickname`) VALUES ('leo', '1qazxsw2', '刘磊');
UNLOCK TABLES;








