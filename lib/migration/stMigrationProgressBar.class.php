<?php

/**
 * SOTESHOP/stMigration
 *
 * Ten plik należy do aplikacji stMigration opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stMigration
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stMigrationProgressBar.class.php 2217 2009-07-20 13:49:18Z marcin $
 */

/**
 * Klasa odpowiadająca za obsługę procesu migracji
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @package     stMigration
 * @subpackage  libs
 */
class stMigrationProgressBar
{

   protected $context = null;
   protected $migrations = array();
   protected $migrationList = array();
   protected $migrationListIndex = 0;
   protected $databaseParams = array();
   protected $migrationType = '';
   protected $pluginName = '';
   protected $tableOffset = 0;
   protected $tableRecordCount = 0;
   /**
    *
    * Obiekt odpowiedzialny za import danych
    *
    * @var stMigrationDataProcesor
    */
   protected $dataProcessor = null;
   /**
    *
    * Obiekt odpowiedzialny za eksport danych
    *
    * @var stMigrationDataRetriever
    */
   protected $dataRetriever = null;

   public function __construct()
   {
      $this->disableEvents();          
      
      $this->context = sfContext::getInstance();

      $this->loadSession();

      $this->dataRetriever = stMigrationDataRetriever::getInstance($this->databaseParams);

      $this->dataProcessor = new stMigrationDataProcesor();

      $this->dataProcessor->setModelParams(array('www' => $this->databaseParams['www']));
   }

   public function cleanup($offset)
   {      
      $user = $this->context->getUser();

      $i18n = sfContext::getInstance()->getI18N();

      $this->setMessage($i18n->__('Usuwanie aktualnych danych', array(), 'stMigration'));

      $clean_list = $user->getAttribute('cleanList', array(), 'soteshop/stMigrationProgressBar');

      $clean_list_index = $user->getAttribute('cleanList-index', 0, 'soteshop/stMigrationProgressBar');

      $erase_count = $user->getAttribute('cleanList-count', 0, 'soteshop/stMigrationProgressBar');

      $c = new Criteria();

      $c->setLimit(100);

      $modelName = $clean_list[$clean_list_index];

      if ($modelName == 'sfGuardUser')
      {
         $c->addJoin(sfGuardUserGroupPeer::USER_ID, sfGuardUserPeer::ID);

         $c->addJoin(sfGuardUserGroupPeer::GROUP_ID, sfGuardGroupPeer::ID);

         $c->add(sfGuardGroupPeer::NAME, 'user');
      }
      elseif ($modelName == 'sfAsset')
      {
         $c->add(sfAssetPeer::FILENAME, 'no_image.png', Criteria::NOT_LIKE);
      }
      elseif ($modelName == 'sfAssetFolder')
      {

         $criterion = $c->getNewCriterion(sfAssetFolderPeer::NAME, 'media', Criteria::NOT_LIKE);

         $criterion->addAnd($c->getNewCriterion(sfAssetFolderPeer::NAME, 'products', Criteria::NOT_LIKE));

         $criterion->addAnd($c->getNewCriterion(sfAssetFolderPeer::NAME, 'categories', Criteria::NOT_LIKE));

         $criterion->addAnd($c->getNewCriterion(sfAssetFolderPeer::NAME, 'shares', Criteria::NOT_LIKE));

         $c->add($criterion);

         $c->addDescendingOrderByColumn(sfAssetFolderPeer::RELATIVE_PATH);
      }
      elseif ($modelName == 'Category')
      {
         $c->add(CategoryPeer::PARENT_ID, null, Criteria::ISNULL);
      }
      elseif ($modelName == 'ProductOptionsValue')
      {
         $c->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID, null, Criteria::ISNULL);
      }

      $objects = call_user_func($modelName . 'Peer::doSelect', $c);

      $erased = 0;

      foreach ($objects as $object)
      {
         $offset++;

         $erase_count--;

         if ($modelName == 'sfAssetFolder')
         {
            $object = $object->reload();

            $path = $object->getFullPath();

            $this->recursiveRemoveDirectory($path);
         }

         $object->delete();
      }

