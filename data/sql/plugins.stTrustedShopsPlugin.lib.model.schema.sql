
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_trusted_shops
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_trusted_shops`;


CREATE TABLE `st_trusted_shops`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`certificate` VARCHAR(255),
	`username` VARCHAR(255),
	`password` VARCHAR(255),
	`type` VARCHAR(20),
	`url` VARCHAR(255),
	`language` VARCHAR(2),
	`status` VARCHAR(255),
	`logo` INTEGER,
	`rating_widget` INTEGER,
	`rating_status` INTEGER,
	`rating_in_order_mail` INTEGER,
	`trustbadge_code` TEXT,
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_trusted_shops_has_payment_type
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_trusted_shops_has_payment_type`;


CREATE TABLE `st_trusted_shops_has_payment_type`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`trusted_shops_id` INTEGER  NOT NULL,
	`payment_type_id` INTEGER  NOT NULL,
	`method` VARCHAR(255),
	PRIMARY KEY (`trusted_shops_id`,`payment_type_id`),
	CONSTRAINT `st_trusted_shops_has_payment_type_FK_1`
		FOREIGN KEY (`trusted_shops_id`)
		REFERENCES `st_trusted_shops` (`id`)
		ON DELETE CASCADE,
	INDEX `st_trusted_shops_has_payment_type_FI_2` (`payment_type_id`),
	CONSTRAINT `st_trusted_shops_has_payment_type_FK_2`
		FOREIGN KEY (`payment_type_id`)
		REFERENCES `st_payment_type` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_trusted_shops_protection_products
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_trusted_shops_protection_products`;


CREATE TABLE `st_trusted_shops_protection_products`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`trusted_shops_id` INTEGER  NOT NULL,
	`currency` VARCHAR(5),
	`gross` DECIMAL(10,2),
	`netto` DECIMAL(10,2),
	`amount` DECIMAL(10,2),
	`duration` INTEGER,
	`product_id` VARCHAR(255),
	PRIMARY KEY (`id`),
	INDEX `st_trusted_shops_protection_products_FI_1` (`trusted_shops_id`),
	CONSTRAINT `st_trusted_shops_protection_products_FK_1`
		FOREIGN KEY (`trusted_shops_id`)
		REFERENCES `st_trusted_shops` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_trusted_shops_has_order
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_trusted_shops_has_order`;


CREATE TABLE `st_trusted_shops_has_order`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`trusted_shops_id` INTEGER  NOT NULL,
	`order_id` INTEGER  NOT NULL,
	`status` VARCHAR(255),
	`checked` INTEGER,
	PRIMARY KEY (`trusted_shops_id`,`order_id`),
	CONSTRAINT `st_trusted_shops_has_order_FK_1`
		FOREIGN KEY (`trusted_shops_id`)
		REFERENCES `st_trusted_shops` (`id`)
		ON DELETE RESTRICT,
	INDEX `st_trusted_shops_has_order_FI_2` (`order_id`),
	CONSTRAINT `st_trusted_shops_has_order_FK_2`
		FOREIGN KEY (`order_id`)
		REFERENCES `st_order` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
