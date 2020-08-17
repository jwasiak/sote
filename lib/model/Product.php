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
 * @version     $Id: Product.php 2542 2009-08-11 13:07:15Z krzysiek $
 */

/**
 * Klasa Product
 *
 * @package     stProduct
 * @subpackage  libs
 */
class Product extends BaseProduct implements DiscountInterface
{

   protected static
      $config = null,
      $globalCurrency = null,
      $eff = false;

   protected
      $wholesale = array(),
      $prevCode = null,
      $category = null,
      $discount = array(),
      $priceModifiers = array(),
      $frontendAvailability = null,
      $defaultAssetImage = null,
      $currencyBackend = null,
      $aParent = null,
      $defaultCategory = null,
      $images = array();

   public function __construct()
   {
      $this->setIsStockValidated(true);
      $this->setHidePrice(0);
   }

   public function __toString()
   {
      return $this->getName();
   }

   public static function enableFrontendFunctions($value = true)
   {
      self::$eff = $value;
   }

   public function getParent()
   {
      if (null === $this->aParent && null !== $this->parent_id)
      {
         $this->aParent = ProductPeer::retrieveByPK($this->parent_id);
      }

      return $this->aParent;
   }

   public function setParent($v)
   {
      $this->setParentId($v->getId());

      $this->aParent = $v;
   }

   public function setCode($v)
   {
      if (!$this->isColumnModified(ProductPeer::CODE))
      {
         $this->prevCode = $this->code;
      }

      parent::setCode($v);
   }

   public function getConfiguration()
   {
      if (null === self::$config)
      {
         self::$config = stConfig::getInstance(null, 'stProduct');
      }

      return self::$config;
   }

   public function getBasePriceNetto($with_currency = false)
   {
      return stPrice::extract($this->getBasePriceBrutto($with_currency), $this->opt_vat);
   }

   public function getBasePriceBrutto($with_currency = false)
   {
      $price = $this->opt_price_brutto;

      if (true === $with_currency)
      {
         $price = $this->hasLocalCurrency() ? $this->currency_price : $this->getGlobalCurrency()->exchange($price);
      }

      return $price;
   }
   
   public function getBasicPriceBrutto($with_currency = false)
   {      
      if ($this->hasBasicPrice())
      {
         $price_brutto = $this->getPriceBrutto($with_currency);
         $bpum_default = BasicPriceUnitMeasurePeer::retrieveCachedArrayByPK($this->bpum_default_id);
         $bpum = BasicPriceUnitMeasurePeer::retrieveCachedArrayByPK($this->bpum_id);
                  
         $price = $price_brutto * (($this->bpum_value / $bpum['multiplier']) / ($this->bpum_default_value / $bpum_default['multiplier']));  

         return stPrice::round($price);
      }

      return 0;
   }
   
   public function getBasicPriceNetto($with_currency = false)
   {
      return stPrice::extract($this->getBasePriceBrutto($with_currency), $this->opt_vat);
   }

   public function hasBasicPrice()
   {
      return null !== $this->bpum_default_id && $this->bpum_default_id && $this->bpum_default_value > 0;
   }
   
   public function getOldPriceNetto($with_currency = false)
   {
      if (SF_APP == 'backend' && !self::$eff)
      {
         return $this->old_price;
      }

      return stPrice::extract($this->getOldPriceBrutto($with_currency), $this->opt_vat);
   }

   public function getOldPriceBrutto($with_currency = false)
   {
      $price = $this->opt_old_price_brutto;

      if (SF_APP == 'backend' && !self::$eff)
      {
         return $price;
      }

      if (true === $with_currency)
      {
         $price = $this->hasLocalCurrency() ? $this->getCurrencyOldPrice() : $this->getGlobalCurrency()->exchange($price);
      }

      return $price;
   }

   public function setOldPriceNetto($v)
   {
      $this->setOldPrice($v);
   }

   public function setPriceNetto($v)
   {
      $this->setPrice($v);
   }

