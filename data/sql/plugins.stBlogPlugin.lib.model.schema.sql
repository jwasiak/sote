
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_blog
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_blog`;


CREATE TABLE `st_blog`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`sf_asset_id` INTEGER,
	`active` INTEGER,
	`opt_name` VARCHAR(255),
	`opt_short_description` TEXT,
	`opt_long_description` TEXT,
	`image_main_page` VARCHAR(255),
	`image` VARCHAR(255),
	`opt_url` VARCHAR(255),
	`alternative_url` VARCHAR(255),
	`gallery` VARCHAR(4096),
	PRIMARY KEY (`id`),
	INDEX `st_blog_FI_1` (`sf_asset_id`),
	CONSTRAINT `st_blog_FK_1`
		FOREIGN KEY (`sf_asset_id`)
		REFERENCES `sf_asset` (`id`)
		ON DELETE SET NULL
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_blog_category
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_blog_category`;


CREATE TABLE `st_blog_category`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`active` INTEGER,
	`opt_name` VARCHAR(255),
	`opt_url` VARCHAR(255),
	`banner_group` VARCHAR(255),
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_blog_has_blog_category
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_blog_has_blog_category`;


CREATE TABLE `st_blog_has_blog_category`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`blog_id` INTEGER  NOT NULL,
	`blog_category_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `st_blog_has_blog_category_FI_1` (`blog_id`),
	CONSTRAINT `st_blog_has_blog_category_FK_1`
		FOREIGN KEY (`blog_id`)
		REFERENCES `st_blog` (`id`)
		ON DELETE CASCADE,
	INDEX `st_blog_has_blog_category_FI_2` (`blog_category_id`),
	CONSTRAINT `st_blog_has_blog_category_FK_2`
		FOREIGN KEY (`blog_category_id`)
		REFERENCES `st_blog_category` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_blog_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_blog_i18n`;


CREATE TABLE `st_blog_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`name` VARCHAR(255),
	`short_description` TEXT,
	`long_description` TEXT,
	`url` VARCHAR(255),
	PRIMARY KEY (`id`,`culture`),
	KEY `blog_Index1`(`url`, `culture`),
	CONSTRAINT `st_blog_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_blog` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_blog_category_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_blog_category_i18n`;


CREATE TABLE `st_blog_category_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`name` VARCHAR(255),
	`url` VARCHAR(255),
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_blog_category_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_blog_category` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
