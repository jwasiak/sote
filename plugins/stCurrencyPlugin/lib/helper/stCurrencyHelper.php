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
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stCurrencyHelper.php 4964 2010-05-17 07:04:37Z marcin $
 * @author      Marcin Olejniczak <marcin.olejniczak@sote.pl>
 */

/**
 * Ładowanie helpera
 */
sfLoader::loadHelpers('Number');

/**
 * Funkcja zmieniajaca cene na walute
 *
 * @deprecated
 * @param         Price       $price
 * @param                Front       symbol              $with_front_symbol
 * @param                Back        symbol              $with_back_symbol
 * @return   $price
 */
function st_price($prices = array(), $with_front_symbol = false, $with_back_symbol = false)
{
   $currency = stCurrency::getInstance(sfContext::getInstance());

   $price = 0;
   if (is_array($prices))
   {
      foreach ($prices as $pric)
      {
         $format_price = $currency->getPrice($pric);
         $price = $price +$format_price;
      }
   }
   else
   {
      $price = $currency->getPrice($prices);
   }

   if ($with_front_symbol == true or $with_back_symbol == true)
   {
      if ($with_front_symbol == true)
      {
         $front_symbol = $currency->getFrontSymbol();
      } else
      {
         $front_symbol = '';
      }
      if ($with_back_symbol == true)
      {
         $back_symbol = $currency->getBackSymbol();
      } else
      {
         $back_symbol = '';
      }
      $price = $front_symbol . ' ' . st_format_price($price) . ' ' . $back_symbol;
   } else
   {
      $price = st_format_price($currency->getPrice($price));
   }

   return $price;
}

function st_currency_format($price, $params = array())
{
   static $currency = null;

   if (is_null($currency))
   {
      $currency = stCurrency::getInstance(sfContext::getInstance());
   }

   $with_symbol = isset($params['with_symbol']) ? $params['with_symbol'] : true;

   if (isset($params['with_exchange']) && $params['with_exchange'])
   {
      $price = $currency->get() ? $currency->get()->exchange($price) : $price;
   } 

   $digits = isset($params['digits']) ? $params['digits'] : null;

   if ($with_symbol)
   {
      $price = $currency->getFrontSymbol() . st_format_price($price, $digits) . ' '. $currency->getBackSymbol();
   }
   else
   {
      $price = st_format_price($price, $digits);
   }

   return $price;
}

/**
 * funcja do zmiany ceny na gowwna walute
 *
 * @param         Price       $price
 * @param                Front       symbol              $with_front_symbol
 * @param                Back        symbol              $with_back_symbol
 * @return       string      $price
 */
function st_back_price($price, $with_front_symbol = false, $with_back_symbol = false)
{
   $main_currency = stCurrency::getInstance(sfContext::getInstance())->getBackendMainCurrency();

   if(is_object($main_currency))
   {
      if ($with_front_symbol == true or $with_back_symbol == true)
      {
         if ($with_front_symbol == true)
         {
            $front_symbol = $main_currency->getFrontSymbol();
         } else
         {
            $front_symbol = '';
         }
         if ($with_back_symbol == true)
         {
            $back_symbol = $main_currency->getBackSymbol();
         } else
         {
            $back_symbol = '';
         }
         $price = st_format_price($price);
         $price = $front_symbol . ' ' . $price . ' ' . $back_symbol;
      } else
      {
         $price = st_format_price($price);
      }
   } else
   {
      $price = st_format_price($price);
   }

   return $price;
}
/**
 * Zwraca symbol przed waluta
 *
 * @return       string      front_symbol
 */
function st_front_symbol($postfix = null)
{
   static $symbol = null;

   if (null === $symbol)
   {
      $symbol = stCurrency::getInstance(sfContext::getInstance())->getFrontSymbol();

      $symbol = $symbol ? $symbol.$postfix : '';
   }

   return $symbol;
}
/**
 * Zwraca symbol za waluta
 *
 * @return       string      back_symbol
 */
function st_back_symbol($prefix = null)
{
   static $symbol = null;

   if (null === $symbol)
   {
      $symbol = stCurrency::getInstance(sfContext::getInstance())->getBackSymbol();

      $symbol = $symbol ? $prefix.$symbol : '';
   }

   return $symbol;
}

/**
 * Zwraca symbol głównej waluty w backendzie
 *
 * @return   string
 */
function st_backend_front_symbol()
{
   $main = stCurrency::getInstance(sfContext::getInstance())->getBackendMainCurrency();
   return $main->getFrontSymbol();
}

/**
 * Zwraca symbol głównej waluty w backendzie
 *
 * @return   string
 */
function st_backend_back_symbol()
{
   $main = stCurrency::getInstance(sfContext::getInstance())->getBackendMainCurrency();
   return $main->getBackSymbol();
}

function st_format_price($number, $decimal_digits = null)
{
   static $format_info = null;

   if (null === $number)
   {
      return null;
   }

   if (null === $format_info)
   {
      $tmp = sfNumberFormatInfo::getInstance(sfContext::getInstance()->getUser()->getCulture(), sfNumberFormatInfo::CURRENCY);

      $format_info['decimal_digits'] = $tmp->getDecimalDigits();

      $format_info['decimal_sep'] = $tmp->getDecimalSeparator();

      // a fix for strange space character encodings
      $format_info['thousand_sep'] = str_replace(' ', ' ', $tmp->getGroupSeparator());
   }

   return number_format($number, null !== $decimal_digits ? $decimal_digits : $format_info['decimal_digits'], $format_info['decimal_sep'], $format_info['thousand_sep']);
}
?>