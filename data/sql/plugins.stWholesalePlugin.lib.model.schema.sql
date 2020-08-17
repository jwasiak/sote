
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_product_has_wholesale
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_has_wholesale`;


CREATE TABLE `st_product_has_wholesale`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`product_id` INTEGER  NOT NULL,
	`price_a` DECIMAL(10,2),
	`price_b` DECIMAL(10,2),
	`price_c` DECIMAL(10,2),
	`opt_price_brutto_a` DECIMAL(10,2),
	`opt_price_brutto_b` DECIMAL(10,2),
	`opt_price_brutto_c` DECIMAL(10,2),
	PRIMARY KEY (`id`),
	INDEX `st_product_has_wholesale_FI_1` (`product_id`),
	CONSTRAINT `st_product_has_wholesale_FK_1`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
