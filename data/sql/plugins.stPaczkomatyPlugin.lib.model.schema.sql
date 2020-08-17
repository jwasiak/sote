
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_paczkomaty_pack
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_paczkomaty_pack`;


CREATE TABLE `st_paczkomaty_pack`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`customer_email` VARCHAR(255),
	`customer_phone` VARCHAR(255),
	`customer_paczkomat` VARCHAR(24),
	`sending_method` VARCHAR(48),
	`sender_paczkomat` VARCHAR(24),
	`use_sender_paczkomat` INTEGER default 0,
	`pack_type` CHAR(1),
	`inpost_shipment_id` INTEGER,
	`insurance` DECIMAL(10,2),
	`cash_on_delivery` DECIMAL(10,2),
	`description` VARCHAR(255),
	`code` VARCHAR(255),
	`has_cash_on_delivery` INTEGER,
	`customer_delivering_code` VARCHAR(255),
	`status` VARCHAR(255),
	`status_changed_at` DATETIME,
	`order_id` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `st_paczkomaty_pack_FI_1` (`order_id`),
	CONSTRAINT `st_paczkomaty_pack_FK_1`
		FOREIGN KEY (`order_id`)
		REFERENCES `st_order` (`id`)
		ON DELETE SET NULL
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