   public function getPriceNetto($with_currency = false, $with_discount = true, $with_wholesale = true)
   {
      if (SF_APP == 'backend'  && !self::$eff)
      {
         return $this->price;
      }

      $price = stPrice::extract($this->getPriceBrutto($with_currency, $with_discount, $with_wholesale), $this->opt_vat);

      return $price;
   }

   public function setPriceBrutto($v)
   {
      $this->setOptPriceBrutto($v);
   }

   public function getPriceBrutto($with_currency = false, $with_discount = true, $with_wholesale = true)
   {
      $price = $this->opt_price_brutto;

      if (SF_APP == 'backend'  && !self::$eff)
      {
         return $price;
      }

      if ($with_wholesale && $this->wholesale && ($wholesale_price = $this->getWholesalePriceBrutto($with_currency)) > 0)
      {
         $price = $wholesale_price;
      }
      elseif ($with_currency)
      {
         $price = $this->hasLocalCurrency() ? $this->getCurrencyPrice() : $this->getGlobalCurrency()->exchange($price);
      }

      if ($this->priceModifiers)
      {
         $price = stPrice::computePriceModifiers($this, $price, 'brutto', $with_currency);
      }

      if ($with_discount && $this->discount)
      {
         $price = stDiscount::apply($price, $this->discount, $this->max_discount);
      }

      return $price;
   }

   public function getRetailPriceBrutto($with_currency = false, $with_discount = true)
   {
      return $this->getPriceBrutto($with_currency, $with_discount, false);
   }

   public function getRetailPriceNetto($with_currency = false, $with_discount = true)
   {
      return $this->getPriceNetto($with_currency, $with_discount, false);
   }

   public function setWholesale($netto, $brutto, $currency, $custom = array())
   {
      $this->wholesale = array('netto' => $netto, 'brutto' => $brutto, 'currency' => $currency, 'custom' => $custom);
   }

   public function getWholesale()
   {
      return $this->wholesale;
   }

   public function getWholesalePriceNetto($with_currency = false)
   {
      $price = stPrice::extract($this->getWholesalePriceBrutto(), $this->opt_vat);

      if ($with_currency)
      {
         $price = $this->getGlobalCurrency()->exchange($price, false, $this->hasLocalCurrency() ? $this->getCurrencyExchange() : null);
      }
   }

   public function getWholesalePriceBrutto($with_currency = false)
   {
      $price = $this->wholesale['brutto'];

      if ($with_currency)
      {
         $price = $this->hasLocalCurrency() ? $this->wholesale['currency'] : $this->getGlobalCurrency()->exchange($price);
      }

      return $price;
   }

   public function getHasWholesalePrice()
   {
      return (bool) $this->wholesale;
   }

   public function setOldPriceBrutto($v)
   {
      $this->setOptOldPriceBrutto($v);
   }

   public function setDiscount($discount)
   {
      $this->discount = array($discount);
   }

   public function getDiscount()
   {
      return $this->discount;
   }

   public function getDiscountInPercent()
   {
      $percent = stDiscount::percent($this->getPriceBrutto(false, false), $this->discount);

      return $percent > $this->max_discount ? $this->max_discount : $percent;
   }

   public function getDiscountNetto($with_currency = false)
   {
      return stPrice::extract($this->getDiscountBrutto($with_currency), $this->opt_vat);
   }

   public function getDiscountBrutto($with_currency = false)
   {
      return $this->getPriceBrutto($with_currency, false) - $this->getPriceBrutto($with_currency);
   }

   public function hasDiscount()
   {
      return $this->discount;
   }

   public function addPriceModifier($value, $type, $prefix, $level = 1, $custom = array())
   {
      $this->priceModifiers[] = stPrice::createPriceModifier($value, $type, $prefix, $level, $custom);
   }

   public function getPriceModifiers()
   {
      return $this->priceModifiers;
   }

   public function setPriceModifiers($v)
   {
      return $this->priceModifiers = $v;
   }

