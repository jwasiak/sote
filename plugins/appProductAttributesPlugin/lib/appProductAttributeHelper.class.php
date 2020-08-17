<?php 
class appProductAttributeHelper
{
   public static $origProductPagerCriteria = null;

   public static function getTypes()
   {
      $i18n = sfContext::getInstance()->getI18n();

      return array(
         'C' => $i18n->__('Kolor'),         
         'B' => $i18n->__('Tak/Nie'),         
         'T' => $i18n->__('Tekst'),
      );      
   } 

   public static function addProductPagerCriteria($product_pager)
   {
      if (stConfig::getInstance('appProductAttributeBackend')->get('filters_enabled'))
      {
         $sf_context = sfContext::getInstance();
         
         $sf_context->getUser()->setParameter('pre_filter_criteria', clone $product_pager->getCriteria(), 'soteshop/appProductAttribute');

         $request = $sf_context->getRequest();

         $has_filters = appProductAttributeHelper::hasFilters($sf_context);

         if ($has_filters && !$request->hasParameter('filter') && $request->getHttpHeader('X-Moz') != 'prefetch')
         {
            appProductAttributeHelper::clearFilters($sf_context);

            $has_filters = false;
         }

         $c = $product_pager->getCriteria();

         appProductAttributeHelper::$origProductPagerCriteria = clone $c;      

         if ($has_filters)
         {
            appProductAttributeHelper::addProductFilterCriteria($sf_context, $c);

            $product_pager->setPeerCountMethod(array('appProductAttributeVariantHasProductPeer', 'doCountProduct'));
         }
      }
   }    

   public static function getAttributeLabel(Product $product)
   {
      $label = $product->getAttributesLabel();

      if (null === $label)
      {
         $culture = $product->getCulture();

         $product->setCulture(stLanguage::getOptLanguage());

         $label = $product->getAttributesLabel();

         $product->setCulture($culture);
      }    

      return $label;
   }

   public static function getFilterUrl($url)
   {
      $query_div = strpos($url, '?') !== false ? '&' : '?';

      return strpos($url, 'filter=1') !== false ? $url : $url.$query_div.'filter=1';
   }

   public static function getLabelByType($type)
   {
      $types = self::getTypes();

      return isset($types[$type]) ? $types[$type] : $type; 
   } 

   public static function sortArrayResults(&$array, $preserve_assoc = true)
   {
      if ($preserve_assoc)
      {
         uasort($array, array('appProductAttributeHelper', 'sortArrayResultsHelper'));
      }
      else
      {
         usort($array, array('appProductAttributeHelper', 'sortArrayResultsHelper'));
      }
   }

   public static function sortArrayResultsHelper($arr1, $arr2)
   {
      if ($arr1['position'] == $arr2['position']) 
      {
         if ($arr1['id'] == $arr2['id'])
         {
            return 0;
         }

         return $arr1['id'] < $arr2['id'] ? -1 : 1;
      }

      return $arr1['position'] < $arr2['position'] ? -1 : 1;
   }

