<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2007 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfImageMagickAdapter provides a mechanism for creating thumbnail images.
 * @see http://www.imagemagick.org
 *
 * @package    sfThumbnailPlugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @author     Benjamin Meynell <bmeynell@colorado.edu>
 */

class sfImagickAdapter
{

   protected
      $sourceWidth,
      $sourceHeight,
      $sourceMime,
      $maxWidth,
      $maxHeight,
      $scale,
      $inflate,
      $quality,
      $options,
      $watermark;

   /**
    * Imagick Instance
    *
    * @var Imagick
    */
   protected $imagick;

   protected static $textPosition = array(
      'top' => Imagick::GRAVITY_NORTH,
      'left' => Imagick::GRAVITY_WEST, 
      'middle' => Imagick::GRAVITY_CENTER,
      'right' => Imagick::GRAVITY_EAST,
      'bottom' => Imagick::GRAVITY_SOUTH,
      'diagonal_up' => Imagick::GRAVITY_CENTER,
      'diagonal_down' => Imagick::GRAVITY_CENTER,
   );

   protected static $textAlpha = array(
      32 => 0.75,
      64 => 0.5,
      96 => 0.25,
   );

   public function __construct($maxWidth, $maxHeight, $scale, $inflate, $quality, $options)
   {
      $this->maxWidth = $maxWidth;
      $this->maxHeight = $maxHeight;
      $this->scale = $scale;
      $this->inflate = $inflate;
      $this->quality = $quality;
      $this->options = $options;
   }

   public function toString($thumbnail, $targetMime = null)
   {
      return $this->imagick->getImageBlob();
   }

   public function setWatermarkText($text, $size = null, $position = 'down', $color = '#000', $alpha = 0, $font = null)
   {
      $this->watermark = array(
         'text' => trim($text),
         'color' => $color,
         'alpha' => $alpha,
         'position' => $position,
         'size' => !$size ? 72 : $size,
         'font' => sfConfig::get('sf_data_dir').'/fonts/'.$font,
      );
   }

   public function loadFile($thumbnail, $image, $auto_crop = false)
   {
      $this->imagick = new Imagick($image);

      // if (is_callable(array($this->imagick, 'adaptiveSharpenImage')))
      {
         // $this->imagick->adaptiveSharpenImage(2,1);
      }

      $this->fixOrientation();
      
      if (defined('Imagick::RESOURCETYPE_THREAD'))
      {
         $this->imagick->setResourceLimit(Imagick::RESOURCETYPE_THREAD, 1);
      }

      $this->sourceWidth = $this->imagick->getImageWidth();
      $this->sourceHeight = $this->imagick->getImageHeight();
      $this->sourceMime = $this->imagick->getImageMimeType();
      $thumbnail->initThumb($this->sourceWidth, $this->sourceHeight, $this->maxWidth, $this->maxHeight, $this->scale, $this->inflate, $auto_crop);

      if ($this->sourceWidth > $this->maxWidth || $this->sourceHeight > $this->maxHeight)
      {
         if ($auto_crop && is_array($auto_crop))
         {
            $w = $auto_crop[2] - $auto_crop[0];
            $h = $auto_crop[3] - $auto_crop[1];

            $this->imagick->cropImage($w, $h, $auto_crop[0], $auto_crop[1]);
            $this->resizeImage($thumbnail->getThumbWidth(), $thumbnail->getThumbHeight());

            $thumbnail->setThumbWidth($this->imagick->getImageWidth());
            $thumbnail->setThumbHeight($this->imagick->getImageHeight());
         }
         else
         {
            $this->resizeImage($thumbnail->getThumbWidth(), $thumbnail->getThumbHeight());

            if ($auto_crop)
            {                
               $this->imagick->cropImage($this->maxWidth, $this->maxHeight, ($thumbnail->getThumbWidth() - $this->maxWidth) / 2, ($thumbnail->getThumbHeight() - $this->maxHeight) / 2);
            }

            $thumbnail->setThumbWidth($this->imagick->getImageWidth());
            $thumbnail->setThumbHeight($this->imagick->getImageHeight());
         }

         $this->imagick->setImagePage($this->imagick->getImageWidth(), $this->imagick->getImageHeight(), 0, 0);

         
      }
      

      if ($this->watermark && !empty($this->watermark['text']))
      {  
         $fontSize = $this->watermark['size'];
         $color = $this->watermark['color'];

         if (is_array($this->watermark['color']))
         {
            $color = new ImagickPixel(sprintf('rgb(%s, %s, %s)', $this->watermark['color'][0], $this->watermark['color'][1], $this->watermark['color'][2]));
         }
         else
         {
            $color = new ImagickPixel('#'.$this->watermark['color']);
         }

         $draw = new ImagickDraw();
         $draw->setFont($this->watermark['font']);
         $draw->setFontSize($fontSize);
         $draw->setGravity(self::$textPosition[$this->watermark['position']]);
         $draw->setTextEncoding('UTF-8');
         $draw->setFillColor($color);

         if ($this->watermark['alpha'])
         {
            $draw->setFillOpacity(self::$textAlpha[$this->watermark['alpha']]);
         }

         $angle = 0;
         $x = 0;
         $y = 0;

         $padding = 2;

         $paddingX = $thumbnail->getThumbWidth() * ($padding / 100);
         $paddingY = $thumbnail->getThumbHeight() * ($padding / 100);

         $maxTextWidth = $thumbnail->getThumbWidth() - $paddingX;
         $maxTextHeight = $thumbnail->getThumbHeight() - $paddingY;

         switch ($this->watermark['position'])
         {
            case 'diagonal_up':
               $angle = -45;
            break;

            case 'diagonal_down':
               $angle = 45;
            break;

            case 'right':
               $angle = 90;
               $maxTextWidth = $thumbnail->getThumbHeight() - $paddingY;
               $maxTextHeight = $thumbnail->getThumbWidth() - $paddingX;
            break;

            case 'left':
               $angle = -90;
               $maxTextWidth = $thumbnail->getThumbHeight() - $paddingY;
               $maxTextHeight = $thumbnail->getThumbWidth() - $paddingX;
            break;

            case 'top':
            case 'bottom':
               $maxTextWidth = $thumbnail->getThumbWidth() - $paddingX * 2;
               $y = $paddingY;
            break;
         }

         do 
         {
            $fontSize -= 4;
            $draw->setFontSize($fontSize);
            $metrics = $this->imagick->queryFontMetrics($draw, $this->watermark['text']);
         } while (!$metrics || $metrics['textWidth'] > $maxTextWidth || $metrics['textHeight'] > $maxTextHeight);

         if ($angle == -90)
         {
            $y = ($metrics['textHeight'] + $paddingY) / 2;
            $x = -$metrics['textWidth'] / 2;
         }
         elseif ($angle == 90) 
         {
            $y = -($metrics['textHeight'] + $paddingY) / 2;
            $x = $metrics['textWidth'] / 2;            
         }

         $draw->rotate($angle);

         $draw->annotation($x, $y, $this->watermark['text']);

         $this->imagick->drawImage($draw);
      }
   }

