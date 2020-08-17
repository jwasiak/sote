
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_product_options_template
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_options_template`;


CREATE TABLE `st_product_options_template`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`opt_name` VARCHAR(255),
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product_options_field
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_options_field`;


CREATE TABLE `st_product_options_field`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`product_options_template_id` INTEGER,
	`product_options_filter_id` INTEGER,
	`required` INTEGER,
	`typ` VARCHAR(255),
	`opt_name` VARCHAR(128),
	`opt_default_value` VARCHAR(128),
	`opt_value_id` INTEGER,
	`field_order` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `st_product_options_field_FI_1` (`product_options_template_id`),
	CONSTRAINT `st_product_options_field_FK_1`
		FOREIGN KEY (`product_options_template_id`)
		REFERENCES `st_product_options_template` (`id`)
		ON DELETE CASCADE,
	INDEX `st_product_options_field_FI_2` (`product_options_filter_id`),
	CONSTRAINT `st_product_options_field_FK_2`
		FOREIGN KEY (`product_options_filter_id`)
		REFERENCES `st_product_options_filter` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product_options_default_value
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_options_default_value`;


CREATE TABLE `st_product_options_default_value`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`product_options_template_id` INTEGER  NOT NULL,
	`product_options_default_value_id` INTEGER,
	`product_options_field_id` INTEGER,
	`price` VARCHAR(16),
	`weight` VARCHAR(10),
	`lft` INTEGER,
	`rgt` INTEGER,
	`opt_value` VARCHAR(128),
	`price_type` VARCHAR(6),
	`depth` INTEGER,
	`opt_version` INTEGER default 0,
	`color` VARCHAR(128),
	`use_image_as_color` INTEGER default 0,
	`old_price` DECIMAL(10,2),
	`pum` DECIMAL(10,2),
	PRIMARY KEY (`id`),
	INDEX `st_product_options_default_value_FI_1` (`product_options_template_id`),
	CONSTRAINT `st_product_options_default_value_FK_1`
		FOREIGN KEY (`product_options_template_id`)
		REFERENCES `st_product_options_template` (`id`)
		ON DELETE CASCADE,
	INDEX `st_product_options_default_value_FI_2` (`product_options_default_value_id`),
	CONSTRAINT `st_product_options_default_value_FK_2`
		FOREIGN KEY (`product_options_default_value_id`)
		REFERENCES `st_product_options_default_value` (`id`)
		ON DELETE RESTRICT,
	INDEX `st_product_options_default_value_FI_3` (`product_options_field_id`),
	CONSTRAINT `st_product_options_default_value_FK_3`
		FOREIGN KEY (`product_options_field_id`)
		REFERENCES `st_product_options_field` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product_options_value
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_options_value`;


CREATE TABLE `st_product_options_value`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`sf_asset_id` INTEGER,
	`product_id` INTEGER  NOT NULL,
	`product_options_template_id` INTEGER,
	`product_options_value_id` INTEGER,
	`product_options_field_id` INTEGER,
	`price` VARCHAR(16),
	`weight` VARCHAR(10),
	`lft` INTEGER,
	`rgt` INTEGER,
	`stock` DECIMAL(8,2),
	`opt_value` VARCHAR(128),
	`price_type` VARCHAR(6),
	`depth` INTEGER,
	`opt_version` INTEGER default 0,
	`color` VARCHAR(128),
	`use_image_as_color` INTEGER default 0,
	`opt_filter_id` INTEGER,
	`use_product` VARCHAR(128),
	`old_price` DECIMAL(10,2),
	`man_code` VARCHAR(128),
	`pum` DECIMAL(10,2),
	`is_updated` INTEGER default 0,
	PRIMARY KEY (`id`),
	KEY `product_options_value_color`(`color`),
	KEY `product_options_value_opt_value`(`opt_value`),
	KEY `product_options_value_filter_id`(`opt_filter_id`),
	INDEX `st_product_options_value_FI_1` (`sf_asset_id`),
	CONSTRAINT `st_product_options_value_FK_1`
		FOREIGN KEY (`sf_asset_id`)
		REFERENCES `sf_asset` (`id`)
		ON DELETE SET NULL,
	INDEX `st_product_options_value_FI_2` (`product_id`),
	CONSTRAINT `st_product_options_value_FK_2`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE CASCADE,
	INDEX `st_product_options_value_FI_3` (`product_options_template_id`),
	CONSTRAINT `st_product_options_value_FK_3`
		FOREIGN KEY (`product_options_template_id`)
		REFERENCES `st_product_options_template` (`id`)
		ON DELETE RESTRICT,
	INDEX `st_product_options_value_FI_4` (`product_options_value_id`),
	CONSTRAINT `st_product_options_value_FK_4`
		FOREIGN KEY (`product_options_value_id`)
		REFERENCES `st_product_options_value` (`id`)
		ON DELETE RESTRICT,
	INDEX `st_product_options_value_FI_5` (`product_options_field_id`),
	CONSTRAINT `st_product_options_value_FK_5`
		FOREIGN KEY (`product_options_field_id`)
		REFERENCES `st_product_options_field` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product_options_filter
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_options_filter`;


CREATE TABLE `st_product_options_filter`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`opt_name` VARCHAR(128),
	`filter_type` INTEGER,
	`rank` INTEGER,
	`price_from` DOUBLE,
	`price_to` DOUBLE,
	`is_visible` INTEGER default 1,
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product_options_template_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_options_template_i18n`;


CREATE TABLE `st_product_options_template_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`name` VARCHAR(255),
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_product_options_template_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_product_options_template` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product_options_field_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_options_field_i18n`;


CREATE TABLE `st_product_options_field_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`name` VARCHAR(128),
	`default_value` VARCHAR(128),
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_product_options_field_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_product_options_field` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product_options_default_value_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_options_default_value_i18n`;


CREATE TABLE `st_product_options_default_value_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`value` VARCHAR(128),
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_product_options_default_value_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_product_options_default_value` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product_options_value_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_options_value_i18n`;


CREATE TABLE `st_product_options_value_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`value` VARCHAR(128),
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_product_options_value_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_product_options_value` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product_options_filter_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_options_filter_i18n`;


CREATE TABLE `st_product_options_filter_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`name` VARCHAR(128),
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_product_options_filter_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_product_options_filter` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
