
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_admin_generator_filter
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_admin_generator_filter`;


CREATE TABLE `st_admin_generator_filter`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`guard_user_id` INTEGER  NOT NULL,
	`data_id` INTEGER  NOT NULL,
	`name` VARCHAR(64)  NOT NULL,
	`module_namespace` VARCHAR(64)  NOT NULL,
	`is_global` INTEGER default 0,
	PRIMARY KEY (`id`),
	KEY `namespace_index`(`module_namespace`),
	INDEX `st_admin_generator_filter_FI_1` (`guard_user_id`),
	CONSTRAINT `st_admin_generator_filter_FK_1`
		FOREIGN KEY (`guard_user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE CASCADE,
	INDEX `st_admin_generator_filter_FI_2` (`data_id`),
	CONSTRAINT `st_admin_generator_filter_FK_2`
		FOREIGN KEY (`data_id`)
		REFERENCES `st_admin_generator_filter_data` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_admin_generator_filter_data
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_admin_generator_filter_data`;


CREATE TABLE `st_admin_generator_filter_data`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`data` TEXT,
	PRIMARY KEY (`id`)
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
