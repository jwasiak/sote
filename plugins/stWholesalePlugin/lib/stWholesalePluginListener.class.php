<?php

/**
 * SOTESHOP/stWholesalePlugin
 *
 * Ten plik należy do aplikacji stWholesalePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stWholesalePlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stWholesalePluginListener.class.php 1142 2009-05-13 08:48:03Z krzysiek $
 */

/**
 * Podpięcie pod generator stProduct modułu stWholesalePlugin
 *
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl>
 *
 * @package     stWholesalePlugin
 * @subpackage  libs
 */
class stWholesalePluginListener
{

   /**
    *
    * Listener extending stUser generator configuration
    *
    * @param sfEvent $event
    */
   public static function generateStUser(sfEvent $event)
   {
      $event->getSubject()->attachAdminGeneratorFile('stWholesalePlugin', 'stUser.yml');
   }

   /**
    *
    * Listener extending stProduct generator configuration
    *
    * @param sfEvent $event
    */
   public static function generateStProduct(sfEvent $event)
   {
      $generator = $event->getSubject();

      $generator->insertParameterAfter('edit.display.Ceny[_old_price]', '_wholesale_price');

      $generator->setValueForParameter('edit.fields.wholesale_price', array(
          'name' => 'Ceny hurtowe',
          'module' => 'stWholesaleBackend'
      ));

      $generator->insertParameterAfter('export.fields.old_price_brutto', array(
          'wholesale_a_netto' => array('name' => 'Cena hurt A netto', 'type' => 'string', 'class' => 'stWholesalePluginListener'),
          'wholesale_a_brutto' => array('name' => 'Cena hurt A brutto', 'type' => 'double', 'class' => 'stWholesalePluginListener'),
          'wholesale_b_netto' => array('name' => 'Cena hurt B netto', 'type' => 'string', 'class' => 'stWholesalePluginListener'),
          'wholesale_b_brutto' => array('name' => 'Cena hurt B brutto', 'type' => 'double', 'class' => 'stWholesalePluginListener'),
          'wholesale_c_netto' => array('name' => 'Cena hurt C netto', 'type' => 'string', 'class' => 'stWholesalePluginListener'),
          'wholesale_c_brutto' => array('name' => 'Cena hurt C brutto', 'type' => 'double', 'class' => 'stWholesalePluginListener'),
      ));

      $generator->insertParameterAfter('import.fields.old_price_brutto', array(
          'wholesale_a_netto' => array('name' => 'Cena hurt A netto', 'type' => 'custom', 'class' => 'stWholesalePluginListener'),
          'wholesale_a_brutto' => array('name' => 'Cena hurt A brutto', 'type' => 'custom', 'class' => 'stWholesalePluginListener'),
          'wholesale_b_netto' => array('name' => 'Cena hurt B netto', 'type' => 'custom', 'class' => 'stWholesalePluginListener'),
          'wholesale_b_brutto' => array('name' => 'Cena hurt B brutto', 'type' => 'custom', 'class' => 'stWholesalePluginListener'),
          'wholesale_c_netto' => array('name' => 'Cena hurt C netto', 'type' => 'custom', 'class' => 'stWholesalePluginListener'),
          'wholesale_c_brutto' => array('name' => 'Cena hurt C brutto', 'type' => 'custom', 'class' => 'stWholesalePluginListener'),
      ));
   }

