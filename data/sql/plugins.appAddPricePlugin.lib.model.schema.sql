
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- app_add_price
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `app_add_price`;


CREATE TABLE `app_add_price`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL,
	`currency_id` INTEGER  NOT NULL,
	`tax_id` INTEGER,
	`opt_vat` DECIMAL(10,2),
	`price_netto` DECIMAL(10,2) default 0 NOT NULL,
	`price_brutto` DECIMAL(10,2) default 0 NOT NULL,
	`old_price_netto` DECIMAL(10,2) default 0 NOT NULL,
	`old_price_brutto` DECIMAL(10,2) default 0 NOT NULL,
	`wholesale_a_netto` DECIMAL(10,2) default 0 NOT NULL,
	`wholesale_a_brutto` DECIMAL(10,2) default 0 NOT NULL,
	`wholesale_b_netto` DECIMAL(10,2) default 0 NOT NULL,
	`wholesale_b_brutto` DECIMAL(10,2) default 0 NOT NULL,
	`wholesale_c_netto` DECIMAL(10,2) default 0 NOT NULL,
	`wholesale_c_brutto` DECIMAL(10,2) default 0 NOT NULL,
	PRIMARY KEY (`id`,`currency_id`),
	CONSTRAINT `app_add_price_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_product` (`id`)
		ON DELETE CASCADE,
	INDEX `app_add_price_FI_2` (`currency_id`),
	CONSTRAINT `app_add_price_FK_2`
		FOREIGN KEY (`currency_id`)
		REFERENCES `st_currency` (`id`)
		ON DELETE CASCADE,
	INDEX `app_add_price_FI_3` (`tax_id`),
	CONSTRAINT `app_add_price_FK_3`
		FOREIGN KEY (`tax_id`)
		REFERENCES `st_tax` (`id`)
		ON DELETE SET NULL
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- app_add_group_price
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `app_add_group_price`;


CREATE TABLE `app_add_group_price`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL,
	`currency_id` INTEGER  NOT NULL,
	`tax_id` INTEGER,
	`opt_vat` DECIMAL(10,2),
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
	PRIMARY KEY (`id`,`currency_id`),
	CONSTRAINT `app_add_group_price_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_group_price` (`id`)
		ON DELETE CASCADE,
	INDEX `app_add_group_price_FI_2` (`currency_id`),
	CONSTRAINT `app_add_group_price_FK_2`
		FOREIGN KEY (`currency_id`)
		REFERENCES `st_currency` (`id`)
		ON DELETE CASCADE,
	INDEX `app_add_group_price_FI_3` (`tax_id`),
	CONSTRAINT `app_add_group_price_FK_3`
		FOREIGN KEY (`tax_id`)
		REFERENCES `st_tax` (`id`)
		ON DELETE SET NULL
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
