<?php

if (version_compare($version_old, '1.0.9.78', '<'))
{
   $product_template_dir = sfConfig::get('sf_root_dir').'/apps/backend/modules/stProduct/templates';

   if (is_file($product_template_dir.'/_options_stock_list_th_tabular.php'))
   {
      unlink($product_template_dir.'/_options_stock_list_th_tabular.php');
   }

   if (is_file($product_template_dir.'/_options_stock_list_pager.php'))
   {
      unlink($product_template_dir.'/_options_stock_list_pager.php');
   }

   if (is_file($product_template_dir.'/_options_stock_list_select_control.php'))
   {
      unlink($product_template_dir.'/_options_stock_list_select_control.php');
   }

   if (is_file($product_template_dir.'/_options_stock_list_td_tabular.php'))
   {
      unlink($product_template_dir.'/_options_stock_list_td_tabular.php');
   }

   if (is_file($product_template_dir.'/_options_stock_list_th_filters.php'))
   {
      unlink($product_template_dir.'/_options_stock_list_th_filters.php');
   }
}

if (version_compare($version_old, '2.1.0.18', '<'))
{
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();

    Propel::getConnection()->executeQuery('UPDATE st_product_options_value v, st_product_options_field f SET v.opt_filter_id = f.product_options_filter_id WHERE v.product_options_field_id = f.id');
}

if (version_compare($version_old, '2.1.0.16', '<'))
{
    $dispatcher = stEventDispatcher::getInstance();

    $dispatcher->connect('stInstallerTaks.onClose', array('stProductOptionsPluginListener', 'postInstall'));
}

if (version_compare($version_old, '7.0.1.30', '<'))
{
   $product_template_dir = sfConfig::get('sf_root_dir').'/apps/backend/modules/stProduct/templates';

   if (is_file($product_template_dir.'/_options_stock_list_messages.php'))
   {
      unlink($product_template_dir.'/_options_stock_list_messages.php');
   }
}

if (version_compare($version_old, '7.2.1.2', '<'))
{
   $config = stConfig::getInstance('stProduct');
   $config->set('product_options_filters_enabled', !stConfig::getInstance('appProductAttributeBackend')->get('filters_enabled'));
   $config->save(true);
}