
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_newsletter_user
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_newsletter_user`;


CREATE TABLE `st_newsletter_user`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`sf_guard_user_id` INTEGER,
	`email` VARCHAR(255),
	`active` INTEGER default 1,
	`confirm` INTEGER default 0,
	`hash` VARCHAR(255),
	`language` VARCHAR(255),
	PRIMARY KEY (`id`),
	INDEX `st_newsletter_user_FI_1` (`sf_guard_user_id`),
	CONSTRAINT `st_newsletter_user_FK_1`
		FOREIGN KEY (`sf_guard_user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE SET NULL
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_newsletter_group
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_newsletter_group`;


CREATE TABLE `st_newsletter_group`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`opt_name` VARCHAR(255),
	`opt_description` TEXT,
	`shortcut` VARCHAR(255),
	`is_public` INTEGER,
	`is_default` INTEGER,
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_newsletter_message
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_newsletter_message`;


CREATE TABLE `st_newsletter_message`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`opt_subject` VARCHAR(255)  NOT NULL,
	`opt_content` LONGTEXT,
	`sent_at` DATETIME,
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_newsletter_user_has_newsletter_group
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_newsletter_user_has_newsletter_group`;


CREATE TABLE `st_newsletter_user_has_newsletter_group`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`newsletter_group_id` INTEGER  NOT NULL,
	`newsletter_user_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `st_newsletter_user_has_newsletter_group_FI_1` (`newsletter_group_id`),
	CONSTRAINT `st_newsletter_user_has_newsletter_group_FK_1`
		FOREIGN KEY (`newsletter_group_id`)
		REFERENCES `st_newsletter_group` (`id`)
		ON DELETE CASCADE,
	INDEX `st_newsletter_user_has_newsletter_group_FI_2` (`newsletter_user_id`),
	CONSTRAINT `st_newsletter_user_has_newsletter_group_FK_2`
		FOREIGN KEY (`newsletter_user_id`)
		REFERENCES `st_newsletter_user` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_newsletter_message_has_newsletter_group
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_newsletter_message_has_newsletter_group`;


CREATE TABLE `st_newsletter_message_has_newsletter_group`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`newsletter_message_id` INTEGER  NOT NULL,
	`newsletter_group_id` INTEGER  NOT NULL,
	PRIMARY KEY (`newsletter_message_id`,`newsletter_group_id`),
	CONSTRAINT `st_newsletter_message_has_newsletter_group_FK_1`
		FOREIGN KEY (`newsletter_message_id`)
		REFERENCES `st_newsletter_message` (`id`)
		ON DELETE RESTRICT,
	INDEX `st_newsletter_message_has_newsletter_group_FI_2` (`newsletter_group_id`),
	CONSTRAINT `st_newsletter_message_has_newsletter_group_FK_2`
		FOREIGN KEY (`newsletter_group_id`)
		REFERENCES `st_newsletter_group` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_newsletter_group_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_newsletter_group_i18n`;


CREATE TABLE `st_newsletter_group_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`name` VARCHAR(255),
	`description` VARCHAR(255),
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_newsletter_group_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_newsletter_group` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_newsletter_message_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_newsletter_message_i18n`;


CREATE TABLE `st_newsletter_message_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`subject` VARCHAR(255),
	`content` LONGTEXT,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_newsletter_message_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_newsletter_message` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
