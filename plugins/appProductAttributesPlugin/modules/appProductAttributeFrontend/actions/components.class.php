<?php

class appProductAttributeFrontendComponents extends sfComponents
{
   public function executeShowFilter()
   {
      if (!stConfig::getInstance('appProductAttributeBackend')->get('filters_enabled'))
      {
         return sfView::NONE;
      }
            
      if (!isset($this->criteria))
      {
         $action = $this->getContext()->getActionStack()->getLastEntry()->getActionInstance();

         if (!isset($action->product_pager) || !appProductAttributeHelper::hasFilters($this->getContext()) && !$action->product_pager->getNbResults())
         {
            return sfView::NONE;
         }  

         $this->criteria = clone $this->getUser()->getParameter('pre_filter_criteria', null, 'soteshop/appProductAttribute');
      }
      else
      {
         $this->criteria = clone $this->criteria;
      }
      
      $attributes = $this->getAttributes();

      if (!$attributes)
      {
         return sfView::NONE;
      }

      $variants = $this->getVariants($attributes); 

      if (!$variants)
      {
         return sfView::NONE;
      }

      $category = $this->getUser()->getParameter('selected', null, 'soteshop/stCategory');

      $smarty = new stSmarty('appProductAttributeFrontend');

      $smarty->assign('filters', appProductAttributeHelper::getFilters($this->getContext(), true));

      $smarty->assign('selected', appProductAttributeHelper::getFilters($this->getContext())); 

      $smarty->assign('attributes', $attributes);

      $smarty->assign('variants', $variants);
 
      $smarty->assign('filter_url', $this->getController()->genUrl('@appProductAttributesPlugin').'?category_id='.$category->getId());

      $smarty->assign('reset_url', $this->getController()->genUrl('@stProduct?action=clearFilter&category_id='.$category->getId()));

      $smarty->assign('category', $category);

      return $smarty;
   }

   public function executeList()
   {
      $culture = $this->getUser()->getCulture();

      $variants = appProductAttributeVariantPeer::doSelectArrayWithAttribyteByProduct($this->product, $culture);

      if (!$variants)
      {
         return sfView::NONE;
      }

      $attributes = appProductAttributePeer::doSelectArrayByProduct($this->product, $culture);

      if (!$attributes)
      {
         return sfView::NONE;
      }

      $smarty = new stSmarty('appProductAttributeFrontend');

      $smarty->register_function('pa_text_variants', 'appProductAttributeFrontendComponents::smartyTextVariants');

      $smarty->assign('attributes', $attributes);

      $smarty->assign('variants', $variants);

      $smarty->assign('label', appProductAttributeHelper::getAttributeLabel($this->product));

      return $smarty;
   }

   public function getAttributes()
   {
      $category = $this->getUser()->getParameter('selected', null, 'soteshop/stCategory');

      if (null === $category)
      {
         return array();
      }

      return appProductAttributePeer::doSelectArrayByCategory($category, $this->getUser()->getCulture());      
   }

   public static function smartyTextVariants($params)
   {
      $variants = array();

      foreach ($params['variants'] as $variant)
      {
         $variants[] = $variant['value'];
      }

      return implode(', ', $variants);
   }


   protected function getVariants($attributes)
   {
      $ids = array_keys($attributes);
      
      $this->criteria->clearSelectColumns();
      $this->criteria->clearOrderByColumns();
      $this->criteria->clearGroupByColumns();
      $this->criteria->addSelectColumn(ProductPeer::ID);
      $config = stConfig::getInstance('appProductAttributeBackend'); 

      $disable_filter_dependency = stConfig::getInstance('stProduct')->get('disable_filter_dependency');

      if (!$disable_filter_dependency)
      {
         ProductPeer::addPriceFilterCriteria($this->getContext(), $this->criteria);
         stNewProductOptions::addOptionsFilterCriteria($this->getContext(), $this->criteria);
      }

      $c = clone $this->criteria;

      $c->addJoin(appProductAttributeVariantHasProductPeer::PRODUCT_ID, ProductPeer::ID);
      $c->addJoin(appProductAttributeVariantPeer::ID, appProductAttributeVariantHasProductPeer::VARIANT_ID);

    //   $c->add(appProductAttributeVariantHasProductPeer::PRODUCT_ID, appProductAttributeVariantHasProductPeer::PRODUCT_ID.' IN ('.$sql.')', Criteria::CUSTOM);

      $c->addGroupByColumn(appProductAttributeVariantPeer::ID);

      $variants = appProductAttributeVariantPeer::doSelectArrayWithAttribute($c, $this->getUser()->getCulture(), $ids);

      $narrow = !$config->get('no_narrow_filters', true) && !$disable_filter_dependency;

      if ($narrow && appProductAttributeHelper::hasFilters($this->getContext()))
      {
         $enabled = appProductAttributeHelper::getEnabledVariants($this->getContext(), $this->criteria, $variants);

         foreach ($variants as $id1 => $values)
         {
            foreach ($values as $id2 => $params) 
            {
               if (!isset($enabled[$id2]))
               {
                  unset($variants[$id1][$id2]);
               }
            }
         } 
      }

      return $variants;          
   }
}