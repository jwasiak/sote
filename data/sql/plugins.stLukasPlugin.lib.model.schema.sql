
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_lukas_product
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_lukas_product`;


CREATE TABLE `st_lukas_product`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`product_id` INTEGER  NOT NULL,
	`disable` INTEGER  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `st_lukas_product_FI_1` (`product_id`),
	CONSTRAINT `st_lukas_product_FK_1`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
