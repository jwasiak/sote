
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_discount
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_discount`;


CREATE TABLE `st_discount`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`type` VARCHAR(1) default 'P' NOT NULL,
	`price_type` VARCHAR(1) default '%' NOT NULL,
	`name` VARCHAR(64)  NOT NULL,
	`value` DECIMAL(8,2) default 0 NOT NULL,
	`conditions` VARCHAR(4096),
	`priority` INTEGER default 0 NOT NULL,
	`active` INTEGER default 1 NOT NULL,
	`all_products` INTEGER default 0 NOT NULL,
	`all_clients` INTEGER default 0 NOT NULL,
	`allow_anonymous_clients` INTEGER default 0 NOT NULL,
	`auto_active` INTEGER default 0 NOT NULL,
	`product_id` INTEGER,
	PRIMARY KEY (`id`),
	KEY `discount_priority`(`priority`),
	KEY `discount_active`(`active`),
	INDEX `st_discount_FI_1` (`product_id`),
	CONSTRAINT `st_discount_FK_1`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_user_has_discount
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_user_has_discount`;


CREATE TABLE `st_user_has_discount`
(
	`sf_guard_user_id` INTEGER  NOT NULL,
	`discount_id` INTEGER  NOT NULL,
	`auto` INTEGER default 0 NOT NULL,
	PRIMARY KEY (`sf_guard_user_id`,`discount_id`),
	CONSTRAINT `st_user_has_discount_FK_1`
		FOREIGN KEY (`sf_guard_user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE CASCADE,
	INDEX `st_user_has_discount_FI_2` (`discount_id`),
	CONSTRAINT `st_user_has_discount_FK_2`
		FOREIGN KEY (`discount_id`)
		REFERENCES `st_discount` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_discount_has_product
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_discount_has_product`;


CREATE TABLE `st_discount_has_product`
(
	`discount_id` INTEGER  NOT NULL,
	`product_id` INTEGER  NOT NULL,
	PRIMARY KEY (`discount_id`,`product_id`),
	CONSTRAINT `st_discount_has_product_FK_1`
		FOREIGN KEY (`discount_id`)
		REFERENCES `st_discount` (`id`)
		ON DELETE CASCADE,
	INDEX `st_discount_has_product_FI_2` (`product_id`),
	CONSTRAINT `st_discount_has_product_FK_2`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_discount_range
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_discount_range`;


CREATE TABLE `st_discount_range`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`discount_id` INTEGER  NOT NULL,
	`total_value` DOUBLE default 0 NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `st_discount_range_FI_1` (`discount_id`),
	CONSTRAINT `st_discount_range_FK_1`
		FOREIGN KEY (`discount_id`)
		REFERENCES `st_discount` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_discount_user
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_discount_user`;


CREATE TABLE `st_discount_user`
(
	`sf_guard_user_id` INTEGER  NOT NULL,
	`discount` DOUBLE default 0,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`id`),
	INDEX `st_discount_user_FI_1` (`sf_guard_user_id`),
	CONSTRAINT `st_discount_user_FK_1`
		FOREIGN KEY (`sf_guard_user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_discount_coupon_code
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_discount_coupon_code`;


CREATE TABLE `st_discount_coupon_code`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`sf_guard_user_id` INTEGER,
	`order_id` INTEGER,
	`code` VARCHAR(16)  NOT NULL,
	`used` INTEGER default 0 NOT NULL,
	`valid_usage` INTEGER default 0 NOT NULL,
	`allow_all_products` INTEGER,
	`valid_from` DATETIME,
	`valid_to` DATETIME,
	`discount` DECIMAL(3,1) default 0 NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `discount_coupon_code_index1` (`code`),
	INDEX `st_discount_coupon_code_FI_1` (`sf_guard_user_id`),
	CONSTRAINT `st_discount_coupon_code_FK_1`
		FOREIGN KEY (`sf_guard_user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE CASCADE,
	INDEX `st_discount_coupon_code_FI_2` (`order_id`),
	CONSTRAINT `st_discount_coupon_code_FK_2`
		FOREIGN KEY (`order_id`)
		REFERENCES `st_order` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_discount_has_producer
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_discount_has_producer`;


CREATE TABLE `st_discount_has_producer`
(
	`discount_id` INTEGER  NOT NULL,
	`producer_id` INTEGER  NOT NULL,
	PRIMARY KEY (`discount_id`,`producer_id`),
	CONSTRAINT `st_discount_has_producer_FK_1`
		FOREIGN KEY (`discount_id`)
		REFERENCES `st_discount` (`id`)
		ON DELETE CASCADE,
	INDEX `st_discount_has_producer_FI_2` (`producer_id`),
	CONSTRAINT `st_discount_has_producer_FK_2`
		FOREIGN KEY (`producer_id`)
		REFERENCES `st_producer` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_discount_has_category
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_discount_has_category`;


CREATE TABLE `st_discount_has_category`
(
	`discount_id` INTEGER  NOT NULL,
	`category_id` INTEGER  NOT NULL,
	`is_opt` INTEGER default 0 NOT NULL,
	PRIMARY KEY (`discount_id`,`category_id`),
	CONSTRAINT `st_discount_has_category_FK_1`
		FOREIGN KEY (`discount_id`)
		REFERENCES `st_discount` (`id`)
		ON DELETE CASCADE,
	INDEX `st_discount_has_category_FI_2` (`category_id`),
	CONSTRAINT `st_discount_has_category_FK_2`
		FOREIGN KEY (`category_id`)
		REFERENCES `st_category` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_discount_coupon_code_has_producer
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_discount_coupon_code_has_producer`;


CREATE TABLE `st_discount_coupon_code_has_producer`
(
	`discount_coupon_code_id` INTEGER  NOT NULL,
	`producer_id` INTEGER  NOT NULL,
	PRIMARY KEY (`discount_coupon_code_id`,`producer_id`),
	CONSTRAINT `st_discount_coupon_code_has_producer_FK_1`
		FOREIGN KEY (`discount_coupon_code_id`)
		REFERENCES `st_discount_coupon_code` (`id`)
		ON DELETE CASCADE,
	INDEX `st_discount_coupon_code_has_producer_FI_2` (`producer_id`),
	CONSTRAINT `st_discount_coupon_code_has_producer_FK_2`
		FOREIGN KEY (`producer_id`)
		REFERENCES `st_producer` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_discount_coupon_code_has_category
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_discount_coupon_code_has_category`;


CREATE TABLE `st_discount_coupon_code_has_category`
(
	`discount_coupon_code_id` INTEGER  NOT NULL,
	`category_id` INTEGER  NOT NULL,
	`is_opt` INTEGER default 0 NOT NULL,
	PRIMARY KEY (`discount_coupon_code_id`,`category_id`),
	CONSTRAINT `st_discount_coupon_code_has_category_FK_1`
		FOREIGN KEY (`discount_coupon_code_id`)
		REFERENCES `st_discount_coupon_code` (`id`)
		ON DELETE CASCADE,
	INDEX `st_discount_coupon_code_has_category_FI_2` (`category_id`),
	CONSTRAINT `st_discount_coupon_code_has_category_FK_2`
		FOREIGN KEY (`category_id`)
		REFERENCES `st_category` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_discount_coupon_code_has_product
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_discount_coupon_code_has_product`;


CREATE TABLE `st_discount_coupon_code_has_product`
(
	`discount_coupon_code_id` INTEGER  NOT NULL,
	`product_id` INTEGER  NOT NULL,
	PRIMARY KEY (`discount_coupon_code_id`,`product_id`),
	CONSTRAINT `st_discount_coupon_code_has_product_FK_1`
		FOREIGN KEY (`discount_coupon_code_id`)
		REFERENCES `st_discount_coupon_code` (`id`)
		ON DELETE CASCADE,
	INDEX `st_discount_coupon_code_has_product_FI_2` (`product_id`),
	CONSTRAINT `st_discount_coupon_code_has_product_FK_2`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
