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
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 1417 2009-05-27 10:01:46Z marcin $
 */

/**
 * Akcja aplikacji stMigration
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @package     stMigration
 * @subpackage  actions
 */
class stMigrationActions extends stActions
{

   public function executeProcess()
   {
      $erase_count = 0;

      $migration = $this->getRequestParameter('migration');

      $this->forward404Unless($migration, 'Brak danych migracyjnych...');

      list($plugin, $migrationType) = explode(':', $migration['type']);

      $migrations = stMigration::getConfiguration($plugin, $migrationType);
      
      stMigrationProgressBar::cleanSession();

      $this->getUser()->setAttribute('database', $migration, 'soteshop/stMigrationProgressBar');

      $this->getUser()->setAttribute('migration', $migrations, 'soteshop/stMigrationProgressBar');

      $record_count = $this->getUser()->getAttribute('all_data_count', 0, 'soteshop/stMigrationProgressBar');

      if (!$record_count)
      {
         $data_retriever = stMigrationDataRetriever::getInstance($migration);

         $record_count = 0;

         if (isset($migrations['migration']['_attributes']['imports']))
         {
            foreach ($migrations['migration']['_attributes']['imports'] as $import)
            {
               if (!isset($migrations['migration'][$import]))
               {
                  $definions = array_keys($migrations['migration']);
                  
                  unset($definions[0]);
                  
                  throw new sfException(sprintf('Brak definicji importu migration.%s. Dostępne definicje: "%s"', $import, implode(', ', $definions)));
               }

               $source = $migrations['migration'][$import]['params']['source'];
               
               $record_count += $data_retriever->countAllRecords(isset($source['count_query']) ? $source['count_query'] : $source['query']);
            }            
         }
         else
         {
            foreach ($migrations['migration'] as $config)
            {
               $source = $config['params']['source'];
               $record_count += $data_retriever->countAllRecords(isset($source['count_query']) ? $source['count_query'] : $source['query']);
            }
         }
      }

      if (isset($migration['erase_data']))
      {
         $cleanup = array();
         
         if (isset($migrations['migration']['_attributes']['cleanup'])) 
         {
            $cleanup = $migrations['migration']['_attributes']['cleanup'];
         }
         elseif (isset($migrations['cleanup']))
         {
            $cleanup = $migrations['cleanup'];
         }

         foreach ($cleanup as $modelName)
         {
            $c = new Criteria();

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

               $c->addDescendingOrderByColumn(sfAssetFolderPeer::RELATIVE_PATH);

               $c->add($criterion);
            }
            elseif ($modelName == 'Category')
            {
               $c->add(CategoryPeer::PARENT_ID, null, Criteria::ISNULL);
            }
            elseif ($modelName == 'ProductOptionsValue')
            {
               $c->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID, null, Criteria::ISNULL);
            }

            $erase_count += call_user_func($modelName . 'Peer::doCount', $c);
         }

         $this->getUser()->setAttribute('cleanList', $cleanup, 'soteshop/stMigrationProgressBar');

         $this->getUser()->setAttribute('cleanList-count', $erase_count, 'soteshop/stMigrationProgressBar');

         $this->action = "cleanup";
      }
      else
      {
         $this->action = "process";
      }

      $this->record_count = $record_count + $erase_count;
   }

   public function executeIndex()
   {
      $this->getLabels();

      $plugins = stMigration::getRegisteredPlugins();

      $i18n = $this->getContext()->getI18N();

      $migration_options = array();

      foreach ($plugins as $plugin => $config)
      {
         foreach ($config['migrations'] as $migration => $title)
         {
            $migration_options[$plugin . ':' . $migration] = $i18n->__($title);
         }
      }

      $this->migration_options = $migration_options;
   }

   public function handleErrorProcess()
   {
      return $this->forward('stMigration', 'index');
   }

   public function validateProcess()
   {
      stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());

      $i18n = $this->getContext()->getI18N();

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $migration = $this->getRequestParameter('migration');

         $data_retriever = stMigrationDataRetriever::getInstance($migration);

         try
         {
            $data_retriever->getDatabaseConnection();
         } catch (sfDatabaseException $e)
         {
            if (strpos($e->getMessage(), 'connect failed') !== false)
            {
               $ip_addr = gethostbyname($this->getRequest()->getHost());

               $error = $i18n->__('Zweryfikuj podane dane dostępowe.');
               $error_info = $i18n->__('Jeżeli dane są prawidłowe skontaktuj się z administratorem serwera, na którym znajduje się importowany sklep i poproś aby umożliwił dostęp do bazy danych o nazwie "%s" na adres IP "%s" dla użytkownika "%s"');

               if ($migration['host'] != 'localhost')
               {
                  $error .= sprintf($error_info, $migration['host'], $migration['database'], $ip_addr, $migration['username']);
               }
            }
            elseif (strpos($e->getMessage(), 'no such database') !== false)
            {
               $error_info = $i18n->__('Baza danych "%s" nie istnieje');
               $error = sprintf($error_info, $migration['database']);
            }
            else
            {
               $error = $e->getMessage();
            }

            $this->getRequest()->setError('database_connection', $error);

            return false;
         }
      }

      return true;
   }

   protected function getLabels()
   {
      $this->labels = array('migration{erase_data}' => 'Usuń dane', 'migration{www}' => 'Adres sklepu', 'migration{database}' => 'Baza danych', 'migration{type}' => 'Importuj z', 'migration{host}' => 'Host', 'migration{port}' => 'Port', 'migration{username}' => 'Nazwa użytkownika', 'migration{password}' => 'Hasło', 'database_connection' => 'Połączenie z bazą danych');
   }

}

?>