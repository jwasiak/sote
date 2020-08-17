<?php

/**
 * SOTESHOP/stProduct
 *
 * Ten plik należy do aplikacji stProduct opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stProduct
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stProductImportExport.class.php 31490 2020-03-09 11:44:06Z marcin $
 */
class stProductImportExport extends autoStProductImportExport
{
   protected static $deliveryModes = array(
      "W" => "exclude",
      "Z" => "allow",
      "E" => "exclude",
      "A" => "allow"
   );
   public static function ImportValidateCode($value, $product_code)
   {
      if (preg_match('/[\'"]/', $value))
      {
         stImportExportLog::getActiveLogger()->add($product_code, sfContext::getInstance()->getI18n()->__('Kod produktu nie może zawierać znakow \' oraz "'), 2);

         return false;
      }

      return true;
   }

   public static function ImportValidateMinQty($value, $product_code, $data)
   {
      if ($data['max_qty'] > 0 && $value > $data['max_qty'])
      {
         stImportExportLog::getActiveLogger()->add($product_code, sfContext::getInstance()->getI18n()->__('Minimalna ilość nie może być większa od maksymalnej ilości', null, 'stProduct'), 2);

         return false;
      }

      return true;
   }

   public static function ImportValidateCurrencyExchange($value, $product_code, $data)
   {
      if (empty($value) && $value !== 0)
      {
         return true;
      }

      if (!is_numeric($value))
      {
         $context = sfContext::getInstance();

         stImportExportLog::getActiveLogger()->add($product_code, $context->getI18n()->__('Kurs "%%exchange%%" posiada nieprawidłowy format (poprawny format: 10, 10.0000)', array('%%exchange%%' => $value)), 2);

         return false;
      }

      return true;
   }

   public static function ImportValidateCurrencyIso($value, $product_code, $data)
   {
      if (empty($value))
      {
         $context = sfContext::getInstance();

         stImportExportLog::getActiveLogger()->add($product_code, $context->getI18n()->__('Brak ustawionej waluty'), 2);

         return false;
      }

      if (CurrencyPeer::retrieveByIso($value) === null)
      {
         $context = sfContext::getInstance();

         stImportExportLog::getActiveLogger()->add($product_code, $context->getI18n()->__('Waluta "%%currency%%" nie istnieje', array('%%currency%%' => $value)), 2);

         return false;
      }

      return true;
   }

   public static function ImportValidateOldPriceNetto($value, $product_code, $data)
   {
      $context = sfContext::getInstance();

      if (!self::validatePriceFormat($context, $value))
      {
         $message = $context->getI18n()->__('Stara cena netto "%%price%%" posiada nieprawidłowy format (poprawny format: 10, 10.00).', array('%%price%%' => $value));

         stImportExportLog::getActiveLogger()->add($product_code, $message, 2);

         return false;
      }

      if (!empty($value) && $data['old_price_brutto'] && self::validateNettoBrutto($value, $data['old_price_brutto'], $data['vat_value'], $data['currency_iso']) == false)
      {
         stImportExportLog::getActiveLogger()->add($product_code, $context->getI18n()->__('Stara cena netto nie pokrywa się z ceną brutto (jeżeli chcesz zmienić cenę netto usuń cenę brutto).'), 2);

         return false;
      }

      return true;
   }

   public static function ImportValidateOldPriceBrutto($value, $product_code, $data)
   {
      $context = sfContext::getInstance();

      if (!self::validatePriceFormat($context, $value))
      {
         $message = $context->getI18n()->__('Stara cena brutto "%%price%%" posiada nieprawidłowy format (poprawny format: 10, 10.00).', array('%%price%%' => $value));

         stImportExportLog::getActiveLogger()->add($product_code, $message, 2);

         return false;
      }

      if (!empty($value) && $data['old_price_netto'] && self::validateNettoBrutto($data['old_price_netto'], $value, $data['vat_value'], $data['currency_iso']) == false)
      {
         stImportExportLog::getActiveLogger()->add($product_code, $context->getI18n()->__('Stara cena brutto nie pokrywa się z ceną netto (jeżeli chcesz zmienić cenę brutto usuń cenę netto).'), 2);

         return false;
      }

      return true;
   }

