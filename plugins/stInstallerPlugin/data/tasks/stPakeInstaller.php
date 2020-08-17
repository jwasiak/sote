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
 * @subpackage  tasks
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stPakeInstaller.php 3782 2010-03-05 13:39:42Z marek $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 * @author      Marcun Butlak <marcin.butlak@sote.pl>
 */
pake_desc('(SOTE) PEAR Commands. Installer.');
pake_task('pear', 'project_exists');

pake_desc('(SOTE) Synchroznizing installed applications.');
pake_task('installer-sync', 'project_exists');
pake_alias('install-sync', 'installer-sync'); // dodanie starej nazwy

pake_desc('(SOTE) create schema diff for installed applications');
pake_task('installer-schema-diff', 'project_exists');

pake_desc('(SOTE) clean all generated-* schema files');
pake_task('installer-schema-clean', 'project_exists');

pake_desc('(SOTE) installer: rebuilds model and database (production enviroment)');
pake_task('installer-build-all', 'project_exists');

pake_desc('(SOTE) installer: clean om/map, sql and schema files (production enviroment)');
pake_task('installer-clean-model', 'project_exists');

pake_desc('(SOTE) installer: convert yml -> xml schema (production enviroment)');
pake_task('installer-convert-schema', 'project_exists');

pake_desc('(SOTE) installer: create classes for current model (production enviroment)');
pake_task('installer-build-model', 'project_exists');

pake_desc('(SOTE) installer: create sql statements for current model (production enviroment)');
pake_task('installer-build-sql', 'project_exists');

pake_desc('(SOTE) installer: executes sql statements created by installer-build-sql (production enviroment)');
pake_task('installer-insert-sql', 'project_exists');

pake_desc('(SOTE) installer: data loader (production enviroment)');
pake_task('installer-load-data', 'project_exists');

pake_desc('(SOTE) build schema YAML');
pake_task('installer-build-schema-yml', 'project_exists');
pake_alias('build-schema-yml', 'installer-build-schema-yml'); // dodanie starej nazwy
//!hack!: konieczne aby zadanie 'propel-build-sql' uzywalo naszej klasy 'StMysqlDDLBuilder' do generowania SQL
set_include_path(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.sfConfig::get('sf_lib_dir_name').DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'propel-generator'.DIRECTORY_SEPARATOR.'classes'.PATH_SEPARATOR.get_include_path());

sfConfig::set('st_install_dir', sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'src');

/**
 * Wywołaj system instalacji pakietów.
 * Wywołanie 'pear' z odpowiednią konfiguracją. Wrapper soteshop->pear.
 *
 * @param      PakeTask    $task
 * @param         array       $args
 */
function run_pear($task, $args)
{
   stRegisterSync::fixmd5sum();

   $installer = new stInstaller();
   $installer->preAction();

   $system_return = '';

   $argv = array('pear', '-c', sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'.pearrc');
   foreach ($args as $arg)
      $argv[] = $arg;

   $ret = 0;
   system(implode(" ", $argv), $ret);

   if (PEAR::isError($ret))
   {
      throw new PakeException($ret->getMessage()."\n");
   }
   else
   {
      $installer->postAction(); // synchronizacja
      pake_echo($system_return);
   }
}

/**
 * Uaktualnia plikacje w sklepie.
 * Synchronizacja zoinstalownaych przez 'PEAR' aplikacji
 *
 * @param      PakeTask    $task
 * @param         array       $args
 */
function run_installer_sync($task, $args)
{

   $regsync = new stRegisterSync();
   $apps_sync = $regsync->getAppsToSync();

   if ((!empty($args[1])) && ($args[0] == 'forced'))
   {
      $apps_sync = array();
      $nargs = sizeof($args) - 1;
      for ($i = 1; $i <= $nargs; $i++)
      {
         $app_dir = sfConfig::get('st_install_dir').DIRECTORY_SEPARATOR.$args[$i];
         if (is_dir($app_dir))
         {
            $apps_sync['all'][] = $args[$i];
         }
         else
         {
            pake_echo($args[$i].' The '.$args[0].' not found in install/src.');
         }
      }
   }

// czy zapisywac historie instalacji pakietow
// if ($args[0]=='nohistory')  $history=false;
//  else $history=true;
//
// if ($history) pake_echo ("HISTORY TRUE");
//  else pake_echo ("HISTORY FALSE");



   $installer = new stInstaller();
   $ui = new stInstallerOutputPake();
   $installer->setOutputObject($ui);

   if (!empty($apps_sync['all']))
   {

      pake_echo("Upgrading: ".sizeof($apps_sync['all']).' packages. Please wait...');
      $installer->sync($apps_sync['all'], 'Synchronization ('.sizeof($apps_sync['all']).')');

// weryfikacja czy wszystkie pakiety zostaly zsynchronizowane
      $apps_sync_pots = $regsync->getAppsToSync();
      if (sizeof($apps_sync_pots['all']) == 0)
      {
         pake_echo_action("Synchronization", "OK");
      }
   }
   else
      pake_echo_action("Software is already updated.", '');

   unset($regsync);    // memory optimization
   unset($installer);  // memory optimization
   unset($ui);         // memory optimization

   run_clear_cache($task, $args, array('lock' => false));
}

