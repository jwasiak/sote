<?php
/**
 * Optimized version of product options managment
 */
class stNewProductOptions
{
   protected static $cachePool = array();

   protected static $filtersPool = null;

   protected static $post_product_criteria = null;

   protected static $pre_product_criteria = null;

   protected static $hide_no_stock = true;

   public static function updateProduct(Product $product, $selected_ids = array(), $selected_values = array(), $hide_no_stock = true)
   {
      $debug = sfConfig::get('sf_logging_enabled') && sfConfig::get('sf_debug');

      if ($debug)
      {
         $timer = sfTimerManager::getTimer('__SOTE stNewProductOptions::updateProduct()');
      }

      if (!isset(self::$cachePool[$product->getId()]))
      {
         $options = ProductOptionsValuePeer::doSelectByProduct($product, $hide_no_stock);

         $price_type = ProductOptionsValuePeer::getPriceType($product);

         self::$hide_no_stock = $hide_no_stock;

         self::updateProductRecursive($product, $options, $price_type, $selected_ids, $asset_image_id, $selected_values);

         self::updateProductImage($product, $asset_image_id);

         stEventDispatcher::getInstance()->notify(new sfEvent($product, 'stNewProductOptions.updateProduct'));

         self::$cachePool[$product->getId()] = array(
           'price_modifiers' => $product->getPriceModifiers(),
           'stock' => $product->getStock(),
           'weight' => $product->getWeight(),
           'selected_options' => $selected_ids,
           'asset_image' => $product->getDefaultAssetImage(),
           'image' => $product->getOptImage(),
           'currency_old_price' => $product->getCurrencyOldPrice(),
           'old_price' => $product->getOldPriceBrutto(),
           'code' => $product->getCode(),
           'man_code' => $product->getManCode(),
         );

         self::$hide_no_stock = true;
      }
      else
      {
         $cache = self::$cachePool[$product->getId()];

         $product->setPriceModifiers($cache['price_modifiers']);

         $product->setStock($cache['stock']);

         $product->setWeight($cache['weight']);

         $product->setBpumDefaultValue($cache['pum']);

         $product->setDefaultAssetImage($cache['asset_image']);

         $product->setOptImage($cache['image']);
        
         $product->setOldPriceBrutto($cache['old_price']);

         $product->setCurrencyOldPrice($cache['currency_old_price']);

         $product->setCode($cache['code']);

         $product->setManCode($cache['man_code']);

         $selected_ids = $cache['selected_options'];

         $product->resetModified(); 
      }

      if ($debug)
      {
         $timer->addTime();
      }

      return $selected_ids;
   }

   public static function getSelectedOptions($product)
   {
      return isset(self::$cachePool[$product->getId()]) ? self::$cachePool[$product->getId()]['selected_options'] : array();
   }

   public static function updateProductBySelectedOptions($product, $options)
   {
    if ($options)
    {
      ProductOptionsValue::setProductPool($product);

      $price_type = ProductOptionsValuePeer::getPriceType($product);

      $image = null;

      $product->setPriceModifiers(array());

      $selected_ids = array();

      foreach ($options as $option)
      {
         self::addProductPriceModifier($product, $option->getPrice($price_type), $option->getDepth(), $price_type, array('id' => $option->getId(), 'label' => $option->getValue(), 'color' => $option->getUseImageAsColor() ? $option->getColorImagePath() : $option->getColor(), 'field' => $option->getProductOptionsField()->getName(), 'type' => 'product_options'));

         if ($option->getsfAssetId())
         {
            $image = $option->getsfAssetId();
         }

         if ($option->isLeaf())
         {
            self::updateProductStock($product, $option->getStock());
         }
         self::updateProductOldPrice($product, $option);
         self::updateProductWeight($product, $option->getWeight());

         if ($option->getUseProduct())
         {
            $product->setCode($option->getUseProduct());
         }

         if ($option->getManCode())
         {
            $product->setManCode($option->getManCode());
         }

         if ($option->getPum())
         {
            $product->setBpumDefaultValue($option->getPum());
         }

         $selected_ids[] = $option->getId();
      }  

      self::updateProductImage($product, $image);

      self::$cachePool[$product->getId()] = array(
        'price_modifiers' => $product->getPriceModifiers(),
        'stock' => $product->getStock(),
        'weight' => $product->getWeight(),
        'selected_options' => $selected_ids,
        'asset_image' => $product->getDefaultAssetImage(),
        'image' => $product->getOptImage(),
        'old_price' => $product->getOldPriceBrutto(),
        'code' => $product->getCode(),
      );

      $product->resetModified();   
    } 
   }

