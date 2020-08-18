
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- ALTER TABLE sf_asset_folder
#-----------------------------------------------------------------------------

ALTER TABLE `sf_asset_folder` CHANGE `static_scope` `static_scope` INTEGER;

ALTER TABLE `sf_asset_folder` ADD CONSTRAINT `sf_asset_folder_FK_1`
		FOREIGN KEY (`tree_parent`)
		REFERENCES `sf_asset_folder` (`id`)
		ON DELETE RESTRICT;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
