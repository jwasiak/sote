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
 * @version     $Id: StMysqlDDLBuilder.php 3782 2010-03-05 13:39:42Z marek $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */
require_once 'propel/engine/builder/sql/mysql/MysqlDDLBuilder.php';

/**
 * Rozszerzenie klasy MysqlDDLBuilder - generowanie SQL na podstawie różnicy schema.yml
 *
 * @package     stInstallerPlugin
 * @subpackage  libs
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */
class StMysqlDDLBuilder extends MysqlDDLBuilder
{
   protected $con = null;

   /**
    * Załadowane definicje z 'package-schema-diff.yml'
    * @var array
    */
   public static $tableDiff = null;
   /**
    * Lista tabel do utworzenia
    * @var array
    */
   protected $tableCreateDiff = array();
   /**
    * Lista tabel i kolumn do modyfikacji
    * @var array
    */
   protected $tableAlterDiff = array();

   protected static $indexes = array();

   /**
    * Przeciążenie konstruktora - załadowanie definicji 'package-schema-diff.yml'
    *
    * @param         Table       $table
    */
   public function __construct(Table $table)
   {
      parent::__construct($table);

      if (stPropelGeneratorController::isSchemaDiffBuildControl())
      {
         $schema_diff_file = sfConfig::get('sf_config_dir') . DIRECTORY_SEPARATOR . 'schema-diff.yml';
         
         if (is_null(self::$tableDiff) && is_file($schema_diff_file))
         {
            self::$tableDiff = sfYaml::load($schema_diff_file);
         }

         $this->tableCreateDiff = isset(self::$tableDiff['propel']['create']) ? self::$tableDiff['propel']['create'] : array();

         $this->tableAlterAddDiff = isset(self::$tableDiff['propel']['alter_add']) ? self::$tableDiff['propel']['alter_add'] : array();

         $this->tableAlterChangeDiff = isset(self::$tableDiff['propel']['alter_change']) ? self::$tableDiff['propel']['alter_change'] : array();
      }
   }

   public function setCreoleConnection($con)
   {
      $this->con = $con;
   }

   /**
    * Przeciążenie głównej metody zwracającej SQL
    *
    * @return  string      zapytania SQL
    */
   public function build()
   {
      if (stPropelGeneratorController::isSchemaDiffBuildControl())
      {
         $lines = array();

         if (isset($this->tableCreateDiff[$this->getTable()->getName()]))
         {
            $lines[] = parent::build();
         }

         if (isset($this->tableAlterAddDiff[$this->getTable()->getName()]) || stPropelGeneratorController::isForced())
         {
            $this->addAlterHeader($lines);
            $this->addAlterTable($lines);
         }

         if (isset($this->tableAlterChangeDiff[$this->getTable()->getName()]))
         {
            $this->addAlterHeader($lines);
            $this->addAlterTable($lines, true);
         }

         if (isset($this->tableAlterChangeDiff[$this->getTable()->getName()]) || isset($this->tableAlterAddDiff[$this->getTable()->getName()]))
         {
            $this->addAlterTableIndex($lines);
         }

         return implode("\n", $lines);
      }

      return parent::build();
   }

   protected function addAlterTableIndex(&$lines)
   {
      $table = $this->getTable();

      $platform = $this->getPlatform();

      $con = $this->con;
      
      $rs = $con->executeQuery("SHOW INDEXES FROM ".$this->quoteIdentifier($table->getName()));

      $index_list = array();

      while($rs->next())
      {
         $row = $rs->getRow();
         if (!isset($index_list[$row['Key_name']]))
         {
            $index_list[$row['Key_name']] = $row['Column_name'];
         }
      }

      $match_index = implode('|', array_keys($index_list));
     
      $this->addForeignKeysLines($forgeins);

      foreach ($forgeins as $forgein)
      {
         if (!preg_match('/`('.$match_index.')`/', $forgein))
         {
            $alters[] = " ADD ".$forgein;
         }
      }

      $indices = array();

      $this->addIndicesLines($indices);

      // Generowanie zapytań alter dla indeksów
      foreach ($indices as $indice)
      {
         if (!preg_match('/`('.$match_index.')`/', $indice))
         {
            $alters[] = " ADD ".$indice;
         }
      }

      if (!empty($alters))
      {
         $lines[] = "ALTER TABLE ".$this->quoteIdentifier($table->getName()).implode(",", $alters).";\n";
      }      
   }

