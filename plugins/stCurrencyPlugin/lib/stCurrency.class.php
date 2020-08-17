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
 * @version     $Id: stCurrency.class.php 13226 2011-05-30 14:29:24Z marcin $
 * @author      Marcin Olejnczak <marcin.olejniczak@sote.pl>
 */

/**
 * Klasa przeliczania walut.
 *
 * @package     stCurrencyPlugin
 * @subpackage  libs
 */
class stCurrency extends stPrice
{
   /**
    * Nazwa dla definiowanie sesji
    */
   const SESSION_NAMESPACE = 'soteshop/currency';

   /**
    * Instanacja obiektu stCurrency
    * @var stCurrency object
    */
   protected static $instance = null;
   /**
    * Aktualnie ustawiona waluta
    * @var stCurrency object
    */
   private $currency = null;
   /**
    * Domyślna waluta
    * @var stCurrency object
    */
   protected static $defaultCurrency = null;
   /**
    * Inicjalizacja currency
    *
    * @param   string      $context            instancja obiektu sfContext::getInstance()
    */
   private $context;

   /**
    * Incjalizacja klasy stCurrency
    *
    * @param        string      $context
    */
   public function initialize($context)
   {
      $this->context = $context;
      $this->currency = $context->getUser()->getAttribute('currency', null, self::SESSION_NAMESPACE);

      /**
       * Sprawdzenie czy waluta jeszcze istnieje.
       */
      if ($this->currency)
      {
         $this->currency = CurrencyPeer::retrieveByPKCached($this->currency->getId());
      }
   }

   /**
    * Zwraca instancje obiektu
    *
    * @param        string      $context
    * @return   stCurrency  $instance
    */
   public static function getInstance($context)
   {
      if (!isset(self::$instance))
      {
         $class = __CLASS__;

         self::$instance = new $class();

         self::$instance->initialize($context);
      }
      return self::$instance;
   }

   /**
    * Zapisuje ID currency dla użytkownika
    *
    * @param    idCurrency  $id
    */
   public function set($id)
   {
      $this->currency = CurrencyPeer::retrieveByPKCached($id);

      $this->context->getUser()->setAttribute('currency', $this->currency, self::SESSION_NAMESPACE);
   }

   /**
    * Ustawia walutę w sklepie po jej kodzie ISO
    *
    * @param string $iso
    * @return void
    */
   public function setByIso($iso)
   {
      $this->currency = CurrencyPeer::retrieveByIso($iso);

      $this->context->getUser()->setAttribute('currency', $this->currency, self::SESSION_NAMESPACE);
   }

   /**
    * Pobiera wartosc currency dla danego uzytkownika
    *
    * @return   $currency
    */
   public function get()
   {
      if (!$this->currency)
      {
         $this->currency = CurrencyPeer::retrieveMain();
      }

      return $this->currency;
   }

   /**
    * Zwraca symbol przed walutą
    *
    * @return   $front_symbol
    */
   public function getFrontSymbol()
   {
      $currency = $this->get();

      if ($currency != null)
      {
         $front_symbol = $currency->getFrontSymbol();
         return $front_symbol;
      }
   }

   /**
    * Zwraca symbol za walutą
    *
    * @return   $back_symbol
    */
   public function getBackSymbol()
   {
      $currency = $this->get();

      if ($currency != null)
      {
         $back_symbol = $currency->getBackSymbol();
         return $back_symbol;
      }
   }

   /**
    * Przeliczania cen
    *
    * @param         price       $price
    * @return      integer     $price
    */
   public function getPrice($price)
   {
      return $this->get() ? $this->get()->exchange($price) : $price;
   }

   /**
    * Zwraca walutę głowną
    *
    * @return       string      $main_currency
    */
   public function getMainCurrency()
   {
      return self::getDefault();
   }

   public static function getDefault()
   {
      if (null === self::$defaultCurrency)
      {
         $config = stConfig::getInstance(sfContext::getInstance(), 'stCurrencyPlugin');
         
         $currency_list = sfConfig::get('app_stCurrencyPlugin_currency_list');

         $default_currency = $config->get('default_currency');

         $c = new Criteria();

         $c->add(CurrencyPeer::SHORTCUT, $default_currency);

         $currency = CurrencyPeer::doSelectOne($c);

         if (null === $currency)
         {
            $currency = new Currency();

            $currency->setShortcut($default_currency);

            if (isset($currency_list['postfix']))
            {
               $currency->setPostfixSign($currency_list['postfix']);
            }
            
            if (isset($currency_list['prefix']))
            {
               $currency->setPrefixSign($currency_list['prefix']);
            }            
            
            $currency->setActive(true);

            $currency->setNbpExchange(1);
         }
         
         self::$defaultCurrency = $currency;
      }
      
      return self::$defaultCurrency;
   }

   /**
    *
    * @deprecated Use stCurrency::getDefault() instead
    * 
    */
   public function getBackendMainCurrency()
   {
      return self::getDefault();
   }

   /**
    *
    * Oblicza cenę uwzgledniając podatek
    *
    * @see stPrice::calculate($price, $tax)
    */
   public static function calculateVat($price, $tax = 0)
   {
      return self::calculate($price, $tax);
   }

   /**
    *
    * Wyciąga cenę bez podatku
    *
    * @see stPrice::extract($price, $tax)
    */
   public static function extractNettoFromBrutto($price_with_tax, $tax = 0)
   {
      return self::extract($price_with_tax, $tax);
   }

   /**
    *
    * Oblicza cenę uwzgledniając podatek
    *
    * @see stPrice::calculate($price, $tax)
    */
   public static function calculateBruttoFromNetto($price, $tax)
   {
      return self::calculate($price, $tax);
   }

   /**
    * Zwraca kwotę w podanym kursie
    *
    * @author Marcin Butlak <marcin.butlak@sote.pl>
    * @param   float       $price              Kwota do przeliczenia
    * @param   float       $exchange           Kurs waluty
    * @return   float
    */
   public static function calculateCurrencyPrice($price, $exchange = 0, $reversed = false)
   {
      $config = stConfig::getInstance('stCurrencyPlugin');

      if (!$config->get('inverse') && $config->get('default_currency') != 'PLN')
      {
         if (!$reversed)
         {
            return self::round($price * $exchange);
         }
         else
         {
            return self::round($price / $exchange);
         }         
      }
      else 
      {
         if ($reversed)
         {
            return self::round($price * $exchange);
         }
         else
         {
            return self::round($price / $exchange);
         }
      }
   }

   /**
    *
    * Alias metody round
    *
    * @see stPrice::round($price)
    */
   public static function formatPrice($price)
   {
      return self::round($price);
   }

   public static function exchange($price)
   {
      return stCurrency::getInstance(sfContext::getInstance())->getPrice($price);
   }
}