   public function loadData($thumbnail, $image, $mime)
   {
      throw new Exception('This function is not yet implemented. Try a different adapter.');
   }

   public function save($thumbnail, $thumbDest, $targetMime = null)
   {      
      if ($this->sourceMime != 'image/png')
      {
         $this->imagick->setImageCompressionQuality($this->quality);
      }
      else
      {
         $this->imagick->setFormat('PNG');
         $this->imagick->setImageCompression(Imagick::COMPRESSION_NO);
         $this->imagick->setImageCompressionQuality(100);
         $this->imagick->writeImage($thumbDest);
      }

      $this->imagick->writeImage($thumbDest);
   }

   public function freeSource()
   {
      if ($this->imagick)
      {
         $this->imagick->clear();
      }
   }

   public function freeThumb()
   {
      return true;
   }

   public function getSourceMime()
   {
      return $this->sourceMime;
   }

   protected function resizeImage($width, $height)
   {
      if (isset($this->options['high_quality_images']) && $this->options['high_quality_images'])
      {
         $this->imagick->resizeImage($width, $height, Imagick::FILTER_LANCZOS, 0.9);
      }
      else
      {
         $this->imagick->scaleImage($width, $height);
      }
   }

   protected function fixOrientation()
   {
      if (isset($this->options['respect_exif_orientation']) && $this->options['respect_exif_orientation'])
      {
         switch ($this->imagick->getImageOrientation()) {
            case \Imagick::ORIENTATION_BOTTOMRIGHT:
               $this->imagick->rotateimage("#000", 180); // rotate 180 degrees
               break;

            case \Imagick::ORIENTATION_RIGHTTOP:
               $this->imagick->rotateimage("#000", 90); // rotate 90 degrees CW
               break;

            case \Imagick::ORIENTATION_LEFTBOTTOM:
               $this->imagick->rotateimage("#000", -90); // rotate 90 degrees CCW
               break;
         }
      }

      $this->imagick->setImageOrientation(\Imagick::ORIENTATION_TOPLEFT);
      $this->imagick->setImagePage($this->imagick->getImageWidth(), $this->imagick->getImageHeight(), 0, 0);
   }

}
