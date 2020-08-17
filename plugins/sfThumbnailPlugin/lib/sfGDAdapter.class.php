<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2007 Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfGDAdapter provides a mechanism for creating thumbnail images.
 * @see http://www.php.net/gd
 *
 * @package    sfThumbnailPlugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @author     Benjamin Meynell <bmeynell@colorado.edu>
 */
class sfGDAdapter
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
   $source,
   $transparent,
   $thumb;
   /**
    * List of accepted image types based on MIME
    * descriptions that this adapter supports
    */
   protected $imgTypes = array(
       'image/jpeg',
       'image/pjpeg',
       'image/png',
       'image/gif',
   );
   /**
    * Stores function names for each image type
    */
   protected $imgLoaders = array(
       'image/jpeg' => 'imagecreatefromjpeg',
       'image/pjpeg' => 'imagecreatefromjpeg',
       'image/png' => 'imagecreatefrompng',
       'image/gif' => 'imagecreatefromgif',
   );
   /**
    * Stores function names for each image type
    */
   protected $imgCreators = array(
       'image/jpeg' => 'imagejpeg',
       'image/pjpeg' => 'imagejpeg',
       'image/png' => 'imagepng',
       'image/gif' => 'imagegif',
   );

   public function __construct($maxWidth, $maxHeight, $scale, $inflate, $quality, $options)
   {
      if (!extension_loaded('gd'))
      {
         throw new Exception('GD not enabled. Check your php.ini file.');
      }
      $this->maxWidth = $maxWidth;
      $this->maxHeight = $maxHeight;
      $this->scale = $scale;
      $this->inflate = $inflate;
      $this->quality = $quality;
      $this->options = $options;
   }
   
   public function loadFile($thumbnail, $image, $auto_crop = false)
   {
      $this->transparent = false;

      $imgData = @GetImageSize($image);

      if (!$imgData)
      {
         throw new Exception(sprintf('Could not load image %s', $image));
      }

      if (in_array($imgData['mime'], $this->imgTypes))
      {
         $loader = $this->imgLoaders[$imgData['mime']];
         if (!function_exists($loader))
         {
            throw new Exception(sprintf('Function %s not available. Please enable the GD extension.', $loader));
         }



         $this->source = $loader($image);
         $this->sourceWidth = $imgData[0];
         $this->sourceHeight = $imgData[1];
         $this->sourceMime = $imgData['mime'];
         $thumbnail->initThumb($this->sourceWidth, $this->sourceHeight, $this->maxWidth, $this->maxHeight, $this->scale, $this->inflate, $auto_crop);

         $this->thumb = imagecreatetruecolor($thumbnail->getThumbWidth(), $thumbnail->getThumbHeight());

         if ($imgData[0] == $this->maxWidth && $imgData[1] == $this->maxHeight)
         {
            $this->thumb = $this->source;
         }
         else
         {
            $mime_type = $this->getSourceMime();

            if ($mime_type == 'image/png' || $mime_type == 'image/gif')
            {
               $this->preserveTransparency($this->thumb, $this->source);
            }

            if ($mime_type == 'image/png')
            {
               $this->preserveAlpha($this->thumb);
            }

            if ($auto_crop && is_array($auto_crop))
            {
               $w = $auto_crop[2] - $auto_crop[0];
               $h = $auto_crop[3] - $auto_crop[1];

               imagecopyresampled($this->thumb, $this->source, 0, 0, $auto_crop[0], $auto_crop[1], $thumbnail->getThumbWidth(), $thumbnail->getThumbHeight(), $w, $h);
               $this->sharpenImage($this->thumb);
            }
            else
            {
               imagecopyresampled($this->thumb, $this->source, 0, 0, 0, 0, $thumbnail->getThumbWidth(), $thumbnail->getThumbHeight(), $imgData[0], $imgData[1]);

               if ($auto_crop)
               {
                  $this->freeSource();

                  $this->thumb = $this->cropImage($this->thumb);

                  $thumbnail->setThumbWidth(imagesx($this->thumb));

                  $thumbnail->setThumbHeight(imagesy($this->thumb));
               }

               $this->sharpenImage($this->thumb);
            }
         }

         return true;
      }
      else
      {
         throw new Exception(sprintf('Image MIME type %s not supported', $imgData['mime']));
      }
   }

   protected function sharpenImage($image, $strength = 0.2) 
   {
        $mime_type = $this->getSourceMime();

      if (function_exists('imageconvolution') && $mime_type != 'image/png' && $mime_type != 'image/gif') {
         // black pixel bug fix
         $pixel_fix = imagecolorat($image, 0, 0);
         $matrix = array(
            array(0, -$strength, 0),
            array(-$strength, 8*$strength+1, -$strength),
            array(0, -$strength, 0),
         );

         $divisor = array_sum(array_map('array_sum', $matrix));
         imageconvolution($image, $matrix, $divisor, 0);
         // black pixel bug fix
         imagesetpixel($image, 0, 0, $pixel_fix);
      }
   }

   protected function cropImage($source)
   {
      $sw = imagesx($source);

      $sh = imagesy($source);

      $sx = 0;

      $sy = 0;

      $dw = $sw;

      $dh = $sh;

      if ($sw > $this->maxWidth)
      {
         $sx = round(($sw - $this->maxWidth) / 2);
         
         $dw = $sw - $sx * 2;         
      }
      elseif ($sh > $this->maxHeight)
      {
         $sy = round(($sh - $this->maxHeight) / 2);

         $dh = $sh - $sy * 2;
      }

      $croped = imagecreatetruecolor($dw, $dh);

      $mime_type = $this->getSourceMime();

      if ($mime_type == 'image/png' || $mime_type == 'image/gif')
      {
         $this->preserveTransparency($croped, $source);
      }

      if ($mime_type == 'image/png')
      {
         $this->preserveAlpha($croped);
      }

      imagecopyresampled($croped, $source, 0, 0, $sx, $sy, $dw, $dh, $dw, $dh);

      imagedestroy($source);

      return $croped;
   }

   public function loadData($thumbnail, $image, $mime)
   {
      if (in_array($mime, $this->imgTypes))
      {
         $this->source = imagecreatefromstring($image);
         $this->sourceWidth = imagesx($this->source);
         $this->sourceHeight = imagesy($this->source);
         $this->sourceMime = $mime;
         $thumbnail->initThumb($this->sourceWidth, $this->sourceHeight, $this->maxWidth, $this->maxHeight, $this->scale, $this->inflate);

         $this->thumb = imagecreatetruecolor($thumbnail->getThumbWidth(), $thumbnail->getThumbHeight());
         if ($this->sourceWidth == $this->maxWidth && $this->sourceHeight == $this->maxHeight)
         {
            $this->thumb = $this->source;
         }
         else
         {
            imagecopyresampled($this->thumb, $this->source, 0, 0, 0, 0, $thumbnail->getThumbWidth(), $thumbnail->getThumbHeight(), $this->sourceWidth, $this->sourceHeight);
         }

         return true;
      }
      else
      {
         throw new Exception(sprintf('Image MIME type %s not supported', $mime));
      }
   }

   protected function preserveTransparency($thumb, $source)
   {
      $trans_index = imagecolortransparent($source);

      if ($trans_index >= 0 && $trans_index < imagecolorstotal($source))
      {
         $this->transparent = true;

         $trans_color = imagecolorsforindex($source, $trans_index);

         $trans_index = imagecolorallocate($thumb, $trans_color['red'], $trans_color['green'], $trans_color['blue']);

         imagefill($thumb, 0, 0, $trans_index);

         imagecolortransparent($thumb, $trans_index);
      }
      else
      {
         $this->transparent = false;
      }
   }

   protected function preserveAlpha($source)
   {
      imagealphablending($source, false);

      imagesavealpha($source, true);
   }

   protected function disableAlpha($source)
   {
      imagealphablending($source, true);

      imagesavealpha($source, false);
   }

   public function save($thumbnail, $thumbDest, $targetMime = null)
   {
      imageinterlace($this->thumb, true);
      
      if ($targetMime !== null)
      {
         $creator = $this->imgCreators[$targetMime];
      }
      else
      {
         $creator = $this->imgCreators[$thumbnail->getMime()];
      }

      if ($creator == 'imagejpeg')
      {
         imagejpeg($this->thumb, $thumbDest, $this->quality);
      }
      else
      {
         $creator($this->thumb, $thumbDest);
      }
   }

   public function toString($thumbnail, $targetMime = null)
   {
      if ($targetMime !== null)
      {
         $creator = $this->imgCreators[$targetMime];
      }
      else
      {
         $creator = $this->imgCreators[$thumbnail->getMime()];
      }

      ob_start();

      if ($creator == 'imagejpeg')
      {
         $creator($this->thumb, null, $this->quality);
      }
      else
      {
         $creator($this->thumb);
      }

      return ob_get_clean();
   }

   public function freeSource()
   {
      if (is_resource($this->source))
      {
         imagedestroy($this->source);
      }
   }

   public function freeThumb()
   {
      if (is_resource($this->thumb))
      {
         imagedestroy($this->thumb);
      }
   }

   public function getSourceMime()
   {
      return $this->sourceMime;
   }

}
