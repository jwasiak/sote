<?php
/**
 * SOTESHOP/stCurrencyPlugin
 *
 * Ten plik należy do aplikacji stCurrencyPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stCurrencyPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * Klasa pomocnicza dodająca podstawowe operacje na cenach
 *
 * @package     stCurrencyPlugin
 * @subpackage  libs
 */
class stPrice
{
   /**
    *
    * Oblicza cenę uwzgledniając podatek
    *
    * @param float $price Cena bez podatku
    * @param float $tax Podatek
    * @return float Cena z podatkiem
    */
   public static function calculate($price, $tax)
   {
      return self::round($price * (1 + $tax * 0.01));
   }

   /**
    *
    * Wyciąga cenę bez podatku
    *
    * @param float $price Cena z podatkiem
    * @param float $tax Podatek
    * @return float Cena bez podatku
    */
   public static function extract($price_brutto, $tax)
   {
      return self::round($price_brutto / (1 + $tax * 0.01));
   }

   /**
    *
    * Zaokrągla cene
    *
    * @param float $price Cena
    * @return float Cena zaokrąglona
    */
   public static function round($price, $precision = 2)
   {
      return number_format($price, $precision, '.', '');
   }

   public static function applyDiscount($price, $discount)
   {
      return stPrice::round($price * (1 - $discount * 0.01));
   }

   public static function discountValue($price, $discount)
   {
      return $price * ($discount * 0.01);
   }

   public static function percentValue($price, $percent)
   {
      return self::discountValue($price, $percent);
   }

   public static function percentFromValue($value, $discount)
   {
      return $discount >= $value ?  100 : stPrice::round($discount * 100 / $value, 1);
   }

   public static function createPriceModifier($value, $type, $prefix, $level = 1, $custom = array())
   {
      return array('value' => $value, 'type' => $type, 'level' => $level, 'prefix' => $prefix, 'custom' => $custom);
   }

   public static function computePriceModifiers($product, $base_price, $price_type = 'netto', $with_currency = false)
   {
      $currency = $product->getGlobalCurrency();

      $has_local_currency = $product->hasLocalCurrency();

      if ($with_currency && $has_local_currency)
      {
          $price_type = 'currency_'.$price_type;
      }

      foreach ($product->getPriceModifiers() as $price_modifier)
      {
         if ($price_modifier['type'] === null) continue;

         $prefix = $price_modifier['prefix'];

         $value = $price_modifier['value'];

         if ($price_modifier['type'] == 'percent')
         {
            $price = stPrice::percentValue($base_price, $value);
         }
         else
         {
            $price = $value[$price_type];

            if ($with_currency && !$has_local_currency)
            {
               $price = $currency->exchange($price);
            }
         }
         
         if ($prefix)
         {
            $base_price += $prefix.$price;
         }
         else
         {
            $base_price = $price;
         }
      }

      return stPrice::round($base_price >= 0 ? $base_price : 0.00);
   }
}
