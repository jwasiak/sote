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
 * @version     $Id: Currency.php 13236 2011-05-31 10:57:59Z marcin $
 * @author      Marcin Olejnczak <marcin.olejniczak@sote.pl>
 */

/**
 * Klasa Currency
 *
 * @package     stCurrencyPlugin
 * @subpackage  libs
 */
class Currency extends BaseCurrency
{
   protected $isCustomized = null;

   protected static $configuration = null;

   public function __toString()
   {
      return $this->getShortcut();
   }

   /**
    * Save z usuwanie cachu
    *
    * @param        object      $con
    */
   public function save($con = null)
   {
      $stCache = new stFunctionCache('stCurrency');
      $stCache->removeAll();

      if ($this->getMain() && $this->isColumnModified(CurrencyPeer::MAIN))
      {
         $c = new Criteria();

         $c->add(CurrencyPeer::MAIN, true);

         $currency = CurrencyPeer::doSelectOne($c);

         if ($currency)
         {
            $currency->setMain(false);

            $currency->save();
         }
      }

      if (!$this->isNew() && !$this->getIsSystemCurrency() && $this->isColumnModified(CurrencyPeer::EXCHANGE))
      {
         $con = Propel::getConnection();

         $con->prepareStatement($sql);

         $update_criteria = new Criteria();

         $sql = sprintf('UPDATE %1$s SET %3$s = %4$s * ?, %5$s = %6$s * ?, %7$s = %3$s / (1 + %2$s * 0.01),  %8$s = %5$s / (1 + %2$s * 0.01), %9$s = ? WHERE %10$s = ? AND %11$s = ?',
                 ProductPeer::TABLE_NAME,
                 ProductPeer::OPT_VAT,
                 ProductPeer::OPT_PRICE_BRUTTO,
                 ProductPeer::CURRENCY_PRICE,
                 ProductPeer::OPT_OLD_PRICE_BRUTTO,
                 ProductPeer::CURRENCY_OLD_PRICE,
                 ProductPeer::PRICE,
                 ProductPeer::OLD_PRICE,
                 ProductPeer::CURRENCY_EXCHANGE,
                 ProductPeer::CURRENCY_ID,
                 ProductPeer::HAS_FIXED_CURRENCY);

         $st = $con->prepareStatement($sql);

         $st->setFloat(1, $this->getExchange());

         $st->setFloat(2, $this->getExchange());

         $st->setFloat(3, $this->getExchange());

         $st->setInt(4, $this->getId());

         $st->setBoolean(5, false);

         $st->executeUpdate();
      }

      parent::save($con);
   }

   public function getEditIsoCode()
   {
      return $this->getShortcut();
   }

   public function setEditIsoCode($v)
   {
      $this->setShortcut($v);
   }

   public function setEditMain($v)
   {
      $this->setMain($v);
   }

   public function getExchangeBackend()
   {
      return number_format($this->getExchange(), 4, '.', 0);
   }

   public function getPrefixSign()
   {
      return $this->getFrontSymbol();
   }

   public function getPostfixSign()
   {
      return $this->getBackSymbol();
   }

   public function setPrefixSign($v)
   {
      $this->setFrontSymbol($v);
   }

   public function setPostfixSign($v)
   {
      $this->setBackSymbol($v);
   }

   public function getIsCustomized()
   {
      $currencies = sfConfig::get('app_stCurrencyPlugin_currency_list');
      
      return !isset($currencies[$this->getShortcut()]);
   }

   /**
    * Delete z usuwaniem cachu
    *
    * @param        object      $con
    */
   public function delete($con = null)
   {
      $stCache = new stFunctionCache('stCurrency');
      $stCache->removeAll();
      parent::delete($con);
   }

   /**
    * Przeciążenie hydrate
    *
    * @param ResultSet $rs
    * @param int $startcol
    * @return object
    */
   public function hydrate(ResultSet $rs, $startcol = 1)
   {
      $this->setCulture(stLanguage::getHydrateCulture());
      return parent::hydrate($rs, $startcol);
   }

   /**
    * Przeciążenie getName
    *
    * @return string
    */
   public function getName()
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         return stLanguage::getDefaultValue($this, __METHOD__);
      }
      $v = parent::getName();
      if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
      return $v;
   }

   /**
    * Przeciążenie setName
    *
    * @param string $v
    */
   public function setName($v)
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         stLanguage::setDefaultValue($this, __METHOD__, $v);
      }

      parent::setName($v);
   }
   /**
    *
    * Zwraca kwotę po przewalutowaniu
    *
    * @param float $amount Kwota
    * @return float Kwota po przewalutowaniu
    */
   public function exchange($amount, $reversed = false, $exchange = null)
   {
      return stCurrency::calculateCurrencyPrice($amount, $exchange ? $exchange : $this->getExchange(), $reversed);
   }

   public function getNameBackend()
   {
      return $this->getShortcut().' - '.$this->getOptName();
   }
   
   public function getConfiguration()
   {
      if (null === self::$configuration)
      {
         self::$configuration = self::$configuration = stConfig::getInstance(null, 'stCurrencyPlugin'); 
      }
      
      return self::$configuration;
   }

   public function getIsSystemDefault()
   {
      return $this->getMain() || $this->getIsSystemCurrency();
   }

   public function getIsSystemCurrency()
   {
      return $this->getShortcut() == $this->getConfiguration()->get('default_currency');
   }

}