function run_installer_schema_clean($task, $args)
{
   _st_clean_schema();
}

/**
 * Wykonuje różnice pomiedzy schematem aktualnej bazy danych i schematami aplikacji
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @param                 pakeTask    $task               Zadanie
 * @param                 array       $args               Argumenty
 * @return bool
 */
function run_installer_schema_diff($task, $args)
{
   $schema_merge = array();

   _st_clean_schema();

   run_propel_build_schema($task, $args);

   $current_data = Yaml::parse(sfConfig::get('sf_config_dir').DIRECTORY_SEPARATOR.'schema.yml');

   $package_schemas = glob(sfConfig::get('sf_config_dir').DIRECTORY_SEPARATOR.'*.schema.yml');

   foreach (stPropelGeneratorController::getPluginDirs() as $plugin_dir)
   {
      $schema_file = $plugin_dir.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'schema.yml';

      if (is_file($schema_file))
      {
         $package_schemas[] = $schema_file;
      }
   }

   foreach ($package_schemas as $package_schema)
   {
      pake_echo_action('generating diff for', $package_schema);

      $custom_schema_filename = str_replace(array(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR, 'plugins'.DIRECTORY_SEPARATOR, 'config'.DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, 'schema.yml'), array('', '', '', '_', 'schema.custom.yml'), $package_schema);

      pake_echo_action('merging custom schema', $custom_schema_filename);

      $package_data = Yaml::parse($package_schema);

      if (is_file(sfConfig::get('sf_config_dir').DIRECTORY_SEPARATOR.$custom_schema_filename))
      {
         $package_data = sfToolkit::arrayDeepMerge($package_data, Yaml::parse(sfConfig::get('sf_config_dir').DIRECTORY_SEPARATOR.$custom_schema_filename));
      }

      foreach (stPropelGeneratorController::getPluginDirs() as $plugin_dir)
      {
         $custom_schema = $plugin_dir.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.$custom_schema_filename;

         if (is_file($custom_schema))
         {
            $package_data = sfToolkit::arrayDeepMerge($package_data, Yaml::parse($custom_schema));
         }
      }

      $schema_merge = _st_diff_schema($schema_merge, $package_data, $current_data);
   }

   if ($schema_merge)
   {
      $schema_diff_file = sfConfig::get('sf_config_dir').DIRECTORY_SEPARATOR.'schema-diff.yml';

      pake_echo_action('Writing schema diff', $schema_diff_file);

      file_put_contents($schema_diff_file, sfYaml::dump($schema_merge));
   }
   else
   {
      pake_echo_comment('No changes detected');
   }

   pake_echo_action('Schema diff Finished', 'running cleaning task');

   stPakeFileManager::getInstance()->remove(sfConfig::get('sf_config_dir').DIRECTORY_SEPARATOR.'schema.yml');

   return true;
}

function run_installer_load_data($task, $args)
{
   $params = array_flip($args);

   $env = isset($params['env']) ? $params['env'] : 'prod';

   $no_delay = isset($params['no-delay']);

   $more_info = isset($params['more-info']);

   define('SF_ROOT_DIR', sfConfig::get('sf_root_dir'));

   define('SF_APP', 'backend');

   define('SF_ENVIRONMENT', $env);

   define('SF_DEBUG', $env == 'dev');

   require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

   $plugin_dirs = glob(sfConfig::get('sf_plugins_dir').'/*/data/fixtures');

   $dirs = array_merge($plugin_dirs, array(sfConfig::get('sf_data_dir').'/fixtures'));

   $databaseManager = new sfDatabaseManager();

   $databaseManager->initialize();

   $data = new stPropelDataLoader();

   $data->indexFixturesFiles($dirs, $no_delay ? 0 : 200);

   foreach ($dirs as $fixtures_dir)
   {
      pake_echo_action('propel', sprintf('load data from "%s"', $fixtures_dir));

      $files = $data->loadData($fixtures_dir);

      if (!$no_delay)
      {
         sleep(1);
      }

      if ($more_info)
      {
         foreach ($files as $file)
         {
            pake_echo_comment(sprintf('Processing fixture file "%s"', $file));
         }
      }
   }
}

