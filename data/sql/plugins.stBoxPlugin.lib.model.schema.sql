
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_box
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_box`;


CREATE TABLE `st_box`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`box_group_id` INTEGER  NOT NULL,
	`active` INTEGER,
	`opt_name` VARCHAR(255),
	`opt_content` TEXT,
	`show_title` INTEGER,
	`webmaster_id` VARCHAR(255),
	PRIMARY KEY (`id`),
	INDEX `st_box_FI_1` (`box_group_id`),
	CONSTRAINT `st_box_FK_1`
		FOREIGN KEY (`box_group_id`)
		REFERENCES `st_box_group` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_box_group
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_box_group`;


CREATE TABLE `st_box_group`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`opt_name` VARCHAR(255),
	`box_group` VARCHAR(45),
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_box_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_box_i18n`;


CREATE TABLE `st_box_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`name` VARCHAR(255),
	`content` TEXT,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_box_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_box` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_box_group_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_box_group_i18n`;


CREATE TABLE `st_box_group_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`name` VARCHAR(255),
	PRIMARY KEY (`id`,`culture`),
	KEY `box_group_Index1`(`culture`),
	CONSTRAINT `st_box_group_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_box_group` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