   /**
    *
    * @param Product $product
    * @param <type> $options
    * @param <type> $price_type
    * @return <type>
    */
   public static function updateProductRecursive($product, $options, $price_type, &$selected_ids, &$asset_image_id, &$selected_values = array(), &$index = 0)
   {
      if (empty($options))
      {
         return;
      }

      $selected = null;

      $field_id = $options[0]->getProductOptionsFieldId();

      $first_option = $options[0];

      $last_option_id = end($options)->getId();

      foreach ($options as $option)
      {
         $option_id = $option->getId();

         $field = $option->getProductOptionsField();

         if (null === $selected && $option->getOptValue() == $field->getOptDefaultValue() && $field->getId() == $field_id)
         {
            $selected = $option;
         }

         if (isset($selected_values[$index]) && isset($selected_values[$index][trim($option->getOptValue())]))
         {
            $selected = $option;
            unset($selected_values[$index][trim($option->getOptValue())]);
         }

         if ($field->getId() != $field_id)
         {
            self::updateProductRecursiveHelper($product, $options, $price_type, $selected_ids, $asset_image_id, $selected_values, $index, $option, $selected, $field_id, $first_option); 
         }
      }

      self::updateProductRecursiveHelper($product, $options, $price_type, $selected_ids, $asset_image_id, $selected_values, $index, $option, $selected, $field_id, $first_option);

      $product->resetModified(); 
   }

   public static function updateProductRecursiveHelper($product, $options, $price_type, &$selected_ids, &$asset_image_id, &$selected_values = array(), &$index = 0, $option, &$selected, &$field_id, &$first_option)
   {
      $index++;

      $option_id = $option->getId();

      $field = $option->getProductOptionsField();

      if (null === $selected) 
      {
         $selected = $first_option;
      }

      $selected_ids[$field_id] = $selected->getId();

      if ($selected->getsfAssetId())
      {
         $asset_image_id = $selected->getsfAssetId();
      }

      self::addProductPriceModifier($product, $selected->getPrice($price_type), $selected->getDepth(), $price_type, array('id' => $selected->getId(), 'label' => $selected->getValue(), 'color' => $selected->getUseImageAsColor() ? $selected->getColorImagePath() : $selected->getColor(), 'field' => $selected->getProductOptionsField()->getName(), 'type' => 'product_options'));
      self::updateProductWeight($product, $selected->getWeight());

      if ($selected->getUseProduct())
      {
         $product->setCode($selected->getUseProduct());
      }

      if ($selected->getManCode())
      {
         $product->setManCode($selected->getManCode());
      }

      if ($selected->hasChildren())
      {
         self::updateProductOldPrice($product, $selected);
         self::updateProductRecursive($product, $selected->getChildOptions($product->getConfiguration()->get('hide_options_with_empty_stock') && self::$hide_no_stock), $price_type, $selected_ids, $asset_image_id, $selected_values, $index);
      }
      else
      {
         self::updateProductStock($product, $selected->getStock());
         self::updateProductOldPrice($product, $selected);
         if ($selected->getPum())
         {
            $product->setBpumDefaultValue($selected->getPum());
         }
      }

      $selected = null;

      $first_option = $option;

      if (isset($selected_values[$index]) && isset($selected_values[$index][trim($option->getOptValue())]))
      {
         $selected = $option;
         unset($selected_values[$index][trim($option->getOptValue())]);
      }

      $field_id = $field->getId();
   }

