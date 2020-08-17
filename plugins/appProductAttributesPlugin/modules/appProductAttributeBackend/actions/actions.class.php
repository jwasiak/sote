<?php

class appProductAttributeBackendActions extends autoappProductAttributeBackendActions
{
   public function executeAjaxVariantToken()
   {
      $query = $this->getRequestParameter('q');

      $duplicates = explode(',', $this->getRequestParameter('d'));

      $attribute_id = $this->getRequestParameter('id');

      $type = $this->getRequestParameter('type');

      $c = new Criteria();

      $c->addJoin(appProductAttributeVariantPeer::ID, appProductAttributeHasVariantPeer::VARIANT_ID);

      $c->add(appProductAttributeHasVariantPeer::ATTRIBUTE_ID, $attribute_id);

      if ($duplicates)
      {
         $c->add(appProductAttributeVariantPeer::ID, $duplicates, Criteria::NOT_IN);  
      } 

      if ($type == 'C')
      {
         $c->add(appProductAttributeVariantPeer::NAME, '%'.$query.'%', Criteria::LIKE);
      }
      else
      {
         $c->add(appProductAttributeVariantPeer::OPT_VALUE, '%'.$query.'%', Criteria::LIKE);
      }

      $c->setLimit(100);

      $tokens = appProductAttributeVariantPeer::doSelectTokens($c, $type);

      return $this->renderJson($tokens);
   }

   public function executeAjaxCategoryToken()
   {
      $query = $this->getRequestParameter('q');

      $c = new Criteria();

      $duplicates = explode(',', $this->getRequestParameter('d'));

      $c->add(CategoryPeer::ID, $duplicates, Criteria::NOT_IN);

      $c->add(CategoryPeer::PARENT_ID, null, Criteria::ISNOTNULL);

      $c->add(CategoryPeer::OPT_NAME, $query.'%', Criteria::LIKE);                 

      $c->setLimit(100);
      
      $tokens = ProductPeer::doSelectCategoriesTokens($c);

      return $this->renderJson($tokens);
   }
   
   public function executeProductAttribute()
   {
      $request = $this->getRequest();

      $product_id = $request->getParameter('product_id');

      $this->product = ProductPeer::retrieveByPK($product_id);

      $this->product->setCulture($request->getParameter('culture', stLanguage::getOptLanguage()));  

      if ($request->getMethod() == sfRequest::POST)
      {
         $app_product_attribute_variant = $request->getParameter('app_product_attribute_variant');

         $app_product_attribute = $request->getParameter('app_product_attribute');

         if (isset($app_product_attribute['label'])) {
         	$this->product->setAttributesLabel($app_product_attribute['label']);
         	$this->product->save();
         }

         $c = new Criteria();

         $c->add(appProductAttributeVariantHasProductPeer::PRODUCT_ID, $product_id);

         appProductAttributeVariantHasProductPeer::doDelete($c);

         foreach ($app_product_attribute_variant as $attribute_id => $variant)
         {
            $attribute = appProductAttributePeer::retrieveByPK($attribute_id);

            if ($attribute->getType() == 'B')
            {
               $vhp = new appProductAttributeVariantHasProduct();

               $vhp->setProductId($product_id);

               $vhp->setVariantId($variant);

               $vhp->save();               
            }
            else
            {
               $tokens = stJQueryToolsHelper::parseTokensFromRequest($variant);

               foreach ($tokens as $token)
               {
                  if ($token['new'])
                  {
                     $v = new appProductAttributeVariant();

                     $v->setCulture(stLanguage::getOptLanguage());

                     $v->setValue($token['id']);

                     $v->save();

                     $variant_id = $v->getId();

                     $ahv = new appProductAttributeHasVariant();

                     $ahv->setAttributeId($attribute_id);

                     $ahv->setVariantId($variant_id);

                     $ahv->save();
                  }
                  else
                  {
                     $variant_id = $token['id'];
                  }

                  $vhp = new appProductAttributeVariantHasProduct();

                  $vhp->setProductId($product_id);

                  $vhp->setVariantId($variant_id);

                  $vhp->save();
               }
            }
         }

         $i18n = $this->getContext()->getI18n();

         $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));

