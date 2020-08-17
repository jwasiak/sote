<?php
try {
if (version_compare($version_old, '1.0.6.22', '<'))
{
    $databaseManager = new sfDatabaseManager();

    $databaseManager->initialize();

    $con = Propel::getConnection();

    BasketProductPeer::doDeleteAll($con);

    BasketPeer::doDeleteAll($con);
}

if (version_compare($version_old, '1.1.0.4', '<'))
{
   $remove_path = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'backend'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'stBasket'.DIRECTORY_SEPARATOR.'templates';

   if (is_file($remove_path.DIRECTORY_SEPARATOR.'_basket_product_list_select_control.php'))
   {
      unlink($remove_path.DIRECTORY_SEPARATOR.'_basket_product_list_select_control.php');
   }

   if (is_file($remove_path.DIRECTORY_SEPARATOR.'_basket_product_list_td_action_select.php'))
   {
      unlink($remove_path.DIRECTORY_SEPARATOR.'_basket_product_list_td_action_select.php');
   }

   if (is_file($remove_path.DIRECTORY_SEPARATOR.'_list_select_control.php'))
   {
      unlink($remove_path.DIRECTORY_SEPARATOR.'_list_select_control.php');
   }

   if (is_file($remove_path.DIRECTORY_SEPARATOR.'_list_td_action_select.php'))
   {
      unlink($remove_path.DIRECTORY_SEPARATOR.'_list_td_action_select.php');
   }     
}

if (version_compare($version_old, '1.2.0.12', '<'))
{

   $context = sfContext::getInstance();
   $config = stConfig::getInstance($context, 'stBasket');
   $config->set('show_products', 1);
   $config->save(true);
}

if (version_compare($version_old, '2.1.2.98', '<'))
{
    $databaseManager = new sfDatabaseManager();

    $databaseManager->initialize();

    $con = Propel::getConnection();

    $c = new Criteria();

    $c->add(BasketProductPeer::PRODUCT_ID, 0);

    BasePeer::doDelete($c, $con);     
}

} catch (Exception $e) {}