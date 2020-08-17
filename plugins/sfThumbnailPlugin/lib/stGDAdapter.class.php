<?php

/**
 * @package sfThumbnailPlugin 
 */

/**
 * Rozszerzenie pluginu stThumbnailPlugin
 *
 * @package sfThumbnailPlugin
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @copyright SOTE
 * @license SOTE
 * @version $Id: stGDAdapter.class.php 3382 2008-12-16 10:03:52Z marcin $
 */
class stGDAdapter extends sfGDAdapter
{

   protected $watermarkText = false, $watermarkColor, $watermarkAlpha, $watermarkPosition, $watermarkSize, $watermarkFont = 'arial.ttf';

   /**
    * @todo dodac opis phpdoc
    */
   public function setWatermarkText($text, $size = null, $position = 'down', $color = '#000', $alpha = 0, $font = null)
   {
      $this->watermarkText = $text;
      $this->watermarkColor = $color;
      $this->watermarkAlpha = $alpha;
      $this->watermarkPosition = $position;
      $this->watermarkSize = !$size ? 72 : $size;

      if ($font)
      {
         $this->watermarkFont = $font;
      }
   }

   /**
    * @todo dodać opis phpdoc
    */
   public function loadFile($thumbnail, $image, $auto_crop = null)
   {
      if (parent::loadFile($thumbnail, $image, $auto_crop))
      {
         if ($this->watermarkText)
         {
            $this->disableAlpha($this->thumb);
            
            $font_file = sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'fonts'.DIRECTORY_SEPARATOR.$this->watermarkFont;

            $rgb = $this->watermarkColor;

            $color = imagecolorallocatealpha($this->thumb, $rgb[0], $rgb[1], $rgb[2], $this->watermarkAlpha);

            $metrics = $this->acquireTextMetrics($thumbnail, $font_file);

            imagettftext($this->thumb, $metrics['size'], $metrics['angle'], $metrics['x_offset'], $metrics['y_offset'], $color, $font_file, $this->watermarkText);

            $this->preserveAlpha($this->thumb);
         }
      }
   }

   protected function acquireTextMetrics($thumbnail, $font_file)
   {
      $thumb_width = $thumbnail->getThumbWidth();

      $thumb_height = $thumbnail->getThumbHeight();

      $position = sfThumbnail::getWatermarkPosition($this->watermarkPosition);

      $angle = 0;

      switch ($this->watermarkPosition)
      {
         case 'top':
            list($tb, $watermark_width, $watermark_height, $watermark_size) = $this->calculateTextMetrics(0, $this->watermarkSize, $thumb_width, $thumb_height, $font_file);
            $x_offset = abs($watermark_width - $thumb_width) / 2;
            $y_offset = abs($tb[7]) + $thumb_height * 0.01;
            break;
         case 'bottom':
            list($tb, $watermark_width, $watermark_height, $watermark_size) = $this->calculateTextMetrics(0, $this->watermarkSize, $thumb_width, $thumb_height, $font_file);
            $x_offset = abs($watermark_width - $thumb_width) / 2;
            $y_offset = $thumb_height - $tb[1] - $thumb_height * 0.01;
            break;
         case 'left':
            $angle = -90;
            list($tb, $watermark_height, $watermark_width, $watermark_size) = $this->calculateTextMetrics(0, $this->watermarkSize, $thumb_height, $thumb_width, $font_file);
            $x_offset = abs($tb[1]) + $thumb_width * 0.01;
            $y_offset = abs($watermark_height - $thumb_height) / 2;
            break;
         case 'right':
            $angle = 90;
            list($tb, $watermark_height, $watermark_width, $watermark_size) = $this->calculateTextMetrics(0, $this->watermarkSize, $thumb_height, $thumb_width, $font_file);
            $x_offset = $thumb_width - abs($tb[1]) - $thumb_width * 0.01;
            $y_offset = abs($watermark_height + $thumb_height) / 2;
            break;
         case 'middle':
            list($tb, $watermark_width, $watermark_height, $watermark_size) = $this->calculateTextMetrics(0, $this->watermarkSize, $thumb_width, $thumb_height, $font_file);
            $x_offset = abs($watermark_width - $thumb_width) / 2;
            $y_offset = abs($watermark_height + $thumb_height) / 2 - $tb[1];
            break;
         case 'diagonal_up':
            $angle = 45;
            list($tb, $watermark_width, $watermark_height, $watermark_size) = $this->calculateTextMetrics($angle, $this->watermarkSize, $thumb_width, $thumb_height, $font_file);
            $x_offset = abs($watermark_width - $thumb_width) / 2;
            $y_offset = abs($watermark_height + $thumb_height) / 2;
            break;
         case 'diagonal_down':
            $angle = -45;
            list($tb, $watermark_width, $watermark_height, $watermark_size) = $this->calculateTextMetrics(45, $this->watermarkSize, $thumb_width, $thumb_height, $font_file);
            $x_offset = abs($watermark_height - $thumb_width) / 2 + $tb[0];
            $y_offset = abs($watermark_width - $thumb_height) / 2;
            break;
      }

      return array('size' => $watermark_size, 'x_offset' => $x_offset, 'y_offset' => $y_offset, 'angle' => $angle, 'width' => $watermark_width, 'height' => $watermark_height);
   }

   protected function calculateTextMetrics($angle, $size, $thumb_width, $thumb_height, $font_file)
   {
      do
      {
         $tb = imagettfbbox($size, $angle, $font_file, $this->watermarkText);

         $watermark_width = abs($tb[4]) + abs($tb[0]);

         $watermark_height = abs($tb[3]) + abs($tb[7]);

         $size -= 2;
      }
      while (($watermark_height * 1.2 > $thumb_height || $watermark_width * 1.2 > $thumb_width) && $size >= 2);

      return array($tb, $watermark_width, $watermark_height, $size + 2);
   }

}