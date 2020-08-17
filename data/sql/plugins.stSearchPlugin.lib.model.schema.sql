
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_searched_words
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_searched_words`;


CREATE TABLE `st_searched_words`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`word` VARCHAR(255)  NOT NULL,
	`results` INTEGER default 0 NOT NULL,
	`searched` INTEGER default 0 NOT NULL,
	`swap` VARCHAR(255),
	`url` VARCHAR(255),
	PRIMARY KEY (`id`),
	KEY `searched_words_searched`(`word`),
	KEY `searched_words_swap`(`swap`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product_search_index
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_search_index`;


CREATE TABLE `st_product_search_index`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`name` TEXT,
	`simple_search` TEXT,
	`advanced_search` TEXT,
	`advanced_name` TEXT,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_product_search_index_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_product` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product_search_tag
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_search_tag`;


CREATE TABLE `st_product_search_tag`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`tag` VARCHAR(64)  NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `unique_tag` (`tag`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product_has_product_search_tag
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_has_product_search_tag`;


CREATE TABLE `st_product_has_product_search_tag`
(
	`product_id` INTEGER  NOT NULL,
	`product_search_tag_id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`tag_value` INTEGER default 1 NOT NULL,
	PRIMARY KEY (`product_id`,`product_search_tag_id`,`culture`),
	CONSTRAINT `st_product_has_product_search_tag_FK_1`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE RESTRICT,
	INDEX `st_product_has_product_search_tag_FI_2` (`product_search_tag_id`),
	CONSTRAINT `st_product_has_product_search_tag_FK_2`
		FOREIGN KEY (`product_search_tag_id`)
		REFERENCES `st_product_search_tag` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_search_link
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_search_link`;


CREATE TABLE `st_search_link`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`opt_title` VARCHAR(255),
	`opt_description` TEXT,
	`opt_url` VARCHAR(255),
	`opt_meta_title` VARCHAR(255),
	`opt_meta_keywords` VARCHAR(255),
	`opt_meta_description` VARCHAR(160),
	`opt_search_keywords` VARCHAR(100),
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_search_link_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_search_link_i18n`;


CREATE TABLE `st_search_link_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`title` VARCHAR(255),
	`description` TEXT,
	`url` VARCHAR(255),
	`meta_title` VARCHAR(255),
	`meta_keywords` VARCHAR(255),
	`meta_description` VARCHAR(160),
	`search_keywords` VARCHAR(100),
	PRIMARY KEY (`id`,`culture`),
	UNIQUE KEY `url_idx` (`url`, `culture`),
	CONSTRAINT `st_search_link_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_search_link` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
