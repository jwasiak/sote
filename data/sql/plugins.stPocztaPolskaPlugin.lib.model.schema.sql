
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_poczta_polska_punkt_odbioru
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_poczta_polska_punkt_odbioru`;


CREATE TABLE `st_poczta_polska_punkt_odbioru`
(
	`order_id` INTEGER  NOT NULL,
	`pni` VARCHAR(16),
	`type` VARCHAR(16),
	`name` VARCHAR(64),
	`description` VARCHAR(512),
	`phone` VARCHAR(128),
	`street` VARCHAR(100),
	`city` VARCHAR(64),
	`zip_code` VARCHAR(16),
	`province` VARCHAR(45),
	`ekspres24` INTEGER,
	`kurier48` INTEGER,
	`paczka_ekstra24` INTEGER,
	PRIMARY KEY (`order_id`),
	CONSTRAINT `st_poczta_polska_punkt_odbioru_FK_1`
		FOREIGN KEY (`order_id`)
		REFERENCES `st_order` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_poczta_polska_paczka
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_poczta_polska_paczka`;


CREATE TABLE `st_poczta_polska_paczka`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`order_id` INTEGER  NOT NULL,
	`guid` CHAR(32)  NOT NULL,
	`numer_nadania` VARCHAR(20),
	`envelope_id` INTEGER,
	`bufor_id` INTEGER,
	`parameters` VARCHAR(8192),
	PRIMARY KEY (`id`),
	INDEX `st_poczta_polska_paczka_FI_1` (`order_id`),
	CONSTRAINT `st_poczta_polska_paczka_FK_1`
		FOREIGN KEY (`order_id`)
		REFERENCES `st_order` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_poczta_polska_bufor
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_poczta_polska_bufor`;


CREATE TABLE `st_poczta_polska_bufor`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`bufor_id` INTEGER,
	`urzad_nadania` INTEGER  NOT NULL,
	`data_nadania` DATE  NOT NULL,
	PRIMARY KEY (`id`)
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
