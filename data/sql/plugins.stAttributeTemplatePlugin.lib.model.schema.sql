
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_attribute_template
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_attribute_template`;


CREATE TABLE `st_attribute_template`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255),
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_attribute_field
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_attribute_field`;


CREATE TABLE `st_attribute_field`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`attribute_template_id` INTEGER,
	`name` VARCHAR(255),
	`rank` INTEGER,
	PRIMARY KEY (`id`),
	KEY `pattern_field_FKIndex1`(`attribute_template_id`),
	CONSTRAINT `st_attribute_field_FK_1`
		FOREIGN KEY (`attribute_template_id`)
		REFERENCES `st_attribute_template` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product_has_attribute_field
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_has_attribute_field`;


CREATE TABLE `st_product_has_attribute_field`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`attribute_field_id` INTEGER  NOT NULL,
	`product_id` INTEGER  NOT NULL,
	`value` VARCHAR(255),
	PRIMARY KEY (`id`),
	INDEX `st_product_has_attribute_field_FI_1` (`attribute_field_id`),
	CONSTRAINT `st_product_has_attribute_field_FK_1`
		FOREIGN KEY (`attribute_field_id`)
		REFERENCES `st_attribute_field` (`id`)
		ON DELETE RESTRICT,
	INDEX `st_product_has_attribute_field_FI_2` (`product_id`),
	CONSTRAINT `st_product_has_attribute_field_FK_2`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