   public static function updateProductWeight($product, $weight)
   {
      list($prefix, $type, $value) = self::parseValue($weight);

      $base_weight = $product->getWeight();

      if ($type == 'percent')
      {
        $value = stPrice::percentValue($base_weight, $value);
      } 

      if ($prefix)
      {
         $base_weight += $prefix.$value;
      }
      elseif ($value != 0)
      {
         $base_weight = $value;
      }

      if ($base_weight < 0)
      {
         $base_weight = 0;
      }

      $product->setWeight(stPrice::round($base_weight)); 
   }

   public static function parseValue($value)
   {
      if (!$value)
      {
         return array(null, 'numeric', null);
      }
      
      $prefix = $value{0} == '+' || $value{0} == '-' ? $value{0} : null;
      $type = substr($value, -1) == '%' ? 'percent' : 'numeric'; 

      return array($prefix, $type, floatval(trim($value, '+-%')));   
   }

   public static function addProductPriceModifier($product, $price, $depth, $price_type, $custom = array())
   {
      if (!$price)
      {
         $value = null;

         $type = null;

         $prefix = null;
      }
      else
      {
         list($prefix, $type, $price_value) = self::parseValue($price);

         if ($type == 'numeric')
         {
            $price = $price_value;

            $tax = $product->getVatValue(false);

            $type = 'numeric';

            if ($product->getCurrencyExchange() != 1)
            {
               $value = array('currency_brutto' => $price, 'tax' => $tax);

               $value['brutto'] = stCurrency::calculateCurrencyPrice($price, $product->getCurrencyExchange(), true);

               $value['netto'] = stPrice::extract($value['brutto'], $tax);

               $value['currency_netto'] = stCurrency::calculateCurrencyPrice($value['netto'], $product->getCurrencyExchange());
            }
            else
            {
               $value = array($price_type => $price, 'tax' => $tax);

               if ($price_type == 'netto')
               {
                  $value['brutto'] = stPrice::calculate($price, $tax);
               }
               else
               {
                  $value['netto'] = stPrice::extract($price, $tax);
               }
            }
         }
         else
         {
            $value = $price_value;
         }
      }

      $product->addPriceModifier($value, $type, $prefix, $depth, $custom);
   }

   public static function updateProductStock($product, $stock)
   {
      if ($product->getStockManagment() == ProductPeer::STOCK_PRODUCT_OPTIONS && $product->getStock() !== null && null !== $stock && $product->getStock() > $stock)
      {
         $product->setStock($stock);
      }
   }

   public static function updateProductOldPrice($product, $selected)
   {
      $oldPrice = $selected->getOldPrice();

      if ($oldPrice > 0)
      {
         if ($product->getCurrencyExchange() != 1)
         {
            $product->setCurrencyOldPrice($oldPrice);
            $product->setOldPriceBrutto($product->getGlobalCurrency()->exchange($oldPrice, true, $product->getCurrencyExchange()));
         }
         else
         {
            if (ProductOptionsValuePeer::getPriceType($product) == 'netto' ) 
            {
                $product->setOldPriceBrutto(stPrice::calculate($oldPrice, $product->getOptVat()));
            }
            else 
            {
                $product->setOldPriceBrutto($oldPrice);
            }
         }
      }
   }

   public static function updateProductImage($product, $asset)
   {
      if ($asset)
      {
         $product->setDefaultAssetImage($asset);

         $default = $product->getDefaultAssetImage();

         if ($default)
         {
            $product->setOptImage($default->getRelativePath());
         }
      }
   }