   public function getCurrency($con = null)
   {
      $this->aCurrency = parent::getCurrency($con);

      if (null === $this->aCurrency)
      {
         $this->aCurrency = CurrencyPeer::doSelectSystemDefault(new Criteria);
      }

      return $this->aCurrency;
   }
   
   public function getIsStockValidated($raw = false)
   {            
      $valid = parent::getIsStockValidated();   

      if ($raw)
      {
         return $valid;
      } 
      
      return (null !== $valid && $valid) && $this->getConfiguration()->get('depository_basket');
   }

   public function getSearchKeywords()
   {
      $result = parent::getSearchKeywords();

      if (null === $result)
      {
         $culture = $this->getCulture();

         $this->setCulture(stLanguage::getOptLanguage());

         $result = parent::getSearchKeywords();

         $this->setCulture($culture);
      }

      return $result;
   }

   public function setSearchKeywords($value)
   {
      $value = preg_replace('/<script[^>]*>(.*?)<\/script>/is', "", $value);
      $value = strip_tags($value);
      $value = str_replace(array("\n", "\r"), " ", $value);
      $value = str_replace("  ", " ", $value);

      return parent::setSearchKeywords(trim($value));
   }

   public function setEditCurrency($v)
   {
      $this->setCurrencyId($v);
   }

   public function getFixedCurrencyExchangeBackend()
   {
      return stPrice::round($this->getCurrencyExchange(), 4);
   }

   public function getCurrencyIso()
   {
      return $this->getCurrency()->getShortcut();
   }
   
   public function setCurrencyIso($v)
   {
      $currency = CurrencyPeer::retrieveByIso($v);

      if ($currency)
      {
         $this->setCurrency($currency);
      }
   }

   public function setCategoryList($v)
   {
      $this->setCategoryId($v);
   }

   public function getCategoryList()
   {
      return $this->getCategoryId();
   }

   public function getCategoryId()
   {
      return $this->getCategory() ? $this->getCategory()->getId() : null;
   }

   public function getDefaultCategory()
   {
      if (null === $this->defaultCategory)
      {  
         $c = new Criteria();
         $c->addJoin(ProductHasCategoryPeer::CATEGORY_ID, CategoryPeer::ID);
         $c->addDescendingOrderByColumn(ProductHasCategoryPeer::IS_DEFAULT);
         $c->add(ProductHasCategoryPeer::PRODUCT_ID, $this->id);
         
         stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stProductModel.defaultCategoryCriteria',array('criteria'=>$c)));

         $this->defaultCategory = CategoryPeer::doSelectOne($c);
      }

      return $this->defaultCategory;
   }

   public function getCategory()
   {
      return $this->getDefaultCategory();
   }

   public function getFrontendAvailability()
   {
      $this->frontendAvailability = $this->getAvailability();

      if (null === $this->frontendAvailability)
      {
         $this->frontendAvailability = AvailabilityPeer::retrieveByProduct($this);
      }

      return $this->frontendAvailability;
   }

   public function getCategoryPath()
   {
      if ($this->getCategory())
      {
         return $this->getCategory()->getPath();
      }
      return null;
   }

   public function setImage($v)
   {
      if (!$this->getImage())
      {
         parent::setImage($v);
      }
   }

   public function getAssetFolder()
   {
      return parent::getOptAssetFolder();
   }

   public function hasStockManagmentWithOptions()
   {
      return $this->stock_managment == ProductPeer::STOCK_PRODUCT_OPTIONS && $this->opt_has_options > 1;
   }

