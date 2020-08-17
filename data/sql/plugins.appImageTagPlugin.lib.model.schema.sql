
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- app_category_image_tag
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `app_category_image_tag`;


CREATE TABLE `app_category_image_tag`
(
	`id` INTEGER  NOT NULL,
	`tags` VARCHAR(8192),
	`image` VARCHAR(128),
	PRIMARY KEY (`id`),
	CONSTRAINT `app_category_image_tag_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_category` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- app_category_image_tag_gallery
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `app_category_image_tag_gallery`;


CREATE TABLE `app_category_image_tag_gallery`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`category_id` INTEGER  NOT NULL,
	`position` INTEGER default 0 NOT NULL,
	`opt_url` VARCHAR(255),
	`tags` VARCHAR(8192),
	`opt_description` VARCHAR(512),
	`description_color` SMALLINT default 0 NOT NULL,
	`image` VARCHAR(128),
	PRIMARY KEY (`id`),
	INDEX `app_category_image_tag_gallery_FI_1` (`category_id`),
	CONSTRAINT `app_category_image_tag_gallery_FK_1`
		FOREIGN KEY (`category_id`)
		REFERENCES `st_category` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- app_category_image_tag_gallery_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `app_category_image_tag_gallery_i18n`;


CREATE TABLE `app_category_image_tag_gallery_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`url` VARCHAR(255),
	`description` VARCHAR(512),
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `app_category_image_tag_gallery_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `app_category_image_tag_gallery` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
