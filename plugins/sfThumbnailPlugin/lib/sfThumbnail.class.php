<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2007 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfThumbnail provides a mechanism for creating thumbnail images.
 *
 * This is taken from Harry Fueck's Thumbnail class and
 * converted for PHP5 strict compliance for use with symfony.
 *
 * @package    sfThumbnailPlugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @author     Benjamin Meynell <bmeynell@colorado.edu>
 */
class sfThumbnail
{

   /**
    * Width of thumbnail in pixels
    */
   protected $thumbWidth;
   /**
    * Height of thumbnail in pixels
    */
   protected $thumbHeight;
   /**
    * Temporary file if the source is not local
    */
   protected $tempFile = null;

   public static function getWatermarkFonts()
   {
      static $arr = array();

      if (!$arr)
      {
         $fonts = sfConfig::get('app_stThumbnailPlugin_watermark_fonts');

         $i18n = sfContext::getInstance()->getI18N();

         foreach ($fonts as $k => $v)
         {
            $arr[$k] = $i18n->__($v, array(), 'stThumbnail');
         }

         asort($arr);
      }

      return $arr;
   }

   public static function getWatermarkPosition($position = null)
   {
      static $arr = array();

      $positions = sfConfig::get('app_stThumbnailPlugin_watermark_positions');

      if ($position)
      {
         return isset($positions[$position]) ? $positions[$position] : null;
      }
      elseif (!$arr)
      {
         $i18n = sfContext::getInstance()->getI18N();

         foreach ($positions as $k => $v)
         {
            $arr[$k] = $i18n->__($v['name'], array(), 'stThumbnail');
         }
      }

      return $arr;
   }

   public static function create($image_from, $image_to = null, $params = array())
   {
      $thumbnail = new sfThumbnail($params['width'], $params['height'], true, true, $params['quality']);

      if (isset($params['watermark']))
      {
         $thumbnail->setWatermarkText($params['watermark']['text'], isset($params['watermark']['size']) ? $params['watermark']['size'] : null, $params['watermark']['position'], $params['watermark']['color'], $params['watermark']['alpha'], $params['watermark']['font']);
      }

      $thumbnail->loadFile($image_from, isset($params['auto_crop']) ? $params['auto_crop'] : null);

      if ($image_to)
      {
         $thumbnail->save($image_to);
      }

      return $thumbnail;
   }

   public static function getDefaultAdapter()
   {
      $adapters = self::getSupportedAdapters();

      return isset($adapters['sfImagickAdapter']) ? 'sfImagickAdapter' : 'stGDAdapter';
   }

   public static function getSupportedAdapters()
   {
      $adapters = array('stGDAdapter' => 'GD');

      if (class_exists('Imagick'))
      {
         $adapters['sfImagickAdapter'] = 'ImageMagick';
      }

      return $adapters;
   }

   /**
    * Thumbnail constructor
    *
    * @param int (optional) max width of thumbnail
    * @param int (optional) max height of thumbnail
    * @param boolean (optional) if true image scales
    * @param boolean (optional) if true inflate small images
    * @param string (optional) adapter class name
    * @param array (optional) adapter options
    */
   public function __construct($maxWidth = null, $maxHeight = null, $scale = true, $inflate = true, $quality = 75, $adapterClass = null, $adapterOptions = array())
   {
      if (!$adapterClass)
      {
         $general = stConfig::getInstance('stAsset')->get('general', array());
         $adapters = self::getSupportedAdapters();
         $adapterClass =  isset($general['adapter']) && isset($adapters[$general['adapter']]) ? $general['adapter'] : self::getDefaultAdapter();

         if (isset($general['high_quality_images']))
         {
            $adapterOptions['high_quality_images'] = $general['high_quality_images'];
         }
      }

      $this->adapter = new $adapterClass($maxWidth, $maxHeight, $scale, $inflate, $quality, $adapterOptions);
   }

   /**
    * Loads an image from a file and creates an internal thumbnail out of it
    *
    * @param string filename (with absolute path) of the image to load
    *
    * @return boolean True if the image was properly loaded
    * @throws Exception If the image cannot be loaded, or if its mime type is not supported
    */
   public function loadFile($image, $auto_crop = null)
   {
      $this->adapter->loadFile($this, $image, $auto_crop);
   }

   /**
    * Loads an image from a string (e.g. database) and creates an internal thumbnail out of it
    *
    * @param string the image string (must be a format accepted by imagecreatefromstring())
    * @param string mime type of the image
    *
    * @return boolean True if the image was properly loaded
    * @access public
    * @throws Exception If image mime type is not supported
    */
   public function loadData($image, $mime)
   {
      $this->adapter->loadData($this, $image, $mime);
   }

