
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_paybynet_has_order
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_paybynet_has_order`;


CREATE TABLE `st_paybynet_has_order`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`order_id` INTEGER  NOT NULL,
	`payment_type` VARCHAR(255),
	PRIMARY KEY (`order_id`),
	CONSTRAINT `st_paybynet_has_order_FK_1`
		FOREIGN KEY (`order_id`)
		REFERENCES `st_order` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
