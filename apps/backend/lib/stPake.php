<?php            

/*
 * Wykonywanie task'ów przez WWW     
 *
 * Dane wejsciowe jako zmienne globalne: argv, sf_root_dir  
 * Skrypt zbudowany na podstwie symfony.php
 * 
 */
 
error_reporting(E_ALL);      
 
if (ini_get('zend.ze1_compatibility_mode'))
{
   die("symfony cannot run with zend.ze1_compatibility_mode enabled.\nPlease turn zend.ze1_compatibility_mode to Off in your php.ini.\n");
}

// set magic_quotes_runtime to off
ini_set('magic_quotes_runtime', 'Off');

/*
// force populating $argc and $argv in the case PHP does not automatically create them (fixes #2943)
if (empty($argv)) $argv = $_SERVER['argv'];
$argc = $_SERVER['argc'];             
 
echo "<form>command:<input type=text size=80 name=task><input type=submit value=execute></form>";           
$task=@$_REQUEST['task'];
if (! empty($task)) {             
    $argv=array();$argv=array('/usr/bin/symfony');    
    $command=explode(' ',$task,1000);
    $argv=array_merge($argv,$command);
} 
*/           
                                     
// zaladuj konfiguracje                 
if (empty($sf_root_dir)) $sf_root_dir=dirname(dirname(__FILE__).DIRECTORY_SEPARATOR); // +sote  
require_once ("config/config.php");   
define("STDOUT",1);        
$stderr=fopen($sf_root_dir.DIRECTORY_SEPARATOR.'log'.DIRECTORY_SEPARATOR.'webinstaller.log','a+');     // w tym pliku zapisywane sa Exceptions jako text
define("STDERR",$stderr);        
// end

require_once($sf_symfony_lib_dir.'/vendor/pake/pakeFunction.php');
require_once($sf_symfony_lib_dir.'/vendor/pake/pakeGetopt.class.php');

// autoloading for pake tasks
class simpleAutoloader
{
  static public
    $class_paths        = array(),
    $autoload_callables = array();

  static public function initialize($sf_symfony_lib_dir)
  {
    self::$class_paths = array();

    self::register($sf_symfony_lib_dir, '.class.php');
    self::register($sf_symfony_lib_dir.'/vendor/propel', '.php');
    self::register($sf_symfony_lib_dir.'/vendor/creole', '.php');
    self::register('lib/model', '.php');
    // self::register('plugins', '.php');          // - sote
    self::register('../plugins', '.php');          // + sote
  }

  static public function __autoload($class)
  {
    if (!isset(self::$class_paths[$class]))
    {
      foreach ((array) self::$autoload_callables as $callable)
      {
        if (call_user_func($callable, $class))
        {
          return true;
        }
      }

      return false;
    }

    require_once(self::$class_paths[$class]);

    return true;
  }

  static public function register($dir, $ext)
  {
    if (!is_dir($dir))
    {
      return;
    }

    foreach (pakeFinder::type('file')->name('*'.$ext)->ignore_version_control()->follow_link()->in($dir) as $file)
    {
      self::$class_paths[str_replace($ext, '', str_replace('.class', '', basename($file, $ext)))] = $file;
    }
  }

  static public function add($class, $file)
  {   
    if (!is_file($file))
    {
      return;
    }

    self::$class_paths[$class] = $file;
  }

  static public function registerCallable($callable)
  {
    if (!is_callable($callable))
    {
      throw new Exception('Autoload callable does not exist');
    }

    self::$autoload_callables[] = $callable;
  }
}

function __autoload($class)
{
  static $initialized = false;

  if (!$initialized)
  {
    simpleAutoloader::initialize(sfConfig::get('sf_symfony_lib_dir'));
    $initialized = true;
  }

  return simpleAutoloader::__autoload($class);
}
  
// trap -V before pake
if (in_array('-V', $argv) || in_array('--version', $argv))
{
  printf("symfony version %s\n", trim(file_get_contents($sf_symfony_lib_dir.'/VERSION'), 'INFO'));
  exit(0);
}

if (count($argv) <= 1)
{
  $argv[] = '-T';
}                                                      

// @todo przeciazyc ta klase zmienic odczytywanie konfigow           
require_once($sf_symfony_lib_dir.'/config/sfConfig.class.php');                                    

sfConfig::add(array(
  'sf_root_dir'         => $sf_root_dir,                                              // +- sote
  'sf_symfony_lib_dir'  => $sf_symfony_lib_dir,
  'sf_symfony_data_dir' => $sf_symfony_data_dir,
));

// directory layout     
// @todo dodac przeciazenie tego wywolania
include($sf_symfony_data_dir.'/config/constants.php');       
#include(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'stInstallerWebPlugin'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'constants.php');   


// include path
set_include_path(
  sfConfig::get('sf_lib_dir').PATH_SEPARATOR.
  sfConfig::get('sf_app_lib_dir').PATH_SEPARATOR.
  sfConfig::get('sf_model_dir').PATH_SEPARATOR.
  sfConfig::get('sf_symfony_lib_dir').DIRECTORY_SEPARATOR.'vendor'.PATH_SEPARATOR.
  get_include_path()
);
          

// register tasks
$dirs = array(
  sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'tasks'         => 'myPake*.php', // project tasks
  sfConfig::get('sf_symfony_data_dir').DIRECTORY_SEPARATOR.'tasks' => 'sfPake*.php', // symfony tasks
  sfConfig::get('sf_root_dir').'/plugins/*/data/tasks'             => '*.php',       // plugin tasks                  // +- sote 
);               

                         
foreach ($dirs as $globDir => $name)
{                          
  if ($dirs = glob($globDir))
  {                 
    $tasks = pakeFinder::type('file')->ignore_version_control()->name($name)->in($dirs);
    foreach ($tasks as $task)
    {                      
      // echo "inclue task: $task \n";
      include_once($task);
    }
  }
}    

// run task
// pakeApp::get_instance()->run(null, null, false);