   /**
    * Saves the thumbnail to the filesystem
    * If no target mime type is specified, the thumbnail is created with the same mime type as the source file.
    *
    * @param string the image thumbnail file destination (with absolute path)
    * @param string The mime-type of the thumbnail (possible values are 'image/jpeg', 'image/png', and 'image/gif')
    *
    * @access public
    * @return void
    */
   public function save($thumbDest, $targetMime = null)
   {
      $dir = dirname($thumbDest);

      if (!is_dir($dir))
      {
         mkdir($dir, 0755, true);
      }

      $this->adapter->save($this, $thumbDest, $targetMime);
   }

   public function __toString()
   {
      return $this->toString();
   }

   /**
    * Returns the thumbnail as a string
    * If no target mime type is specified, the thumbnail is created with the same mime type as the source file.
    *
    *
    * @param string The mime-type of the thumbnail (possible values are adapter dependent)
    *
    * @access public
    * @return string
    */
   public function toString($targetMime = null)
   {
      return $this->adapter->toString($this, $targetMime);
   }

   public function freeSource()
   {
      if (!is_null($this->tempFile))
      {
         unlink($this->tempFile);
      }
      $this->adapter->freeSource();
   }

   public function freeThumb()
   {
      $this->adapter->freeThumb();
   }

   public function freeAll()
   {
      $this->adapter->freeSource();
      $this->adapter->freeThumb();
   }

   /**
    * Returns the width of the thumbnail
    */
   public function getThumbWidth()
   {
      return $this->thumbWidth;
   }

   /**
    * Returns the height of the thumbnail
    */
   public function getThumbHeight()
   {
      return $this->thumbHeight;
   }
   
   public function setThumbWidth($v)
   {
      $this->thumbWidth = $v;
   }
   
   public function setThumbHeight($v)
   {
      $this->thumbHeight = $v;
   }   

   /**
    * Returns the mime type of the source image
    */
   public function getMime()
   {
      return $this->adapter->getSourceMime();
   }

   /**
    * Computes the thumbnail width and height
    * Used by adapter
    */
   public function initThumb($sourceWidth, $sourceHeight, $maxWidth, $maxHeight, $scale, $inflate, $crop = null)
   {
      if ($crop && is_array($crop)) 
      {
         $this->thumbWidth = $sourceWidth > $maxWidth ? $maxWidth : $sourceWidth;
         $this->thumbHeight = $sourceHeight > $maxHeight ? $maxHeight : $sourceHeight;
      }
      else
      {
         list($this->thumbWidth, $this->thumbHeight) = $this->getImageSize($sourceWidth, $sourceHeight, $maxWidth, $maxHeight, $scale, $inflate, $crop);
      }
   }

   public function getImageSize($sourceWidth, $sourceHeight, $maxWidth, $maxHeight, $scale, $inflate, $crop = null)
   {
      $size = array();

      if ($maxWidth > 0)
      {
         $ratioWidth = $maxWidth / $sourceWidth;
      }
      if ($maxHeight > 0)
      {
         $ratioHeight = $maxHeight / $sourceHeight;
      }

      if ($scale)
      {
         if ($maxWidth && $maxHeight)
         {
            $ratio = !$crop && ($ratioWidth < $ratioHeight) || $crop && ($ratioWidth > $ratioHeight)  ? $ratioWidth : $ratioHeight;
         }
         if ($maxWidth xor $maxHeight)
         {
            $ratio = (isset($ratioWidth)) ? $ratioWidth : $ratioHeight;
         }
         if ((!$maxWidth && !$maxHeight) || (!$inflate && $ratio > 1))
         {
            $ratio = 1;
         }

         $ratio = min($ratio, 1);

         $size = array(floor($ratio * $sourceWidth), floor($ratio * $sourceHeight));
      }
      else
      {
         if (!isset($ratioWidth) || (!$inflate && $ratioWidth > 1))
         {
            $ratioWidth = 1;
         }
         if (!isset($ratioHeight) || (!$inflate && $ratioHeight > 1))
         {
            $ratioHeight = 1;
         }
         $size = array(floor($ratioWidth * $sourceWidth), floor($ratioHeight * $sourceHeight));
      }

      return $size;
   }

   public function __destruct()
   {
      $this->freeAll();
   }

   protected function html2rgb($color)
   {
      if ($color[0] == '#')
         $color = substr($color, 1);

      if (strlen($color) == 6)
         list($r, $g, $b) = array($color[0].$color[1], $color[2].$color[3], $color[4].$color[5]); elseif (strlen($color) == 3)
         list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]); else
         return false;

      $r = hexdec($r);
      $g = hexdec($g);
      $b = hexdec($b);

      return array($r, $g, $b);
   }

   public function setWatermarkText($text, $size = 12, $position = 'diagonal_down', $color = '#000', $alpha = 0, $font = null)
   {
      if (is_string($color))
      {
         $color = $this->html2rgb($color);
      }

      $this->adapter->setWatermarkText($text, $size, $position, $color, $alpha, $font);
   }

}

class stThumbnail extends sfThumbnail
{
   
}