      if ($erase_count == 0 && !isset($clean_list[$clean_list_index]))
      {
         $this->updateAutoIncrement($modelName);
         $user->setAttribute('cleanList-count', $erase_count, 'soteshop/stMigrationProgressBar');

         self::setAction('process');

         return $offset;
      }

      $c->setLimit(0);

      $count = call_user_func($modelName . 'Peer::doCount', $c);

      if ($count == 0)
      {
         $this->updateAutoIncrement($modelName);

         $clean_list_index++;

         if (!isset($clean_list[$clean_list_index])) 
         {
            $user->setAttribute('cleanList-count', 0, 'soteshop/stMigrationProgressBar');
            self::setAction('process');
            return $offset + $erase_count;
         }
      }

      $user->setAttribute('cleanList-index', $clean_list_index, 'soteshop/stMigrationProgressBar');

      $user->setAttribute('cleanList-count', $erase_count, 'soteshop/stMigrationProgressBar');

      return $offset;
   }

   public function process($offset)
   {
      $user = $this->context->getUser();

      $i18n = sfContext::getInstance()->getI18N();

      $migration_name = $this->getCurrentMigrationName();

      $model_fillin = $this->migrations[$migration_name]['model_fillin'];

      $params = $this->migrations[$migration_name]['params'];

      $query = $params['source']['query'];

      $limit = $params['limit'];

      $description = isset($params['description']) ? $params['description'] : $i18n->__('Import danych', array(), 'stMigration');

      $this->setMessage(sprintf("%s - %d / %d", $i18n->__($description, array(), 'stMigration'), $this->tableOffset, $this->getTableRecordCount()));

      try
      {
         $stmt = $this->dataRetriever->prepareStatement($query);

         $stmt->setOffset($this->tableOffset);

         $stmt->setLimit($limit);

         $rs = $stmt->executeQuery();

         while ($rs->next())
         {
            $migration_data = $rs->getRow();

            foreach ($model_fillin as $model_class => $fillin_data)
            {
               stMigrationDataProcesor::includeMigrationModelClass($this->pluginName, $this->migrationType, $model_class);

               $class = stMigration::getMigrationModelClassName($model_class);

               if ($this->tableOffset == 0)
               {
                  call_user_func(array($class, 'preProcess'), $this->dataRetriever);
               }

               $this->dataProcessor->setModelClass($model_class);

               $this->dataProcessor->setModelFillin($fillin_data);

               $this->dataProcessor->process($migration_data);
            }

            $offset++;
            
            $this->tableOffset++;
         }

      } catch (sfException $e)
      {
         throw $e;
      }

      if ($this->tableOffset >= $this->getTableRecordCount())
      {
         foreach ($model_fillin as $model_class => $fillin_data)
         {
            stMigrationDataProcesor::includeMigrationModelClass($this->pluginName, $this->migrationType, $model_class);

            $class = stMigration::getMigrationModelClassName($model_class);
            
            call_user_func(array($class, 'postProcess'), $this->dataRetriever);
         }
         
         $this->getNextMigrationName();

         $this->tableOffset = 0;

         $this->tableRecordCount = null;
      }

      $this->saveSession();

      return $offset;
   }

   public function init()
   {
      if (is_file(sfConfig::get('sf_log_dir') . DIRECTORY_SEPARATOR . 'migration.log'))
      {
         unlink(sfConfig::get('sf_log_dir') . DIRECTORY_SEPARATOR . 'migration.log');
      }
   }

   public function close()
   {
      $i18n = sfContext::getInstance()->getI18N();

      $this->setMessage($i18n->__('Import danych zakończony sukcesem', array(), 'stMigration'));

      self::cleanSession();
   }

   public function setMessage($message)
   {
      $user = $this->context->getUser();

      $user->setAttribute('stProgressBar-stMigration', $message, 'symfony/flash');
   }

   protected function loadSession()
   {
      $user = $this->context->getUser();

      $this->databaseParams = $user->getAttribute('database', null, 'soteshop/stMigrationProgressBar');

      $migrations = $user->getAttribute('migration', array(), 'soteshop/stMigrationProgressBar');

      $this->migrations = $migrations['migration'];

      $this->tableOffset = $user->getAttribute('tableOffset', 0, 'soteshop/stMigrationProgressBar');

      $this->tableRecordCount = $user->getAttribute('tableRecordCount', null, 'soteshop/stMigrationProgressBar');

      $this->migrationListIndex = $user->getAttribute('migrationListIndex', 0, 'soteshop/stMigrationProgressBar');

      $this->migrationList = isset($migrations['migration']['_attributes']['imports']) ? $migrations['migration']['_attributes']['imports'] : array_keys($this->migrations);

      list($this->pluginName, $this->migrationType) = explode(':', $this->databaseParams['type']);
   }

   public static function cleanSession()
   {
      $user = sfContext::getInstance()->getUser();

      $user->getAttributeHolder()->removeNamespace('soteshop/stMigrationProgressBar');
   }

   /**
    * Zwraca nazwę aktualnej migracji danych
    *
    * @return string Nazwa migracji danych
    */
   protected function getCurrentMigrationName()
   {
      return isset($this->migrationList[$this->migrationListIndex]) ? $this->migrationList[$this->migrationListIndex] : null;
   }

   /**
    * Zwiększa indeks na liście migracji i zwraca następną nazwę migracji
    *
    * @return string Nazwa następnej migracji
    */
   protected function getNextMigrationName()
   {
      $this->migrationListIndex++;

      return $this->getCurrentMigrationName();
   }

   protected function saveSession()
   {
      $user = $this->context->getUser();

      $user->setAttribute('tableOffset', $this->tableOffset, 'soteshop/stMigrationProgressBar');

      $user->setAttribute('tableRecordCount', $this->getTableRecordCount(), 'soteshop/stMigrationProgressBar');

      $user->setAttribute('migrationListIndex', $this->migrationListIndex, 'soteshop/stMigrationProgressBar');
   }

   protected function getTableRecordCount()
   {
      $migration_name = $this->getCurrentMigrationName();

      if (is_null($this->tableRecordCount) && $migration_name)
      {
         $source = $this->migrations[$migration_name]['params']['source'];

         $query = isset($source['count_query']) ? $source['count_query'] : $source['query'];

         $this->tableRecordCount = $this->dataRetriever->countAllRecords($query);
      }

      return $this->tableRecordCount;
   }

   protected static function setAction($action)
   {
      $user = sfContext::getInstance()->getUser();

      $name = sfContext::getInstance()->getRequest()->getParameter('name');

      $info = $user->getAttribute($name, array(), 'soteshop/stProgressBarPlugin');

      $info['method'] = $action;

      $user->setAttribute($name, $info, 'soteshop/stProgressBarPlugin');
   }
   
   protected function disableEvents()
   {
      $config = stConfig::getInstance('stProduct');

      $config->set('depository_enabled', false);      
   }

   protected function updateAutoIncrement($modelName)
   {
      $table = constant($modelName . 'Peer::TABLE_NAME');
      $primary_key = constant($modelName . 'Peer::ID');

      if ($primary_key)
      {
         $con = Propel::getConnection();
         $stmt = $con->prepareStatement("SELECT MAX($primary_key) as id FROM $table");
         $rs = $stmt->executeQuery();

         if ($rs->next()) {
            $autoincrement = $rs->getInt('id') + 1;
         } else {
            $autoincrement = 1;
         }

         $stmt = $con->prepareStatement("ALTER TABLE $table AUTO_INCREMENT = ?");
         $stmt->setInt(1, $autoincrement);
         $stmt->executeQuery();
      }      
   }


   protected function recursiveRemoveDirectory($directory)
   {
      foreach(glob("{$directory}/*") as $file)
      {
         if(is_dir($file)) { 
            $this->recursiveRemoveDirectory($file);
         } else {
            unlink($file);
         }
      }

      rmdir($directory);
   }   
   

}

?>