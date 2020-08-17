
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_invoice
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_invoice`;


CREATE TABLE `st_invoice`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`invoice_user_seller_id` INTEGER,
	`invoice_user_customer_id` INTEGER,
	`order_id` INTEGER,
	`invoice_currency_id` INTEGER,
	`invoice_proforma_id` INTEGER,
	`company_description` TEXT,
	`invoice_description` TEXT,
	`order_discount` DECIMAL(10,2),
	`date_selle` DATE,
	`date_create_copy` DATE,
	`number` VARCHAR(45),
	`signature_seller` VARCHAR(45),
	`signature_customer` VARCHAR(45),
	`opt_total_ammount_brutto` DECIMAL(10,2),
	`town` VARCHAR(255),
	`curency` VARCHAR(20),
	`max_day` VARCHAR(20) default 'none',
	`payment_type` VARCHAR(20) default 'none',
	`is_proforma` INTEGER default 1,
	`is_request` INTEGER default 0,
	`is_confirm` INTEGER default 0,
	PRIMARY KEY (`id`),
	KEY `order_number`(`date_create_copy`),
	INDEX `st_invoice_FI_1` (`invoice_user_seller_id`),
	CONSTRAINT `st_invoice_FK_1`
		FOREIGN KEY (`invoice_user_seller_id`)
		REFERENCES `st_invoice_user_seller` (`id`)
		ON DELETE RESTRICT,
	INDEX `st_invoice_FI_2` (`invoice_user_customer_id`),
	CONSTRAINT `st_invoice_FK_2`
		FOREIGN KEY (`invoice_user_customer_id`)
		REFERENCES `st_invoice_user_customer` (`id`)
		ON DELETE RESTRICT,
	INDEX `st_invoice_FI_3` (`order_id`),
	CONSTRAINT `st_invoice_FK_3`
		FOREIGN KEY (`order_id`)
		REFERENCES `st_order` (`id`)
		ON DELETE SET NULL,
	INDEX `st_invoice_FI_4` (`invoice_currency_id`),
	CONSTRAINT `st_invoice_FK_4`
		FOREIGN KEY (`invoice_currency_id`)
		REFERENCES `st_invoice_currency` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_invoice_status
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_invoice_status`;


CREATE TABLE `st_invoice_status`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`invoice_id` INTEGER  NOT NULL,
	`payment_id` INTEGER default 0,
	`opt_payment_type_name` VARCHAR(255),
	`opt_payment_status` INTEGER default 0,
	`opt_payment_type_id` INTEGER,
	`hand_mod` INTEGER default 0,
	`paid_amount` DECIMAL(10,2),
	PRIMARY KEY (`id`),
	INDEX `st_invoice_status_FI_1` (`invoice_id`),
	CONSTRAINT `st_invoice_status_FK_1`
		FOREIGN KEY (`invoice_id`)
		REFERENCES `st_invoice` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_invoice_product
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_invoice_product`;


CREATE TABLE `st_invoice_product`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`invoice_id` INTEGER  NOT NULL,
	`product_id` INTEGER,
	`name` VARCHAR(1024),
	`code` VARCHAR(255),
	`pkwiu` VARCHAR(255),
	`quantity` DECIMAL(8,2),
	`measure_unit` VARCHAR(20),
	`discount` FLOAT,
	`price_netto` DECIMAL(10,2),
	`price_brutto` DECIMAL(10,2),
	`vat` FLOAT,
	`vat_id` INTEGER,
	`total_price_netto` DECIMAL(10,2),
	`vat_ammount` DECIMAL(10,2),
	`opt_total_price_brutto` DECIMAL(10,2),
	PRIMARY KEY (`id`),
	INDEX `st_invoice_product_FI_1` (`invoice_id`),
	CONSTRAINT `st_invoice_product_FK_1`
		FOREIGN KEY (`invoice_id`)
		REFERENCES `st_invoice` (`id`)
		ON DELETE CASCADE,
	INDEX `st_invoice_product_FI_2` (`product_id`),
	CONSTRAINT `st_invoice_product_FK_2`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE SET NULL
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_invoice_user_customer
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_invoice_user_customer`;


CREATE TABLE `st_invoice_user_customer`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`country` VARCHAR(255),
	`full_name` VARCHAR(255),
	`name` VARCHAR(1024),
	`surname` VARCHAR(255),
	`address` VARCHAR(255),
	`address_more` VARCHAR(255),
	`region` VARCHAR(255),
	`street` VARCHAR(255),
	`house` VARCHAR(255),
	`flat` VARCHAR(255),
	`code` VARCHAR(255),
	`town` VARCHAR(255),
	`company` VARCHAR(255),
	`vat_number` VARCHAR(255),
	`pesel` VARCHAR(255),
	`crypt` INTEGER default 0,
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_invoice_user_seller
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_invoice_user_seller`;


CREATE TABLE `st_invoice_user_seller`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`country` VARCHAR(255),
	`full_name` VARCHAR(255),
	`name` VARCHAR(1024),
	`surname` VARCHAR(255),
	`address` VARCHAR(255),
	`address_more` VARCHAR(255),
	`region` VARCHAR(255),
	`street` VARCHAR(255),
	`house` VARCHAR(255),
	`flat` VARCHAR(255),
	`code` VARCHAR(255),
	`town` VARCHAR(255),
	`company` VARCHAR(255),
	`vat_number` VARCHAR(255),
	`crypt` INTEGER default 0,
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_invoice_currency
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_invoice_currency`;


CREATE TABLE `st_invoice_currency`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255),
	`exchange` FLOAT,
	`shortcut` VARCHAR(20),
	`front_symbol` VARCHAR(20),
	`back_symbol` VARCHAR(20),
	PRIMARY KEY (`id`)
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