function run_installer_clean_model($task, $args)
{
   $params = array_flip($args);

   if (stPropelGeneratorController::isDatabaseRebuildNeeded() || isset($params['forced']))
   {
      $plugins_dirs = stPropelGeneratorController::getPluginDirs();

      _st_clean_schema($plugins_dirs);

      _st_clean_model($plugins_dirs);

      _st_clean_sql();
   }
   else
   {
      pake_echo_comment('No "config/schema-diff.yml" file found. Taking no action...');
   }
}

function run_installer_build_model($task, $args)
{
   $params = array_flip($args);

   if (stPropelGeneratorController::isDatabaseRebuildNeeded() || isset($params['forced']))
   {
      _call_phing($task, 'om', false);
   }
   else
   {
      pake_echo_comment('No "config/schema-diff.yml" file found. Taking no action...');
   }
}

function run_installer_build_sql($task, $args)
{
   $params = array_flip($args);

   if (stPropelGeneratorController::isDatabaseRebuildNeeded() || isset($params['forced']))
   {
      if (!isset($params['drop-tables']))
      {
         stPropelGeneratorController::disableDropStatements();

         stPropelGeneratorController::enableSchemaDiffBuildControl();
      }

      _call_phing($task, 'sql', false);
   }
   else
   {
      pake_echo_comment('No "config/schema-diff.yml" file found. Taking no action...');
   }
}

function run_installer_insert_sql($task, $args)
{
   $params = array_flip($args);

   if (stPropelGeneratorController::isDatabaseRebuildNeeded() || isset($params['forced']))
   {
      _call_phing($task, 'insert-sql', false);

      if (is_file(sfConfig::get('sf_config_dir').DIRECTORY_SEPARATOR.'schema-diff.yml'))
      {
         pake_echo_action('removing', sfConfig::get('sf_config_dir').DIRECTORY_SEPARATOR.'schema-diff.yml');

         unlink(sfConfig::get('sf_config_dir').DIRECTORY_SEPARATOR.'schema-diff.yml');
      }
   }
   else
   {
      pake_echo_comment('No "config/schema-diff.yml" file found. Taking no action...');
   }
}

function run_installer_convert_schema($task, $args)
{
   $params = array_flip($args);

   if (stPropelGeneratorController::isDatabaseRebuildNeeded() || isset($params['forced']))
   {
      _installer_convert_schema('generated-');
   }
   else
   {
      pake_echo_comment('No "config/schema-diff.yml" file found. Taking no action...');
   }
}

/**
 * Wykonuje wszystkie potrzebne zadania dla nowo instalowanej aplikacji
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @param      paketask    $task
 * @param   array       $args               Lista argumentów przekazanych do zadania
 */
function run_installer_build_all($task, $args)
{
   $params = array_flip($args);

   if (isset($params['forced'])) {
      stPropelGeneratorController::forceRebuild();
   }

   if (stPropelGeneratorController::isDatabaseRebuildNeeded())
   {
      $no_delay = isset($params['no-delay']);

      run_installer_clean_model($task, $args);

      if (!$no_delay)
      {
         sleep(5);
      }

      run_installer_convert_schema($task, $args);

      if (!$no_delay)
      {
         sleep(5);
      }

      run_installer_build_model($task, $args);

      if (!$no_delay)
      {
         sleep(5);
      }

      run_installer_build_sql($task, $args);

      if (!$no_delay)
      {
         sleep(5);
      }

      run_installer_insert_sql($task, $args);

      if (!$no_delay)
      {
         sleep(5);
      }

      _st_clean_schema();

      if (isset($params['and-load']))
      {
         if (!$no_delay)
         {
            sleep(5);
         }

         run_installer_load_data($task, $args);
      }
   }
   else
   {
      pake_echo_comment('No "config/schema-diff.yml" file found. Taking no action...');
   }
}