   public static function ImportValidatePriceNetto($value, $product_code, $data)
   {
      $context = sfContext::getInstance();

      if (!self::validatePriceFormat($context, $value))
      {
         $message = $context->getI18n()->__('Cena netto "%%price%%" posiada nieprawidłowy format (poprawny format: 10, 10.00).', array('%%price%%' => $value));

         stImportExportLog::getActiveLogger()->add($product_code, $message, 2);

         return false;
      }

      if (!empty($value) && $data['price_brutto'] && self::validateNettoBrutto($value, $data['price_brutto'], $data['vat_value'], $data['currency_iso']) == false)
      {
         stImportExportLog::getActiveLogger()->add($product_code, $context->getI18n()->__('Cena netto nie pokrywa się z ceną brutto (jeżeli chcesz zmienić cenę netto usuń cenę brutto).'), 2);

         return false;
      }

      return true;
   }

   public static function ImportValidatePriceBrutto($value, $product_code, $data)
   {
      $context = sfContext::getInstance();

      if (!self::validatePriceFormat($context, $value))
      {
         $message = $context->getI18n()->__('Cena brutto "%%price%%" posiada nieprawidłowy format (poprawny format: 10, 10.00).', array('%%price%%' => $value));

         stImportExportLog::getActiveLogger()->add($product_code, $message, 2);

         return false;
      }

      if (!empty($value) && $data['price_netto'] && self::validateNettoBrutto($data['price_netto'], $value, $data['vat_value'], $data['currency_iso']) == false)
      {
         stImportExportLog::getActiveLogger()->add($product_code, $context->getI18n()->__('Cena brutto nie pokrywa się z ceną netto (jeżeli chcesz zmienić cenę brutto usuń cenę netto).'), 2);

         return false;
      }

      return true;
   }

   public static function validatePriceFormat($context, $value)
   {
      $nv = new sfNumberValidator();

      $nv->initialize($context, array(
          'min' => 0,
          'type' => 'any'
      ));

      return empty($value) || $nv->execute($value, $error) == true;
   }

   public static function validateNettoBrutto($netto, $brutto, $tax, $currency)
   {
      $config = stConfig::getInstance(null, 'stCurrencyPlugin');

      if ($currency != $config->get('default_currency'))
      {
         return true;
      }

      return stPrice::round($netto) == stPrice::extract($brutto, $tax) || stPrice::round($brutto) == stPrice::calculate($netto, $tax);
   }

   public static function setCurrencyExchange($product, $value, $logger, $data)
   {
      $config = stConfig::getInstance(null, 'stCurrencyPlugin');

      if ($value && $data['currency_iso'] != $config->get('default_currency'))
      {
         $product->setCurrencyExchange($value);

         $product->setHasFixedCurrency(true);
      }
      else
      {
         $product->setHasFixedCurrency(false);

         $product->setCurrencyExchange($product->getCurrency()->getExchange());
      }
   }

   public static function getCurrencyExchange($product)
   {
      return $product->getHasFixedCurrency() ? stPrice::round($product->getCurrencyExchange(), 4) : null;
   }

   public static function getPriceNetto($product)
   {
      return $product->getCurrencyExchange() == 1 ? stPrice::round($product->getPriceNetto()) : null;
   }

   public static function setPriceBrutto($product, $value, $logger, $data)
   {
      $config = stConfig::getInstance(null, 'stCurrencyPlugin');

      if ($data['currency_iso'] == $config->get('default_currency'))
      {
         $product->setPriceBrutto($value);

         $product->setCurrencyPrice(null);
      }
      else
      {
         $product->setCurrencyPrice($value);
      }
   }

   public static function setOldPriceBrutto($product, $value, $logger, $data)
   {
      $config = stConfig::getInstance(null, 'stCurrencyPlugin');

      if ($data['currency_iso'] == $config->get('default_currency'))
      {
         $product->setOldPriceBrutto($value);

         $product->setCurrencyOldPrice(null);
      }
      else
      {
         $product->setCurrencyOldPrice($value);
      }
   }

   public static function getPriceBrutto($product)
   {
      return $product->getCurrencyExchange() == 1 ? $product->getPriceBrutto() : $product->getCurrencyPrice();
   }

   public static function getOldPriceNetto($product)
   {
      return $product->getCurrencyExchange() == 1 ? stPrice::round($product->getOldPriceNetto()) : null;
   }

