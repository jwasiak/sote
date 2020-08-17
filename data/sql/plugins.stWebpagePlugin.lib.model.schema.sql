
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_webpage
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_webpage`;


CREATE TABLE `st_webpage`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`active` INTEGER default 1,
	`opt_name` VARCHAR(255),
	`opt_content` LONGTEXT,
	`opt_url` VARCHAR(255),
	`state` VARCHAR(255),
	PRIMARY KEY (`id`),
	KEY `webpage_url`(`opt_url`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_webpage_group
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_webpage_group`;


CREATE TABLE `st_webpage_group`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`opt_name` VARCHAR(255),
	`group_page` VARCHAR(255),
	`show_footer` INTEGER,
	`show_header` INTEGER,
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_webpage_group_has_webpage
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_webpage_group_has_webpage`;


CREATE TABLE `st_webpage_group_has_webpage`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`webpage_id` INTEGER  NOT NULL,
	`webpage_group_id` INTEGER  NOT NULL,
	`rank` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `st_webpage_group_has_webpage_FI_1` (`webpage_id`),
	CONSTRAINT `st_webpage_group_has_webpage_FK_1`
		FOREIGN KEY (`webpage_id`)
		REFERENCES `st_webpage` (`id`)
		ON DELETE CASCADE,
	INDEX `st_webpage_group_has_webpage_FI_2` (`webpage_group_id`),
	CONSTRAINT `st_webpage_group_has_webpage_FK_2`
		FOREIGN KEY (`webpage_group_id`)
		REFERENCES `st_webpage_group` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_webpage_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_webpage_i18n`;


CREATE TABLE `st_webpage_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`name` VARCHAR(255),
	`content` LONGTEXT,
	`url` VARCHAR(255),
	`other_link` VARCHAR(255),
	`target` INTEGER,
	PRIMARY KEY (`id`,`culture`),
	KEY `webpage_Index1`(`url`, `culture`),
	CONSTRAINT `st_webpage_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_webpage` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_webpage_group_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_webpage_group_i18n`;


CREATE TABLE `st_webpage_group_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`name` VARCHAR(255),
	PRIMARY KEY (`id`,`culture`),
	KEY `webpage_group_Index1`(`culture`),
	CONSTRAINT `st_webpage_group_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_webpage_group` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