function _installer_convert_schema($prefix = '')
{
   $plugin_dirs = stPropelGeneratorController::getPluginDirs();

   $finder = pakeFinder::type('file')->ignore_version_control()->name('*schema.yml')->prune('doctrine');

   $dirs = array('config');

   if ($plugin_dirs)
   {
      $dirs = array_merge($dirs, $plugin_dirs);
   }

   $schemas = $finder->in($dirs);

   if (!count($schemas))
   {
      throw new Exception('You must create a schema.yml file.');
   }

   $db_schema = new sfPropelDatabaseSchema();

   foreach ($schemas as $schema)
   {
      $db_schema->loadYAML($schema);

      pake_echo_action('schema', 'converting "'.$schema.'"'.' to XML');

      // save converted xml files in original directories
      $xml_file_name = str_replace('.yml', '.xml', basename($schema));

      $localprefix = $prefix;

      $is_plugin = preg_match('#plugins[/\\\\]([^/\\\\]+)[/\\\\]#', $schema, $match);

      // change prefix for plugins
      if ($is_plugin)
      {
         $localprefix = $prefix.$match[1].'-';

         $file = sfConfig::get('sf_config_dir').DIRECTORY_SEPARATOR.$localprefix.$xml_file_name;
      }
      else
      {
         $file = str_replace(basename($schema), $localprefix.$xml_file_name, $schema);
      }

      pake_echo_action('schema', 'putting '.$file);

      file_put_contents($file, $db_schema->asXML());
   }
}

/**
 * Funkcja pomocnicza wykonująca różnicę "$schema_merge = $package_data / $current_data"
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @param   array       $schema_merge       Tablica z ktora ma
 * @param   unknown_type $package_data
 * @param   unknown_type $current_data
 * @return   unknown
 */
function _st_diff_schema($schema_merge, $package_data, $current_data = array())
{
   $options = array(
         'ignore_columns' => array('foreignTable', 'foreignReference', 'onDelete', 'onUpdate', '_attributes', 'culture', 'phpType', 'isCulture', 'phpName'),
         'convert_types' => array('BOOLEAN' => 'INTEGER'),
         'autocomplete_columns' => array(
            'id' => array(
               'type' =>  'INTEGER',
               'required' => true,
               'primaryKey' => true,
               'autoIncrement' => true,               
            ),
            'created_at' => array(
               'type' => 'TIMESTAMP',
            ),
            'updated_at' => array(
               'type' => 'TIMESTAMP',
            )
         ),
         'autocomplete_attributes' => array('required' => false, 'default' => null, 'autoIncrement' => false),
   );

   foreach ($package_data['propel'] as $table => $package_table_data)
   {
      if ($table[0] == '_')
      {
         continue;
      }

      if (isset($current_data['propel'][$table]))
      {
         if (isset($current_data['propel'][$table]['_uniques'])) {
            foreach ($current_data['propel'][$table]['_uniques'] as $columns) {
               foreach ($columns as $column) {
                  $current_data['propel'][$table][$column]['index'] = 'unique';
               }
            }         
         }

         $column_diff = _st_column_recursive_diff($package_table_data, $current_data['propel'][$table], $options);


         foreach ($column_diff as $column => $data)
         {
            if (!isset($current_data['propel'][$table][$column]))
            {
               $schema_merge['propel']['alter_add'][$table][$column] = $data;
            }
            else
            {
               $schema_merge['propel']['alter_change'][$table][$column] = $data;
            }
         }
      }
      else if (!isset($schema_merge['propel']['alter_add'][$table]) && !isset($schema_merge['propel']['alter_change'][$table]))
      {
         $schema_merge['propel']['create'][$table] = '-';
      }
   }

   return $schema_merge;
}

