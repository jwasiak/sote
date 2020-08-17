<?php
if (version_compare($version_old, '1.0.2.51', '<'))
{
   $template_dir = sfConfig::get('sf_plugins_dir').DIRECTORY_SEPARATOR.'stDiscountPlugin'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'stDiscountBackend'.DIRECTORY_SEPARATOR.'templates';

   if (is_file($template_dir.DIRECTORY_SEPARATOR.'_product_list.php'))
   {
      unlink($template_dir.DIRECTORY_SEPARATOR.'_product_list.php');
   }

   if (is_file($template_dir.DIRECTORY_SEPARATOR.'_user_list.php'))
   {
      unlink($template_dir.DIRECTORY_SEPARATOR.'_user_list.php');
   }

}

if (version_compare($version_old, '2.1.0.5', '<'))
{
    try
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();    
        $con = Propel::getConnection();
        $con->executeQuery('ALTER TABLE `st_discount_has_product` DROP PRIMARY KEY, ADD PRIMARY KEY (`product_id`, `discount_id`)');
        $con->executeQuery('ALTER TABLE `st_discount_has_product` DROP INDEX `st_discount_has_product_FI_2`, ADD INDEX `st_discount_has_product_FI_2` ( `discount_id` )');
        $con->executeQuery('OPTIMIZE TABLE `st_discount_has_product`');
    }
    catch(Exception $e)
    {
    }
}
?>