   public static function preSaveCurrency(sfEvent $event)
   {
      $currency = $event->getSubject();

      if (!$currency->isNew() && !$currency->getIsSystemCurrency() && $currency->isColumnModified(CurrencyPeer::EXCHANGE))
      {

         $con = Propel::getConnection();

         $sql = sprintf('UPDATE %1$s SET %3$s = %4$s * ?, %5$s = %6$s * ?, %7$s = %8$s * ?, %9$s = %3$s / (1 + %2$s * 0.01),  %10$s = %5$s / (1 + %2$s * 0.01), %11$s = %7$s / (1 + %2$s * 0.01) WHERE %12$s = ? AND %13$s = ?',
                         ProductPeer::TABLE_NAME,
                         ProductPeer::OPT_VAT,
                         ProductPeer::WHOLESALE_A_BRUTTO,
                         ProductPeer::CURRENCY_WHOLESALE_A,
                         ProductPeer::WHOLESALE_B_BRUTTO,
                         ProductPeer::CURRENCY_WHOLESALE_B,
                         ProductPeer::WHOLESALE_C_BRUTTO,
                         ProductPeer::CURRENCY_WHOLESALE_C,
                         ProductPeer::WHOLESALE_A_NETTO,
                         ProductPeer::WHOLESALE_B_NETTO,
                         ProductPeer::WHOLESALE_C_NETTO,
                         ProductPeer::CURRENCY_ID,
                         ProductPeer::HAS_FIXED_CURRENCY);

         $st = $con->prepareStatement($sql);

         $st->setFloat(1, $currency->getExchange());

         $st->setFloat(2, $currency->getExchange());

         $st->setFloat(3, $currency->getExchange());

         $st->setInt(4, $currency->getId());

         $st->setBoolean(5, false);

         $st->executeUpdate();
      }
   }

   public static function productPostHydrate(sfEvent $event)
   {
      $wholesale_type = self::getWholesaleType();

      if ($wholesale_type)
      {
         $product = $event->getSubject();

         $netto = call_user_func(array($product, 'getWholesale'.$wholesale_type.'Netto'));

         $currency = call_user_func(array($product, 'getCurrencyWholesale'.$wholesale_type));

         if ($netto > 0 || $product->hasLocalCurrency() && $currency > 0)
         {
            $brutto = call_user_func(array($product, 'getWholesale'.$wholesale_type.'Brutto'));

            $product->setWholesale(stPrice::round($netto), stPrice::round($brutto), stPrice::round($currency), array('group' => $wholesale_type));
         }
      }
   }

   public static function getWholesaleType()
   {
		static $wholesale_type = null;
		
		$user = sfContext::getInstance()->getUser();

      if (null === $wholesale_type)
      {
         $wholesale_type = $user->getAttribute('wholesale_type', null, 'sfGuardSecurityUser');

         if (null === $wholesale_type && $user->isAuthenticated() && $user->getGuardUser())
         {
           $wholesale_type = $user->getGuardUser()->getWholesale() ? $user->getGuardUser()->getWholesale() : false;

           $user->setAttribute('wholesale_type', $wholesale_type, 'sfGuardSecurityUser');
         }
      }
       
      return $user->isAuthenticated() && $wholesale_type ? ucfirst($wholesale_type) : false;
   }

   public static function postUpdateFromRequestProduct(sfEvent $event)
   {
      $parameters = $event['requestParameters'];

      $product = $event['modelInstance'];

      $system_currency = $product->getCurrency()->getIsSystemCurrency();

      foreach ($parameters['wholesale'] as $group => $price)
      {
         if (isset($price['netto']))
         {
            call_user_func(array($product, 'setWholesale'.ucfirst($group).'Netto'), $price['netto']);
         }

         if (isset($price['brutto']))
         {
            if ($system_currency)
            {
               call_user_func(array($product, 'setCurrencyWholesale'.ucfirst($group)), null);

               call_user_func(array($product, 'setWholesale'.ucfirst($group).'Brutto'), $price['brutto']);
            }
            else
            {
               call_user_func(array($product, 'setCurrencyWholesale'.ucfirst($group)), $price['brutto']);
            }
         }
      }
   }

   public static function preSaveProduct(sfEvent $event)
   {
      $product = $event->getSubject();

      $tax = $product->getVatValue();

      $product_modified = $product->isColumnModified(ProductPeer::CURRENCY_EXCHANGE) || $product->isColumnModified(ProductPeer::CURRENCY_ID);

      foreach (array('A', 'B', 'C') as $group)
      {
         $getter_brutto = 'getWholesale'.$group.'Brutto';

         $getter_netto = 'getWholesale'.$group.'Netto';

         $setter_brutto = 'setWholesale'.$group.'Brutto';

         $setter_netto = 'setWholesale'.$group.'Netto';

         $getter_currency = 'getCurrencyWholesale'.$group;

         if ($product->$getter_currency() && ($product_modified || $product->isColumnModified(constant('ProductPeer::CURRENCY_WHOLESALE_'.$group))))
         {
            $product->$setter_brutto($product->getCurrency()->exchange($product->$getter_currency(), true, $product->getCurrencyExchange()));

            $product->$setter_netto(null);
         }

         if (!$product->$getter_netto() && $product->$getter_brutto())
         {
            $product->$setter_netto(stPrice::extract($product->$getter_brutto(), $tax));
         }
         elseif ($product->$getter_netto() && !$product->$getter_brutto())
         {
            $product->$setter_brutto(stPrice::calculate($product->$getter_netto(), $tax));
         }
      }
   }