   public function save($con = null)
   {      
      if ($this->isNew() && null === $this->opt_asset_folder)
      {
         $this->setOptAssetFolder(md5($this->getName().$this->getCode().microtime(true).uniqid()));
      }

      if ($this->isColumnModified(ProductPeer::STOCK_MANAGMENT) && $this->hasStockManagmentWithOptions())
      {
         $this->setStock(ProductOptionsValuePeer::getMaxStock($this));
      }

      if ($this->isModified() && !$this->isColumnModified(ProductPeer::UPDATED_AT))
      {
         $stCache = new stFunctionCache('stProduct');
         $stCache->clearFunction('retrieve_'.$this->getId());
      }

      if (null !== $this->opt_vat && null === $this->tax_id)
      {
         $this->setVatValue($this->opt_vat);
      }

      if (!$this->has_fixed_currency && ($this->isColumnModified(ProductPeer::HAS_FIXED_CURRENCY) || $this->isColumnModified(ProductPeer::CURRENCY_ID)))
      {
         $this->setCurrencyExchange($this->getCurrency()->getExchange());
      }

      if ($this->getCurrencyPrice() && $this->isColumnModified(ProductPeer::CURRENCY_PRICE))
      {
         $this->setPriceBrutto($this->getGlobalCurrency()->exchange($this->getCurrencyPrice(), true, $this->getCurrencyExchange()));

         $this->setPriceNetto(null);
      }

      if ($this->getCurrencyOldPrice() && $this->isColumnModified(ProductPeer::CURRENCY_OLD_PRICE))
      {
         $this->setOldPriceBrutto($this->getGlobalCurrency()->exchange($this->getCurrencyOldPrice(), true, $this->getCurrencyExchange()));

         $this->setOldPriceNetto(null);
      }

      if (!$this->getPriceNetto() && $this->getPriceBrutto())
      {
         $this->setPriceNetto(stPrice::extract($this->getPriceBrutto(), $this->getVatValue()));
      }
      elseif ($this->getPriceNetto() && !$this->getPriceBrutto())
      {
         $this->setPriceBrutto(stPrice::calculate($this->getPriceNetto(), $this->getVatValue()));
      }

      if (!$this->getOldPriceNetto() && $this->getOldPriceBrutto())
      {
         $this->setOldPriceNetto(stPrice::extract($this->getOldPriceBrutto(), $this->getVatValue()));
      }
      elseif ($this->getOldPriceNetto() && !$this->getOldPriceBrutto())
      {
         $this->setOldPriceBrutto(stPrice::calculate($this->getOldPriceNetto(), $this->getVatValue()));
      }

      if ($this->isModified(ProductPeer::STOCK) || $this->isModified(ProductPeer::PRICE) || $this->isModified(ProductPeer::OPT_PRICE_BRUTTO))
      {
         AllegroAuctionPeer::updateRequiresSync($this->getId());
      }
      
      if ($this->step_qty > 0)
      {
         $this->setStockInDecimals(true);      
      }
      
      if ($this->isColumnModified(ProductPeer::PRODUCER_ID) || $this->isColumnModified(ProductPeer::ACTIVE))
      {
         ProducerPeer::clearCache();
         ProductHasCategoryPeer::cleanCache();
      }
      
      $ret = parent::save($con);

      $this->setDefaultCategory();

      return $ret;
   }

   public function delete($con = null)
   {
      $ret = parent::delete($con);

      $folder = $this->getAssetFolder();

      if (!empty($folder) && $folder != 'images')
      {
         $asset_folder = sfAssetFolderPeer::retrieveByPath('media/products/'.$folder);

         foreach ($this->getProductHasAttachmentsJoinsfAsset() as $asset)
         {
            $asset->delete();
         }
         
         foreach ($this->getProductHasSfAssetsJoinsfAsset() as $asset)
         {
            $asset->delete();
         }         
         
         if ($asset_folder)
         {
            stWebFileManager::getInstance()->remove($asset_folder->getFullPath());
            
            $asset_folder->delete($con, 'product');
         }
      }

      if (is_dir(sfConfig::get('sf_web_dir').'/uploads/options/'.$this->getId()))
      {
         stWebFileManager::getInstance()->remove(sfConfig::get('sf_web_dir').'/uploads/options/'.$this->getId());
      }

      ProductHasCategoryPeer::cleanCache();

      return $ret;
   }

