
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_availability
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_availability`;


CREATE TABLE `st_availability`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`sf_asset_id` INTEGER,
	`stock_from` DECIMAL(8,2),
	`is_system_default` INTEGER,
	`opt_availability_name` TEXT,
	`color` VARCHAR(6),
	`image` VARCHAR(255),
	PRIMARY KEY (`id`),
	INDEX `st_availability_FI_1` (`sf_asset_id`),
	CONSTRAINT `st_availability_FK_1`
		FOREIGN KEY (`sf_asset_id`)
		REFERENCES `sf_asset` (`id`)
		ON DELETE SET NULL
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_availability_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_availability_i18n`;


CREATE TABLE `st_availability_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`availability_name` VARCHAR(255),
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_availability_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_availability` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
