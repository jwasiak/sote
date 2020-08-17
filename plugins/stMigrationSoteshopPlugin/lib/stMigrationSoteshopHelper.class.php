<?php

/**
 * SOTESHOP/stMigrationSoteshopPlugin
 *
 * Ten plik należy do aplikacji stMigrationSoteshopPlugin opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stMigrationSoteshopPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stMigrationSoteshopHelper.class.php 13946 2011-07-05 13:22:43Z marcin $
 */

/**
 * Klasa odpowiadająca za obsługę procesu migracji
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @package     stMigrationSoteshopPlugin
 * @subpackage  libs
 */
class stMigrationSoteshopHelper
{
   const SALT = 'f37e02d876032f4335ceb2c97a4b831c';

   protected static $rootCategory = null;

   public static function getCultureByLangId($lang_id)
   {
      $culture = array(0 => 'pl_PL', 1 => 'en_US', 2 => 'de', 3 => 'cs', 4 => 'ru');

      return isset($culture[$lang_id]) ? $culture[$lang_id] : 'pl_PL';
   }

   public static function xmlOptionsToArray($xml_options)
   {
      $xml_options = str_replace("\r\n", "\n", $xml_options);

      $attributes = explode("\n\n", $xml_options);

      return self::xmlOptionToArrayHelper($attributes, 0);
   }

   public static function xmlOptionToArrayHelper($attributes)
   {
      $arr = array();

      foreach ($attributes as $attribute)
      {
         $tmp = explode("\n", $attribute);

         $name = trim($tmp[0]);

         unset($tmp[0]);

         if ($name == 'multi')
         {
            continue;
         }

         foreach ($tmp as $i => $option)
         {
            @list($opt_name, $opt_price, $opt_image) = explode(',', $option);

            $opt_name = trim($opt_name);

            $arr[$name][$opt_name]['price'] = trim($opt_price);

            $arr[$name][$opt_name]['image'] = trim($opt_image);
         }
      }

      return $arr;
   }

   public static function getAddress($crypt_street, $crypt_house, $crypt_flat)
   {
      $address = self::decrypt($crypt_street);

      if ($crypt_house || $crypt_flat)
      {
         $address .= ' ';
      }

      if ($crypt_house)
      {
         $address .= self::decrypt($crypt_house);
      }

      if ($crypt_house && $crypt_flat)
      {
         $address .= '/';
      }

      if ($crypt_flat)
      {
         $address .= self::decrypt($crypt_flat);
      }

      return $address;
   }

   public static function getFullName($crypt_name, $crypt_surname)
   {
      return self::decrypt($crypt_name) . ' ' . self::decrypt($crypt_surname);
   }

   /**
    * Odkodowuje dane z wersji 3.x, 4.0
    *
    * @param string $data Dane do odkodowania
    *
    * @return string Odkodowane dane
    */
   public static function decrypt($data)
   {
      $pwd = md5(self::SALT);

      $data = urldecode($data);

      $key[] = "";

      $box[] = "";

      $temp_swap = "";

      $pwd_length = 0;

      $pwd_length = strlen($pwd);

      for ($i = 0; $i < 255; $i++)
      {

         $key[$i] = ord(substr($pwd, ($i % $pwd_length) + 1, 1));
         $box[$i] = $i;
      }

      $x = 0;

      for ($i = 0; $i < 255; $i++)
      {
         $x = ($x + $box[$i] + $key[$i]) % 256;

         $temp_swap = $box[$i];

         @$box[$i] = $box[$x];

         $box[$x] = $temp_swap;
      }

      $temp = "";

      $k = "";

      $cipherby = "";

      $cipher = "";

      $a = 0;

      $j = 0;

      for ($i = 0; $i < strlen($data); $i++)
      {
         $a = ($a + 1) % 256;

         $j = ($j + $box[$a]) % 256;

         $temp = $box[$a];

         @$box[$a] = $box[$j];

         $box[$j] = $temp;

         @$k = $box[(($box[$a] + $box[$j]) % 256)];

         $cipherby = ord(substr($data, $i, 1)) ^ $k;

         $cipher .= chr($cipherby);
      }

      return iconv('ISO-8859-2', 'UTF-8', $cipher);
   }

   public static function algorithm($password)
   {
      return md5($password);
   }

   /**
    * Oblicza kwotę netto na podstawie kwoty brutto i vatu
    *
    * @param float $price_with_vat Kwota brutto
    * @param float $vat Vat
    *
    * @return float Kwota netto
    */
   public static function calculateNettoPrice($price_with_vat, $vat)
   {
      return $price_with_vat / (1 + $vat / 100);
   }

   public static function fixString($code)
   {
      $code = str_replace(" ", "-", $code);

      return preg_replace("/[^a-zA-Z0-9_-]/", "_", $code);
   }

   public static function getRootCategory()
   {
      if (null === self::$rootCategory)
      {
         $c = new Criteria();

         $c->add(CategoryPeer::PARENT_ID, null, Criteria::ISNULL);

         self::$rootCategory = CategoryPeer::doSelectOne($c);

         if (null === self::$rootCategory)
         {
            $tmp = new Category();

            $tmp->setCulture('pl_PL');

            $tmp->setName('Kategorie');

            $tmp->makeRoot();

            $tmp->save();

            $tmp->setScope($tmp->getId());

            $tmp->save();

            self::$rootCategory = $tmp;
         }            
      }

      return self::$rootCategory;      
   }

}

?>