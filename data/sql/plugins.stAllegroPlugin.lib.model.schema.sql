
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_allegro_auction
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_allegro_auction`;


CREATE TABLE `st_allegro_auction`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`product_id` INTEGER  NOT NULL,
	`product_options` VARCHAR(255),
	`requires_sync` INTEGER default 0,
	`site` VARCHAR(255),
	`name` VARCHAR(255),
	`auction_id` BIGINT,
	`ended` INTEGER default 0,
	`ended_at` DATETIME,
	`commands` VARCHAR(1024),
	PRIMARY KEY (`id`),
	KEY `auction_id_idx`(`auction_id`),
	INDEX `st_allegro_auction_FI_1` (`product_id`),
	CONSTRAINT `st_allegro_auction_FK_1`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_allegro_auction_has_order
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_allegro_auction_has_order`;


CREATE TABLE `st_allegro_auction_has_order`
(
	`trans_id` BIGINT  NOT NULL,
	`allegro_auction_id` BIGINT  NOT NULL,
	`order_id` INTEGER  NOT NULL,
	`allegro_user_id` BIGINT  NOT NULL,
	PRIMARY KEY (`trans_id`,`allegro_auction_id`,`order_id`),
	INDEX `st_allegro_auction_has_order_FI_1` (`order_id`),
	CONSTRAINT `st_allegro_auction_has_order_FK_1`
		FOREIGN KEY (`order_id`)
		REFERENCES `st_order` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
