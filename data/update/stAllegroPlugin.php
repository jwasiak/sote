<?php
try {
    if (version_compare($version_old, '7.0.0.0', '<'))
    {
            $file = 'web/images/backend/icons/refresh.png';
            copy(sfConfig::get('sf_root_dir').'/install/src/stAllegroPlugin/stAllegroPlugin/'.$file, sfConfig::get('sf_root_dir').'/'.$file);
    }

} catch (Exception $e) {
    // @todo: log this message
}

try {
    if (version_compare($version_old, '7.1.0.5', '<')) {
        $oldConfig = stConfig::getInstance('stAllegroBackend');
        $newConfig = stConfig::getInstance('stAllegroPlugin');

        $newConfig->set('allegro_pl_api_key', $oldConfig->get('web_api_key'));
        $newConfig->set('allegro_pl_username', $oldConfig->get('allegro_user'));
        $newConfig->set('allegro_pl_password', $oldConfig->get('allegro_pass'));
        $newConfig->set('allegro_pl_state', $oldConfig->get('allegro_state'));
        $newConfig->set('allegro_pl_city', $oldConfig->get('allegro_city'));
        $newConfig->set('allegro_pl_post_code', $oldConfig->get('allegro_post_code'));
        $newConfig->set('bank_account1', $oldConfig->get('bank_account1'));
        $newConfig->set('bank_account2', $oldConfig->get('bank_account2'));
        $newConfig->set('order_combination', $oldConfig->get('order_combination_off'));
        $newConfig->set('image_size', $oldConfig->get('image_size'));
        $newConfig->save(true);

        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $paymentType = new PaymentType();
        $paymentType->setCulture('pl_PL');
        $paymentType->setName('Płatność w serwisie Allegro');
        $paymentType->setModuleName('stAllegro');
        $paymentType->setHideModule(1);
        $paymentType->setActive(0);
        $paymentType->save();
    }

    if (version_compare($version_old, '7.1.0.9', '<')) {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();
        $con = Propel::getConnection();
        $con->executeQuery('ALTER TABLE `st_allegro_auction` CHANGE `id` `id` INT( 11 ) NOT NULL AUTO_INCREMENT');
    }

    if (version_compare($version_old, '7.1.0.31', '<')) {
        $files = array(
                        // files
                        sfConfig::get('sf_root_dir').'/apps/backend/i18n/stAllgroBackend.pl.xml',
                        sfConfig::get('sf_root_dir').'/apps/backend/modules/stProduct/templates/_allegro_list_actions.php',
                        sfConfig::get('sf_root_dir').'/apps/backend/modules/stProduct/templates/_allegro_list_auction_status.php',
                        sfConfig::get('sf_root_dir').'/apps/backend/modules/stProduct/templates/_allegro_list_footer.php',
                        sfConfig::get('sf_root_dir').'/apps/backend/modules/stProduct/templates/_allegro_list_td_actions.php',
                        sfConfig::get('sf_root_dir').'/data/config/stAllegroBackend.yml',
                        sfConfig::get('sf_root_dir').'/packages/stAllegroPlugin/ignore.yml',
                        sfConfig::get('sf_root_dir').'/packages/stAllegroPlugin/phpdoc.yml',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/config/generator/extendComponents.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/lib/helper/AllegroAttributesHelper.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/lib/stAllegroDeliveryValidator.class.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/lib/stAllegroImageValidator.class.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/lib/stAllegroStockValidator.class.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/lib/stAllegroOrder.class.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/lib/stAllegro.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/config/view.yml',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_allegroCategoryId.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_allegro_image.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_allegro_params.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_allegro_state.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_auction_id.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_auction_info.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_auction_status.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_auction_type.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_config_delivery.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_delivery_business.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_delivery_business_on_delivery.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_delivery_cash_on_delivery.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_delivery_cash_on_delivery_priori.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_delivery_certified_letter.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_delivery_certified_letter_priori.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_delivery_courier.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_delivery_courier_cash_on_delivery.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_delivery_letter.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_delivery_letter_priori.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_delivery_option.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_delivery_pack.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_delivery_pack_priori.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_depository_on_sale.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_edit_actions.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_how_long.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_imageSize.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_import_allegro_cateogry.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_import_order.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_import_testwebapi_cateogry.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_list_footer.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_name.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_no_soap.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_orderDeliveryId.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_orderPaymentId.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_order_import_info.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_other_option.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_pay_option.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_price_buy_now.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_price_min.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_price_start.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_product_code.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_sale_many_info.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_shipping_time.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_site.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_status.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_stock.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_stock_type.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_test_state.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/_who_pay.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/copySuccess.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/getcatsSuccess.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/getstatusSuccess.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/infoSuccess.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/listInfoSuccess.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/makeOrderSuccess.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/saleManySuccess.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/showcatSuccess.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/templates/showparamsSuccess.php',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/validate/edit.yml',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroTemplateBackend/lib/stPluginAllegroTemplateBackendActions.class.php',
                        sfConfig::get('sf_root_dir').'/web/css/backend/stAllegro.css',
                        sfConfig::get('sf_root_dir').'/web/stAllegroPlugin/images/ajax-loader.gif',
                        sfConfig::get('sf_root_dir').'/web/stAllegroPlugin/js/stAllegroAuctionStatus.js',
                        sfConfig::get('sf_root_dir').'/web/stAllegroPlugin/js/stCategoryTree.js',
                        sfConfig::get('sf_root_dir').'/web/images/backend/auction/allegro.gif',
                        sfConfig::get('sf_root_dir').'/web/images/backend/icons/copy.png',
                        sfConfig::get('sf_root_dir').'/web/images/backend/icons/refresh.png',
                        sfConfig::get('sf_root_dir').'/web/images/backend/main/icons/stAllegroPlugin.png',
                        sfConfig::get('sf_root_dir').'/web/images/backend/main/icons_small/stAllegroBackend.png',
                        // directories
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroBackend/validate',
                        sfConfig::get('sf_root_dir').'/plugins/stAllegroPlugin/modules/stAllegroTemplateBackend/lib',
                        sfConfig::get('sf_root_dir').'/web/stAllegroPlugin/js',
                        sfConfig::get('sf_root_dir').'/web/stAllegroPlugin/images',
                        sfConfig::get('sf_root_dir').'/web/stAllegroPlugin',
                        sfConfig::get('sf_root_dir').'/web/images/backend/auction',
                    );

        foreach ($files as $file)
            if (file_exists($file))
                if (is_dir($file))
                    rmdir($file);
                else 
                    unlink($file);
    }

    if (version_compare($version_old, '7.1.0.31', '<')) {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();
        $con = Propel::getConnection();
        $con->executeQuery('UPDATE `st_allegro_auction` SET `site` = "AllegroPl" WHERE `site` = "Allegro";');
    }

} catch (Exception $e) {
    // @todo: log this message
}


try
{
    if (version_compare($version_old, '7.5.0.10', '<')) {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize(); 
        Propel::getConnection()->executeQuery("ALTER TABLE `sf_guard_user` DROP INDEX `sf_guard_user_opt_allegro_user_id_unique`");
    }

    if (version_compare($version_old, '7.5.0.14', '<')) {
        $config = stConfig::getInstance('stAllegroBackend');
        $config->set('webapi_order_backward_compatibility_check', true);
        $config->set('import_offset', 14);
        $config->save(true);
    }
}
catch(Exception $e)
{

}

if (version_compare($version_old, '7.5.0.64', '<')) {
    try
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize(); 
        Propel::getConnection()->executeQuery("UPDATE `st_task` SET status = 0");
    }
    catch(Exception $exception)
    {

    }
}

if (version_compare($version_old, '7.5.0.76', '<')) {
    try
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize(); 
        Propel::getConnection()->executeQuery("UPDATE st_allegro_auction a LEFT JOIN st_product p ON p.id = a.product_id SET a.requires_sync = 1 WHERE p.id is not null");
    }
    catch(Exception $exception)
    {

    }
}