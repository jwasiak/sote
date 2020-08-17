
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_zakupomat
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_zakupomat`;


CREATE TABLE `st_zakupomat`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`product_id` INTEGER  NOT NULL,
	`active` INTEGER,
	`description` TEXT,
	PRIMARY KEY (`id`),
	INDEX `st_zakupomat_FI_1` (`product_id`),
	CONSTRAINT `st_zakupomat_FK_1`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
