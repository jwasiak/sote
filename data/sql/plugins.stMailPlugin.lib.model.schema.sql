
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_mail_smtp_profile
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_mail_smtp_profile`;


CREATE TABLE `st_mail_smtp_profile`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255)  NOT NULL,
	`host` VARCHAR(255)  NOT NULL,
	`port` INTEGER default 25 NOT NULL,
	`enc_type` VARCHAR(7),
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_mail_account
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_mail_account`;


CREATE TABLE `st_mail_account`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`mail_smtp_profile_id` INTEGER  NOT NULL,
	`version` INTEGER default 1,
	`username` VARCHAR(255)  NOT NULL,
	`password` VARCHAR(255),
	`email` VARCHAR(255)  NOT NULL,
	`is_default` INTEGER default 0,
	`is_newsletter` INTEGER default 0,
	`name` VARCHAR(255),
	PRIMARY KEY (`id`),
	INDEX `st_mail_account_FI_1` (`mail_smtp_profile_id`),
	CONSTRAINT `st_mail_account_FK_1`
		FOREIGN KEY (`mail_smtp_profile_id`)
		REFERENCES `st_mail_smtp_profile` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_mail_description
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_mail_description`;


CREATE TABLE `st_mail_description`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`system_name` VARCHAR(255),
	`opt_name` VARCHAR(255),
	`opt_description` TEXT,
	`is_active` INTEGER default 0,
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_mail_description_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_mail_description_i18n`;


CREATE TABLE `st_mail_description_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`description` TEXT,
	`name` VARCHAR(255),
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_mail_description_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_mail_description` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