   /**
     * Kopiowanie opcji produktu
     * @param object $source  element zrodlowy
     * @param object $dest element docelowy
     */
    static public function copyDescendands($source, $dest)
    {
        if(count($source->getChildren())!=0)
        {
            $transform_fields = array();
            foreach($source->getChildren() as $srcValue)
            {
                $dest = $dest->reload();

                $newChild = new ProductOptionsValue();
                $newChild->setProductId($dest->getProductId());
                $newChild->setProductOptionsTemplateId(0);

                $newChild->setCulture($srcValue->getCulture());
                $newChild->setValue($srcValue->getValue());
                $newChild->setStock($srcValue->getStock());
                $newChild->setPrice($srcValue->getPrice());
                $newChild->setPriceType($srcValue->getPriceType());
                $newChild->setSfAsset(self::getDuplicatedImageId($dest->getProductId(), $srcValue));
                $newChild->insertAsLastChildOf($dest);
                $newChild->save();

                if(empty($transform_fields[$srcValue->getProductOptionsFieldId()]))
                {
                    $newField = new ProductOptionsField();
                    $oldField = $srcValue->getProductOptionsField();

                    $newField->setRequired($oldField->getRequired());
                    $newField->setTyp($oldField->getTyp());
                    $newField->setProductOptionsTemplateId(0);
                    $newField->setCulture($oldField->getCulture());
                    $newField->setName($oldField->getName());
                    $newField->setDefaultValue($newField->getDefaultValue());
                    $newField->setOptValueId($newChild->getParentId());
                    $newField->save();

                    foreach($oldField->getProductOptionsFieldI18ns() as $i18n)
                    {
                        $newField->setCulture($i18n->getCulture());
                        $newField->setName($i18n->getName());
                        $newField->setDefaultValue($i18n->getDefaultValue());
                        $newField->save();
                    }

                    $transform_fields[$srcValue->getProductOptionsFieldId()] = $newField->getId();
                }
                $newChild->setProductOptionsFieldId($transform_fields[$srcValue->getProductOptionsFieldId()]);
                $newChild->save();

                foreach($srcValue->getProductOptionsValueI18ns() as $sourceI18n)
                {
                    $newChild->setCulture($sourceI18n->getCulture());
                    $newChild->setValue($sourceI18n->getValue());
                    $newChild->setId($newChild->getId());
                    $newChild->save();
                }

                self::copyDescendands($srcValue, $newChild);
                
            }
        }
    }

    public static function getDuplicatedImageId($dest_product_id, $src_option)
    {
        $src_asset = $src_option->getSfAsset();
        if (is_object($src_asset))
        {
            $src_filename = $src_asset->getFilename();
            $c = new Criteria();
            $c->add(ProductHasSfAssetPeer::PRODUCT_ID, $dest_product_id);
            $c->add(SfAssetPeer::FILENAME, $src_filename);
            $c->addJoin(SfAssetPeer::ID, ProductHasSfAssetPeer::SF_ASSET_ID);
            return SfAssetPeer::doSelectOne($c);
        }
        return null;
    }
    
    public static function clearCache($product = null)
    {
        $product->setPriceModifiers(array());
        
        if (isset(self::$cachePool[$product->getId()]))
        {
            unset(self::$cachePool[$product->getId()]);
        }
    }

    public static function clearStaticPool()
    {
        self::$cachePool = array();
    }

    public static function getOptionsFilters() {
      
        $pConfig = stConfig::getInstance(null, 'stProduct');

        $c = new Criteria();

        $c->add(ProductOptionsFilterPeer::FILTER_TYPE, ProductOptionsFilterPeer::PRICE_FILTER, Criteria::NOT_EQUAL);
        $c->add(ProductOptionsFilterPeer::IS_VISIBLE, true);

        $filters = ProductOptionsFilterPeer::doSelectWithI18n($c);  

        if (!$filters)
        {
            return array();
        }

        $ids = array();

        foreach ($filters as $filter)
        {
           $ids[] = $filter->getId();
        }

        $pc = self::getCriteriaForFilter();

        $c = new Criteria();

        if($pConfig->get('hide_options_with_empty_stock'))
        {
            $c->add(ProductOptionsValuePeer::STOCK, sprintf('(%1$s IS NULL OR %1$s > 0)', ProductOptionsValuePeer::STOCK), Criteria::CUSTOM);
        }

        $c->addSelectColumn(ProductOptionsValuePeer::OPT_FILTER_ID);

        $c->add(ProductOptionsValuePeer::OPT_FILTER_ID, $ids, Criteria::IN);

        $c->addGroupByColumn(ProductOptionsValuePeer::OPT_FILTER_ID);

        $c->add('custom_product_criteria', sprintf("EXISTS (%s)", BasePeer::createSqlQuery($pc)), Criteria::CUSTOM | Criteria::IGNORE_TABLE);

        $rs = ProductOptionsValuePeer::doSelectRS($c);

        $available_ids = array();

        while($rs->next())
        {
            $row = $rs->getRow();

            $available_ids[$row[0]] = $row[0];
        }

        $results = array();

        if ($available_ids)
        {
            foreach ($filters as $index => $filter)
            {
                if (isset($available_ids[$filter->getId()]))
                {
                    $results[] = $filter;
                }
            }
        }

        return $results;
    }

