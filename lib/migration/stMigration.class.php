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
 * @version     $Id: stMigration.class.php 617 2009-04-09 13:02:31Z michal $
 */

/**
 * Klasa pomocnicza aplikacji stMigration
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @package     stMigration
 * @subpackage  libs
 */
class stMigration
{
   /**
    * Rejestruje migracyjne z podanego pluginu
    * 
    * @param string $plugin Nazwa pluginu zawierającego moduły migracyjne
    * @param array $migrations Lista modułów migracyjnych (format: 'nazwa_modułu' => 'tytuł')  
    * @param string $group_title Opcjonalna nazwa dla grupy modułów  
    */
   public static function register($plugin, $migrations = array(), $group_title = null)
   {
      $plugins = sfConfig::get('st_migration_plugins', array());

      if (isset($plugins[$plugin]))
      {
         throw new sfException(sprintf('Plugin "%s" is already registered...', $plugin));
      }

      $plugins[$plugin] = array('migrations' => $migrations, 'group_title' => $group_title);

      sfConfig::set('st_migration_plugins', $plugins);
   }

   /**
    * Ładuje konfigurację migracji dla danego pluginu
    * 
    * @param string $config_dir Pełna ścieżka do pliku migration.yml
    */
   public static function getConfiguration($plugin, $migration)
   {
      $migration_config_dir = sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . $plugin . DIRECTORY_SEPARATOR . sfConfig::get('sf_app_config_dir_name') . DIRECTORY_SEPARATOR . 'migrations';

      $config = sfYaml::load($migration_config_dir . DIRECTORY_SEPARATOR . (strpos($migration, '.yml') !== false ? $migration : $migration . '.yml'));

      if (isset($config['migration']['_attributes']['extend']))
      {
         $extend = self::getConfiguration($plugin, $config['migration']['_attributes']['extend']);

         unset($config['migration']['_attributes']['extend']);

         $config = self::mergeConfigurations($extend, $config);
      }

      return $config;
   }

   public static function mergeConfigurations($config1, $config2)
   {
      if (!is_array($config2))
      {
         return $config2;
      }

      if (is_int(key($config2)))
      {
         return $config2;
      }

      foreach ($config2 as $k => $v)
      {
         if (!isset($config1[$k]))
         {
            $config1[$k] = $v;
         }
         else
         {
            $config1[$k] = self::mergeConfigurations($config1[$k], $v);
         }
      }

      return $config1;
   }

   public static function getMigrationModelClassPath($plugin, $migration, $model_class)
   {
      $migration_lib_dir = sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . $plugin . DIRECTORY_SEPARATOR . sfConfig::get('sf_app_lib_dir_name') . DIRECTORY_SEPARATOR . 'migrations';

      return $migration_lib_dir . DIRECTORY_SEPARATOR . $migration . DIRECTORY_SEPARATOR . self::getMigrationModelClassName($model_class) . '.class.php';
   }

   public static function getMigrationModelClassName($model_class)
   {
      return 'stMigration' . $model_class;
   }

   /**
    * Pobiera zarejestrowane pluginy wraz z modułami migracyjnymi
    * 
    * @return array
    */
   public static function getRegisteredPlugins()
   {
      return sfConfig::get('st_migration_plugins', array());
   }
}

?>