
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_product_has_accessories
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_has_accessories`;


CREATE TABLE `st_product_has_accessories`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`accessories_id` INTEGER  NOT NULL,
	`product_id` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `st_product_has_accessories_FI_1` (`accessories_id`),
	CONSTRAINT `st_product_has_accessories_FK_1`
		FOREIGN KEY (`accessories_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE CASCADE,
	INDEX `st_product_has_accessories_FI_2` (`product_id`),
	CONSTRAINT `st_product_has_accessories_FK_2`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
