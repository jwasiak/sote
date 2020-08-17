
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_currency
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_currency`;


CREATE TABLE `st_currency`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`currency_standard_id` INTEGER,
	`shortcut` VARCHAR(20),
	`exchange` DECIMAL(6,4),
	`active` INTEGER,
	`main` INTEGER,
	`front_symbol` VARCHAR(20),
	`back_symbol` VARCHAR(20),
	`nbp_exchange` FLOAT,
	`system` INTEGER,
	`opt_name` VARCHAR(255),
	PRIMARY KEY (`id`),
	INDEX `st_currency_FI_1` (`currency_standard_id`),
	CONSTRAINT `st_currency_FK_1`
		FOREIGN KEY (`currency_standard_id`)
		REFERENCES `st_currency_standard` (`id`)
		ON DELETE SET NULL
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_currency_standard
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_currency_standard`;


CREATE TABLE `st_currency_standard`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`code` INTEGER,
	`shortcut` VARCHAR(20),
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_currency_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_currency_i18n`;


CREATE TABLE `st_currency_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`name` VARCHAR(64),
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_currency_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_currency` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