   public static function getOldPriceBrutto($product)
   {
      return $product->getCurrencyExchange() == 1 ? $product->getOldPriceBrutto() : $product->getCurrencyOldPrice();
   }
   
   public static function getUom($product)
   {
      return $product->getUom() ? $product->getUom() : sfContext::getInstance()->getI18N()->__('szt.');
   }

   public static function ImportValidateName($value, $product_code, $data)
   {
      if (strlen(trim($value)) == 0)
      {
         stImportExportLog::getActiveLogger()->add($product_code, sfContext::getInstance()->getI18n()->__('Nazwa produktu jest pusta'), 2);
         return false;
      }
      return true;
   }

   public static function getStockManagment($product)
   {
      return intval($product->getStockManagment() == ProductPeer::STOCK_PRODUCT_OPTIONS);
   }

   public static function setStockManagment($product, $value)
   {
      return $product->setStockManagment($value ? ProductPeer::STOCK_PRODUCT_OPTIONS : ProductPeer::STOCK_PRODUCT);
   } 

   public static function setHidePrice($product, $value)
   {
      if ($value == 4)
      {
         $value = null;
      }

      return $product->setHidePrice($value);
   }

   public static function getHidePrice($product)
   {
      $value = $product->getHidePrice();

      return null === $value ? 4 : $value;
   }

   public static function setDeliveries($product, $value)
   {
      if (empty($value))
      {
         $product->setDeliveries(null);
      }
      else
      {
         $product->setDeliveries(self::parseDeliveries($value));
      }
   }

   public static function getDeliveries($product)
   {
      $culture = sfContext::getInstance()->getUser()->getCulture();

      $deliveries = $product->getDeliveries();

      $ids = DeliveryPeer::retrieveIdsCached();

      if (!$deliveries || !$deliveries["mode"] || !$deliveries["ids"])
      {
         return '';
      }

      $deliveries["ids"] = array_intersect($ids, $deliveries["ids"]);

      if (!$deliveries["ids"])
      {
         return '';
      }

      $content = array();

      if ($culture == 'pl_PL')
      {
         $content[] = $deliveries['mode'] == "exclude" ? "W" : "Z"; 
      }
      else 
      {
         $content[] = $deliveries['mode'] == "exclude" ? "E" : "A"; 
      }

      $content[] = implode(", ",  $deliveries["ids"]);

      return implode(" | ", $content);
   } 

   public static function parseDeliveries($value)
   {
      list($mode, $ids) = explode("|", preg_replace('/[ ]+/', "", $value));   

      return array(
         "mode" => isset(self::$deliveryModes[trim($mode)]) ? self::$deliveryModes[trim($mode)] : null,
         "ids" => explode(",", $ids)
      );
   }

   public static function ImportValidateDeliveries($value, $product_code, $data)
   {
      $context = sfContext::getInstance();

      if ($value)
      {
         $parsed = self::parseDeliveries($value);

         if (null === $parsed['mode'] || empty($parsed['ids']) || in_array(false, filter_var_array($parsed['ids'], FILTER_VALIDATE_INT)))
         {
            $message = $context->getI18n()->__('Dostawy "%%deliveries%%" posiadają nieprawidłowy format (poprawny format: "W | 1, 2" lub "Z | 2, 3, 4").', array('%%deliveries%%' => $value));

            stImportExportLog::getActiveLogger()->add($product_code, $message, 2);

            return false;
         }

         $ids = array_diff($parsed['ids'], DeliveryPeer::retrieveIdsCached());

         if ($ids && $ids != $parsed['ids'])
         {
            $message = $context->getI18n()->__('Dostawy o id "%%deliveries%%" nie istnieją lub nie są aktywne.', array('%%deliveries%%' => implode(", ", $ids)));

            stImportExportLog::getActiveLogger()->add($product_code, $message, 2);

            return false;            
         }
      }


      return true;
   }

   public static function getProductImages(Product $product)
   {
      $sf_context = sfContext::getInstance();
      $externalImages = $sf_context->getUser()->getAttribute('external_images', false, 'soteshop/stProduct/export');
      
      return implode(' | ', ProductPeer::getProductImagesArray($product, $externalImages));
   }