   public function setDefaultCategory()
   {
      if (!$this->getDefaultCategory())
      {
         $c = new Criteria();
         $c->add(ProductHasCategoryPeer::PRODUCT_ID, $this->id);
         $category = ProductHasCategoryPeer::doSelectOne($c);

         if ($category)
         {
            $category->setIsDefault(true);
            $category->save();
            $this->defaultCategory = $category;
         }
      }
   }

   public function getOptImageDescription()
   {
      $image = $this->getDefaultAssetImage();

      return $image ? $image->getDescription() : '';
   }

   public function getOptImageFolderId()
   {
      $image = $this->getDefaultAssetImage();

      return $image ? $image->getFolderId() : '';
   }

   public function getOptImageFilename()
   {
      $image = $this->getDefaultAssetImage();

      return $image ? $image->getFilename() : '';
   }

   public function setDefaultAssetImage($v)
   {
      $this->defaultAssetImage = is_object($v) ? $v : sfAssetPeer::retrieveByPK($v);
   }

   public function getDefaultAssetImage()
   {
      if (null === $this->defaultAssetImage && $this->getOptImage())
      {
         $c = new Criteria();

         $c->addDescendingOrderByColumn(ProductHasSfAssetPeer::IS_DEFAULT);

         $c->setLimit(1);

         $tmp = ProductPeer::doSelectImages($this, $c);

         $this->defaultAssetImage = $tmp ? $tmp[0] : null;
      }

      return $this->defaultAssetImage;
   }

   public function getNotDefaultAssetImage()
   {
      $default = $this->getDefaultAssetImage() ? $this->getDefaultAssetImage()->getId() : null;

      $images = array();

      foreach ($this->getImages() as $image)
      {
         if ($image->getId() == $default)
         {
            continue;
         }

         $images[] = $image;
      }

      return $images;
   }

   public function getImages()
   {
      if (!$this->images)
      {
         $c = new Criteria();

         $c->addAscendingOrderByColumn(ProductHasSfAssetPeer::ID);

         stEventDispatcher::getInstance()->notify(new sfEvent($this, 'Product.getImages', array('criteria' => $c)));

         $this->images = ProductPeer::doSelectImages($this, $c);
      }

      return $this->images;
   }
   
   public function hydrate(ResultSet $rs, $startcol = 1)
   {
      $this->setCulture(stLanguage::getHydrateCulture());

      return parent::hydrate($rs, $startcol);
   }

