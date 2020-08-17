
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_gift_card
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_gift_card`;


CREATE TABLE `st_gift_card`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`status` VARCHAR(1) default 'A',
	`amount` DECIMAL(10,2)  NOT NULL,
	`min_order_amount` INTEGER default 0 NOT NULL,
	`code` VARCHAR(64)  NOT NULL,
	`valid_to` DATE,
	`currency_id` INTEGER  NOT NULL,
	`allow_all_products` INTEGER,
	PRIMARY KEY (`id`),
	UNIQUE KEY `code_idx` (`code`),
	KEY `status_idx`(`status`),
	INDEX `st_gift_card_FI_1` (`currency_id`),
	CONSTRAINT `st_gift_card_FK_1`
		FOREIGN KEY (`currency_id`)
		REFERENCES `st_currency` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_gift_card_has_category
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_gift_card_has_category`;


CREATE TABLE `st_gift_card_has_category`
(
	`gift_card_id` INTEGER  NOT NULL,
	`category_id` INTEGER  NOT NULL,
	`is_opt` INTEGER default 0 NOT NULL,
	PRIMARY KEY (`gift_card_id`,`category_id`),
	CONSTRAINT `st_gift_card_has_category_FK_1`
		FOREIGN KEY (`gift_card_id`)
		REFERENCES `st_gift_card` (`id`)
		ON DELETE CASCADE,
	INDEX `st_gift_card_has_category_FI_2` (`category_id`),
	CONSTRAINT `st_gift_card_has_category_FK_2`
		FOREIGN KEY (`category_id`)
		REFERENCES `st_category` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_gift_card_has_producer
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_gift_card_has_producer`;


CREATE TABLE `st_gift_card_has_producer`
(
	`gift_card_id` INTEGER  NOT NULL,
	`producer_id` INTEGER  NOT NULL,
	PRIMARY KEY (`gift_card_id`,`producer_id`),
	CONSTRAINT `st_gift_card_has_producer_FK_1`
		FOREIGN KEY (`gift_card_id`)
		REFERENCES `st_gift_card` (`id`)
		ON DELETE CASCADE,
	INDEX `st_gift_card_has_producer_FI_2` (`producer_id`),
	CONSTRAINT `st_gift_card_has_producer_FK_2`
		FOREIGN KEY (`producer_id`)
		REFERENCES `st_producer` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_gift_card_has_product
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_gift_card_has_product`;


CREATE TABLE `st_gift_card_has_product`
(
	`gift_card_id` INTEGER  NOT NULL,
	`product_id` INTEGER  NOT NULL,
	PRIMARY KEY (`gift_card_id`,`product_id`),
	CONSTRAINT `st_gift_card_has_product_FK_1`
		FOREIGN KEY (`gift_card_id`)
		REFERENCES `st_gift_card` (`id`)
		ON DELETE CASCADE,
	INDEX `st_gift_card_has_product_FI_2` (`product_id`),
	CONSTRAINT `st_gift_card_has_product_FK_2`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
