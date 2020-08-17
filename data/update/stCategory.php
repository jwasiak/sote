<?php

if (version_compare($version_old, '1.0.4', '<'))
{
   try
   {
      $databaseManager = new sfDatabaseManager();

      $databaseManager->initialize();

      CategoryPeer::fixDepths();

      $databaseManager->shutdown();
   }
   catch (Exception $e)
   {

   }
}

if (version_compare($version_old, '1.0.5.8', '<'))
{
   try
   {
      $databaseManager = new sfDatabaseManager();

      $databaseManager->initialize();

      $c = new Criteria();

      $c->add(CategoryPeer::SF_ASSET_ID, null, Criteria::ISNOTNULL);

      $categories = CategoryPeer::doSelectJoinsfAsset($c);

      foreach ($categories as $category)
      {
         $category->setOptImage($category->getsfAsset()->getRelativePath());

         $category->save();
      }

      $databaseManager->shutdown();
   }
   catch (Exception $e)
   {

   }
}

if (version_compare($version_old, '1.1.0.14', '<'))
{
   try
   {
      $databaseManager = new sfDatabaseManager();

      $databaseManager->initialize();

      $con = Propel::getConnection();

      $con->executeQuery('ALTER TABLE `st_category` CHANGE `lft` `lft` INT( 11 ) NOT NULL ');

      $con->executeQuery('ALTER TABLE `st_category` CHANGE `rgt` `rgt` INT( 11 ) NOT NULL ');

      $con->executeQuery('ALTER TABLE `st_category` CHANGE `scope` `scope` INT( 11 ) NOT NULL ');

      $con->executeQuery('ALTER TABLE `st_category` ADD INDEX `category_Index2` ( `lft` , `scope` )');

      $databaseManager->shutdown();
   }
   catch (Exception $e)
   {

   }
}

if (version_compare($version_old, '1.1.0.17', '<'))
{
   try
   {   
      $databaseManager = new sfDatabaseManager();

      $databaseManager->initialize();
      
      $con = Propel::getConnection();

      $con->executeQuery('DELETE i18n FROM `st_category_i18n` i18n LEFT JOIN `st_category` c ON c.id = i18n.id WHERE c.id IS NULL');

      $databaseManager->shutdown();  
   }
   catch (Exception $e)
   {
      
   }      
}


if (version_compare($version_old, '1.2.0.1', '<'))
{
   try
   {   
      $databaseManager = new sfDatabaseManager();

      $databaseManager->initialize();
      
      $c = new Criteria();
      
      $c->add(CategoryPeer::PARENT_ID, null, Criteria::ISNULL);
      
      $c->addAscendingOrderByColumn(CategoryPeer::ID);
      
      $roots = CategoryPeer::doSelect($c);
      
      foreach ($roots as $index => $root)
      {
         $root->setRootPosition($index + 1);
         
         $root->save();
      }

      $databaseManager->shutdown();  
   }
   catch (Exception $e)
   {
      
   }      
}

if (version_compare($version_old, '2.1.0.8', '<'))
{
   try
   {   
      $databaseManager = new sfDatabaseManager();

      $databaseManager->initialize();
      
      $con = Propel::getConnection();

      $con->executeQuery(sprintf("UPDATE %s SET %s = NULL WHERE %s IS NULL", CategoryPeer::TABLE_NAME, CategoryPeer::OPT_IMAGE, CategoryPeer::SF_ASSET_ID));
   }
   catch (Exception $e)
   {
   }      
}

if (version_compare($version_old, '2.1.0.10', '<'))
{
    $fc = new stFunctionCache('stCategoryTree');
    $fc->removeAll();    
}

if (version_compare($version_old, '7.1.0.0', '<'))
{

   $config1 = stConfig::getInstance('appCategoryHorizontalBackend');
   $config2 = stConfig::getInstance('stCategory');

   $config2->set('menu_on', $config1->get('menu_on'));
   $config2->set('description_on', $config1->get('description_on'));
   $config2->set('image_on', $config1->get('image_on'));
   $config2->set('cathor_tree', $config1->get('category_id'));
   sleep(2);
   $config2->save();
   $config2->load();
}