    public static function getOptionsForFilter($filter)
    {
        $config = stConfig::getInstance(null, 'stProduct');

        $pc = self::getCriteriaForFilter();
        $pc->setLimit(null);
        $pc->setOffset(null);

        $c = new Criteria();

        $c->add(ProductOptionsValuePeer::OPT_FILTER_ID, $filter->getId());
        
        if ($filter->getFilterType() == 2) 
        {
            $c->addGroupByColumn(ProductOptionsValuePeer::COLOR);
        }
        else
        {
            $c->addGroupByColumn(ProductOptionsValuePeer::OPT_VALUE);    
        }
        
        if($config->get('hide_options_with_empty_stock'))
        {
            $c->add(ProductOptionsValuePeer::STOCK, sprintf('(%1$s IS NULL OR %1$s > 0)', ProductOptionsValuePeer::STOCK), Criteria::CUSTOM);
        }

        $c->add('custom_product_criteria', sprintf("EXISTS (%s)", BasePeer::createSqlQuery($pc)), Criteria::CUSTOM | Criteria::IGNORE_TABLE);

        $options = ProductOptionsValuePeer::doSelectWithI18n($c);

        uasort($options, array('stNewProductOptions', 'sortHelper'));

        return $options;
    }

    public static function sortHelper($o1, $o2)
    {
        return strnatcasecmp($o1->getValue(), $o2->getValue());
    }

    /**
     * Returns Filter criteria
     *
     * @return Criteria
     */
    protected static function getCriteriaForFilter()
    {
        $c = !stConfig::getInstance('stProduct')->get('filter_narrow') ? clone self::$post_product_criteria : clone self::$pre_product_criteria;
        $c->clearSelectColumns()->clearOrderByColumns();
        $c->addSelectColumn(ProductPeer::ID); 
        $c->add('custom_option_join', sprintf("%s = %s", ProductOptionsValuePeer::PRODUCT_ID, ProductPeer::ID), Criteria::CUSTOM | Criteria::IGNORE_TABLE);
        $c->setLimit(null);
        $c->setOffset(null);

        return $c;
    }

    protected static function getFilterById($id)
    {
        if (null === self::$filtersPool)
        {
            $filters = array();
            foreach (ProductOptionsFilterPeer::doSelect(new Criteria()) as $filter)
            {
                $filters[$filter->getId()] = $filter;
            }
            self::$filtersPool = $filters;
        }

        return isset(self::$filtersPool[$id]) ? self::$filtersPool[$id] : null;
    }

    public static function listFilter($event)
    {
        $action = $event->getSubject();

        if (isset($action->product_pager))
        {   
            $request = $action->getRequest();
            
            if (!$request->hasParameter('filter') && $request->getHttpHeader('X-Moz') != 'prefetch')
            {
               self::clearFilters($action->getContext());
            }

            $c = $action->product_pager->getCriteria();
            self::addOptionsFilterCriteria($action->getContext(), $c);
        }
    }

