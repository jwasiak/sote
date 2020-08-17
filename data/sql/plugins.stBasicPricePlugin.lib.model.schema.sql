
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_basic_price_unit_measure
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_basic_price_unit_measure`;


CREATE TABLE `st_basic_price_unit_measure`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`is_default` INTEGER default 0,
	`is_system` INTEGER default 1,
	`unit_name` VARCHAR(32),
	`unit_symbol` VARCHAR(10)  NOT NULL,
	`unit_group` VARCHAR(10)  NOT NULL,
	`multiplier` DECIMAL(12,4),
	PRIMARY KEY (`id`)
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
