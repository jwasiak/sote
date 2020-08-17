
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_guard_user_has_navigation
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_guard_user_has_navigation`;


CREATE TABLE `st_guard_user_has_navigation`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`sf_guard_user_id` INTEGER  NOT NULL,
	`products` TEXT,
	PRIMARY KEY (`id`,`sf_guard_user_id`),
	INDEX `st_guard_user_has_navigation_FI_1` (`sf_guard_user_id`),
	CONSTRAINT `st_guard_user_has_navigation_FK_1`
		FOREIGN KEY (`sf_guard_user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
