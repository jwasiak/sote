
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_theme_layout
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_theme_layout`;


CREATE TABLE `st_theme_layout`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`theme_id` INTEGER  NOT NULL,
	`sf_guard_user_id` INTEGER,
	`container` VARCHAR(255),
	`blocks` TEXT,
	PRIMARY KEY (`id`),
	INDEX `st_theme_layout_FI_1` (`theme_id`),
	CONSTRAINT `st_theme_layout_FK_1`
		FOREIGN KEY (`theme_id`)
		REFERENCES `st_theme` (`id`)
		ON DELETE CASCADE,
	INDEX `st_theme_layout_FI_2` (`sf_guard_user_id`),
	CONSTRAINT `st_theme_layout_FK_2`
		FOREIGN KEY (`sf_guard_user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_theme
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_theme`;


CREATE TABLE `st_theme`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`base_theme_id` INTEGER,
	`theme` VARCHAR(48)  NOT NULL,
	`active` INTEGER default 0,
	`opt_color_scheme` VARCHAR(32),
	`version` INTEGER,
	`is_system_default` INTEGER default 0 NOT NULL,
	`is_hidden` INTEGER default 0 NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `st_theme_theme_unique` (`theme`),
	INDEX `st_theme_FI_1` (`base_theme_id`),
	CONSTRAINT `st_theme_FK_1`
		FOREIGN KEY (`base_theme_id`)
		REFERENCES `st_theme` (`id`)
		ON DELETE SET NULL
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_theme_css
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_theme_css`;


CREATE TABLE `st_theme_css`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`theme_id` INTEGER  NOT NULL,
	`css_head_id` VARCHAR(255),
	`css_content` TEXT,
	PRIMARY KEY (`id`),
	INDEX `st_theme_css_FI_1` (`theme_id`),
	CONSTRAINT `st_theme_css_FK_1`
		FOREIGN KEY (`theme_id`)
		REFERENCES `st_theme` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_theme_color_scheme
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_theme_color_scheme`;


CREATE TABLE `st_theme_color_scheme`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`theme_id` INTEGER  NOT NULL,
	`name` VARCHAR(255),
	`is_default` INTEGER default 0,
	PRIMARY KEY (`id`),
	INDEX `st_theme_color_scheme_FI_1` (`theme_id`),
	CONSTRAINT `st_theme_color_scheme_FK_1`
		FOREIGN KEY (`theme_id`)
		REFERENCES `st_theme` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_theme_config
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_theme_config`;


CREATE TABLE `st_theme_config`
(
	`id` INTEGER  NOT NULL,
	`parameters` TEXT,
	PRIMARY KEY (`id`),
	CONSTRAINT `st_theme_config_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_theme` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_theme_content
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_theme_content`;


CREATE TABLE `st_theme_content`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`theme_id` INTEGER  NOT NULL,
	`content_id` VARCHAR(48)  NOT NULL,
	`opt_name` VARCHAR(64)  NOT NULL,
	`opt_content` VARCHAR(1024),
	PRIMARY KEY (`id`),
	UNIQUE KEY `content_id_idx` (`content_id`, `theme_id`),
	INDEX `st_theme_content_FI_1` (`theme_id`),
	CONSTRAINT `st_theme_content_FK_1`
		FOREIGN KEY (`theme_id`)
		REFERENCES `st_theme` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_theme_content_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_theme_content_i18n`;


CREATE TABLE `st_theme_content_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`name` VARCHAR(64)  NOT NULL,
	`content` VARCHAR(1024),
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_theme_content_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_theme_content` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
