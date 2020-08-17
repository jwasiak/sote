
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_group_price
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_group_price`;


CREATE TABLE `st_group_price`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255),
	`description` VARCHAR(255),
	`tax_id` INTEGER,
	`opt_vat` DECIMAL(10,2),
	`currency_id` INTEGER,
	`price_netto` DECIMAL(10,2),
	`price_brutto` DECIMAL(10,2),
	`old_price_netto` DECIMAL(10,2),
	`old_price_brutto` DECIMAL(10,2),
	`wholesale_a_netto` DECIMAL(10,2),
	`wholesale_a_brutto` DECIMAL(10,2),
	`wholesale_b_netto` DECIMAL(10,2),
	`wholesale_b_brutto` DECIMAL(10,2),
	`wholesale_c_netto` DECIMAL(10,2),
	`wholesale_c_brutto` DECIMAL(10,2),
	PRIMARY KEY (`id`),
	INDEX `st_group_price_FI_1` (`tax_id`),
	CONSTRAINT `st_group_price_FK_1`
		FOREIGN KEY (`tax_id`)
		REFERENCES `st_tax` (`id`)
		ON DELETE SET NULL,
	INDEX `st_group_price_FI_2` (`currency_id`),
	CONSTRAINT `st_group_price_FK_2`
		FOREIGN KEY (`currency_id`)
		REFERENCES `st_currency` (`id`)
		ON DELETE SET NULL
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
