
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_slide_banner
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_slide_banner`;


CREATE TABLE `st_slide_banner`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`language_id` INTEGER  NOT NULL,
	`image` VARCHAR(255),
	`image_small` VARCHAR(255),
	`banner_type` INTEGER default 0 NOT NULL,
	`link` VARCHAR(255),
	`group_name` VARCHAR(255),
	`description` TEXT,
	`banner_title` VARCHAR(255),
	`banner_description` TEXT,
	`button_text` VARCHAR(255),
	`button_link` VARCHAR(255),
	`banner_description_position` INTEGER default 0 NOT NULL,
	`banner_margin_left` VARCHAR(255),
	`banner_margin_right` VARCHAR(255),
	`is_active` INTEGER default 1 NOT NULL,
	`opt_culture` VARCHAR(7)  NOT NULL,
	`rank` INTEGER,
	PRIMARY KEY (`id`),
	KEY `opt_culture_idx`(`opt_culture`),
	KEY `is_active_idx`(`is_active`),
	KEY `group_name_idx`(`group_name`),
	INDEX `st_slide_banner_FI_1` (`language_id`),
	CONSTRAINT `st_slide_banner_FK_1`
		FOREIGN KEY (`language_id`)
		REFERENCES `st_language` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
