<?php

/**
 * SOTESHOP/stAdminGeneratorPlugin
 *
 * Ten plik należy do aplikacji stAdminGeneratorPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stAdminGeneratorPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stPropelManyToMany.php 8434 2010-09-23 13:14:35Z marcin $
 */

/**
 * Enter description here...
 *
 * @package     stAdminGeneratorPlugin
 * @subpackage  libs
 */
class stPropelManyToMany extends sfPropelManyToMany
{

   public static function getPrimaryKeyColumn($class)
   {
      $tableMap = call_user_func(array($class.'Peer', 'getTableMap'));

      foreach ($tableMap->getColumns() as $column)
      {
         if ($column->isPrimaryKey())
         {
            return $column;
         }
      }

      return null;
   }

   public static function getRelatedColumn($class, $middleClass, $columnName = '')
   {

      // find the related class
      $tableMap = call_user_func(array($middleClass.'Peer', 'getTableMap'));
      $object_table_name = constant($class.'Peer::TABLE_NAME');
      foreach ($tableMap->getColumns() as $column)
      {
         if ($middleClass == 'ProductHasAccessories')
         {
//                print "<pre>";
//                print_r ($column->isForeignKey() . ':' . $object_table_name . '!=' . $column->getRelatedTableName() . ':' . $column->getColumnName() .'=='. strtoupper($columnName));
//                print "</pre>";
         }
         if ($column->isForeignKey() && ($object_table_name != $column->getRelatedTableName() || $column->getColumnName() == strtoupper($columnName)))
         {
            return $column;
         }
      }

//        if ($middleClass == 'ProductHasAccessories')
//        {
//            die();
//        }
   }

   public static function getColumn($class, $middleClass, $columnName = '')
   {
      // find the related class
      $tableMap = call_user_func(array($middleClass.'Peer', 'getTableMap'));
      $object_table_name = constant($class.'Peer::TABLE_NAME');
      foreach ($tableMap->getColumns() as $column)
      {
         if ($column->isForeignKey() && $object_table_name == $column->getRelatedTableName() && $column->getColumnName() != strtoupper($columnName))
         {
            return $column;
         }
      }
   }

   public static function getRelatedClass($class, $middleClass, $columnName = '')
   {
      $column = self::getRelatedColumn($class, $middleClass, $columnName);

      // we must load all map builder classes
      $classes = sfFinder::type('file')->ignore_version_control()->name('*MapBuilder.php')->in(sfLoader::getModelDirs());
      foreach ($classes as $class)
      {
         $class_map_builder = basename($class, '.php');
         $map = new $class_map_builder();
         $map->doBuild();
      }

      $tableMap = call_user_func(array($middleClass.'Peer', 'getTableMap'));

      return $tableMap->getDatabaseMap()->getTable($column->getRelatedTableName())->getPhpName();
   }

}