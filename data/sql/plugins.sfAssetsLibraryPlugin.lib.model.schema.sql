
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- sf_asset_folder
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `sf_asset_folder`;


CREATE TABLE `sf_asset_folder`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`tree_left` INTEGER  NOT NULL,
	`tree_right` INTEGER  NOT NULL,
	`tree_parent` INTEGER,
	`tree_depth` INTEGER,
	`static_scope` INTEGER,
	`name` VARCHAR(255),
	`relative_path` VARCHAR(255),
	`is_enabled` INTEGER default 1,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	UNIQUE KEY `uk_relative_path` (`relative_path`),
	INDEX `sf_asset_folder_FI_1` (`tree_parent`),
	CONSTRAINT `sf_asset_folder_FK_1`
		FOREIGN KEY (`tree_parent`)
		REFERENCES `sf_asset_folder` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- sf_asset
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `sf_asset`;


CREATE TABLE `sf_asset`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`folder_id` INTEGER  NOT NULL,
	`filename` VARCHAR(255),
	`opt_description` TEXT,
	`author` VARCHAR(255),
	`copyright` VARCHAR(100),
	`type` VARCHAR(10),
	`filesize` DECIMAL(10,2),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	UNIQUE KEY `uk_folder_filename` (`folder_id`, `filename`),
	CONSTRAINT `sf_asset_FK_1`
		FOREIGN KEY (`folder_id`)
		REFERENCES `sf_asset_folder` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- sf_asset_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `sf_asset_i18n`;


CREATE TABLE `sf_asset_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`description` TEXT,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `sf_asset_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `sf_asset` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
