
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_ceneo
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_ceneo`;


CREATE TABLE `st_ceneo`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`product_id` INTEGER  NOT NULL,
	`active` INTEGER  NOT NULL,
	`description` TEXT,
	PRIMARY KEY (`id`),
	INDEX `st_ceneo_FI_1` (`product_id`),
	CONSTRAINT `st_ceneo_FK_1`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
