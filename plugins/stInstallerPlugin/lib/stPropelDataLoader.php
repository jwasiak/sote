<?php

/**
 * This class interacts with the data source
 * and loads data.
 *
 * @package    symfony
 * @subpackage addon
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfPropelData.class.php 662 2009-09-21 12:14:20Z marcin $
 */
class stPropelDataLoader
{

   protected $data = array();
   protected $fixtureMap = array();
   protected $moduleIndex = array();
   protected $maps = array();
   protected $processed = array();
   protected $deletedClasses = array();
   protected $objectReferences = array();

   public function loadData($fixture_dir_or_file, $delay = 0)
   {
      $fixture_files = $this->getFixtureFiles($fixture_dir_or_file);

      foreach ($fixture_files as $fixture_file)
      {
         $this->doLoadData($fixture_file, $delay);
      }

      return $fixture_files;
   }

   protected function doLoadData($fixture_file, $delay = 0)
   {
      if (!isset($this->processed[$fixture_file]))
      {
         $this->doDeleteCurrentData($fixture_file);

         $data = $this->loadFixtureFromFile($fixture_file);

         $this->processed[$fixture_file] = true;

         $this->loadDataFromArray($data, $delay);
      }
   }

   public function loadDataFromArray($data, $delay = 0)
   {
      if ($data === null)
      {
         return;
      }

      foreach ($data as $class => $datas)
      {
         $class = trim($class);

         $peer_class = $class.'Peer';

         $this->loadMapBuilder($class);

         $tableMap = $this->maps[$class]->getDatabaseMap()->getTable(constant($peer_class.'::TABLE_NAME'));

         $column_names = array_flip(call_user_func_array(array($peer_class, 'getFieldNames'), array(BasePeer::TYPE_FIELDNAME)));

         if (!is_array($datas))
         {
            continue;
         }

         if (!is_subclass_of($class, 'BaseObject'))
         {
            throw new Exception(sprintf('The class "%s" is not a Propel class. This probably means there is already a class named "%s" somewhere in symfony or in your project.', $class, $class));
         }

         foreach ($datas as $key => $data)
         {
            $obj = new $class();

            if (!is_array($data))
            {
               throw new Exception(sprintf('You must give a name for each fixture data entry (class %s)', $class));
            }

            foreach ($data as $name => $value)
            {
               $isARealColumn = true;

               try
               {
                  $column = $tableMap->getColumn($name);
               }
               catch (PropelException $e)
               {
                  $isARealColumn = false;
               }

               // foreign key?
               if ($isARealColumn)
               {
                  if ($column->isForeignKey() && !is_null($value))
                  {
                     list($relatedObjectName) = explode("_", $value);

                     if (!isset($this->objectReferences[$value]))
                     {
                        if (!$this->loadFixturesFromClassName($relatedObjectName))
                        {
                           throw new sfException(sprintf('Failed when trying to locate the object "%s" from class "%2$s" or "%2$s.yml" fixture file', $value, $relatedObjectName));
                        }

                        if (!isset($this->objectReferences[$value]))
                        {
                           throw new sfException(sprintf('The object "%s" from class "%s" is not defined in your data file.', $value, $relatedObjectName));
                        }
                     }

                     $value = $this->objectReferences[$value];
                  }
               }

               if (isset($column_names[$name]))
               {
                  $obj->setByPosition($column_names[$name], $value);
               }
               else if (is_callable(array($obj, $method = 'set'.sfInflector::camelize($name))))
               {
                  $obj->$method($value);
               }
               else
               {
                  $error = 'Column "%s" does not exist for class "%s"';

                  $error = sprintf($error, $name, $class);

                  throw new sfException($error);
               }
            }

            $obj->save();

            if (method_exists($obj, 'getPrimaryKey'))
            {
               $this->objectReferences[$key] = $obj->getPrimaryKey();
            }

            $this->delay($delay);
         }
      }
   }

   protected function doDeleteCurrentData($fixture_file)
   {
      $data = $this->loadFixtureFromFile($fixture_file);

      if ($data === null)
      {
         return;
      }

      $classes = array_keys($data);

      krsort($classes);

      foreach ($classes as $class)
      {
         $class = trim($class);

         if (isset($this->deletedClasses[$class]))
         {
            continue;
         }
         
         $peer_class = $class.'Peer';

         if (!$classPath = sfCore::getClassPath($peer_class))
         {
            throw new sfException(sprintf('Unable to find path for class "%s".', $peer_class));
         }

         require_once($classPath);

         call_user_func(array($peer_class, 'doDeleteAll'));

         $this->deletedClasses[$class] = true;
      }
   }

   protected function loadMapBuilder($class)
   {
      $mapBuilderClass = $class.'MapBuilder';

      if (!isset($this->maps[$class]))
      {
         if (!$classPath = sfCore::getClassPath($mapBuilderClass))
         {
            throw new sfException(sprintf('Unable to find path for class "%s".', $mapBuilderClass));
         }

         require_once($classPath);

         $this->maps[$class] = new $mapBuilderClass();

         $this->maps[$class]->doBuild();
      }
   }

   public function indexFixturesFiles($fixtures_dirs = array(), $delay = 0)
   {
      foreach ($fixtures_dirs as $dir)
      {
         $files = $this->getFiles($dir);

         sort($files);

         $this->fixtureMap[$dir] = $files;

         foreach ($files as $file)
         {
            $this->indexFixtureFile($file);
         }

         $this->delay($delay);
      }
   }

   protected function delay($ms = 0)
   {
      if ($ms)
      {
         usleep($ms * 1000);
      }
   }

   protected function indexFixtureFile($file)
   {
      $data = sfYaml::load($file);

      $model_classes = array_keys($data);

      foreach ($model_classes as $model_class)
      {
         if (!isset($this->modelIndex[$model_class]))
         {
            $this->modelIndex[$model_class] = array();
         }

         $this->modelIndex[$model_class][] = $file;
      }

      $this->data[$file] = $data;

      unset($data);
   }

   protected function loadFixtureFromFile($fixture_file)
   {
      if (!isset($this->data[$fixture_file]))
      {
         $this->indexFixtureFile($fixture_file);
      }

      return $this->data[$fixture_file];
   }

   protected function loadFixturesFromClassName($classname)
   {
      if (isset($this->modelIndex[$classname]))
      {
         foreach ($this->modelIndex[$classname] as $file)
         {
            $this->doLoadData($file);
         }
      }
      else
      {
         return false;
      }

      return true;
   }

   protected function getFixtureFiles($dir_or_file)
   {
      if (isset($this->fixtureMap[$dir_or_file]))
      {
         return $this->fixtureMap[$dir_or_file];
      }

      return array($dir_or_file);
   }

   protected function getFiles($directory_or_file = null)
   {
      // directory or file?
      $fixture_files = array();
      if (!$directory_or_file)
      {
         $directory_or_file = sfConfig::get('sf_data_dir').'/fixtures';
      }

      if (is_file($directory_or_file))
      {
         $fixture_files[] = $directory_or_file;
      }
      else if (is_dir($directory_or_file))
      {
         $fixture_files = sfFinder::type('file')->ignore_version_control()->maxdepth(0)->name('*.yml')->in($directory_or_file);
      }
      else
      {
         throw new sfInitializationException('You must give a directory or a file.');
      }

      return $fixture_files;
   }

}