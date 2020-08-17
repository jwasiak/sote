
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_web_api_session
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_web_api_session`;


CREATE TABLE `st_web_api_session`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`sf_guard_user_id` INTEGER  NOT NULL,
	`hash` VARCHAR(255),
	`active` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `st_web_api_session_FI_1` (`sf_guard_user_id`),
	CONSTRAINT `st_web_api_session_FK_1`
		FOREIGN KEY (`sf_guard_user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
