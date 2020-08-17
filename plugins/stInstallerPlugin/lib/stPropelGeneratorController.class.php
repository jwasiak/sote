<?php

/**
 * SOTESHOP/stInstallerPlugin
 *
 * Ten plik należy do aplikacji stInstallerPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stInstallerPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stPropelGeneratorController.class.php 3782 2010-03-05 13:39:42Z marek $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */
require_once sfConfig::get('sf_symfony_lib_dir').'/vendor/pake/pakeColor.class.php';
/**
 * Klasa umożliwiająca kontrolę nad przebiegiem generowania bazy danych na podstawie schematów *schema.yml
 *
 * @package     stInstallerPlugin
 * @subpackage  libs
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */
class stPropelGeneratorController
{

   /**
    * Flaga - buduj bazę danych na podstawie informacji z pliku package-schema-diff.yml
    *
    * @var bool 
    */
   protected static $schemaDiffBuildControl = false;
   /**
    * Flaga - usuwaj tabele podczas ich tworzenia
    *
    * @var bool
    */
   protected static $dropStatements = true;
   protected static $forceRebuild = false;

   public static function forceRebuild()
   {
      self::$forceRebuild = true;
   }

   /**
    * Wyłącz usuwanie tabel podczas ich tworzenia
    *
    */
   public static function disableDropStatements()
   {
      self::showInfo('disabling', 'drop statements on table creation');

      self::$dropStatements = false;
   }

   /**
    * Włącz usuwanie tabel podczas ich tworzenia
    *
    */
   public static function enableDropStatements()
   {
      self::showInfo('enabling', 'drop statements on table creation');

      self::$dropStatements = true;
   }

   /**
    * Wyłącz budowanie bazy danych na podstawie informacji z pliku package-schema-diff.yml
    *
    */
   public static function disableSchemaDiffBuildControl()
   {
      self::showInfo('disabling', 'schema difference build control');

      self::$schemaDiffBuildControl = false;
   }

   /**
    * Włącz budowanie bazy danych na podstawie informacji z pliku package-schema-diff.yml
    *
    */
   public static function enableSchemaDiffBuildControl()
   {
      self::showInfo('enabling', 'schema difference build control');

      self::$schemaDiffBuildControl = true;
   }

   public static function isSchemaDiffBuildControl()
   {
      return self::$schemaDiffBuildControl;
   }

   public static function isDropStatements()
   {
      return self::$dropStatements;
   }

   public static function getPluginDirs()
   {
      static $plugin_dirs = null;

      if (null === $plugin_dirs)
      {
         $plugin_dirs = glob(sfConfig::get('sf_plugins_dir').DIRECTORY_SEPARATOR.'*');
      }

      return $plugin_dirs;
   }

   public static function isDatabaseRebuildNeeded()
   {
      return self::$forceRebuild || is_file(sfConfig::get('sf_config_dir').DIRECTORY_SEPARATOR.'schema-diff.yml');
   }

   public static function isForced()
   {
      return self::$forceRebuild;
   }

   protected static function showInfo($action, $message)
   {
      if (pakeApp::get_instance()->get_verbose())
      {
         pakeColor::style('GENERATOR_INFO', array('fg' => 'blue'));
         $width = 9 + strlen(pakeColor::colorize('', 'GENERATOR_INFO'));
         echo sprintf('>> %-'.$width.'s %s', pakeColor::colorize($action, 'GENERATOR_INFO'), $message)."\n";
      }
   }

}

?>