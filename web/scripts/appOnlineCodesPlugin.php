<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

if (!isset($_REQUEST['hash']) || empty($_REQUEST['hash'])) {
    header('Location: /');
    exit();
}

if (file_exists('../.profile.php'))
    include_once('../.profile.php');


if (defined('ST_ROOT_DIR'))
{
   $sf_root_dir = dirname(__FILE__) . '/..' . ST_ROOT_DIR;
}
else
{
   $sf_root_dir = dirname(__FILE__)  . '/../..';
}

require $sf_root_dir.'/config/config.php';
require $sf_symfony_lib_dir.'/config/sfConfig.class.php';
sfConfig::add(array('sf_root_dir' => $sf_root_dir, 'sf_app' => 'frontend', 'sf_enviroment' => 'prod', 'sf_symfony_lib_dir' => $sf_symfony_lib_dir));

require $sf_symfony_data_dir.'/config/constants.php';

function simpleAutoloader($class) 
{
    $sf_plugins_dir = sfConfig::get('sf_plugins_dir');
    $sf_symfony_lib_dir = sfConfig::get('sf_symfony_lib_dir');
    $classes = array(
        'sfCache' => $sf_symfony_lib_dir.'/cache/sfCache.class.php',
        'sfException' => $sf_symfony_lib_dir.'/exception/sfException.class.php',        
        'sfFileCache' => $sf_symfony_lib_dir.'/cache/sfFileCache.class.php',
        'sfAssetsLibraryTools' => $sf_plugins_dir.'/sfAssetsLibraryPlugin/lib/sfAssetsLibraryTools.class.php',
        'stConfig' => $sf_plugins_dir.'/stConfigPlugin/lib/stConfig.class.php',        
        'Dumper' =>  $sf_plugins_dir.'/stConfigPlugin/lib/sfYaml/Dumper.php',
        'Escaper' =>  $sf_plugins_dir.'/stConfigPlugin/lib/sfYaml/Escaper.php',
        'Inline' =>  $sf_plugins_dir.'/stConfigPlugin/lib/sfYaml/Inline.php',
        'Parser' =>  $sf_plugins_dir.'/stConfigPlugin/lib/sfYaml/Parser.php',
        'Unescaper' =>  $sf_plugins_dir.'/stConfigPlugin/lib/sfYaml/Unescaper.php',
        'Yaml' =>  $sf_plugins_dir.'/stConfigPlugin/lib/sfYaml/Yaml.php',
        'DumpException' =>  $sf_plugins_dir.'/stConfigPlugin/lib/sfYaml/Exception/DumpException.php',
        'ParseException' =>  $sf_plugins_dir.'/stConfigPlugin/lib/sfYaml/Exception/ParseException.php',
    );

    if (isset($classes[$class]))
    {
        include $classes[$class];   
    }
}

spl_autoload_register('simpleAutoloader');

$filePath = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, md5(stConfig::getInstance('stRegister')->get('license')), base64_decode($_REQUEST['hash']), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_RAND)));

if (file_exists($filePath)) {
    header('Content-Type: application/octet-stream');
    $file = pathinfo($filePath);
    header('Content-Disposition: attachment; filename="'.$file['basename'].'"');
    $handle = fopen($filePath, 'rb');
    if ($handle) {
        while (!feof($handle)) {
            echo fread($handle, 8192);
        }
        fclose($handle);
    }
} else {
    header('Location: /');
    exit();
}
exit();
