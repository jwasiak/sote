
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_backend_alert
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_backend_alert`;


CREATE TABLE `st_backend_alert`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`opt_name` VARCHAR(255),
	`display` INTEGER,
	`code` VARCHAR(45),
	`opt_description` TEXT,
	PRIMARY KEY (`id`),
	UNIQUE KEY `backed_alert_code_index` (`code`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_backend_alert_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_backend_alert_i18n`;


CREATE TABLE `st_backend_alert_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`name` VARCHAR(255),
	`description` TEXT,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_backend_alert_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_backend_alert` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
