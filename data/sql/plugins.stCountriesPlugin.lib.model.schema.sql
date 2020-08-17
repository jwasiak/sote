
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_countries
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_countries`;


CREATE TABLE `st_countries`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`iso_a2` CHAR(2),
	`iso_a3` CHAR(3),
	`continent` TEXT,
	`number` VARCHAR(3),
	`opt_name` VARCHAR(255),
	`is_active` INTEGER default 0,
	`is_default` INTEGER default 0,
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_countries_area
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_countries_area`;


CREATE TABLE `st_countries_area`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255),
	`is_active` INTEGER default 0,
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_countries_area_has_countries
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_countries_area_has_countries`;


CREATE TABLE `st_countries_area_has_countries`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`countries_id` INTEGER  NOT NULL,
	`countries_area_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `st_countries_area_has_countries_FI_1` (`countries_id`),
	CONSTRAINT `st_countries_area_has_countries_FK_1`
		FOREIGN KEY (`countries_id`)
		REFERENCES `st_countries` (`id`)
		ON DELETE CASCADE,
	INDEX `st_countries_area_has_countries_FI_2` (`countries_area_id`),
	CONSTRAINT `st_countries_area_has_countries_FK_2`
		FOREIGN KEY (`countries_area_id`)
		REFERENCES `st_countries_area` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_countries_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_countries_i18n`;


CREATE TABLE `st_countries_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`name` VARCHAR(255),
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_countries_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_countries` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
