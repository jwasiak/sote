
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- app_online_codes
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `app_online_codes`;


CREATE TABLE `app_online_codes`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`product_id` INTEGER,
	`name` VARCHAR(255),
	`code` VARCHAR(255)  NOT NULL,
	`usage_limit` INTEGER,
	`used` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `app_online_codes_FI_1` (`product_id`),
	CONSTRAINT `app_online_codes_FK_1`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- app_online_files
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `app_online_files`;


CREATE TABLE `app_online_files`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`product_id` INTEGER  NOT NULL,
	`name` VARCHAR(255),
	`filename` VARCHAR(255),
	`media_type` VARCHAR(20),
	PRIMARY KEY (`id`),
	INDEX `app_online_files_FI_1` (`product_id`),
	CONSTRAINT `app_online_files_FK_1`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
