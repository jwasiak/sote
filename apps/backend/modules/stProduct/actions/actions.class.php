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
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 2545 2009-08-11 13:58:21Z pawel $
 */

/**
 * Akcje stProduct
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @author Marcin Olejncizak <marcin.olejniczak@sote.pl>
 * @author Krzysztof Beblo <krzysztof.beblo@sote.pl>
 *
 * @package     stProduct
 * @subpackage  actions
 */
class stProductActions extends autostProductActions
{
   public function executeImageGalleryEdit()
   {
      $image_id = $this->getRequestParameter('image_id');

      $culture = $this->getRequestParameter('culture');

      $this->asset = sfAssetPeer::retrieveByPK($image_id);

      if (null === $this->asset) 
      {
         return sfView::NONE;
      }      

      $this->asset->setCulture($culture);

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $this->asset->setDescription($this->getRequestParameter('plupload_edit[description]'));

         $this->asset->save();

         return sfView::NONE;
      }
   }

   public function executeAjaxFilterCategory()
   {
      $pk = str_replace('cf-trigger-', '', $this->getRequestParameter('id'));

      sfLoader::loadHelpers('stPartial');

      $params = array('include_container' => false);

      $c = new Criteria();

      $c->add(CategoryPeer::PARENT_ID, null, Criteria::ISNULL);

      if ($pk == 'null')
      {
         $roots = CategoryPeer::doSelect($c);

         if (isset($roots[1]))
         {
            $params['children'] = $roots;
         }
         elseif ($roots)
         {
            $params['parent'] = $roots[0];
         }
      }
      else
      {
         $parent = CategoryPeer::retrieveByPK($pk);

         if (!$parent->getParentId() && CategoryPeer::doCount($c) > 1)
         {
            $params['return_value'] = array('return_id' => 'null', 'label' => $parent->getName(), 'id' => null);
         }
         elseif ($parent->getParentId())
         {
            $params['return_value'] = array('return_id' => $parent->getParentId(), 'label' => $parent->getName(), 'id' => $parent->getId());
         }

         $params['parent'] = $parent;
      }



      return $this->renderText(st_get_partial('stProduct/category_filter', $params));
   }

   public function filterCriteriaByProductHidePrice(Criteria $c, $value)
   {
      if ($value !== "")
      {
         if ($value < 0)
         {
            $c->add(ProductPeer::HIDE_PRICE, null, Criteria::ISNULL);
         }
         else
         {
            $c->add(ProductPeer::HIDE_PRICE, $value);
         }
      }

      return true;
   }

   public function executeAjaxCategoryToken()
   {
      $query = $this->getRequestParameter('q');

      $ids = $this->getRequestParameter('ids');

      $allow_assign_leaf_only = $this->getRequestParameter('allow_assign_leaf_only');

      $c = new Criteria();

      if ($query)
      {
         $duplicates = explode(',', $this->getRequestParameter('d'));

         //$c->addJoin(CategoryPeer::PARENT_ID, CategoryPeer::alias('parent', CategoryPeer::ID));

         $c->add(CategoryPeer::ID, $duplicates, Criteria::NOT_IN);

         $c->add(CategoryPeer::PARENT_ID, null, Criteria::ISNOTNULL);

         $c->add(CategoryPeer::OPT_NAME, $query.'%', Criteria::LIKE); 

         if ($allow_assign_leaf_only)
         {
            $c->add(CategoryPeer::LFT, sprintf('%s - %s = 1', CategoryPeer::RGT, CategoryPeer::LFT), Criteria::CUSTOM);
         }
         
         //$c->add(CategoryPeer::alias('parent', OPT_NAME), $query.'%', Criteria::LIKE);                 

         $c->setLimit(100);
      }
      elseif ($ids)
      {
         $c->add(CategoryPeer::ID, $ids, Criteria::IN);
      }

      $tokens = ProductPeer::doSelectCategoriesTokens($c);

      return $this->renderJson($tokens);
   }

   public function executeAjaxProductsToken()
   {
      $query = $this->getRequestParameter('q');

      $id = $this->getRequestParameter('id');

      $duplicates = explode(',', $this->getRequestParameter('d'));

      if ($id)
      {
         $duplicates[] = $id;
      }

      $c = new Criteria();

      $criterion = $c->getNewCriterion(ProductPeer::CODE, $query);

      $criterion->addOr($c->getNewCriterion(ProductPeer::OPT_NAME, '%'.$query.'%', Criteria::LIKE));

      if ($duplicates)
      {
         $c->add(ProductPeer::ID, $duplicates, Criteria::NOT_IN);
      }

      $c->add($criterion);

      $c->setLimit(100);

      $tokens = ProductPeer::doSelectTokens($c);

      return $this->renderJson($tokens);
   }   

   public function executeList()
   {
      if ($this->getActionName() == 'list' &&  $this->getUser()->getAttribute('list_type', 'long', 'soteshop/stProduct') == 'long')
      {
         return $this->forward('stProduct', 'listLong');
      }

      parent::executeList();

      $this->pager->getCriteria()->setDistinct();

      $this->pager->init();

   }

   public function executeListLong()
   {
      $this->executeList();

   }

   public function executeChooseList()
   {
      $type = $this->getRequestParameter('type');

      $this->getUser()->setAttribute('list_type', $type, 'soteshop/stProduct');

      if ($type == 'long')
      {
         $this->redirect('stProduct/listLong');
      }
      else
      {
         $this->redirect('stProduct/list');
      }
   }


   protected function addSortCriteria($c)
   {
      if ($sort_column = $this->getUser()->getAttribute('sort', null, 'sf_admin/autoStProduct/sort'))
      {
         $sort_column = $this->translateSortColumn($sort_column);

         if ($sort_column == ProductPeer::CODE)
         {
            if ($this->getUser()->getAttribute('type', null, 'sf_admin/autoStProduct/sort') == 'asc')
            {

               $c->addAscendingOrderByColumn($sort_column.' + 0');
            }
            else
            {
               $c->addDescendingOrderByColumn($sort_column.' + 0');
            }
         }
      }
      
      parent::addSortCriteria($c);
   }

   /**
    * Zapisuje atrybuty produktu
    *
    * @param       Product     $product
    */
   protected function saveAttributes($product)
   {

      $attribute_fields = $this->getRequestParameter('attribute_field', array());

      $product_id = $product->getId();

      $c = new Criteria();
      $c->add(ProductHasAttributeFieldPeer::PRODUCT_ID, $product_id);
      ProductHasAttributeFieldPeer::doDelete($c);
      if (is_array($attribute_fields))
      {
         foreach ($attribute_fields as $id => $value)
         {
            $product_has_attribute_field = new ProductHasAttributeField();
            $product_has_attribute_field->setValue($value);
            $product_has_attribute_field->setProductId($product_id);
            $product_has_attribute_field->setAttributeFieldId($id);
            $product_has_attribute_field->save();
         }
      }
   }

   /**
    * Dodaje produkt do wybranych kategorii
    *
    * @param       Product     $product
    */
   protected function saveProductInCategory($product)
   {
      $product_category = $this->getRequestParameter('product_category');

      $tokens = stJQueryToolsHelper::parseTokensFromRequest($product_category);

      $product_id = $product->getId();

      $c = new Criteria();

      $c->add(ProductHasCategoryPeer::PRODUCT_ID, $product_id);

      ProductHasCategoryPeer::doDelete($c);

      if ($tokens)
      {
         $default_id = $this->getRequestParameter('product_default_category');
         
         foreach ($tokens as $token)
         {
            $pc = new ProductHasCategory();

            $pc->setProductId($product_id);

            $pc->setCategoryId($token['id']);

            if ($default_id == $token['id'])
            {
               $pc->setIsDefault(true);
            }

            $pc->save();
         }
      }  
   }

   protected function saveProductInAccessories($product)
   {
      $product_accessories = $this->getRequestParameter('product_accessories');

      $tokens = stJQueryToolsHelper::parseTokensFromRequest($product_accessories);

      $product_id = $product->getId();

      $c = new Criteria();

      $c->add(ProductHasAccessoriesPeer::PRODUCT_ID, $product_id);

      ProductHasAccessoriesPeer::doDelete($c);

      if ($tokens)
      {         
         foreach ($tokens as $token)
         {
            $pa = new ProductHasAccessories();

            $pa->setProductId($product_id);

            $pa->setAccessoriesId($token['id']); 

            $pa->save();
         }
      }  
   }

   protected function saveProductInRecommend($product)
   {
      $product_recommend = $this->getRequestParameter('product_recommend');

      $tokens = stJQueryToolsHelper::parseTokensFromRequest($product_recommend);

      $product_id = $product->getId();

      $c = new Criteria();

      $c->add(ProductHasRecommendPeer::PRODUCT_ID, $product_id);

      ProductHasRecommendPeer::doDelete($c);

      if ($tokens)
      {         
         foreach ($tokens as $token)
         {
            $pa = new ProductHasRecommend();

            $pa->setProductId($product_id);

            $pa->setRecommendId($token['id']); 

            $pa->save();
         }
      }  
   } 

   protected function saveProductInGroup($product)
   {
      $product_group = $this->getRequestParameter('product_group');

      $tokens = stJQueryToolsHelper::parseTokensFromRequest($product_group);      

      $product_id = $product->getId();

      $ids = array();

      $c = new Criteria();
      $c->addSelectColumn(ProductGroupPeer::ID);
      $c->add(ProductGroupPeer::FROM_BASKET_VALUE, null, Criteria::ISNOTNULL);
      $rs = ProductGroupPeer::doSelectRs($c);

      while($rs->next())
      {
         $ids[] = $rs->getInt(1);
      }

      $c = new Criteria();
      $c->add(ProductGroupHasProductPeer::PRODUCT_ID, $product_id);
      if ($ids) 
      {
         $c->add(ProductGroupHasProductPeer::PRODUCT_GROUP_ID, $ids, Criteria::NOT_IN);
      }

      BasePeer::doDelete($c, Propel::getConnection());

      $ids = array();

      $opt_product_group_array = array();

      foreach ($tokens as $token)
      {
         $ids[] = $token['id'];

         $pg = new ProductGroupHasProduct();

         $pg->setProductId($product_id);

         $pg->setProductGroupId($token['id']);

         $pg->save();

         $opt_product_group_array[]= $token['id'];
      }
   
      if (end($opt_product_group_array))
      {
         $opt_product_group_array = serialize($opt_product_group_array);

         $product->setOptProductGroup($opt_product_group_array);

      }else{

         $product->setOptProductGroup(NULL);
         
      }

      $product->save();

      if ($product->getMainPageOrder() > 0) 
      {
         $group = ProductGroupPeer::doSelectOneByType('MAIN_PAGE');

         if ($group)
         {
            if (!in_array($group->getId(), $ids))
            {
               $pg = new ProductGroupHasProduct();

               $pg->setProductId($product_id);

               $pg->setProductGroupId($group->getId());

               $pg->save();  
            }
         }
      }
   } 
   
   protected function saveProductInDiscountGroup($product)
   {
      $discount_group = $this->getRequestParameter('discount_group');

      $tokens = stJQueryToolsHelper::parseTokensFromRequest($discount_group);      

      $product_id = $product->getId();

      $c = new Criteria();

      $c->add(DiscountHasProductPeer::PRODUCT_ID, $product_id);

      DiscountHasProductPeer::doDelete($c);

      foreach ($tokens as $token)
      {
         $d = new DiscountHasProduct();

         $d->setProductId($product_id);

         $d->setDiscountId($token['id']);

         $d->save();
      }
   }      

   public function executePresentationConfig()
   {

      $i18n = $this->getContext()->getI18N();

      $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStProduct/presentation_forward_parameters');

      $this->config = $this->loadPresentationConfigOrCreate();

      $this->labels = $this->getPresentationConfigLabels();

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $this->updatePresentationConfigFromRequest();

         $this->savePresentationConfig();

         stTheme::clearSmartyCache(true);

         stFunctionCache::clearFrontendModule('stProduct', 'product');

         ProductGroupPeer::cleanCache();

         stFastCacheManager::clearCache();

         $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));

         return $this->redirect('stProduct/presentationConfig');
      }
   }

   /**
    * Przeciązenie aktualizowania ceny produktu
    *
    */
   protected function updateProductFromRequest()
   {
      $product = $this->getRequestParameter('product');

      parent::updateProductFromRequest();

      if ($this->product->getDimensionId())
      {
         $this->product->setWidth($this->product->getProductDimension()->getWidth());
         $this->product->setHeight($this->product->getProductDimension()->getHeight());
         $this->product->setDepth($this->product->getProductDimension()->getDepth());
      }

      if (isset($product['bpum_default_value']))
      {
         $this->product->setBpumDefaultValue($product['bpum_default_value']);
      }

      if (isset($product['bpum_default_id']))
      {
         $this->product->setBpumDefaultId($product['bpum_default_id']);
      }
      
      if (isset($product['bpum_value']))
      {
         $this->product->setBpumValue($product['bpum_value']);
      }

      if (isset($product['bpum_id']))
      {
         $this->product->setBpumId($product['bpum_id']);
      }

      if ($this->product->getCurrency()->getIsSystemCurrency())
      {
         if (isset($product['price_netto']))
         {
            $this->product->setPriceNetto($product['price_netto']);
         }

         if (isset($product['price_brutto']))
         {
            $this->product->setPriceBrutto($product['price_brutto']);
         }

         if (isset($product['old_price_netto']))
         {
            $this->product->setOldPriceNetto($product['old_price_netto']);
         }

         if (isset($product['old_price_brutto']))
         {
            $this->product->setOldPriceBrutto($product['old_price_brutto']);
         }

         $this->product->setCurrencyPrice(null);

         $this->product->setCurrencyOldPrice(null);

         $this->product->setHasFixedCurrency(false);

         $this->product->setCurrencyExchange(1);
      }
      else
      {
         if (isset($product['price_brutto']))
         {
            $this->product->setCurrencyPrice($product['price_brutto']);
         }

         if (isset($product['old_price_brutto']))
         {
            $this->product->setCurrencyOldPrice($product['old_price_brutto']);
         }

         if (isset($product['has_fixed_currency_exchange']))
         {
            $this->product->setHasFixedCurrency(true);

            $this->product->setCurrencyExchange($product['fixed_currency_exchange']);
         }
         else
         {
            $this->product->setHasFixedCurrency(false);
         }
      }

      $product_delivery = $this->getRequestParameter('product_delivery');

      if ($product_delivery)
      {

         $tokens = stJQueryToolsHelper::parseTokensFromRequest($product_delivery['ids']);   

         $ids = array();

         foreach ($tokens as $token) 
         {
            $ids[] = $token['id'];
         }

         $product_delivery['ids'] = $ids;

         $this->product->setDeliveries($product_delivery);
      }

      if (isset($product['hide_price']))
      {
         $this->product->setHidePrice($product['hide_price'] !== "" ? $product['hide_price'] : null);
      }
   }

   /**
    * Przeciażenie zapisywania produktu
    *
    * @param       Product     $product
    */
   protected function saveProduct($product)
   {
      $this->getDispatcher()->notify(new sfEvent($this, 'autoStProductActions.preSave', array('modelInstance' => $product)));
      $product->save();

      $this->saveProductInCategory($product);

      $this->saveProductInRecommend($product);

      $this->saveProductInAccessories($product);

      $this->saveProductInGroup($product);

      $this->saveProductInDiscountGroup($product);

      $this->saveProductImage($product);

      $this->getDispatcher()->notify(new sfEvent($this, 'autoStProductActions.postSave', array('modelInstance' => $product)));
   }

   /**
    * Ustawianie kodu przy dodawniu produktu
    */
   public function executeEdit()
   {
      sfLoader::loadHelpers(array('Helper', 'stProduct'), 'stProduct');

      parent::executeEdit();

      if (!$this->product->getCode())
      {
         $this->product->setCode($this->getDefaultCode());
      }
   }

   public function validateEdit()
   {
      $product = $this->getRequestParameter('product');

      $request = $this->getRequest();
      
      $product_id = $this->getRequestParameter('id');

      $i18n = $this->getContext()->getI18N();

      if ($request->getMethod() == sfRequest::POST)
      {
         if ($product['max_qty'] > 0 && $product['min_qty'] > $product['max_qty'])
         {
            $request->setError('product{min_qty}', $i18n->__('Minimalna ilość nie może być większa od maksymalnej ilości'));
         }
         
         if ($product['points_value'] < 0)
         {
            $request->setError('product{points_value}', $i18n->__('Wartość nie może być ujemna'));   
         }
         
         if ($product['points_earn'] < 0)
         {
            $request->setError('product{points_earn}', $i18n->__('Wartość nie może być ujemna'));   
         }
         
         if($product_id!="" && $product['points_only']==1)
         {
             $error = 0;
             
              $c = new Criteria();
              $c->add(DiscountPeer::PRODUCT_ID, $product_id);
              $discounts = DiscountPeer::doSelect($c);
              
              if ($discounts)
              {
                 foreach ($discounts as $discount) {
                     if($discount->getType()=="S"){
                         $error = 1;
                     }
                 }    
              }
             
              $c = new Criteria();
              $c->add(DiscountHasProductPeer::PRODUCT_ID, $product_id);
              $c->addJoin(DiscountHasProductPeer::DISCOUNT_ID, DiscountPeer::ID);
              $discounts = DiscountHasProductPeer::doSelectJoinAll($c);

              if ($discounts)
              {
                 foreach ($discounts as $discount) {
                     
                     if($discount->getDiscount()->getType()=="S"){
                         $error = 1;
                     }
                 }
              }
              
              if($error ==1){
                  $request->setError('product{points_only}', $i18n->__('Nie można uczynić produktu tylko za punkty, ponieważ produkt należy do zestawu rabatowego.'));
              }      
             
         }
         
      }
      return!$request->hasErrors();
   }

   public function handleErrorEdit()
   {
      sfLoader::loadHelpers(array('Helper', 'stProduct'), 'stProduct');

      return parent::handleErrorEdit();
   }

   public function executeAttachmentList()
   {
      parent::executeAttachmentList();

      $this->pager->getCriteria()->add(ProductHasAttachmentPeer::PRODUCT_ID, $this->forward_parameters['product_id']);

      $this->pager->getCriteria()->addAscendingOrderByColumn(ProductHasAttachmentPeer::ID);

      $this->pager->init();
   }

   /**
    * Pokazuje domyślny kod produktu, na podstawie id produktu
    *
    * @return  domyślny   kod produktu
    */
   private function getDefaultCode()
   {
      $c = new Criteria();
      $c->addDescendingOrderByColumn('id');
      $product = ProductPeer::doSelectOne($c);
      if ($product)
      {
         $num = $product->getId() + 1;
      }
      else
      {
         $num = 1;
      }
      return $num;
   }

   protected function updateConfigFromRequest()
   {

      parent::updateConfigFromRequest();

      $config = $this->getRequestParameter('config');

      if($config['global_price_netto']==1)

      {

         $this->config->set("price_view", "only_net", false);

         $this->config->set("price_view_long", "only_net", false);

         $this->config->set("price_view_short", "only_net", false);

         $this->config->set("price_view_other", "only_net", false);

         $this->config->set("price_view_group", "only_net", false);

         $config_product = stConfig::getInstance('stProduct');

         if ($config_product->get("global_price_netto")!=1)

         {

            $config_basket = stConfig::getInstance('stBasket');

            $config_basket->set("show_netto_in_basket",1);

            $config_basket->save();
      
         }

      }

   }

   protected function saveConfig()
   {
      parent::saveConfig();

      stFunctionCache::clearFrontendModule('stProduct', 'product');
      ProductGroupPeer::cleanCache();
      stTheme::clearSmartyCache(true);
      stFastCacheManager::clearCache();
   }

   public function executeExport()
   {
      if ($this->getRequest()->getMethod() != sfRequest::POST)
      {
         $this->getUser()->setAttribute('criteria', null, 'soteshop/stProduct/export');
         $this->getUser()->setAttribute('map_builders', null, 'soteshop/stProduct/export');

         if ($this->getRequestParameter('type') == 'list')
         {
            $this->filters = $this->getUser()->getAttributeHolder()->getAll('soteshop/stAdminGenerator/stProduct/list/filters');

            $c = new Criteria();
            $this->addFiltersCriteria($c);

            $this->getUser()->setAttribute('criteria', $c, 'soteshop/stProduct/export');
            $this->getUser()->setAttribute('map_builders', array_keys(BasePeer::getMapBuilders()), 'soteshop/stProduct/export');
         }
      }
      else
      {
         $criteria = $this->getUser()->getAttribute('criteria', null, 'soteshop/stProduct/export');

         if ($criteria)
         {
            $this->getRequest()->setParameter('exporter', $this->getRequest()->getParameter('exporter').'List');
         }

         $this->getUser()->setAttribute('external_images', $this->getRequestParameter('external_images'), 'soteshop/stProduct/export');
      }

      return parent::executeExport();
   }

   /**
    * Dodaje zdjęcie do produktu
    *
    * @param Product $product Produkt
    */
   protected function saveProductImage($product)
   {
      $product_images = $this->getRequestParameter('product_images');

      $plupload = stJQueryToolsHelper::parsePluploadFromRequest($product_images);

      if ($plupload['delete'])
      {
         foreach (sfAssetPeer::retrieveByPKs($plupload['delete']) as $asset)
         {
            if ($asset->getRelativePath() == $product->getOptImage())
            {
               $product->setOptImage(null);
               $product->save();
            }
            
            $asset->delete();
         }
      }

      if ($plupload['modified'])
      {
         $c = new Criteria();

         $c->add(ProductHasSfAssetPeer::PRODUCT_ID, $product->getId());

         BasePeer::doDelete($c, Propel::getConnection());
         
         foreach ($plupload['modified'] as $offset => $filename)
         {
            $product_has_asset = new ProductHasSfAsset();

            $product_has_asset->setProduct($product);

            $product_has_asset->setIsDefault($offset == 0);

            if (is_numeric($filename))
            {
               $product_has_asset->setSfAssetId($filename);
            }
            else
            {
               $product_has_asset->createAsset($filename, $plupload['dir'].'/'.$filename, ProductHasSfAssetPeer::IMAGE_FOLDER);
            }

            $product_has_asset->save();
         }
      }
    
      stJQueryToolsHelper::pluploadCleanup($plupload);

      if ($delete || $modified)
      {
         ExportMd5HashPeer::clearHash($product->getId(), 'Product', 'product_images');       
      }
   }

   protected function getAttachmentProductHasAttachmentOrCreate($id = 'id')
   {
      $product_has_attachment = parent::getAttachmentProductHasAttachmentOrCreate($id);

      $product_has_attachment->setProductId($this->forward_parameters['product_id']);

      return $product_has_attachment;
   }

   protected function saveAttachmentProductHasAttachment($product_has_attachment)
   {
      $custom_name = $product_has_attachment->getAttachmentEditFilename();

      if ($this->getRequest()->getFileError('product_has_attachment[attachment_edit_file]') == UPLOAD_ERR_OK)
      {
         $filename = $this->getRequest()->getFileName('product_has_attachment[attachment_edit_file]');

         $filepath = $this->getRequest()->getFilePath('product_has_attachment[attachment_edit_file]');

         $info = pathinfo($filename);

         if ($custom_name)
         {
            $filename = stPropelSeoUrlBehavior::makeSeoFriendly($custom_name).'.'.$info['extension'];
         }
         else
         {
            $filename = stPropelSeoUrlBehavior::makeSeoFriendly($info['filename']).'.'.$info['extension'];
         }

         $product_has_attachment->createAsset($filepath, $filename, false);
      }
      else
      {
         $product_has_attachment->renameAsset(stPropelSeoUrlBehavior::makeSeoFriendly($custom_name));
      }

      parent::saveAttachmentProductHasAttachment($product_has_attachment);
   }

   protected function deleteAttachmentProductHasAttachment($product_has_attachment)
   {
      parent::deleteAttachmentProductHasAttachment($product_has_attachment);

      $product_has_attachment->getsfAsset()->delete();
   }

   public function validateAttachmentEdit()
   {
      $ok = true;

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $id = $this->getRequestParameter('id');

         $validator = new stAssetFileValidator();

         $validator->initialize($this->getContext(), array('mime_types' => null, 'required' => !$id));

         $value = $this->getRequest()->getFileValues('product_has_attachment[attachment_edit_file]');

         if (!$validator->execute($value, $error))
         {
            $this->getRequest()->setError('product_has_attachment{attachment_edit_file}', $error);

            return false;
         }

         $c = new Criteria();

         $product_id = $this->getRequestParameter('product_id');

         $product = ProductPeer::retrieveByPK($product_id);

         $filename = $this->getRequestParameter('product_has_attachment[attachment_edit_filename]');

         if ($pk = $this->getRequestParameter('id'))
         {
            $pha = ProductHasAttachmentPeer::retrieveByPK($pk);

            $uploaded_filename = $pha->getSfAsset()->getFilename();

            $check_filename = $pha->getAttachmentEditFilename() != $filename;

            $culture = $pha->getOptCulture();
         }
         else
         {
            $check_filename = true;

            $language = LanguagePeer::retrieveByPK($this->getRequestParameter('product_has_attachment[attachment_edit_language]'));

            if ($language)
            {
               $culture = $language->getOriginalLanguage();
            }
         }

         if ($this->getRequest()->getFileError('product_has_attachment[attachment_edit_file]') == UPLOAD_ERR_OK)
         {
            $uploaded_filename = $this->getRequest()->getFileName('product_has_attachment[attachment_edit_file]');
         }

         $ext = sfAssetsLibraryTools::getFileExtension($uploaded_filename);

         if ($check_filename && sfAssetPeer::retrieveFromUrl('/media/products/'.$product->getAssetFolder().'/attachments/'.$culture.'/'.$filename.'.'.$ext))
         {
            $this->getRequest()->setError('product_has_attachment{attachment_edit_filename}', 'Załącznik o podanej nazwie już istnieje...');

            $ok = false;
         }
      }

      return $ok;
   }

   public function executeFixCode()
   {
      $this->checked = $this->getRequestParameter('checked');
   }

   /**
    * Poprawne filtry w produkcie
    *
    */
   public function executeFixProducts()
   {
      
   }

   /**
    * Tymczasowa poprawka filtrowania po producencie
    *
    * @author Marcin Butlak <marcin.butlak@sote.pl>
    *
    */
   protected function addFiltersCriteria($c)
   {
      if (isset($this->filters['producer_id']) && $this->filters['producer_id'] !== '')
      {
         $c->addJoin(ProductPeer::PRODUCER_ID, ProducerI18nPeer::ID);
      }

      parent::addFiltersCriteria($c);

      if (isset($this->filters['namecode']) && $this->filters['namecode'] !== '')
      {
         $c->add(ProductPeer::CODE, sprintf("(%1\$s LIKE '%3\$s' OR %2\$s LIKE '%3\$s')", ProductPeer::OPT_NAME, ProductPeer::CODE, '%'.$this->filters['namecode'].'%'), Criteria::CUSTOM);
      }  

      if (isset($this->filters['list_image']) && $this->filters['list_image'] !== '')
      {
         $c->add(ProductPeer::OPT_IMAGE, null, $this->filters['list_image'] ? Criteria::ISNOTNULL : Criteria::ISNULL);
      }

      if (($category = $this->getRequestParameter('category_filter')) !== null)
      {
         $this->getUser()->setAttribute('category_filter', $category, 'soteshop/stProduct');
      }

      $category_filter = $this->getUser()->getAttribute('category_filter', null, 'soteshop/stProduct');

      $cc = new Criteria();

      $cc->add(CategoryPeer::ID, $category_filter);

      if ($category_filter && CategoryPeer::doCount($cc))
      {
         $c->addJoin(ProductHasCategoryPeer::PRODUCT_ID, ProductPeer::ID);

         $c->add(ProductHasCategoryPeer::CATEGORY_ID, $category_filter);
      }
      else
      {
         $this->getUser()->setAttribute('category_filter', null, 'soteshop/stProduct');
      }

      if (isset($this->filters['allegro']) && $this->filters['allegro'] !== '')
      {
         $c->addJoin(ProductPeer::ID, AllegroAuctionPeer::PRODUCT_ID, Criteria::LEFT_JOIN);

         $c->add(AllegroAuctionPeer::PRODUCT_ID, null, $this->filters['allegro'] ? Criteria::ISNOTNULL : Criteria::ISNULL);
      }
   }

   /**
    * Zapisywanie wyglądu karty produktu
    *
    */
   protected function updatePresentationConfigFromRequest()
   {
      parent::updatePresentationConfigFromRequest();

      $config = $this->getRequestParameter('config');
   }

   public function handleErrorPresentationConfig()
   {
      $this->preExecute();
      $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStProduct/forward_parameters');

      $this->config = $this->loadPresentationConfigOrCreate();

      $this->labels = $this->getPresentationConfigLabels();

      $this->updatePresentationConfigFromRequest();

      return sfView::SUCCESS;
   }

   /**
    * Zduplikuj produkt
    *
    */
   public function executeDuplicate()
   {
      stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());

      $i18n = $this->getContext()->getI18N();

      if ($this->hasRequestParameter('id'))
      {
         $id = $this->getRequestParameter('id');
      }

      $this->new_code = $this->getDefaultCode();

      $default_culture = $this->getUser()->getCulture();
      $product = ProductPeer::retrieveByPK($id);
      $this->product = $product;

      if ($this->hasRequestParameter('save'))
      {
         $duplicate_product = $product->copy();
         $duplicate_product->setCreatedAt(time());
         $duplicate_product->setCulture($default_culture);
         $duplicate_product->setUrl(null);
         $duplicate_product->setActive(0);
         $duplicate_product->setCode($this->getRequestParameter('product[code]'));
         $duplicate_product->setName($this->getRequestParameter('product[name]'));
         $duplicate_product->setOptName($this->getRequestParameter('product[name]'));
         $duplicate_product->setDescription($product->getDescription());
         $duplicate_product->setShortDescription($product->getShortDescription());
         $duplicate_product->setDescription2($product->getDescription2());
         $duplicate_product->setParentId($id);
         $duplicate_product->setOptAssetFolder(null);
         $duplicate_product->save();


         // duplikuje zdjęcie produktu
         $duplicated_assets = array();
         $c = new Criteria();
         $c->add(ProductHasSfAssetPeer::PRODUCT_ID, $id);
         $phas = ProductHasSfAssetPeer::doSelectJoinsfAsset($c);
         foreach ($phas as $pha)
         {
           $asset = $pha->getSfAsset();
            $tmp = new ProductHasSfAsset();
            $tmp->setProduct($duplicate_product);
            $tmp->setIsDefault($pha->getIsDefault());
            $duplicated_asset = $tmp->createAsset($asset->getFilename(), $asset->getFullPath(), null, null, $asset->getDescription(), false, false);
            $tmp->save();
            $duplicated_assets[$asset->getId()] = $duplicated_asset->getId();
         }
         unset($phas);

         /*duplikuje nazwe produktu
         $c = new Criteria();
         $c->add(ProductI18nPeer::ID, $id);
         $productI18ns = ProductI18nPeer::doSelect($c);
         foreach ($productI18ns as $productI18n)
         {
            $culture = $productI18n->getCulture();
            if ($culture != $default_culture)
            {
               $duplicate_product_i18n = $productI18n->copy();
               $duplicate_product_i18n->setCulture($culture);
               $duplicate_product_i18n->setUrl($productI18n->getUrl().'-duplicate-'.$num_duplicated);
               $duplicate_product_i18n->setName($productI18n->getName().' Duplicate-'.$num_duplicated);
               $duplicate_product_i18n->setId($duplicate_product->getId());
               $duplicate_product_i18n->save();
            }
         }
         unset($productI18ns);
         */

         //duplikuje kategorie produktu
         $c = new Criteria();
         $c->add(ProductHasCategoryPeer::PRODUCT_ID, $id);
         $product_has_categories = ProductHasCategoryPeer::doSelect($c);
         foreach ($product_has_categories as $product_has_category)
         {
            $duplicate_product_has_category = $product_has_category->copy();
            $duplicate_product_has_category->setProductId($duplicate_product->getId());
            $duplicate_product_has_category->save();
         }
         unset($product_has_categories);

         /* duplikuje pozycjonowanie
         $c = new Criteria();
         $c->add(ProductHasPositioningPeer::PRODUCT_ID, $id);
         $product_has_positioning = ProductHasPositioningPeer::doSelectOne($c);
         if ($product_has_positioning)
         {
            $duplicate_product_has_positioning = $product_has_positioning->copy();
            $duplicate_product_has_positioning->setProductId($duplicate_product->getId());
            $duplicate_product_has_positioning->save();

            $c = new Criteria();
            $c->add(ProductHasPositioningI18nPeer::ID, $product_has_positioning->getId());
            $product_has_positioning_i18ns = ProductHasPositioningI18nPeer::doSelect($c);
            foreach ($product_has_positioning_i18ns as $product_has_positioning_i18n)
            {
               $culture = $product_has_positioning_i18n->getCulture();
               $duplicate_product_has_positioning_i18n = $product_has_positioning_i18n->copy();
               $duplicate_product_has_positioning_i18n->setCulture($culture);
               $duplicate_product_has_positioning_i18n->setId($duplicate_product_has_positioning->getId());
               $duplicate_product_has_positioning_i18n->save();
            }

            unset($product_has_positioning_i18ns);
            
         }
         */
         //duplikuje grupy produku
         $c = new Criteria();
         $c->add(ProductGroupHasProductPeer::PRODUCT_ID, $id);
         $product_has_groups = ProductGroupHasProductPeer::doSelect($c);
         foreach ($product_has_groups as $product_has_group)
         {
            $duplicate_product_has_group = $product_has_group->copy();
            $duplicate_product_has_group->setProductId($duplicate_product->getId());
            $duplicate_product_has_group->save();
         }


         stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stProductActions.postExecuteDuplicate', array(
             'id' => $id, 
             'duplicate_id' => $duplicate_product->getId(),
             'product' => $product,
             'duplicate' => $duplicate_product,
             'duplicated_assets' => $duplicated_assets,
           )));

         $this->redirect("stProduct/edit?id=".$duplicate_product->getId());
      }
   }

   public function handleErrorDuplicate()
   {   
      sfLoader::loadHelpers(array('Helper', 'stProduct'), 'stProduct');
      $this->preExecute();
       
      if ($this->hasRequestParameter('id'))
      {
         $id = $this->getRequestParameter('id');
      }
         
      $product = ProductPeer::retrieveByPK($id);
      $this->product = $product;
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $this->new_code = $this->getRequestParameter('product[code]');
      }
      else
      {
         $this->new_code = $this->getDefaultCode();
      }

      return sfView::SUCCESS;
   }

   /**
    *  Pokaż liste duplikatów
    */
   public function executeDuplicateList()
   {
      parent::executeDuplicateList();

      $this->pager->getCriteria()->add(ProductPeer::PARENT_ID, $this->forward_parameters['product_id']);

      $this->pager->getCriteria()->setDistinct();

      $this->pager->init();
   }

   protected function updateListItem($product, $request)
   {
      parent::updateListItem($product, $request);

      if (isset($request['price_brutto']))
      {
         $product->setPriceBrutto($request['price_brutto']);

         $product->setPriceNetto(null);
      }
   }

   public function validateUpdateList()
   {
      $ok = true;

      $request = $this->getRequest();

      if ($request->getMethod() == sfRequest::POST)
      {
         $products = $request->getParameter('product', array());

         $code_validator = new stProductCodeValidator();

         $code_validator->initialize($this->getContext());

         foreach ($products as $id => $data)
         {
            if ($id == 'selected')
            {
               continue;
            }

            if (isset($data['code']))
            {
               $code_validator->setParameter('primary_key', $id);

               if (!$code_validator->execute($data['code'], $error))
               {
                  $request->setError('product{'.$id.'}{code}', $error);

                  $ok = false;
               }
            }
         }
      }

      return $ok;
   }

   public function handleErrorUpdateList()
   {
      $this->getRequest()->getParameterHolder()->remove('filters');

      $this->executeList();

      $this->setTemplate('list');

      return sfView::SUCCESS;
   }

   public function executeProductEnable()
   {
      stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());

      $products = ProductPeer::retrieveByPKs($this->getRequestParameter('product[selected]', array()));

      foreach ($products as $product)
      {
         $product->setActive(true);

         $product->save();
      }

      return $this->redirect('stProduct/list?page='.$this->getRequestParameter('page', 1));
   }

   public function executeProductDisable()
   {
      stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
      
      $products = ProductPeer::retrieveByPKs($this->getRequestParameter('product[selected]', array()));

      foreach ($products as $product)
      {
         $product->setActive(false);

         $product->save();
      }

      return $this->redirect('stProduct/list?page='.$this->getRequestParameter('page', 1));
   }

   public function executeMoreList()
   {
         $this->product = ProductPeer::retrieveByPk($this->getRequestParameter('product_id'));
   }
  
  public function executeOnlineDocsDelete(){
    $this->executeOnlineImagesDelete();
  }

  public function executeOnlineAudioDelete(){
    $this->executeOnlineImagesDelete();
  }

  public function executeOnlineImagesDelete()
  {
    $forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStProduct/online_images_forward_parameters');

    $ids = $this->getRequestParameter('online_files[selected]', array($this->getRequestParameter('id')));
  
    foreach($ids as $id)
    {
        if (!$this->processOnlineImagesDelete($id))
        {
            break;
        } 
    }
    return $this->redirect($this->getRequest()->getReferer());
  }

  public function executeOnlineCodesDelete()
  {
    $forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStProduct/online_codes_forward_parameters');

    $ids = $this->getRequestParameter('online_codes[selected]', array($this->getRequestParameter('id')));
  
    foreach($ids as $id)
    {
        if (!$this->processOnlineCodesDelete($id))
        {
            break;
        } 
    }
  
    return $this->redirect($this->getRequest()->getReferer());
  }

  protected function updateOnlineAudioOnlineFilesFromRequest()
  {
    parent::updateOnlineDocsOnlineFilesFromRequest();
    $this->online_files->setMediaType('ST_AUDIO');
  }

  protected function updateOnlineImagesOnlineFilesFromRequest()
  {
    parent::updateOnlineDocsOnlineFilesFromRequest();
    $this->online_files->setMediaType('ST_IMAGES');
  }

  protected function updateOnlineDocsOnlineFilesFromRequest()
  {
    parent::updateOnlineDocsOnlineFilesFromRequest();
    $this->online_files->setMediaType('ST_DOCS');
  }

  public function executeViewProduct()
  {

      if ($this->getRequest()->hasParameter('id'))
      {
         $id = $this->getRequestParameter('id');
         $product = ProductPeer::retrieveByPk($id);

         if (is_object($product))
         {
            stPluginHelper::addRouting('stProductUrlLang', '/:lang/:url.html', 'stProduct', 'frontendShow', 'backend', array(), array('lang' => '[a-z]{2,2}'));
            stPluginHelper::addRouting('stProductUrl', '/:url.html', 'stProduct', 'frontendShow', 'backend');
            sfLoader::loadHelpers(array('Helper','stUrl'));

            $c = new Criteria();
            $c->add(LanguagePeer::IS_DEFAULT, 1);
            $default_lang = LanguagePeer::doSelectOne($c);

            if (empty($default_lang)){
               $c = new Criteria();
               $c->add(LanguagePeer::ACTIVE, 1);
               $default_lang = LanguagePeer::doSelectOne($c);  
            }
            
            $culture = $default_lang->getLanguage();
            $url = st_url_for('stProduct/frontendShow?url='.$product->getFriendlyUrl(), true, 'frontend', null, $culture, true, null);
            return $this->redirect($url, 301);      
         }
         else
         {
            return $this->redirect('stProduct/list');
         }
      }
      else
      {
         return $this->redirect('stProduct/list');
      }
  }

  protected function addDepositoryFiltersCriteria($c)
  {
   parent::addDepositoryFiltersCriteria($c);

   if (isset($this->filters['avail']) && $this->filters['avail'])
   {
      $stock_from = false;
      $stock_to = null;

      $availabilities = AvailabilityPeer::doSelectOrderByStockCached(); 

      foreach ($availabilities as $availability)
      {
        if (false !== $stock_from)
        {
            $stock_to=$availability->getStockFrom();
            break;
        }

        if ($availability->getId() == $this->filters['avail'])
        {
            $stock_from=$availability->getStockFrom();
        }
      }      

      $criterion = $c->getNewCriterion(ProductPeer::AVAILABILITY_ID, $this->filters['avail']);
      if ($stock_to)
      {
         $criterion->addOr($c->getNewCriterion(ProductPeer::STOCK, sprintf('%1$s IS NULL AND %2$s >= %3$s AND %2$s < %4$s',
            ProductPeer::AVAILABILITY_ID, 
            ProductPeer::STOCK,
            $stock_from,
            $stock_to
         ), Criteria::CUSTOM));
      }
      else
      {
         $criterion->addOr($c->getNewCriterion(ProductPeer::STOCK, sprintf('%s IS NULL AND %s >= %s',
            ProductPeer::AVAILABILITY_ID, 
            ProductPeer::STOCK,
            $stock_from
         ), Criteria::CUSTOM));
      }

      $c->add($criterion);
   }
   }

    protected function updateReviewReviewFromRequest()
  {
    $review = $this->getRequestParameter('review');

    if (isset($review['created_at']))
    {
      if ($review['created_at'])
      {
        try
        {
          $dateFormat = new sfDateFormat($this->getUser()->getCulture());
                              if (!is_array($review['created_at']))
          {
            $value = $dateFormat->format($review['created_at'], 'I', $dateFormat->getInputPattern('g'));
          }
          else
          {
            $value_array = $review['created_at'];
            $value = $value_array['year'].'-'.$value_array['month'].'-'.$value_array['day'].(isset($value_array['hour']) ? ' '.$value_array['hour'].':'.$value_array['minute'].(isset($value_array['second']) ? ':'.$value_array['second'] : '') : '');
          }
          $this->review->setCreatedAt($value);
        }
        catch (sfException $e)
        {
          // not a date
        }
      }
      else
      {
        $this->review->setCreatedAt(null);
      }
    }
    if (isset($review['admin_name']))
    {
      if (method_exists($this->review, 'setAdminName'))
      {
        $this->review->setAdminName($review['admin_name']);
      }
    }
    if (isset($review['language']))
    {
      if (method_exists($this->review, 'setLanguage'))
      {
        $this->review->setLanguage($review['language']);
      }
    }
    $this->review->setAgreement(isset($review['agreement']) ? $review['agreement'] : 0);
    $this->review->setIsPinReview(isset($review['is_pin_review']) ? $review['is_pin_review'] : 0);
    
    if(isset($review['is_pin_review']) && !$this->review->getPinReview()){
        
        $c = new Criteria();
        $c->add(ReviewPeer::PIN_REVIEW, $this->review->getPinReview(), Criteria::GREATER_THAN);
        $c->add(ReviewPeer::PRODUCT_ID, $this->review->getProductId());
        $c->addDescendingOrderByColumn(ReviewPeer::PIN_REVIEW);
        $max_review = ReviewPeer::doSelectOne($c);
        
        if($max_review){                    
            $this->review->setPinReview($max_review->getPinReview()+1);        
        }else{
            $this->review->setPinReview(1);    
        }        
    }
        
    if(!isset($review['is_pin_review'])){
        $this->review->setPinReview(0);
    }
    
    
    $this->review->setUserReviewVerified(isset($review['user_review_verified']) ? $review['user_review_verified'] : 0);
    if (isset($review['score']))
    {
      if (method_exists($this->review, 'setScore'))
      {
        $this->review->setScore($review['score']);
      }
    }
    if (isset($review['description']))
    {
      $this->review->setDescription($review['description']);
    }
    
    if ($this->getRequest()->getFileSize('review[user_picture]'))
      {
         $currentFile = sfConfig::get('sf_upload_dir') . $this->review->getUserPicture(); 
      
         $fileName = md5($this->getRequest()->getFileName('review[user_picture]') . time() . rand(0, 99999));
         $ext = $this->getRequest()->getFileExtension('review[user_picture]');
         if (is_file($currentFile))
         {
            unlink($currentFile);
         }                 
         $this->review->setUserPicture("/review_picture/" . $this->getRequestParameter('culture', stLanguage::getOptLanguage()) . '/' . $fileName . $ext);
                
         $this->getRequest()->moveFile('review[user_picture]', sfConfig::get('sf_upload_dir') . $this->review->getUserPicture());
      }
    
    
    if (isset($review['user_facebook']))
    {
      $this->review->setUserFacebook($review['user_facebook']);
    }
    if (isset($review['user_instagram']))
    {
      $this->review->setUserInstagram($review['user_instagram']);
    }
    if (isset($review['user_youtube']))
    {
      $this->review->setUserYoutube($review['user_youtube']);
    }
    if (isset($review['user_twitter']))
    {
      $this->review->setUserTwitter($review['user_twitter']);
    }
    $this->getDispatcher()->notify(new sfEvent($this, 'autoStProductActions.postUpdateReviewFromRequest', array('modelInstance' => $this->review, 'requestParameters' => $review)));
  }



   public function executeDeleteImage()
   {
        $request = $this->getRequest();       
                           
        $id = $request->getParameter('id');        

        $review = ReviewPeer::retrieveByPK($id);

        if ($review){
            $review->setUserPicture(null);
            $review->save();
        }           
            
        stFastCacheManager::clearCache();
        foreach (glob(sfConfig::get('sf_root_dir').'/cache/smarty_c/*') as $file)
        {unlink($file);}
        
        $this->setFlash('notice', 'Zdjęcie zostało usunięte');
        $this->redirect('stProduct/reviewEdit?id='.$id.'&product_id'.$review->getProductId());
       
    }

}