         return $this->redirect('@appProductAttributesPlugin?action=productAttribute&product_id='.$product_id.'&culture='.$this->product->getCulture());
      }
      else
      {
         $this->attributes = appProductAttributePeer::doSelectByProduct($this->product);
      }  
   }

   public function executeVariantEdit()
   {
      parent::executeVariantEdit();

      if ($this->app_product_attribute_variant->getType() === null && $this->related_object->getType() == 'C') 
      {
         $this->app_product_attribute_variant->setType('C');
      } 
   }

   public function validateEdit()
   {
   	$request = $this->getRequest();

   	if ($request->getMethod() == sfRequest::POST)
   	{
   		$data = $request->getParameter('app_product_attribute');

   		if (!isset($data['name']) || empty($data['name']))
   		{
   			$request->setError('app_product_attribute{name}', 'Musisz podać wartość');
   		}
   	} 

   	return !$request->hasErrors();  	
   }

   public function validateVariantEdit()
   {
   	$request = $this->getRequest();

   	if ($request->getMethod() == sfRequest::POST)
   	{
   		$data = $request->getParameter('app_product_attribute_variant');

   		if (!isset($data['color_type']) && empty($data['value'])) 
   		{
   			$request->setError('app_product_attribute_variant{_value}', 'Musisz podać wartość');
   		}

   		if (isset($data['value']) && $data['value']) 
   		{
   			$c = new Criteria();

   			$c->addJoin(appProductAttributeVariantPeer::ID, appProductAttributeHasVariantPeer::VARIANT_ID);

   			$c->addJoin(appProductAttributeVariantPeer::ID, appProductAttributeVariantI18nPeer::ID);

   			$c->add(appProductAttributeHasVariantPeer::ATTRIBUTE_ID, $request->getParameter('attr_id'));

   			$c->add(appProductAttributeVariantI18nPeer::VALUE, $data['value']);

   			if ($request->hasParameter('id'))
   			{
   				$c->add(appProductAttributeVariantPeer::ID, $request->getParameter('id'), Criteria::NOT_EQUAL);
   			}

   			if (appProductAttributeVariantPeer::doCount($c) > 0) 
   			{
   				$request->setError('app_product_attribute_variant{_value}', 'Podana wartość już istnieje');
   			}
   		}	
   	}

   	return !$request->hasErrors();
   }

   protected function saveVariantappProductAttributeVariant($app_product_attribute_variant)
   {
      $request = $this->getRequest();

      if ($app_product_attribute_variant->isNew())
      {
         $pahv = new appProductAttributeHasVariant();

         $pahv->setAttributeId($this->forward_parameters['attr_id']);

         $app_product_attribute_variant->addappProductAttributeHasVariant($pahv);
      }

      $this->moveProductAttributeVariantPicture($app_product_attribute_variant);    

      parent::saveVariantappProductAttributeVariant($app_product_attribute_variant);
   } 

   protected function saveappProductAttribute($app_product_attribute)
   {
      $is_new = $app_product_attribute->isNew();

      parent::saveappProductAttribute($app_product_attribute);

      $this->saveProductAttributeInCategory($app_product_attribute);

      if ($is_new && $app_product_attribute->getType() == 'B')
      {
         $variant = new appProductAttributeVariant();

         $variant->setPosition(0);

         $variant->setOptValue('');

         $variant->save();

         $ahv = new appProductAttributeHasVariant();

         $ahv->setAttributeId($app_product_attribute->getId());

         $ahv->setVariantId($variant->getId());

         $ahv->save();
      }
   }  

   protected function getVariantappProductAttributeVariantOrCreate($id = 'id') 
   {
      $app_product_attribute_variant = parent::getVariantappProductAttributeVariantOrCreate($id);

      if ($app_product_attribute_variant->isPictureType())
      {
         $this->previous_app_product_attribute_variant = clone $app_product_attribute_variant;
      }

      return $app_product_attribute_variant;
   } 

   protected function addSortCriteria($c)
   {
      $c->addAscendingOrderByColumn(appProductAttributePeer::POSITION);
      $c->addAscendingOrderByColumn(appProductAttributePeer::ID);       
      parent::addSortCriteria($c);     
   }

   protected function addFiltersCriteria($c)
   {
      parent::addFiltersCriteria($c);

      $category_filter = $this->getRequestParameter('category_filter');

      if (null !== $category_filter)
      {
         $this->getUser()->setAttribute('category_filter', $category_filter, 'soteshop/appProductAttribute');
      }
      else
      {
         $category_filter = $this->getUser()->getAttribute('category_filter', 0, 'soteshop/appProductAttribute');
      }

      if ($category_filter)
      {
         $path = CategoryPeer::doSelectExpanded($category_filter);

         if ($path)
         {
            $c->addJoin(appProductAttributePeer::ID, appProductAttributeHasCategoryPeer::ATTRIBUTE_ID);

            $c->add(appProductAttributeHasCategoryPeer::CATEGORY_ID, array_keys($path), Criteria::IN);

            $c->addGroupByColumn(appProductAttributePeer::ID);
         }
      }
   } 

   protected function addVariantSortCriteria($c)
   {
      $c->addAscendingOrderByColumn(appProductAttributeVariantPeer::POSITION);
      $c->addAscendingOrderByColumn(appProductAttributeVariantPeer::ID);      
      parent::addVariantSortCriteria($c);
   }  

   protected function addVariantFiltersCriteria($c)
   {
      $c->addJoin(appProductAttributeVariantPeer::ID, appProductAttributeHasVariantPeer::VARIANT_ID);

      $c->add(appProductAttributeHasVariantPeer::ATTRIBUTE_ID, $this->forward_parameters['attr_id']);   
   }

   protected function saveProductAttributeInCategory(appProductAttribute $app_product_attribute)
   {
      $app_product_attribute_category = $this->getRequestParameter('app_product_attribute_category');

      $tokens = stJQueryToolsHelper::parseTokensFromRequest($app_product_attribute_category);

      $attribute_id = $app_product_attribute->getId();

      $c = new Criteria();

      $c->add(appProductAttributeHasCategoryPeer::ATTRIBUTE_ID, $attribute_id);

      appProductAttributeHasCategoryPeer::doDelete($c);

      if ($tokens)
      {      
         foreach ($tokens as $token)
         {
            $pc = new appProductAttributeHasCategory();

            $pc->setAttributeId($attribute_id);

            $pc->setCategoryId($token['id']);

            $pc->save();
         }
      }  
   }   

   protected function moveProductAttributeVariantPicture($app_product_attribute_variant)
   {
      $request = $this->getRequest();

      if ($request->getFileError('app_product_attribute_variant[picture]') == UPLOAD_ERR_OK)
      {
         $ext = pathinfo($request->getFileName('app_product_attribute_variant[picture]'), PATHINFO_EXTENSION);

         $name = uniqid().sha1(microtime().serialize($app_product_attribute_variant).serialize($this->related_object).serialize($request->getFile('app_product_attribute_variant[picture]')));

         $image = $app_product_attribute_variant->getUploadDir().'/'.$name.'.'.$ext;

         $request->moveFile('app_product_attribute_variant[picture]', sfConfig::get('sf_web_dir').'/'.$image);

         $app_product_attribute_variant->removePicture();

         $app_product_attribute_variant->setPicture($image);
      }
      elseif (isset($this->previous_app_product_attribute_variant) && $app_product_attribute_variant->isColorType())
      {
         $this->previous_app_product_attribute_variant->removePicture();
      }  
   }

   protected function getVariantLabels()
   {
   	$labels = parent::getVariantLabels();

   	$labels['app_product_attribute_variant{_value}'] = 'Wartość';

   	return $labels;
   }
}