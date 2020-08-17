
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_product_has_positioning
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_has_positioning`;


CREATE TABLE `st_product_has_positioning`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`product_id` INTEGER  NOT NULL,
	`opt_title` VARCHAR(255),
	`opt_keywords` VARCHAR(255),
	`opt_description` TEXT,
	`opt_type` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `st_product_has_positioning_FI_1` (`product_id`),
	CONSTRAINT `st_product_has_positioning_FK_1`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_webpage_has_positioning
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_webpage_has_positioning`;


CREATE TABLE `st_webpage_has_positioning`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`webpage_id` INTEGER  NOT NULL,
	`opt_title` VARCHAR(255),
	`opt_keywords` VARCHAR(255),
	`opt_description` TEXT,
	`opt_type` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `st_webpage_has_positioning_FI_1` (`webpage_id`),
	CONSTRAINT `st_webpage_has_positioning_FK_1`
		FOREIGN KEY (`webpage_id`)
		REFERENCES `st_webpage` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_category_has_positioning
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_category_has_positioning`;


CREATE TABLE `st_category_has_positioning`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`category_id` INTEGER,
	`opt_title` VARCHAR(255),
	`opt_keywords` VARCHAR(255),
	`opt_description` TEXT,
	`opt_type` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `st_category_has_positioning_FI_1` (`category_id`),
	CONSTRAINT `st_category_has_positioning_FK_1`
		FOREIGN KEY (`category_id`)
		REFERENCES `st_category` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product_group_has_positioning
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_group_has_positioning`;


CREATE TABLE `st_product_group_has_positioning`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`product_group_id` INTEGER  NOT NULL,
	`opt_title` VARCHAR(255),
	`opt_keywords` VARCHAR(255),
	`opt_description` TEXT,
	`opt_type` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `st_product_group_has_positioning_FI_1` (`product_group_id`),
	CONSTRAINT `st_product_group_has_positioning_FK_1`
		FOREIGN KEY (`product_group_id`)
		REFERENCES `st_product_group` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_positioning
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_positioning`;


CREATE TABLE `st_positioning`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255),
	`system_name` VARCHAR(255),
	`opt_title` VARCHAR(255),
	`opt_keywords` VARCHAR(255),
	`opt_description` TEXT,
	`opt_type` INTEGER,
	`opt_default_title` VARCHAR(255),
	`opt_title_product` VARCHAR(255),
	`opt_title_category` VARCHAR(255),
	`opt_title_manufacteur` VARCHAR(255),
	`opt_title_blog` VARCHAR(255),
	`opt_title_product_group` VARCHAR(255),
	`opt_title_webpage` VARCHAR(255),
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_producer_has_positioning
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_producer_has_positioning`;


CREATE TABLE `st_producer_has_positioning`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`producer_id` INTEGER  NOT NULL,
	`opt_title` VARCHAR(255),
	`opt_keywords` VARCHAR(255),
	`opt_description` TEXT,
	`opt_type` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `st_producer_has_positioning_FI_1` (`producer_id`),
	CONSTRAINT `st_producer_has_positioning_FK_1`
		FOREIGN KEY (`producer_id`)
		REFERENCES `st_producer` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_blog_has_positioning
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_blog_has_positioning`;


CREATE TABLE `st_blog_has_positioning`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`blog_id` INTEGER  NOT NULL,
	`opt_title` VARCHAR(255),
	`opt_keywords` VARCHAR(255),
	`opt_description` TEXT,
	`opt_type` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `st_blog_has_positioning_FI_1` (`blog_id`),
	CONSTRAINT `st_blog_has_positioning_FK_1`
		FOREIGN KEY (`blog_id`)
		REFERENCES `st_blog` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_positioning_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_positioning_i18n`;


CREATE TABLE `st_positioning_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`title` VARCHAR(255),
	`keywords` VARCHAR(255),
	`description` TEXT,
	`title_product` VARCHAR(255),
	`title_category` VARCHAR(255),
	`title_manufacteur` VARCHAR(255),
	`title_blog` VARCHAR(255),
	`title_product_group` VARCHAR(255),
	`title_webpage` VARCHAR(255),
	`type` INTEGER,
	`default_title` VARCHAR(255),
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_positioning_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_positioning` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product_has_positioning_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_has_positioning_i18n`;


CREATE TABLE `st_product_has_positioning_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`title` VARCHAR(255),
	`keywords` VARCHAR(255),
	`description` TEXT,
	`type` INTEGER,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_product_has_positioning_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_product_has_positioning` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product_group_has_positioning_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_group_has_positioning_i18n`;


CREATE TABLE `st_product_group_has_positioning_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`title` VARCHAR(255),
	`keywords` VARCHAR(255),
	`description` TEXT,
	`type` INTEGER,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_product_group_has_positioning_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_product_group_has_positioning` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_category_has_positioning_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_category_has_positioning_i18n`;


CREATE TABLE `st_category_has_positioning_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`title` VARCHAR(255),
	`keywords` VARCHAR(255),
	`description` TEXT,
	`type` INTEGER,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_category_has_positioning_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_category_has_positioning` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_webpage_has_positioning_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_webpage_has_positioning_i18n`;


CREATE TABLE `st_webpage_has_positioning_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`title` VARCHAR(255),
	`keywords` VARCHAR(255),
	`description` TEXT,
	`type` INTEGER,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_webpage_has_positioning_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_webpage_has_positioning` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_producer_has_positioning_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_producer_has_positioning_i18n`;


CREATE TABLE `st_producer_has_positioning_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`title` VARCHAR(255),
	`keywords` VARCHAR(255),
	`description` TEXT,
	`type` INTEGER,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_producer_has_positioning_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_producer_has_positioning` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_blog_has_positioning_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_blog_has_positioning_i18n`;


CREATE TABLE `st_blog_has_positioning_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`title` VARCHAR(255),
	`keywords` VARCHAR(255),
	`description` TEXT,
	`type` INTEGER,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_blog_has_positioning_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_blog_has_positioning` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
