
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_ecard_transaction
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_ecard_transaction`;


CREATE TABLE `st_ecard_transaction`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`order_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`)
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
