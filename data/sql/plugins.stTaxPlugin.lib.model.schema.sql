
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_tax
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_tax`;


CREATE TABLE `st_tax`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`vat` DECIMAL(5,2) default 0 NOT NULL,
	`is_default` INTEGER default 0 NOT NULL,
	`is_active` INTEGER default 1 NOT NULL,
	`vat_name` VARCHAR(45)  NOT NULL,
	`is_system_default` INTEGER default 0 NOT NULL,
	`update_resume` VARCHAR(64),
	PRIMARY KEY (`id`)
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
