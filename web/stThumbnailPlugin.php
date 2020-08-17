<?php
ini_set('magic_quotes_runtime', '');
ini_set('log_errors', '1');
ini_set('arg_separator.output', '&amp;');

@include('./.profile.php');

if (defined('ST_ROOT_DIR'))
{
   $sf_root_dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . ST_ROOT_DIR;
}
else
{
   $sf_root_dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..';
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
        'sfThumbnail' => $sf_plugins_dir.'/sfThumbnailPlugin/lib/sfThumbnail.class.php',
        'sfGDAdapter' => $sf_plugins_dir.'/sfThumbnailPlugin/lib/sfGDAdapter.class.php',
        'stGDAdapter' => $sf_plugins_dir.'/sfThumbnailPlugin/lib/stGDAdapter.class.php',
        'sfImagickAdapter' => $sf_plugins_dir.'/sfThumbnailPlugin/lib/sfImagickAdapter.class.php',
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

$type = isset($_GET['t']) ? filter_var($_GET['t'], FILTER_UNSAFE_RAW) : null;

$raw_image_path = ltrim($_GET['i'], '/');

$image = filter_var($raw_image_path, FILTER_UNSAFE_RAW);

$source = sfConfig::get('sf_web_dir') . DIRECTORY_SEPARATOR . $image;

$ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));

if ($image != $raw_image_path || $image[0] == '.' || $image[0] == '/' || !is_dir(dirname($source)) || !in_array($ext, array('jpg', 'png', 'gif', 'jpeg')))
{
   http_response_code(400);
   exit(0);   
}

if (!is_file($source))
{
   $source = sfConfig::get('sf_web_dir') . DIRECTORY_SEPARATOR . 'media/shares/no_image.png';

   http_response_code(404);
}

$target = sfAssetsLibraryTools::getThumbnailPath(dirname($image), basename($image), $type);

$config_file = sfConfig::get('sf_data_dir') . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . '__stAsset.yml';

if (is_file($config_file))
{
   $config_time = filemtime($config_file);
}
else
{
   stConfig::getInstance(null, 'stAsset')->save(true);

   $config_time = time();
}

$time_from = max(array(filemtime($source), $config_time));

if (!$type || !is_file($target) || $time_from > filemtime($target))
{   
   $params = array();

   if (!$type)
   {
      $params['width'] = intval($_GET['w']);

      $params['height'] = intval($_GET['h']);

      $params['quality'] = isset($_GET['q']) ? intval($_GET['q']) : 75;

      $params['auto_crop'] = isset($_GET['ac']) ? intval($_GET['ac']) : false;

      if (isset($_GET['wt']))
      {
         $params['watermark']['text'] = $_GET['wt'];

         $params['watermark']['position'] = $_GET['wp'];

         $params['watermark']['color'] = $_GET['wc'];

         $params['watermark']['alpha'] = intval($_GET['wa']);

         $params['watermark']['size'] = intval($_GET['ws']);

         $params['watermark']['font'] = $_GET['wf'];
      }

      $cache = false;
   }
   else
   {
      $cache = isset($_GET['cache']) ? $_GET['cache'] : true;

      $for = filter_var($_GET['f'], FILTER_UNSAFE_RAW);

      $config = stConfig::getInstance('stAsset');

      $tmp = $config->get($for, array());

      if (!isset($tmp[$type]))
      {
         throw new sfException(sprintf('The type "%s" does not exist', $type));
      }

      $params = $tmp[$type];

      if (isset($params['watermark']) && $params['watermark'])
      {
         $params['watermark'] = $config->get('watermark');
      }

      if (isset($params['auto_crop']) && $params['auto_crop'])
      {
         if (is_file($source.'.json'))
         {
            $crop = json_decode(file_get_contents($source.'.json'), true);

            if ($crop && isset($crop[$type]))
            {
               if (!isset($crop['_crop']) || sfAssetsLibraryTools::isValidCrop($crop['_crop'][$type], $params['width'], $params['height']))
               {
                  $params['auto_crop'] = $crop[$type];
               }
            }
         }
      }
   }

   if (!$cache)
   {
      $target = null;
   }

   $thumbnail = sfThumbnail::create($source, $target, $params);

   header('Content-Type: ' . $thumbnail->getMime(), true);

   header('Expires: 0');

   header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

   header('Pragma: public');

   if (null === $target)
   {
      echo $thumbnail;
   }
   else
   {
      echo file_get_contents($target);
   }
}
else
{

   $info = getimagesize($target);

   header('Content-Type: ' . image_type_to_mime_type($info[2]), true);

   header('Expires: 0');

   header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

   header('Pragma: public');

   readfile($target);
}