   public static function setProductImages(Product $product, $value, $logger = null)
   {
      $ok = true;
      $images = array_flip(ProductPeer::getProductImagesArray($product));
      $image_dir = sfConfig::get('sf_upload_dir').'/assets';

      $default = true;

      $imagesToProcess = array();

      foreach (explode('|', $value) as $filename)
      {
         $filename = trim($filename);
         if (!$filename) continue;

         $url = null;

         $is_url = false !== strpos($filename, '://');

         if ($is_url) 
         {
            try 
            {
               $url = str_replace(" ", "%20", $filename);

               $source = self::getFileContents($url);

               $filename = basename(rawurldecode($filename));
            } 
            catch (Exception $e) 
            {
               if ($logger)
               {
                  $logger->add($product->getCode(), sfContext::getInstance()->getI18n()->__('Podczas pobierania zdjęcia "%%url%%" wystąpił błąd: %%error%%', array(
                     '%%url%%' => $url,
                     '%%error%%' => $e->getMessage(),
                  ), 'stProduct'), stImportExportLog::$WARNING);
                  $ok = false;
                  continue;
               }
            }
         }
         else
         {
            $source = $image_dir.'/'.$filename;
         }

         if (!is_file($source) && !isset($images[$filename])) 
         {
            if ($logger)
            {
               $logger->add($product->getCode(), sfContext::getInstance()->getI18n()->__('Zdjęcie "%%filename%%" nie zostało znalezione w katalogu "%%dir%%"', array(
                  '%%filename%%' => $is_url ? $url : $filename,
                  '%%dir%%' => basename(sfConfig::get('sf_web_dir')).'/uploads/assets',
               ), 'stProduct'), stImportExportLog::$WARNING);
            }
            $ok = false;
            continue;
         }

         if (function_exists('exif_imagetype'))
         {
            $type = exif_imagetype($source);
         }
         else
         {
            list(,,$type) = getimagesize($source);
         }

         $pathinfo = pathinfo($filename);

         if (!isset($images[$filename]) && $type != IMAGETYPE_GIF && $type != IMAGETYPE_JPEG && $type != IMAGETYPE_PNG || !in_array(strtolower($pathinfo['extension']), array('jpg', 'jpeg', 'gif', 'png')))
         {
            if ($logger)
            {
               $logger->add($product->getCode(), sfContext::getInstance()->getI18n()->__('Zdjęcie "%%filename%%" nie jest formacie JPEG, GIF lub PNG', array(
                  '%%filename%%' => $url ? $url  : basename(sfConfig::get('sf_web_dir')).'/uploads/assets/'.$filename,
               ), 'stProduct'), stImportExportLog::$WARNING);
            }
            $ok = false;

            if ($is_url)
            {
               unlink($source);
            }

            continue;                    
         }

         $imagesToProcess[] = array(
            'is_url' => $is_url,
            'source' => $source,
            'filename' => $filename, 
         );
      }

      if (!$ok)
      {
         throw new Exception(sfContext::getInstance()->getI18n()->__('Zdjęcia nie zostały zaimportowane. Popraw powyższe błędy.', null, 'stProduct')); 
      }
      else
      {
         foreach ($imagesToProcess as $image)
         {
            $filename = $image['filename'];
            $source = $image['source'];
            $is_url = $image['is_url'];
            $sanitized_filename = sfAssetsLibraryTools::sanitizeName($filename);

            $pha = new ProductHasSfAsset();
            $pha->setProductId($product->getId());

            if (!$is_url && isset($images[$filename]))
            {
               $pha->setSfAssetId($images[$filename]);
               unset($images[$filename]);
            }
            elseif (!$is_url && isset($images[$sanitized_filename]))
            {
               $pha->setSfAssetId($images[$sanitized_filename]);
               unset($images[$sanitized_filename]);
            }
            else
            {
               $pha->createAsset($filename, $source, ProductHasSfAssetPeer::IMAGE_FOLDER, null , null, true, $is_url);
            }

            $pha->setIsDefault($default);
            $pha->save();
            $default = false;
         }
         
         foreach ($images as $id)
         {
            $asset = sfAssetPeer::retrieveByPK($id);
            if (null !== $asset)
            {
               $asset->delete();
            }
         }
      }
   }

}

