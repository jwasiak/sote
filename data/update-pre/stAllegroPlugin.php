<?php

if (version_compare($version_old, '7.3.0.37', '<')) {
    try {

            $databaseManager = new sfDatabaseManager();
            $databaseManager->initialize();

            $con = Propel::getConnection();
            
            $con->executeQuery(sprintf('ALTER TABLE `%s` DROP PRIMARY KEY', AllegroAuctionHasOrderPeer::TABLE_NAME));
            $con->executeQuery(sprintf('ALTER TABLE `%s` DROP `created_at`, DROP `updated_at`, DROP `nickname`', AllegroAuctionHasOrderPeer::TABLE_NAME));
            $con->executeQuery(sprintf('ALTER TABLE `%s` CHANGE `trans_id` `trans_id` BIGINT(20) NOT NULL FIRST', AllegroAuctionHasOrderPeer::TABLE_NAME));
            $con->executeQuery(sprintf('ALTER TABLE `%s` ADD PRIMARY KEY( `trans_id`, `allegro_auction_id`, `order_id`)', AllegroAuctionHasOrderPeer::TABLE_NAME));
            $con->executeQuery(sprintf('OPTIMIZE TABLE `%s`', AllegroAuctionHasOrderPeer::TABLE_NAME));  

    } catch (Exception $e) {
        
    }
}