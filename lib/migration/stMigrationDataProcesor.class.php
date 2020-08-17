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
 * @version     $Id: stMigrationDataProcesor.class.php 2217 2009-07-20 13:49:18Z marcin $
 */

/**
 * Procesor danych aplikacji stMigration
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @package     stMigration
 * @subpackage  libs
 */
class stMigrationDataProcesor extends sfPropelBehavior
{

   /**
    * Nazwa klasy modelu
    *
    * @var string
    */
   protected $modelClass = null;
   /**
    * Lista metod modelu do populacji
    *
    * @var array
    */
   protected $modelFillin = array();
   /**
    * Dodatkowe parametry przekazywane do modelu
    *
    * @var array
    */
   protected $modelParams = array();
   /**
    * Automatyczny zapis modelu
    *
    * @var bool
    */
   protected $autoSaveModel = true;
   /**
    * Lista zarejestrowanych zachowań propela dla danej klasy
    *
    * @var array
    */
   protected static $classBehaviors = array();
   
   protected static $includedModelClass = array();
      
   /**
    *
    * Obiekt polaczenia z baza danych wykorzystywany do transakcji
    *
    * @var CreoleConnection
    */
   protected $propelConnection = null;

   public function __construct()
   {
      stPropelSeoUrlBehavior::configuration(array('auto_generate_url' => true));
   }

   /**
    * Ustawia listę metod modelu do populacji
    *
    * @param array $model_fillin (format: 'nazwa_metody_modelu' => array('params' => 'nazwa_kolumny_zrodlowej'))
    * @return stMigrationDataProcesor
    */
   public function setModelFillin($model_fillin)
   {
      $this->modelFillin = $model_fillin;

      return $this;
   }

   /**
    * Ustawia klase modelu
    *
    * @param string Nazwa klasy modelu
    * @return stMigrationDataProcesor
    */
   public function setModelClass($model_class)
   {
      $this->modelClass = $model_class;

      return $this;
   }

   /**
    * Ustawia dodatkowe parametry przekazywane do metod interfejsowych modelu
    *
    * @param array $params (format: array('nazwa_parametru' => 'wartosc'))
    */
   public function setModelParams($params = array())
   {
      $this->modelParams = $params;
   }

   /**
    * Określa czy utworzony model ma być automatycznie zapisywany
    *
    * @param bool $auto_save Zapisuj automatycznie (domyślnie: true)
    */
   public function autoSaveModel($auto_save = true)
   {
      $this->autoSaveModel = $auto_save;
   }

   public function beginTransaction()
   {
//      $this->propelConnection = Propel::getConnection('propel');

//      $this->propelConnection->begin();
   }

   public function commitTransaction()
   {
//      $this->propelConnection->commit();
   }

   public function rollbackTransaction()
   {
//      $this->propelConnection->rollback();
   }

   public function process($data = array())
   {      
      $model_class = $this->modelClass;

      self::addMigrationBehavior($model_class);

      $object = new $model_class();
      $object->setMigrationParam($this->modelParams);

      if ($object->validateFillin($data))
      {
         $object->postCreate();

         foreach ($this->modelFillin as $model_getter => $source_config)
         {
            $method = 'set' . sfInflector::camelize($model_getter);

            if (!isset($source_config['params']))
            {
               throw new sfException(sprintf('No "params" property set for "model_fillin.%s.%s"', $model_class, $model_getter));
            }

            $source_data = $this->parseSourceData((array) $source_config['params'], $data);

            call_user_func_array(array($object, $method), $source_data);
         }

         if ($this->autoSaveModel)
         {
            $object->preSave($this->propelConnection);

            $object->save($this->propelConnection);

            $object->postSave($this->propelConnection);
         }
      }
   }

   /**
    * Przypisuje wartości poszczególnym parametrom z "model_fillin.model.getter.params"
    *
    * @param array $source_params Parametry z "model_fillin.model.getter.params"
    * @param array $data Dane źródłowe
    *
    * @return array Parametry z danymi źródłowymi
    */
   protected function parseSourceData($source_params, $data)
   {
      $source_data = array();

      foreach ($source_params as $param_name => $param_value)
      {
         if (is_array($param_value))
         {
            $source_data[$param_name] = $this->parseSourceData($param_value, $data);
         }
         else
         {
            if (!array_key_exists($param_value, $data))
            {
               throw new sfException(sprintf('Couldn\'t obtain column "%s" from source data...', $param_value));
            }

            $source_data[$param_value] = trim($data[$param_value]);
         }
      }

      return $source_data;
   }

   /**
    * Sprawdza czy podany model istnieje
    *
    * @param string $model_class Nazwa klasy modelu
    */
   protected static function checkModelClass($model_class)
   {
      if (is_null($model_class))
      {
         throw new sfException('You must set a model class (see ::setModelClass)');
      }

      if (!sfCore::getClassPath($model_class))
      {
         throw new sfException(sprintf('The model class "%s" doesn\'t exist', $model_class));
      }
   }

   /**
    * Podpina klase migracji pod podany model
    *
    * @param string $model_class Nazwa klasy modelu
    */
   protected static function addMigrationBehavior($model_class)
   {
      self::checkModelClass($model_class);

      $behavior_class = stMigration::getMigrationModelClassName($model_class);

      if (!class_exists($behavior_class, false))
      {
         $behavior_class = 'stMigrationModel';
      }

      if (!isset(self::$behaviors[$behavior_class]))
      {
         self::addBehaviorMethods($behavior_class);
      }

      if (!isset(self::$classBehaviors[$model_class . $behavior_class]))
      {
         self::add($model_class, array($behavior_class));

         self::$classBehaviors[$model_class . $behavior_class] = true;
      }
   }

   /**
    * Rejestruje metody dla podanej klasy zachowań
    *
    * @param string $behavior_class Nazwa klasy zawierającej metody zachowań propela
    */
   protected static function addBehaviorMethods($behavior_class)
   {
      $class_methods = get_class_methods($behavior_class);

      foreach ($class_methods as $class_method)
      {
         self::registerMethod($behavior_class, array($behavior_class, $class_method));
      }
   }

   /**
    * Rejestruje nowa metodę dla danego zachowania
    *
    * @param string $name Nazwa zachowania
    * @param array $callable Metoda (format: array('nazwa_klasy' => 'nazwa_metody'))
    */
   public static function registerMethod($name, $callable)
   {
      if (!isset(self::$behaviors[$name]))
      {
         self::$behaviors[$name] = array('methods' => array(), 'hooks' => array());
      }

      self::$behaviors[$name]['methods'][] = $callable;
   }

   /**
    * Recznie załącza klase migracyjną rozszerzającą podany model
    *
    * @param string $plugin Nazwa pluginu który zawiera klase migracyjną
    * @param string $migration Nazwa migracji
    * @param string $model_class Nazwa klasy modelu
    */
   public static function includeMigrationModelClass($plugin, $migration, $model_class)
   {
      if (!isset(self::$includedModelClass[$model_class]))
      {
         $path = stMigration::getMigrationModelClassPath($plugin, $migration, $model_class);

         if (is_file($path))
         {
            include $path;
         }
         
         self::$includedModelClass[$model_class] = true;
      }
   }

}