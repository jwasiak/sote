
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_export_md5_hash
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_export_md5_hash`;


CREATE TABLE `st_export_md5_hash`
(
	`id` INTEGER  NOT NULL,
	`type_id` INTEGER  NOT NULL,
	`md5hash` VARCHAR(8192),
	PRIMARY KEY (`id`,`type_id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_export_profile
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_export_profile`;


CREATE TABLE `st_export_profile`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255),
	`model` VARCHAR(255),
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_export_field
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_export_field`;


CREATE TABLE `st_export_field`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`field` VARCHAR(255),
	`model` VARCHAR(255),
	`is_key` INTEGER,
	`name` VARCHAR(255),
	`i18n_file` VARCHAR(255),
	`i18n` INTEGER,
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_export_profile_has_export_field
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_export_profile_has_export_field`;


CREATE TABLE `st_export_profile_has_export_field`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`export_profile_id` INTEGER  NOT NULL,
	`export_field_id` INTEGER  NOT NULL,
	PRIMARY KEY (`export_profile_id`,`export_field_id`),
	CONSTRAINT `st_export_profile_has_export_field_FK_1`
		FOREIGN KEY (`export_profile_id`)
		REFERENCES `st_export_profile` (`id`)
		ON DELETE RESTRICT,
	INDEX `st_export_profile_has_export_field_FI_2` (`export_field_id`),
	CONSTRAINT `st_export_profile_has_export_field_FK_2`
		FOREIGN KEY (`export_field_id`)
		REFERENCES `st_export_field` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
