
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_trust
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_trust`;


CREATE TABLE `st_trust`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`product_id` INTEGER  NOT NULL,
	`field_on` INTEGER default 0,
	`field_f_on` INTEGER default 0,
	`field_s_on` INTEGER default 0,
	`field_t_on` INTEGER default 0,
	PRIMARY KEY (`id`),
	INDEX `st_trust_FI_1` (`product_id`),
	CONSTRAINT `st_trust_FK_1`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_trust_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_trust_i18n`;


CREATE TABLE `st_trust_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`field_description` TEXT,
	`field_label_f` VARCHAR(255),
	`field_sub_label_f` VARCHAR(255),
	`field_description_f` TEXT,
	`icon_f` VARCHAR(255),
	`field_label_s` VARCHAR(255),
	`field_sub_label_s` VARCHAR(255),
	`field_description_s` TEXT,
	`icon_s` VARCHAR(255),
	`field_label_t` VARCHAR(255),
	`field_sub_label_t` VARCHAR(255),
	`field_description_t` TEXT,
	`icon_t` VARCHAR(255),
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_trust_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_trust` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
