
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- app_product_attribute
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `app_product_attribute`;


CREATE TABLE `app_product_attribute`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`is_active` INTEGER default 1 NOT NULL,
	`is_searchable` INTEGER default 0 NOT NULL,
	`is_visible_on_pp` INTEGER default 1 NOT NULL,
	`opt_name` VARCHAR(128)  NOT NULL,
	`type` CHAR(1) default 'T' NOT NULL,
	`position` INTEGER default 0 NOT NULL,
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- app_product_attribute_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `app_product_attribute_i18n`;


CREATE TABLE `app_product_attribute_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` CHAR(5)  NOT NULL,
	`name` VARCHAR(128)  NOT NULL,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `app_product_attribute_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `app_product_attribute` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- app_product_attribute_has_category
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `app_product_attribute_has_category`;


CREATE TABLE `app_product_attribute_has_category`
(
	`attribute_id` INTEGER  NOT NULL,
	`category_id` INTEGER  NOT NULL,
	PRIMARY KEY (`attribute_id`,`category_id`),
	CONSTRAINT `app_product_attribute_has_category_FK_1`
		FOREIGN KEY (`attribute_id`)
		REFERENCES `app_product_attribute` (`id`)
		ON DELETE CASCADE,
	INDEX `app_product_attribute_has_category_FI_2` (`category_id`),
	CONSTRAINT `app_product_attribute_has_category_FK_2`
		FOREIGN KEY (`category_id`)
		REFERENCES `st_category` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- app_product_attribute_has_variant
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `app_product_attribute_has_variant`;


CREATE TABLE `app_product_attribute_has_variant`
(
	`attribute_id` INTEGER  NOT NULL,
	`variant_id` INTEGER  NOT NULL,
	PRIMARY KEY (`attribute_id`,`variant_id`),
	CONSTRAINT `app_product_attribute_has_variant_FK_1`
		FOREIGN KEY (`attribute_id`)
		REFERENCES `app_product_attribute` (`id`)
		ON DELETE CASCADE,
	INDEX `app_product_attribute_has_variant_FI_2` (`variant_id`),
	CONSTRAINT `app_product_attribute_has_variant_FK_2`
		FOREIGN KEY (`variant_id`)
		REFERENCES `app_product_attribute_variant` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- app_product_attribute_variant_has_product
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `app_product_attribute_variant_has_product`;


CREATE TABLE `app_product_attribute_variant_has_product`
(
	`product_id` INTEGER  NOT NULL,
	`variant_id` INTEGER  NOT NULL,
	PRIMARY KEY (`product_id`,`variant_id`),
	CONSTRAINT `app_product_attribute_variant_has_product_FK_1`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE CASCADE,
	INDEX `app_product_attribute_variant_has_product_FI_2` (`variant_id`),
	CONSTRAINT `app_product_attribute_variant_has_product_FK_2`
		FOREIGN KEY (`variant_id`)
		REFERENCES `app_product_attribute_variant` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- app_product_attribute_variant
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `app_product_attribute_variant`;


CREATE TABLE `app_product_attribute_variant`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`opt_value` VARCHAR(255)  NOT NULL,
	`opt_name` VARCHAR(64),
	`type` CHAR(1),
	`position` INTEGER default 0 NOT NULL,
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- app_product_attribute_variant_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `app_product_attribute_variant_i18n`;


CREATE TABLE `app_product_attribute_variant_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` CHAR(5)  NOT NULL,
	`value` VARCHAR(255)  NOT NULL,
	`name` VARCHAR(64),
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `app_product_attribute_variant_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `app_product_attribute_variant` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
