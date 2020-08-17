
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_partner
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_partner`;


CREATE TABLE `st_partner`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`countries_id` INTEGER  NOT NULL,
	`sf_guard_user_id` INTEGER,
	`company` VARCHAR(255),
	`vat_number` VARCHAR(255),
	`bank_number` VARCHAR(255),
	`name` VARCHAR(255),
	`surname` VARCHAR(255),
	`street` VARCHAR(255),
	`house` VARCHAR(255),
	`flat` VARCHAR(255),
	`code` VARCHAR(255),
	`town` VARCHAR(255),
	`phone` VARCHAR(255),
	`description` TEXT,
	`provision` VARCHAR(255),
	`amount` VARCHAR(255),
	`system_value` INTEGER,
	`is_active` INTEGER default 1,
	`is_system` INTEGER default 0,
	`is_confirm` INTEGER default 0,
	PRIMARY KEY (`id`),
	INDEX `st_partner_FI_1` (`countries_id`),
	CONSTRAINT `st_partner_FK_1`
		FOREIGN KEY (`countries_id`)
		REFERENCES `st_countries` (`id`)
		ON DELETE RESTRICT,
	INDEX `st_partner_FI_2` (`sf_guard_user_id`),
	CONSTRAINT `st_partner_FK_2`
		FOREIGN KEY (`sf_guard_user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_partner_hash
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_partner_hash`;


CREATE TABLE `st_partner_hash`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`partner_id` INTEGER  NOT NULL,
	`hash` VARCHAR(255),
	PRIMARY KEY (`id`),
	INDEX `st_partner_hash_FI_1` (`partner_id`),
	CONSTRAINT `st_partner_hash_FK_1`
		FOREIGN KEY (`partner_id`)
		REFERENCES `st_partner` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
