<?php

use_helper('Tag', 'Asset');

/**
 * SOTESHOP/stBase
 *
 * Ten plik należy do aplikacji stBase opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stBase
 * @subpackage  helpers
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stAssetHelper.php 8099 2010-09-01 11:36:40Z marcin $
 */

/**
 * Zwraca znacznik <img> ze zdjęciem
 *
 * @param Product $asset Plik ze zdjęciem
 * @param string $thumbnail_type Typ zdjęcia (icon, small, large)
 * @param array $option Opcje HTML 
 * @return string HTML znacznik <img>
 */
function st_asset_image_tag($asset, $thumbnail_type = 'full', $options = array())
{
   $options = _parse_attributes($options);

   return image_tag(st_asset_image_path($asset, $thumbnail_type), $options);
}

function st_asset_image_path($asset, $thumbnail_type = 'full', $for = 'product', $system_path = false, $absolute = false)
{
   static $config_time = null;

   if ($asset instanceof sfAsset)
   {
      if (!$asset->isImage())
      {
         throw new sfException("Podany plik nie jest zdjęciem...");
      }

      $path = $asset->getsfAssetFolder()->getRelativePath();

      $filename = $asset->getFilename();
   }
   elseif (is_object($asset) && method_exists($asset, 'getOptImage'))
   {
      if (!$asset->getOptImage())
      {
         return null;
      } 

      $path = dirname($asset->getOptImage());

      $filename = basename($asset->getOptImage());       
   }
   else
   {
      if (!$asset)
      {
         return null;
      }
      
      $path = dirname($asset);

      $filename = basename($asset);
   }

   $img_from = sfAssetsLibraryTools::fixPath(sfAssetsLibraryTools::getThumbnailPath($path, $filename));

   if (!is_readable($img_from))
   {
      return null;
   }

   $img_to = sfAssetsLibraryTools::fixPath(sfAssetsLibraryTools::getThumbnailPath($path, $filename, $thumbnail_type));   

   if (null === $config_time)
   {
      $config_file = sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'__stAsset.yml';

      if (is_file($config_file))
      {
         $config_time = filemtime($config_file);
      }
      else
      {
         stConfig::getInstance(null, 'stAsset')->save(true);

         $config_time = time();
      }
   }

   $time_from = max(array(filemtime($img_from), $config_time));

   if ($thumbnail_type != 'full')
   {
      if (!is_file($img_to) || $time_from > filemtime($img_to))
      {
         if ($system_path)
         {
            $config = stConfig::getInstance('stAsset');

            $tmp = $config->get($for, array());

            if (!isset($tmp[$thumbnail_type]))
            {
               throw new sfException(sprintf('The type "%s" does not exist', $type));
            }

            $params = $tmp[$thumbnail_type];

            if ($params['auto_crop'] && is_object($asset) && method_exists($asset, 'getImageCrop'))
            {
               $image_crop = $asset->getImageCrop();

               if (isset($image_crop[$thumbnail_type]) && $image_crop[$thumbnail_type]) {
                  $params['auto_crop'] = $image_crop[$thumbnail_type];
               }
            }     
                   
            sfThumbnail::create($img_from, $img_to, $params);

            return $img_to;
         }
         else
         {
            $src = '/stThumbnailPlugin.php?i='.rawurlencode($path.'/'.$filename).'&t='.$thumbnail_type.'&f='.$for.'&u='.$time_from;
         }
      }
      elseif ($system_path)
      {
         return $img_to;
      }
      else
      {
         $src = sfAssetsLibraryTools::createAssetUrl($path, $filename, $thumbnail_type, false).'?lm='.max(array($time_from, filemtime($img_to)));
      }
   }
   elseif ($system_path)
   {
      return $img_from;
   }
   else
   {
      $src = sfAssetsLibraryTools::createAssetUrl($path, $filename, $thumbnail_type, false).'?lm='.max(array($time_from, filemtime($img_to)));
   }

   return image_path($src, $absolute);
}

/**
 * Zwraca parametry dla danego typu zdjęć
 *
 * @param string $param Nazwa parametru
 * @param string $thumbnail_type Typ zdjęcia 
 * @return mixed
 */
function st_asset_thumbnail_setting($param, $thumbnail_type = 'large', $for = 'product')
{
   static $config = null;

   if (!$config)
   {
      $config = stConfig::getInstance(null, 'stAsset');
   }

   $settings = $config->get($for, array());

   return isset($settings[$thumbnail_type][$param]) ? $settings[$thumbnail_type][$param] : null;
}