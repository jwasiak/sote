<?php

class stThemeLess
{

   public static function darken($color, $delta)
   {
      $hsl = self::toHSL(self::hexToRgb($color));
      $hsl[3] = self::clamp($hsl[3] - floatval($delta), 100);
      return self::rgbToHex(self::toRGB($hsl));
   }

   public static function lighten($color, $delta)
   {
      $hsl = self::toHSL(self::hexToRgb($color));
      $hsl[3] = self::clamp($hsl[3] + floatval($delta), 100);
      return self::rgbToHex(self::toRGB($hsl));
   }

   public static function hexToRgb($hex)
   {
      $color = array();
      
      $hex = ltrim($hex, '#');

      if (strlen($hex) == 3)
      {
         $color[1] = hexdec(substr($hex, 0, 1) . $r);
         $color[2] = hexdec(substr($hex, 1, 1) . $g);
         $color[3] = hexdec(substr($hex, 2, 1) . $b);
      }
      else if (strlen($hex) == 6)
      {
         $color[1] = hexdec(substr($hex, 0, 2));
         $color[2] = hexdec(substr($hex, 2, 2));
         $color[3] = hexdec(substr($hex, 4, 2));
      }

      return $color;
   }

   public static function rgbToHex($color)
   {
      $hex = "#";
      $hex.= str_pad(dechex($color[1]), 2, "0", STR_PAD_LEFT);
      $hex.= str_pad(dechex($color[2]), 2, "0", STR_PAD_LEFT);
      $hex.= str_pad(dechex($color[3]), 2, "0", STR_PAD_LEFT);

      return $hex;
   }

   protected static function toHSL($color)
   {
      $r = $color[1] / 255;
      $g = $color[2] / 255;
      $b = $color[3] / 255;

      $min = min($r, $g, $b);
      $max = max($r, $g, $b);

      $L = ($min + $max) / 2;
      if ($min == $max)
      {
         $S = $H = 0;
      }
      else
      {
         if ($L < 0.5)
            $S = ($max - $min) / ($max + $min);
         else
            $S = ($max - $min) / (2.0 - $max - $min);

         if ($r == $max)
            $H = ($g - $b) / ($max - $min);
         elseif ($g == $max)
            $H = 2.0 + ($b - $r) / ($max - $min);
         elseif ($b == $max)
            $H = 4.0 + ($r - $g) / ($max - $min);
      }

      $out = array('hsl',
          ($H < 0 ? $H + 6 : $H) * 60,
          $S * 100,
          $L * 100,
      );

      if (count($color) > 4)
         $out[] = $color[4]; // copy alpha
      return $out;
   }

   protected static function toRGBHelper($comp, $temp1, $temp2)
   {
      if ($comp < 0)
         $comp += 1.0;
      elseif ($comp > 1)
         $comp -= 1.0;

      if (6 * $comp < 1)
         return $temp1 + ($temp2 - $temp1) * 6 * $comp;
      if (2 * $comp < 1)
         return $temp2;
      if (3 * $comp < 2)
         return $temp1 + ($temp2 - $temp1) * ((2 / 3) - $comp) * 6;

      return $temp1;
   }

   protected static function toRGB($color)
   {
      if ($color == 'color')
         return $color;

      $H = $color[1] / 360;
      $S = $color[2] / 100;
      $L = $color[3] / 100;

      if ($S == 0)
      {
         $r = $g = $b = $L;
      }
      else
      {
         $temp2 = $L < 0.5 ?
                 $L * (1.0 + $S) :
                 $L + $S - $L * $S;

         $temp1 = 2.0 * $L - $temp2;

         $r = self::toRGBHelper($H + 1 / 3, $temp1, $temp2);
         $g = self::toRGBHelper($H, $temp1, $temp2);
         $b = self::toRGBHelper($H - 1 / 3, $temp1, $temp2);
      }

      $out = array('color', round($r * 255), round($g * 255), round($b * 255));
      if (count($color) > 4)
         $out[] = $color[4]; // copy alpha
      return $out;
   }

   protected static function clamp($v, $max = 1, $min = 0)
   {
      return min($max, max($min, $v));
   }

}