   /**
    * Dodaje zapytania ALTER dla tabeli
    *
    * @param   array       $lines              Lista zapytań SQL 
    */
   protected function addAlterTable(&$lines, $change = false)
   {
      $table = $this->getTable();

      $platform = $this->getPlatform();

      if ($change)
      {
         $alter_columns = isset($this->tableAlterChangeDiff[$table->getName()]) ? $this->tableAlterChangeDiff[$table->getName()] : array();
      }
      else
      {
         $alter_columns = isset($this->tableAlterAddDiff[$table->getName()]) ? $this->tableAlterAddDiff[$table->getName()] : array();
      }

      $forgeins = array();

      $indices = array();

      $alters = array();

      $primary = array();

      $alterAfterIndex = array();

      // $con = self::getPropelConnection();
      // $rs = $con->executeQuery("SHOW INDEXES FROM ".$this->quoteIdentifier($table->getName()));

      // $index_list = array();

      // while($rs->next())
      // {
      //    $row = $rs->getRow();
      //    if (!isset($index_list[$row['Key_name']]))
      //    {
      //       $index_list[$row['Key_name']] = $row['Column_name'];
      //    }
      // }

      // $match_index = implode('|', array_keys($index_list));

      // Generowanie zapytań ALTER dla kolumn
      foreach ($table->getColumns() as $col)
      {
         if (isset($alter_columns[$col->getName()]))
         {
            $entry = $this->getColumnDDL($col);

            if ($col->getDescription())
            {
               $entry .= " COMMENT '".$platform->escapeText($col->getDescription())."'";
            }

            if ($change)
            {
               if (isset($alter_columns[$col->getName()]['primaryKey']) && $alter_columns[$col->getName()]['primaryKey'])
               {
                  $primary[] = $col->getName();
               }

               if (isset($alter_columns[$col->getName()]['autoIncrement']) && $alter_columns[$col->getName()]['autoIncrement'])
               {
                  $alterAfterIndex[] = " CHANGE ".$this->quoteIdentifier($col->getName())." ".$entry;
                  continue;
               }
            }

            if (isset($alter_columns[$col->getName()]['change_column']))
            {
               $alters[] = " CHANGE ".$this->quoteIdentifier($alter_columns[$col->getName()]['change_column'])." ".$entry;
            }
            else
            {
               if ($change)
               {
                  $alters[] = " CHANGE ".$this->quoteIdentifier($col->getName())." ".$entry;
               }
               else
               {
                  $alters[] = " ADD ".$entry;
               }
            }
         }
      }

    
      if ($primary)
      {
         $alters[] = " ADD PRIMARY KEY (".implode(", ", $primary).")";
      }
      
      if (!empty($alters) || !empty($alterAfterIndex))
      {
         $lines[] = "ALTER TABLE ".$this->quoteIdentifier($table->getName()).implode(",", $alters).($alterAfterIndex ? ($alters ? "," : " ").implode(",", $alterAfterIndex) : "").";\n";
      }
   } 

   /**
    * Dodaje komentarz z nagłówkiem dla zapytań ALTER
    *
    * @param   array       $lines              Lista zapytań SQL
    */
   protected function addAlterHeader(&$lines)
   {
      $lines[] = "";
      $lines[] = "#-----------------------------------------------------------------------------";
      $lines[] = "#-- ALTER TABLE ".$this->getTable()->getName();
      $lines[] = "#-----------------------------------------------------------------------------";
      $lines[] = "";
   }

   /**
    * Przeciążenie dodawania usuwania tabeli
    *
    * @param string $script Zapytania
    */
   protected function addDropStatements(&$script)
   {
      if (stPropelGeneratorController::isDropStatements())
      {
         parent::addDropStatements($script);
      }
   }

   // protected static function getPropelConnection()
   // {
   //    if (null === self::$con)
   //    {
   //       define('SF_ROOT_DIR', sfConfig::get('sf_root_dir'));

   //       define('SF_APP', 'backend');

   //       define('SF_ENVIRONMENT', 'prod');

   //       define('SF_DEBUG', false);

   //       require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';
   //       $databaseManager = new sfDatabaseManager();
   //       $databaseManager->initialize();
         
   //       self::$con = Propel::getConnection();
   //    }

   //    return self::$con;
   // }

}
