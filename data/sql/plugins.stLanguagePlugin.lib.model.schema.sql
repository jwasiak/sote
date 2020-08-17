
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_language
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_language`;


CREATE TABLE `st_language`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`currency_id` INTEGER default 0,
	`active_image` VARCHAR(36),
	`inactive_image` VARCHAR(36),
	`shortcut` VARCHAR(3),
	`is_default` INTEGER default 0,
	`active` INTEGER default 1,
	`language` VARCHAR(10),
	`is_translate` INTEGER default 0,
	`system` INTEGER default 0 NOT NULL,
	`is_default_panel` INTEGER,
	`is_translate_panel` INTEGER,
	`opt_name` VARCHAR(255),
	PRIMARY KEY (`id`),
	INDEX `st_language_FI_1` (`currency_id`),
	CONSTRAINT `st_language_FK_1`
		FOREIGN KEY (`currency_id`)
		REFERENCES `st_currency` (`id`)
		ON DELETE SET NULL
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_language_has_domain
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_language_has_domain`;


CREATE TABLE `st_language_has_domain`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`language_id` INTEGER  NOT NULL,
	`domain` VARCHAR(255),
	`is_default` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `st_language_has_domain_FI_1` (`language_id`),
	CONSTRAINT `st_language_has_domain_FK_1`
		FOREIGN KEY (`language_id`)
		REFERENCES `st_language` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_translation_cache
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_translation_cache`;


CREATE TABLE `st_translation_cache`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`language_id` INTEGER  NOT NULL,
	`catalogue` VARCHAR(100),
	`catalogue_index` VARCHAR(8),
	`value` TEXT,
	PRIMARY KEY (`id`),
	INDEX `st_translation_cache_FI_1` (`language_id`),
	CONSTRAINT `st_translation_cache_FK_1`
		FOREIGN KEY (`language_id`)
		REFERENCES `st_language` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_language_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_language_i18n`;


CREATE TABLE `st_language_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`name` VARCHAR(255),
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_language_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_language` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
