
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_crosselling
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_crosselling`;


CREATE TABLE `st_crosselling`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`first_product_id` INTEGER  NOT NULL,
	`secound_product_id` INTEGER  NOT NULL,
	`sum` INTEGER,
	PRIMARY KEY (`id`),
	KEY `crosselling_sum`(`sum`),
	INDEX `st_crosselling_FI_1` (`first_product_id`),
	CONSTRAINT `st_crosselling_FK_1`
		FOREIGN KEY (`first_product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE CASCADE,
	INDEX `st_crosselling_FI_2` (`secound_product_id`),
	CONSTRAINT `st_crosselling_FK_2`
		FOREIGN KEY (`secound_product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
