
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_delivery
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_delivery`;


CREATE TABLE `st_delivery`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`countries_area_id` INTEGER,
	`tax_id` INTEGER,
	`type_id` INTEGER,
	`free_delivery` DECIMAL(10,2) default 0,
	`active` INTEGER,
	`allow_in_selected_products` INTEGER default 0 NOT NULL,
	`default_cost` DECIMAL(10,2) default 0,
	`default_cost_brutto` DECIMAL(10,2),
	`width` INTEGER default 0 NOT NULL,
	`height` INTEGER default 0 NOT NULL,
	`depth` INTEGER default 0 NOT NULL,
	`volume` INTEGER default 0 NOT NULL,
	`is_system_default` INTEGER default 0,
	`opt_name` VARCHAR(255),
	`opt_description` TEXT,
	`is_default` INTEGER default 0,
	`section_cost_type` VARCHAR(32),
	`max_order_weight` DECIMAL(6,2) default 0,
	`max_order_amount` DECIMAL(10,2) default 0,
	`max_order_quantity` INTEGER default 0,
	`min_order_weight` DECIMAL(6,2) default 0,
	`min_order_amount` DECIMAL(10,2) default 0,
	`min_order_quantity` INTEGER default 0,
	`position` INTEGER default 0,
	`params` VARCHAR(4096),
	`paczkomaty_type` VARCHAR(5),
	`paczkomaty_size` VARCHAR(5),
	PRIMARY KEY (`id`),
	KEY `delivery_active`(`max_order_amount`, `max_order_quantity`, `max_order_weight`, `active`),
	KEY `type_id_idx`(`type_id`),
	INDEX `st_delivery_FI_1` (`countries_area_id`),
	CONSTRAINT `st_delivery_FK_1`
		FOREIGN KEY (`countries_area_id`)
		REFERENCES `st_countries_area` (`id`)
		ON DELETE SET NULL,
	INDEX `st_delivery_FI_2` (`tax_id`),
	CONSTRAINT `st_delivery_FK_2`
		FOREIGN KEY (`tax_id`)
		REFERENCES `st_tax` (`id`)
		ON DELETE SET NULL,
	CONSTRAINT `st_delivery_FK_3`
		FOREIGN KEY (`type_id`)
		REFERENCES `st_delivery_type` (`id`)
		ON DELETE SET NULL
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_delivery_type
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_delivery_type`;


CREATE TABLE `st_delivery_type`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(128)  NOT NULL,
	`type` VARCHAR(16),
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_delivery_sections
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_delivery_sections`;


CREATE TABLE `st_delivery_sections`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`attribute_field_id` INTEGER,
	`delivery_id` INTEGER  NOT NULL,
	`value_from` DECIMAL(10,2) default 0,
	`amount` DECIMAL(10,2) default 0,
	`amount_brutto` DECIMAL(10,2),
	PRIMARY KEY (`id`),
	INDEX `st_delivery_sections_FI_1` (`attribute_field_id`),
	CONSTRAINT `st_delivery_sections_FK_1`
		FOREIGN KEY (`attribute_field_id`)
		REFERENCES `st_attribute_field` (`id`)
		ON DELETE CASCADE,
	INDEX `st_delivery_sections_FI_2` (`delivery_id`),
	CONSTRAINT `st_delivery_sections_FK_2`
		FOREIGN KEY (`delivery_id`)
		REFERENCES `st_delivery` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_delivery_has_payment_type
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_delivery_has_payment_type`;


CREATE TABLE `st_delivery_has_payment_type`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`payment_type_id` INTEGER  NOT NULL,
	`delivery_id` INTEGER  NOT NULL,
	`is_active` INTEGER default 0,
	`is_default` INTEGER default 0,
	`cost` DECIMAL(10,2) default 0,
	`cost_brutto` DECIMAL(10,2),
	`free_from` DECIMAL(10,2) default 0,
	`cost_type` CHAR default 'P' NOT NULL,
	`courier_cost` DECIMAL(10,2),
	PRIMARY KEY (`id`),
	INDEX `st_delivery_has_payment_type_FI_1` (`payment_type_id`),
	CONSTRAINT `st_delivery_has_payment_type_FK_1`
		FOREIGN KEY (`payment_type_id`)
		REFERENCES `st_payment_type` (`id`)
		ON DELETE CASCADE,
	INDEX `st_delivery_has_payment_type_FI_2` (`delivery_id`),
	CONSTRAINT `st_delivery_has_payment_type_FK_2`
		FOREIGN KEY (`delivery_id`)
		REFERENCES `st_delivery` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_delivery_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_delivery_i18n`;


CREATE TABLE `st_delivery_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`name` VARCHAR(255),
	`description` TEXT,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_delivery_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_delivery` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