    public static function addOptionsFilterCriteria(sfContext $context, Criteria $c)
    {
        self::$pre_product_criteria = clone $c;

        $config = stConfig::getInstance('stProduct');

        if (stNewProductOptions::hasFilters($context))
        {
            $pConfig = stConfig::getInstance('stProduct');
            $filters = stNewProductOptions::getFilters($context);

            if ($filters) {
                foreach ($filters as $id => $selected) {
                    $filter = self::getFilterById($id);
                    $oc = new Criteria();
                    $oc->addSelectColumn(ProductOptionsValuePeer::ID);
                    $oc->add(ProductOptionsValuePeer::PRODUCT_ID, sprintf("%s = %s", ProductOptionsValuePeer::PRODUCT_ID, ProductPeer::ID), Criteria::CUSTOM);
                    if ($pConfig->get('hide_options_with_empty_stock')) {
                        $oc->add(ProductOptionsValuePeer::STOCK, sprintf('(%1$s IS NULL OR %1$s > 0)', ProductOptionsValuePeer::STOCK), Criteria::CUSTOM);
                    }
                    $oc->add($filter->getFilterType() == 2 ? ProductOptionsValuePeer::COLOR : ProductOptionsValuePeer::OPT_VALUE, array_values($selected), Criteria::IN);
                    $oc->add(ProductOptionsValuePeer::OPT_FILTER_ID, $id);
                    $query = BasePeer::createSqlQuery($oc);
                    $cnew = $c->getNewCriterion(ProductPeer::ID, sprintf("EXISTS (%s)", $query), Criteria::CUSTOM);
                    $c->addAnd($cnew);
                }
            }
        }
        
        self::$post_product_criteria = clone $c;
    }        


    public static function getFilters(sfContext $context)
    {
        return $context->getUser()->getAttribute('filters', array(), stProductFilter::getNamespace($context, 'soteshop/stProductOptions'));
    }

    public static function hasFilters(sfContext $context)
    {
        return (bool)self::getFilters($context);
    }

    public static function setFilters(sfContext $context, $filters)
    {
        $context->getUser()->setAttribute('filters', $filters, stProductFilter::getNamespace($context, 'soteshop/stProductOptions'));
    }

    public static function clearFilters(sfContext $context, $filter = null)
    {
        $filters = self::getFilters($context);

        if ($filter && isset($filters[$filter]))
        {
            unset($filters[$filter]);
        }
        elseif (null === $filter)
        {
            $filters = array();
        }

        self::setFilters($context, $filters);
    }

    public static function saveProductColors($event) 
    {
        $product = $event->getSubject();
        $product_id = $product->getId();

        if (!$product->isNew()) 
        {
            $c = new Criteria();
            $c->addSelectColumn(ProductOptionsFilterPeer::ID);
            $c->add(ProductOptionsFilterPeer::FILTER_TYPE, 2);
            $rs = ProductOptionsFilterPeer::doSelectRs($c);
            $filters = array();

            while($rs->next())
            {
                $filters[] = $rs->getInt(1);
            }

            if ($filters)
            {
                $c = new Criteria();
                $c->addSelectColumn(ProductOptionsValuePeer::ID);
                $c->addSelectColumn(ProductOptionsValuePeer::COLOR);
                $c->addSelectColumn(ProductOptionsValuePeer::STOCK);
                $c->addSelectColumn(ProductOptionsValuePeer::USE_IMAGE_AS_COLOR);
                $c->add(ProductOptionsValuePeer::LFT, ProductOptionsValuePeer::RGT." - ".ProductOptionsValuePeer::LFT." > 0", Criteria::CUSTOM);
                $c->add(ProductOptionsValuePeer::PRODUCT_ID, $product_id);
                $c->add(ProductOptionsValuePeer::OPT_FILTER_ID, $filters, Criteria::IN);
                $c->addDescendingOrderByColumn(ProductOptionsValuePeer::STOCK);
                $c->addGroupByColumn(ProductOptionsValuePeer::COLOR);
                $rs = ProductOptionsValuePeer::doSelectRs($c);

                $colors = array();
                
                while($rs->next())
                {
                    $row = $rs->getRow();
                    $colors[] = array(
                        'color' => $row[3] ? ProductOptionsValuePeer::getColorImagePath($product_id, $row[0], $row[1]) : $row[1],
                        'stock' => $row[2],
                        'image_as_color' => $row[3]
                    );
                }

                $product->setOptionsColor($colors);                
            }
        } 
    }
}