   public static function addProductFilterCriteria(sfContext $context, Criteria $c)
   {
      $config = stConfig::getInstance('appProductAttributeBackend'); 

      if (self::hasFilters($context))
      {
         $c->addJoin(ProductPeer::ID, appProductAttributeVariantHasProductPeer::PRODUCT_ID);

         if (!in_array(ProductPeer::ID, $c->getGroupByColumns()))
         {
            $c->addGroupByColumn(ProductPeer::ID);
         }

         if ($config->get('filter_by', 'or') == 'or')
         {
            $filters = self::getFilters($context, true);

            $c->addJoin(appProductAttributeVariantHasProductPeer::VARIANT_ID, appProductAttributeHasVariantPeer::VARIANT_ID);

            foreach ($filters as $id => $attribute)
            {
               $sql = sprintf('%s = %s AND %s IN (%s)', 
                  appProductAttributeHasVariantPeer::ATTRIBUTE_ID,
                  $id,
                  appProductAttributeVariantHasProductPeer::VARIANT_ID,
                  implode(',',$attribute)
               );

               $c->addOr($c->getNewCriterion(appProductAttributeVariantHasProductPeer::VARIANT_ID, $sql, Criteria::CUSTOM));
            }

            $c->addHaving($c->getNewCriterion(appProductAttributeHasVariantPeer::ATTRIBUTE_ID, 'COUNT(DISTINCT '.appProductAttributeHasVariantPeer::ATTRIBUTE_ID.') >= '. count($filters), Criteria::CUSTOM));
         }
         else
         {
            $filters = self::getFilters($context);

            $c->add(appProductAttributeVariantHasProductPeer::VARIANT_ID, array_values($filters), Criteria::IN);
            $c->addHaving($c->getNewCriterion(appProductAttributeVariantHasProductPeer::VARIANT_ID, 'COUNT(DISTINCT '.appProductAttributeVariantHasProductPeer::VARIANT_ID.') >= '.count($filters), Criteria::CUSTOM));
         }
      }
   }

   public static function getFilters(sfContext $context, $with_attributes = false)
   {
      $namespace = self::getNamespace($context);
      $filters = $context->getUser()->getAttribute('filters', array(), $namespace);

      $results = array();

      if (!$with_attributes)
      {
         foreach ($filters as $attribute)
         {
            foreach ($attribute as $filter_id) 
            {
               $results[$filter_id] = $filter_id;
            }
         }
      } 
      else
      {
         $results = $filters;
      }

      return $results;
   }

   public static function hasFilters(sfContext $context)
   {
      $namespace = self::getNamespace($context);
      $filters = $context->getUser()->getAttribute('filters', array(), $namespace);

      return !empty($filters);
   }

   public static function setFilters(sfContext $context, $filters = array())
   {
      $namespace = self::getNamespace($context);
      $context->getUser()->setAttribute('filters', $filters, $namespace);
   }

   public static function clearFilters(sfContext $context)
   {
      self::setFilters($context);
   }

   public static function getEnabledVariants(sfContext $context, Criteria $pc, $variants)
   {
      $ids = array();
      self::addProductFilterCriteria($context, $pc);
      $pc->clearSelectColumns();
      $pc->clearOrderByColumns();
      $pc->clearGroupByColumns();

      if (!in_array(ProductPeer::ID, $pc->getGroupByColumns()))
      {
         $pc->addGroupByColumn(ProductPeer::ID);
      }
      
      $pc->addSelectColumn(ProductPeer::ID);

      $sql = BasePeer::createSqlQuery($pc);
      
      foreach ($variants as $variant)
      {
         foreach ($variant as $id => $values) 
         {
            $ids[] = $id;
         }
      }

      $enabled = array();

      if ($ids)
      {
         $con = Propel::getConnection();

         $statement = sprintf('SELECT %1$s FROM %2$s, (%3$s) as temp WHERE %4$s = temp.ID AND %1$s IN (%5$s)',
            appProductAttributeVariantHasProductPeer::VARIANT_ID,
            appProductAttributeVariantHasProductPeer::TABLE_NAME,
            $sql,
            appProductAttributeVariantHasProductPeer::PRODUCT_ID,
            implode(',', $ids)
         );

         $rs = $con->executeQuery($statement);

         while($rs->next())
         {
            $row = $rs->getRow();
            $enabled[$row['VARIANT_ID']] = $row['VARIANT_ID'];
         }
      }

      return $enabled;    
   }

   protected static function getNamespace(sfContext $context)
   {   
      $selected = $context->getUser()->getParameter('selected', null, 'soteshop/stCategory');
      $category_id = $selected ? $selected->getId() : 0;
        
      return 'soteshop/appProductAttribute/'.$category_id;   
   }
}