function _st_column_recursive_diff($aArray1, $aArray2, $options = array(), $debug = false)
{
   $aReturn = array();

   foreach ($aArray1 as $mKey => $mValue)
   {
      if (is_numeric($mKey) || array_search($mKey, $options['ignore_columns']) !== false)
         continue;

      if (isset($options['autocomplete_columns'][$mKey]) && empty($mValue))
      {
         $mValue = $options['autocomplete_columns'][$mKey];
      }

      if (!array_key_exists($mKey, $aArray2) && array_key_exists($mKey, $options['autocomplete_attributes']))
      {
         $aArray2[$mKey] = $options['autocomplete_attributes'][$mKey];
      }

      if (array_key_exists($mKey, $aArray2))
      {
         if (is_array($mValue))
         {
            $aRecursiveDiff = _st_column_recursive_diff($mValue, $aArray2[$mKey], $options, $debug);

            if ($rc = count($aRecursiveDiff))
            {
               if (isset($aRecursiveDiff['change_column']))
               {
                  unset($aRecursiveDiff['change_column']);

                  if ($rc == 1)
                     continue;
               }

               $aReturn[$mKey] = $aRecursiveDiff;
            }
         }
         else
         {
            if (is_string($mValue))
            {
               $type = strtoupper($mValue);
            }
            else
            {
               $type = $mValue;
            }

            if (isset($options['convert_types'][$type]))
            {
               $type = $options['convert_types'][$type];
            }

            $matches = array();

            if (preg_match('/([^)]+)\(([^)]+)\)/', $type, $matches))
            {
               if ($matches[1] != strtoupper($aArray2[$mKey]['type']))
               {
                  $aReturn[$mKey]['type'] = $matches[1];
               }

               if (isset($aArray2[$mKey]['size']) && $matches[2] != strtoupper($aArray2[$mKey]['size']))
               {
                  $aReturn[$mKey]['size'] = $matches[2];
               }
            }
            // elseif (is_array($aArray2[$mKey]) && isset($aArray2[$mKey]['type']))
            // {
            //    if ($type != strtoupper($aArray2[$mKey]['type']))
            //    {
            //       $aReturn[$mKey] = $type;
            //    }
            // }
            else
            {
               if (is_string($aArray2[$mKey]))
               {
                  $type2 = strtoupper($aArray2[$mKey]);
               }
               else
               {
                  $type2 = $aArray2[$mKey];
               }

               if ($type != $type2)
               {
                  $aReturn[$mKey] = $type;
               }
            }
         }
      }
      else
      {

         $aReturn[$mKey] = $mValue;
      }
   }

   return $aReturn;
}

/**
 * Funkcja pomocnicza usuwająca *schema.yml lub *schema.xml
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @param   string      $type               Typ schematu bazy danych (domyślnie xml)
 */
function _st_clean_schema($plugin_dirs = array())
{
   $finder = pakeFinder::type('file')->ignore_version_control()->maxdepth(0)->name('schema.xml')->name('*schema.xml')->name('*schema-transformed.xml')->name('*schema-transformed.yml')->name('/generated([^.]+)[\.-]schema\.yml/');

   $clean_dirs = array();

   if (!is_array($plugin_dirs) || is_array($plugin_dirs) && empty($plugin_dirs))
   {
      $plugin_dirs = stPropelGeneratorController::getPluginDirs();
   }

   foreach ($plugin_dirs as $dir)
   {
      if (is_dir($dir.DIRECTORY_SEPARATOR.'config'))
      {
         $clean_dirs[] = $dir.DIRECTORY_SEPARATOR.'config';
      }
   }

   $schemas = array_merge($finder->in('config'), $finder->in($clean_dirs));

   pake_echo_action('schema', 'cleaning generated schema files...');

   foreach ($schemas as $schema)
   {
      pake_echo_action('schema', "deleting \"$schema\"");

      if (!unlink($schema))
      {
         pake_echo_comment('Wystąpił problem podczas usuwania pliku: '.$schema);
      }
   }
}

/**
 * Usuwa wszystkie *schema.yml i *schema.xml
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 */
function _st_clean_all_schemas()
{
   _st_clean_schema('xml');
//    _st_clean_schema('yml');
}

/**
 * Czyści wszystkie modele z om i map
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 */
function _st_clean_model($plugin_dirs = array())
{
   pake_echo_action('model', 'cleaning "om" "map" files...');

   $file_manager = stPakeFileManager::getInstance();

   $file_manager->remove(sfConfig::get('sf_model_lib_dir').DIRECTORY_SEPARATOR.'om');

   $file_manager->remove(sfConfig::get('sf_model_lib_dir').DIRECTORY_SEPARATOR.'map');

   if (!is_array($plugin_dirs))
   {
      $plugins_dirs = stPropelGeneratorController::getPluginDirs();
   }

   $clean_dirs = array();

   foreach ($plugin_dirs as $dir)
   {
      if (is_dir($dir.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.'om'))
      {
         $file_manager->remove($dir.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.'om');
      }

      if (is_dir($dir.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.'map'))
      {
         $file_manager->remove($dir.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.'map');
      }
   }
}

/**
 * Czyści wszystkie pliki *.sql z data/sql
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 */
function _st_clean_sql()
{
   pake_echo_action('sql', 'cleaning *.sql files...');

   $file_manager = stPakeFileManager::getInstance();

   $file_manager->remove(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'sql');
}

/**
 * Buduje pliki schema yml z plikow xml
 *
 * @param PakeTask $task
 * @param array    $argv
 */
function run_installer_build_schema_yml($task, $argv)
{
   _propel_convert_xml_schema(false);
}