   public static function preSaveAddPrice(sfEvent $event)
   {
      /**
       * @var AddPrice $addPrice
       */
      $addPrice = $event->getSubject();

      $tax = $addPrice->getTax()->getVat();

      if (!$addPrice->getWholesaleANetto() && $addPrice->getWholesaleABrutto() || $addPrice->isColumnModified(AddPricePeer::WHOLESALE_A_BRUTTO))
      {
         $addPrice->setWholesaleANetto(stPrice::extract($addPrice->getWholesaleABrutto(), $tax));
      }
      elseif ($addPrice->getWholesaleANetto() && !$addPrice->getWholesaleABrutto() || $addPrice->isColumnModified(AddPricePeer::WHOLESALE_A_NETTO))
      {
         $addPrice->setWholesaleABrutto(stPrice::calculate($addPrice->getWholesaleANetto(), $tax));
      }

      if (!$addPrice->getWholesaleBNetto() && $addPrice->getWholesaleBBrutto() || $addPrice->isColumnModified(AddPricePeer::WHOLESALE_B_BRUTTO))
      {
         $addPrice->setWholesaleBNetto(stPrice::extract($addPrice->getWholesaleBBrutto(), $tax));
      }
      elseif ($addPrice->getWholesaleBNetto() && !$addPrice->getWholesaleBBrutto() || $addPrice->isColumnModified(AddPricePeer::WHOLESALE_B_NETTO))
      {
         $addPrice->setWholesaleBBrutto(stPrice::calculate($addPrice->getWholesaleBNetto(), $tax));
      }

      if (!$addPrice->getWholesaleCNetto() && $addPrice->getWholesaleCBrutto() || $addPrice->isColumnModified(AddPricePeer::WHOLESALE_C_BRUTTO))
      {
         $addPrice->setWholesaleCNetto(stPrice::extract($addPrice->getWholesaleCBrutto(), $tax));
      }
      elseif ($addPrice->getWholesaleCNetto() && !$addPrice->getWholesaleCBrutto() || $addPrice->isColumnModified(AddPricePeer::WHOLESALE_C_NETTO))
      {
         $addPrice->setWholesaleCBrutto(stPrice::calculate($addPrice->getWholesaleCNetto(), $tax));
      }  
   }

   public static function getWholesaleANetto($product)
   {
      return $product->getCurrencyExchange() == 1 ? stPrice::round($product->getWholesaleANetto()) : null;
   }

   public static function getWholesaleABrutto($product)
   {
      return $product->getCurrencyExchange() == 1 ? $product->getWholesaleABrutto() : $product->getCurrencyWholesaleA();
   }

   public static function getWholesaleBNetto($product)
   {
      return $product->getCurrencyExchange() == 1 ? stPrice::round($product->getWholesaleBNetto()) : null;
   }

   public static function getWholesaleBBrutto($product)
   {
      return $product->getCurrencyExchange() == 1 ? $product->getWholesaleBBrutto() : $product->getCurrencyWholesaleB();
   }

   public static function getWholesaleCNetto($product)
   {
      return $product->getCurrencyExchange() == 1 ? stPrice::round($product->getWholesaleCNetto()) : null;
   }

   public static function getWholesaleCBrutto($product)
   {
      return $product->getCurrencyExchange() == 1 ? $product->getWholesaleCBrutto() : $product->getCurrencyWholesaleC();
   }

   public static function setWholesaleANetto($product, $value)
   {
      $product->setWholesaleANetto($value);
   }

