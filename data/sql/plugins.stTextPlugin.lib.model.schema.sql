
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_text
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_text`;


CREATE TABLE `st_text`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`system_name` VARCHAR(255),
	`is_system_default` INTEGER default 1,
	`active` INTEGER,
	`opt_name` VARCHAR(255),
	`opt_content` TEXT,
	PRIMARY KEY (`id`),
	KEY `text_system_name`(`system_name`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_text_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_text_i18n`;


CREATE TABLE `st_text_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`name` VARCHAR(255),
	`content` TEXT,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_text_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_text` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