   public function getName()
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         return stLanguage::getDefaultValue($this, __METHOD__);
      }
      $v = parent::getName();
      if (is_null($v))
         $v = stLanguage::getDefaultValue($this, __METHOD__);
      return $v;
   }

   public function getUom()
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         return stLanguage::getDefaultValue($this, __METHOD__);
      }
      $v = parent::getUom();
      if (is_null($v))
         $v = stLanguage::getDefaultValue($this, __METHOD__);
      return $v;
   }

   public function setUom($v)
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         stLanguage::setDefaultValue($this, __METHOD__, $v);
      }

      parent::setUom($v);
   }      

   public function setName($v)
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         stLanguage::setDefaultValue($this, __METHOD__, $v);
      }

      parent::setName($v);
   }

   public function getShortDescription()
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         return stLanguage::getDefaultValue($this, __METHOD__);
      }
      $v = parent::getShortDescription();
      if (is_null($v))
         $v = stLanguage::getDefaultValue($this, __METHOD__);
      return $v;
   }

   public function setShortDescription($v)
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         stLanguage::setDefaultValue($this, __METHOD__, $v);
      }

      parent::setShortDescription($v);
   }

   public function getDescription()
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         return stLanguage::getDefaultValue($this, __METHOD__);
      }
      $v = parent::getDescription();
      if (is_null($v))
         $v = stLanguage::getDefaultValue($this, __METHOD__);
      return $v;
   }

   public function setDescription($v)
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         stLanguage::setDefaultValue($this, __METHOD__, $v);
      }

      parent::setDescription($v);
   }

   public function setVat($id)
   {
      $this->setTaxId($id);

      $this->setOptVat($this->getTax()->getVat());
   }

   public function setVatValue($v)
   {
      $tax = TaxPeer::retrieveByTax($v);

      if (null === $tax)
      {
         $tax = new Tax();

         $tax->setVatName($v.'%');

         $tax->setVat($v);
      }

      $this->setTax($tax);

      $this->setOptVat($v);
   }

   public function getVatValue()
   {
      return $this->getVat();
   }

   public function getVat()
   {
      return $this->getOptVat();
   }

   public function getTax($con = null)
   {
      if (null === $this->aTax)
      {  
         $this->aTax = stTax::getById($this->tax_id);

         if (null === $this->aTax)
         {
            if ($this->isNew())
            {
               $this->aTax = stTax::getDefault();
            }
            else
            {
               $this->aTax = stTax::getByValue($this->opt_vat);
            }
         }
      }

      return $this->aTax;
   }

   public function getUrl()
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
         return stLanguage::getDefaultValue($this, __METHOD__);

      $v = parent::getUrl();
      if (is_null($v))
         $v = stLanguage::getDefaultValue($this, __METHOD__);
      return $v;
   }

   public function setUrl($v)
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
         stLanguage::setDefaultValue($this, __METHOD__, $v);
      parent::setUrl($v);
   }

   public function urlFilter($friendly_url)
   {
      $c = new Criteria();

      $c->add(ProductI18nPeer::ID, $this->getPrimaryKey(), Criteria::NOT_EQUAL);

      $c->add(ProductI18nPeer::URL, $friendly_url);

      if (ProductI18nPeer::doCount($c) > 0)
      {
         return stPropelSeoUrlBehavior::makeSeoFriendly($friendly_url.'-'.$this->getId());
      }

      return false;
   }

   public function getGlobalCurrency()
   {
      if (null === self::$globalCurrency)
      {
         if (SF_APP == 'backend'  && !self::$eff)
         {
            self::$globalCurrency = $this->getCurrency();
         }
         else
         {
            self::$globalCurrency = stCurrency::getInstance(sfContext::getInstance())->get();
         }
      }

      return self::$globalCurrency;
   }

   public function hasLocalCurrency()
   {
      return $this->getGlobalCurrency()->getId() == $this->currency_id && $this->currency_exchange != 1;
   }

   public function isPriceVisible()
   {
      $hide = false;
      $user = sfContext::getInstance()->getUser();

      if ($this->getConfiguration()->get('global_hide_price'))
      {
         $hide = $this->getConfiguration()->get('global_hide_price');
      }

      if ($this->getHidePrice() !== 0)
      {
         $hide = $this->getHidePrice();
      }

      if ($hide == 1)
      {
         return false;
      } 
      elseif ($hide == 2)
      {
         return $user->isAuthenticated();
      }  
      elseif ($hide == 3)
      {
         return $user->isAuthenticated() && null !== $user->getGuardUser() && $user->getGuardUser()->getIsAdminConfirm();
      }

      return true;
   }

   public function isActive($availability = false)
   {
      $config_avail = stConfig::getInstance('stAvailabilityBackend');

      if (!$this->active || $this->is_gift || ($availability && !AvailabilityPeer::isProductActive($this) && $config_avail->get('hide_no_card')!=1))
      {
         return false;
      }  
      
      if(stPoints::isPointsSystemActive())
      { 
         return !$this->getConfiguration()->get('show_without_price') || $this->getPriceBrutto(true) > 0 || $this->getPointsOnly() == 1;
      }
      else
      {
         return !$this->getConfiguration()->get('show_without_price') || $this->getPriceBrutto(true) > 0 && $this->getPointsOnly() != 1;
      }
   }

}

sfPropelBehavior::add('Product', array('stPropelSeoUrlBehavior' => array('source_column' => 'Name', 'target_column' => 'Url', 'target_column_filter' => 'urlFilter')));