   public static function setWholesaleBNetto($product, $value)
   {
      $product->setWholesaleBNetto($value);
   }

   public static function setWholesaleCNetto($product, $value)
   {
      $product->setWholesaleCNetto($value);
   }

   public static function setWholesaleABrutto($product, $value, $logger, $data)
   {
      $config = stConfig::getInstance(null, 'stCurrencyPlugin');

      if ($data['currency_iso'] == $config->get('default_currency'))
      {
         $product->setWholesaleABrutto($value);

         $product->setCurrencyWholesaleA(null);
      }
      else
      {
         $product->setCurrencyWholesaleA($value);
      }
   }

   public static function setWholesaleBBrutto($product, $value, $logger, $data)
   {
      $config = stConfig::getInstance(null, 'stCurrencyPlugin');

      if ($data['currency_iso'] == $config->get('default_currency'))
      {
         $product->setWholesaleBBrutto($value);

         $product->setCurrencyWholesaleB(null);
      }
      else
      {
         $product->setCurrencyWholesaleB($value);
      }
   }

   public static function setWholesaleCBrutto($product, $value, $logger, $data)
   {
      $config = stConfig::getInstance(null, 'stCurrencyPlugin');

      if ($data['currency_iso'] == $config->get('default_currency'))
      {
         $product->setWholesaleCBrutto($value);

         $product->setCurrencyWholesaleC(null);
      }
      else
      {
         $product->setCurrencyWholesaleC($value);
      }
   }

   public static function ImportValidateWholesaleANetto($value, $product_code, $data)
   {
      return self::validateWholesale($value, $product_code, $data, 'a', 'netto');
   }

   public static function ImportValidateWholesaleABrutto($value, $product_code, $data)
   {
      return self::validateWholesale($value, $product_code, $data, 'a', 'brutto');
   }

   public static function ImportValidateWholesaleBNetto($value, $product_code, $data)
   {
      return self::validateWholesale($value, $product_code, $data, 'b', 'netto');
   }

   public static function ImportValidateWholesaleBBrutto($value, $product_code, $data)
   {
      return self::validateWholesale($value, $product_code, $data, 'b', 'brutto');
   }

   public static function ImportValidateWholesaleCNetto($value, $product_code, $data)
   {
      return self::validateWholesale($value, $product_code, $data, 'c', 'netto');
   }

   public static function ImportValidateWholesaleCBrutto($value, $product_code, $data)
   {
      return self::validateWholesale($value, $product_code, $data, 'c', 'brutto');
   }

   public static function validateWholesale($value, $product_code, $data, $group, $type)
   {
      $context = sfContext::getInstance();

      $v1 = $value;

      $v2 = $data['wholesale_'.$group.'_brutto'];

      $type1 = 'netto';

      $type2 = 'brutto';

      if ('brutto' == $type)
      {
         $v1 = $data['wholesale_'.$group.'_netto'];

         $v2 = $value;

         $type1 = 'brutto';

         $type2 = 'netto';
      }

      if (!stProductImportExport::validatePriceFormat($context, $value))
      {
         $message = $context->getI18n()->__('Cena hurtowa grupa %%group%% - cena %%type1%% "%%price%%" posiada nieprawidłowy format (przykładowy format: 10, 10.00).', array(
                     '%%group%%' => ucfirst($group),
                     '%%type1%%' => $type1,
                     '%%price%%' => $value
                 ));

         stImportExportLog::getActiveLogger()->add($product_code, $message, 2);

         return false;
      }

      if (!empty($value) && $data['wholesale_'.$group.'_'.$type2] && stProductImportExport::validateNettoBrutto($v1, $v2, $data['vat_value'], $data['currency_iso']) == false)
      {
         $message = $context->getI18n()->__('Cena hurtowa grupa %%group%% - cena %%type1%% nie pokrywa się z ceną %%type2%% (jeżeli chcesz zmienić cenę %%type1%% usuń cenę %%type2%%).', array(
                     '%%group%%' => ucfirst($group),
                     '%%type1%%' => $type1,
                     '%%type2%%' => $type2
                 ));

         stImportExportLog::getActiveLogger()->add($product_code, $message, 2);

         return false;
      }

      return true;
   }

}
