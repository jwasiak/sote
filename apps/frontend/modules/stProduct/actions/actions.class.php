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
 * @version     $Id: actions.class.php 2594 2009-08-14 14:12:36Z krzysiek $
 */

/**
 * Akcje produktu
 *
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl>
 *
 * @package     stProduct
 * @subpackage  actions
 */
class stProductActions extends stActions
{
   public function preExecute()
   {
      if ($this->hasRequestParameter('producer'))
      {
         $this->processProducerFriendlyUrl($this->getRequestParameter('producer'));

         if ($this->producer)
         {
            stProducer::setSelectedProducerId($this->producer->getId());
         }
         else
         {
            $this->getRequest()->setParameter('producer', null);
            return $this->forward('stProduct', 'producerNotFound');
         }
      }

      parent::preExecute();
   }
   public function executeAttachmentList()
   {

      if(!$this->getRequest()->isXmlHttpRequest() && $this->getController()->getRenderMode() != sfView::RENDER_VAR){  

        $this->getResponse()->setStatusCode(404);

        $this->getResponse()->setHttpHeader('Status', '404 Not Found');

        return $this->forward('stErrorFrontend', 'error404');
     }

      $product_id = $this->getRequestParameter('id');

      $this->product = ProductPeer::retrieveByPK($product_id);

      $this->smarty = new stSmarty('stProduct');

      $c = new Criteria();

      $c->addJoin(ProductHasAttachmentPeer::SF_ASSET_ID, sfAssetPeer::ID);

      $c->add(ProductHasAttachmentPeer::PRODUCT_ID, $this->product->getId());

      $c->add(ProductHasAttachmentPeer::IS_ACTIVE, true);

      $c->add(ProductHasAttachmentPeer::OPT_CULTURE, $this->getUser()->getCulture());

      $this->attachments = sfAssetPeer::doSelectWithI18n($c);

      $this->setLayout(false);
   }

   /**
    * Lista Produktow z produktów danego producenta 
    */
   public function executeProducerList()
   {
      $this->page = $this->getRequestParameter('page');

      if (!$this->processProducerFriendlyUrl())
      {
         return $this->forward('stProduct', 'producerNotFound');
      }  

      $this->getRequest()->setParameter('producer', $this->getRequestParameter('url'));

      stProducer::setSelectedProducerId($this->producer->getId()); 
      
      $this->config = stConfig::getInstance(sfContext::getInstance(), 'stProduct');

      $this->smarty = new stSmarty($this->getModuleName());

      $pager = new stPropelPager('Product');

      $c = new Criteria();

      $this->productPagerInit($c);

      $this->product_on_page = $this->product_pager->getCntResults();

      $this->forLinkInit($this->producer->getFriendlyUrl(), $this->product_pager->getPage());
      
      $this->config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');
      $this->config_points->setCulture(sfContext::getInstance()->getUser()->getCulture());

      $this->sort_labels = $this->getSortColumns('label_names');

      $this->view_labels = $this->getViewTypes('label_names');

      $this->title = $this->producer->getName();

      $this->addRelLinks('producerList', $this->producer->getFriendlyUrl());
   }

   /**
    * Strona nieznalezionej grupy produktów
    *
    */
   public function executeProducerNotFound()
   {
      $this->getResponse()->setStatusCode(404);

      $this->getResponse()->setHttpHeader('Status', '404 Not Found');

      $this->smarty = new stSmarty($this->getModuleName());
   }

   /**
    * Dodaje kryteria producenta
    *
    * @param      Criteria    $c
    */
   protected function addProducerCriteria(Criteria $c)
   {
      if ($this->getTheme()->getVersion() < 7)
      {
         $producer_id = $this->getUser()->getAttribute('producer_filter', stProducer::getSelectedProducerId(), stProductFilter::getNamespace($this->getContext(), 'soteshop/stProduct'));
      
         if ($producer_id)
         {
            $c->add(ProductPeer::PRODUCER_ID, $producer_id);
         }
      }
      else
      {
         $filters = stProductFilter::getFilters($this->getContext());

         if (isset($filters['producer']) && $filters['producer'])
         {
            if (is_array($filters['producer']))
            {
               $c->add(ProductPeer::PRODUCER_ID, array_values($filters['producer']), Criteria::IN);
            }
            else
            {
               $c->add(ProductPeer::PRODUCER_ID, $filters['producer']);
            }
         }
      }
   }

   /**
    * Dodaje dodatkowe kryteria filtrowania
    *
    */
   protected function addFiltersCriteria(Criteria $c)
   {

   }

   /**
    *
    * Lista Produktow z danej grupy
    * @author Marcin Butlak <marcin.butlak@sote.pl>
    *
    */
   public function executeGroupList()
   {
      $this->page = $this->getRequestParameter('page');

      if (!$this->processGroup301Redirects())
      {
         return $this->forward('stProduct', 'productGroupNotFound');
      }

      if (!$this->processGroupFriendlyUrl())
      {
         return $this->forward('stProduct', 'productGroupNotFound');
      }

      $producer_id = stProducer::getSelectedProducerId();
      stProducer::clearSelectedProducerId();   

      $this->config = stConfig::getInstance(sfContext::getInstance(), 'stProduct');

      $this->config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');

      $this->config_points->setCulture(sfContext::getInstance()->getUser()->getCulture());

      $config_product_group = stConfig::getInstance('stProductGroup');

      $new_type = $config_product_group->get('new_type');

      $this->smarty = new stSmarty($this->getModuleName());

      $pager = new stPropelPager('Product');


      $c = new Criteria();

      $this->addProductGroup($c);

      $this->productPagerInit($c);

      $this->product_on_page = $this->product_pager->getCntResults();

      if ($new_type == 'date' && $this->product_group->getProductGroup() == 'NEW')
      {
         $c->clear();

         $this->addNew($c);

         $this->productPagerInit($c);

         $this->product_on_page = $this->product_pager->getCntResults();
      }

      $page = $this->product_pager->getPage();

      $this->forLinkInit($this->product_group->getFriendlyUrl(), $page);

      $this->sort_labels = $this->getSortColumns('label_names');

      $this->view_labels = $this->getViewTypes('label_names');

      $this->title = $this->product_group->getName();

      $this->addRelLinks('groupList', $this->product_group->getFriendlyUrl());

      $this->getUser()->setParameter('selected', $this->product_group, 'soteshop/stProductGroup');

      stProducer::setSelectedProducerId($producer_id);  
   }

   /**
    *
    * Lista Produktow
    * @author Marcin Butlak <marcin.butlak@sote.pl>
    *
    */
   public function executeList()
   {
      $this->page = $this->getRequestParameter('page');

      $this->processSearchQuery();

      if ($this->hasRequestParameter('producer'))
      {
        $this->getResponse()->addMeta('robots', "noindex");
      }

      if (null === $this->query)
      {
         if (!$this->processGroup301Redirects())
         {
            return $this->forward('stProduct', 'groupNotFound');
         }

         if (!$this->processNew301Redirects())
         {
            return $this->forward('stProduct', 'groupNotFound');
         }

         if (!$this->processCategory301Redirects())
         {
            return $this->forward('stProduct', 'categoryNotFound');
         }

         if (!$this->processCategoryFriendlyUrl())
         {
            return $this->forward('stProduct', 'categoryNotFound');
         }
      }

      $this->config = stConfig::getInstance(sfContext::getInstance(), 'stProduct');
      
      $this->config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');
      $this->config_points->setCulture(sfContext::getInstance()->getUser()->getCulture());

      $this->smarty = new stSmarty($this->getModuleName());

      $c = new Criteria();

      $this->productPagerInit($c);

      $this->product_on_page = $this->query !== null && $this->revelance == 0 ? 0 : $this->product_pager->getCntResults();

      if (!$this->product_on_page && null === $this->query && !$this->hasRequestParameter('filter') && (!$this->category || $this->category->isLeaf()))
      {
         // return $this->forward('stProduct', 'categoryNotFound');
         $this->getResponse()->setStatusCode(404);
      }

      $page = $this->product_pager->getPage();

      $this->forLinkInit($this->category ? $this->category->getFriendlyUrl() : null, $page);

      if (trim($this->getRequestParameter('query_url'))) 
      {
         $this->for_link['query_url'] = trim($this->getRequestParameter('query_url'));
      }

      $this->sort_labels = $this->getSortColumns('label_names');

      $this->view_labels = $this->getViewTypes('label_names');

      if ($this->getTheme()->getVersion() >= 7)
      {
         if (null !== $this->query)
         {
            $this->getTheme()->setLayoutName('one_column');
         }
         else
         {
            $this->getTheme()->setLayoutName('two_column');
         }
      }

      if ($this->category)
      {
         $this->addRelLinks('list', $this->category->getFriendlyUrl());
      }
   }

   /**
    * Wyświetla opis szczegółowy produktu
    */
   public function executeShow()
   {
      $this->config = stConfig::getInstance(sfContext::getInstance(), 'stProduct');
      
      $this->config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');
      $this->config_points->setCulture(sfContext::getInstance()->getUser()->getCulture());


      $this->smarty = new stSmarty($this->getModuleName());

      if (!$this->processProduct301Redirects())
      {
         return $this->forward('stProduct', 'productNotFound');
      }

      if (!$this->processProductFriendlyUrl())
      {
         return $this->forward('stProduct', 'productNotFound');
      }

      if (!$this->product->isActive())
      {
         return $this->forward('stProduct', 'productNotFound');
      }

      if (stProducer::getSelectedProducerId() != $this->product->getProducerId())
      {
         stProducer::clearSelectedProducerId();
      }

      $this->description = $this->product->getDescription();

      if ($this->hasRequestParameter('uniqid'))
      {
         $this->uniqid = $this->getRequestParameter('uniqid');
         $this->getUser()->setAttribute('uniqid', $this->getRequestParameter('uniqid'));
         $this->getUser()->setAttribute('uniqid_product_id', $this->product->getId());
      }
      else
      {
         $this->uniqid = false;
      }

      if ($this->product->getProducerId())
      {
         $this->producer = $this->product->getProducer();
      }

      $this->category = null;

      $category = $this->getUser()->getAttribute('selected', null, 'soteshop/stCategory');

      $refinfo = parse_url($this->getRequest()->getReferer());

      if ($category)
      {
         $this->category = preg_match('#/category/'.$category->getFriendlyUrl().'$#', $refinfo['path']) || preg_match('#/manufacturer/[^/]+/'.$category->getFriendlyUrl().'#', $refinfo['path']) ? $category : null;
      }

      if ($this->category)
      {
         $c = new Criteria();
         $c->add(ProductHasCategoryPeer::PRODUCT_ID, $this->product->getId());
         
         if (!$this->category->getShowChildrenProducts())
         {  
            $c->add(ProductHasCategoryPeer::CATEGORY_ID, $this->category->getId());
         }
         else
         {
            $c->addJoin(ProductHasCategoryPeer::CATEGORY_ID, CategoryPeer::ID);
            $c->add(CategoryPeer::SCOPE, $this->category->getScope());
            $c->add(CategoryPeer::LFT, sprintf('%s BETWEEN %d AND %d', CategoryPeer::LFT, $this->category->getLft(), $this->category->getRgt()), Criteria::CUSTOM);
         }

         if (ProductHasCategoryPeer::doCount($c) == 0) 
         {            
            $this->category = null;
         }
      }

      if (null === $this->category)
      {
         $category = $this->product->getDefaultCategory();

         if ($category && $category->getIsActive())
         {
            $this->category = $category;
         }
      }
      elseif (!$this->product->getDefaultCategory())
      {
         $this->category = null;         
      }

      $this->addTabs();

      if ($this->category)
      {         
         $this->getUser()->setParameter('selected', $this->category, 'soteshop/stCategory');
         $this->getUser()->setAttribute('selected', $this->category, 'soteshop/stCategory');
      }
      else
      {
        $this->getUser()->setParameter('selected', null, 'soteshop/stCategory');
        $this->getUser()->setAttribute('selected', null, 'soteshop/stCategory');
      }

      $this->themeVersion = $this->getController()->getTheme()->getVersion();

      sfLoader::loadHelpers(array('Helper', 'stUrl'));

      $this->images_in_options = $this->getImagesInOptions();

      $this->getResponse()->setCanonicalLink(st_url_for('stProduct/show?url='.$this->product->getFriendlyUrl(), true, null, stLanguage::getInstance($this->getContext())->getDomain()));

      $c = new Criteria();
      $c->add(ReviewPeer::PRODUCT_ID, $this->product->getId());
      $c->add(ReviewPeer::SCORE, null, Criteria::ISNOTNULL);
      $c->add(ReviewPeer::AGREEMENT,1);
      $this->structure_review = ReviewPeer::doSelectOne($c);
   }

   /**
    * Polecane produkty w opisie szczegółowym produktu
    */
   public function executeRecommendProducts()
   {
      if(!$this->getRequest()->isXmlHttpRequest() && $this->getController()->getRenderMode() != sfView::RENDER_VAR)
      {  
         $this->getResponse()->setStatusCode(404);

         $this->getResponse()->setHttpHeader('Status', '404 Not Found');

         return $this->forward('stErrorFrontend', 'error404');
      }

      $this->setLayout(false);

      $this->config = stConfig::getInstance(sfContext::getInstance(), 'stProduct');
      
      $this->config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');
      $this->config_points->setCulture(sfContext::getInstance()->getUser()->getCulture());

      $this->smarty = new stSmarty($this->getModuleName());

      $this->product_id = $this->getRequestParameter('id');

      $product = ProductPeer::retrieveByPK($this->product_id);

      $c = new Criteria();

      $this->addProductFilterCriteria($c);

      $ids = $this->getRequestParameter('category_ids');

      if ($ids)
      {
         $c->addDescendingOrderByColumn(ProductI18nPeer::NAME);
         $c->addJoin(ProductHasCategoryPeer::PRODUCT_ID, ProductPeer::ID);
         $c->add(ProductHasCategoryPeer::CATEGORY_ID, explode(",", $ids), Criteria::IN);
         $c->add(ProductPeer::ID, $this->product_id, Criteria::NOT_EQUAL);
         $c->setLimit($this->config->get('other_products_num'));

         $c = $this->getDispatcher()->filter(new sfEvent($this, 'stProductActions.filterRecommendProductsCriteria'), $c)->getReturnValue();

         $this->products = ProductPeer::doSelectForPager($c);         
      }
      elseif (null !== $product && $product->countProductHasRecommendsRelatedByProductId()>0)
      {
         $c->addJoin(ProductHasRecommendPeer::RECOMMEND_ID, ProductPeer::ID);
         $c->add(ProductHasRecommendPeer::PRODUCT_ID, $this->product_id);
         $c->setLimit($this->config->get('other_products_num'));
         $c->addAscendingOrderByColumn(ProductHasRecommendPeer::ID);

         $c = $this->getDispatcher()->filter(new sfEvent($this, 'stProductActions.filterRecommendProductsCriteria'), $c)->getReturnValue();
         
         $this->products = ProductPeer::doSelectForPager($c);
      }
      else
      {  
         $c->addDescendingOrderByColumn(ProductI18nPeer::NAME);
         $c->addJoin(ProductHasCategoryPeer::PRODUCT_ID, ProductPeer::ID);
         $c->add(ProductHasCategoryPeer::CATEGORY_ID, $this->getRequestParameter('id_category'));
         $c->add(ProductPeer::ID, $this->product_id, Criteria::NOT_EQUAL);
         $c->setLimit($this->config->get('other_products_num'));

         $c = $this->getDispatcher()->filter(new sfEvent($this, 'stProductActions.filterRecommendProductsCriteria'), $c)->getReturnValue();

         $this->products = ProductPeer::doSelectForPager($c);
      }

      $this->list_type = "listOther";
   }

   /**
    * Wyświetla opis produktu
    */
   public function executeProductDescription()
   {

    if(!$this->getRequest()->isXmlHttpRequest() && $this->getController()->getRenderMode() != sfView::RENDER_VAR){  

        $this->getResponse()->setStatusCode(404);

        $this->getResponse()->setHttpHeader('Status', '404 Not Found');

        return $this->forward('stErrorFrontend', 'error404');
     }

      $this->smarty = new stSmarty($this->getModuleName());

      $this->setLayout(false);

      $this->product = ProductPeer::getShowedProduct();
      if (!is_object($this->product))
         $this->product = ProductPeer::retrieveByPk($this->getRequestParameter('id'));

      $this->description = $this->product->getDescription();
   }

   /**
    * Strona nieznalezionej kategorii
    *
    */
   public function executeCategoryNotFound()
   {
      $this->getResponse()->setStatusCode(404);

      $this->getResponse()->setHttpHeader('Status', '404 Not Found');

      $this->smarty = new stSmarty($this->getModuleName());
   }

   /**
    * Zwraca zawartość obrazka typu 'big'
    *
    * @author Marcin Butlak <marcin.butlak@sote.pl>
    * @return sfView
    */
   public function executeShowImage()
   {
      $image = $this->getRequestParameter('image');

      $folder = sfAssetFolderPeer::retrieveByPK($this->getRequestParameter('folder'));

      if ($folder)
      {
         $asset = sfAssetPeer::retrieveFromUrl($folder->getRelativePath() . '/' . $image);
      }

      sfLoader::loadHelpers(array('Helper', 'stProductImage'));

      $file = st_product_image_path($asset, 'big', true, true);

      $info = getimagesize($file);

      $this->getResponse()->setHttpHeader('Content-Type', image_type_to_mime_type($info[2]));

      return $this->renderText(file_get_contents($file));
   }

   /**
    * Generuje obrazek z ajax requesta
    *
    * @return   void
    */
   public function executePhotoAjax()
   {
      $product = ProductPeer::retrieveByPK($this->getRequestParameter('id'));
      $this->image = '/uploads/products/' . $product->getImage() . '/' . $this->getRequestParameter("asset_id");
      $dimensions = getimagesize('uploads/products/' . $product->getImage() . '/' . $this->getRequestParameter("asset_id"));
      $dimensions[0] += 20;
      $dimensions[1] += 30;
      $this->dimensions = $dimensions;
   }

   public function executeDownloadAttachment()
   {
      $folder = $this->getRequestParameter('folder');

      $culture = $this->getRequestParameter('culture');

      $filename = $this->getRequestParameter('filename');

      $file = sfAssetPeer::retrieveFromUrl('/media/products/' . $folder . '/attachments/' . $culture . '/' . $filename);

      if (!$file)
      {
         return $this->forward404();
      }

      $filepath = $file->getFullPath();

      $response = $this->getResponse();

      $response->setHttpHeader('Content-Description', 'File Transfer');

      $response->setHttpHeader('Content-Type', 'application/octet-stream');

      $response->setHttpHeader('Content-Disposition', 'attachment; filename=' . $file->getFilename());

      $response->setHttpHeader('Content-Transfer-Encoding', 'binary');

      $response->setHttpHeader('Expires', 0);

      $response->setHttpHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0');

      $response->setHttpHeader('Pragma', 'public');

      $response->setHttpHeader('Content-Length', filesize($filepath));

      return $this->renderText(file_get_contents($filepath));
   }

   /**
    * Strona nieznalezionego produktu
    *
    */
   public function executeProductNotFound()
   {
      $this->getResponse()->setStatusCode(404);

      $this->getResponse()->setHttpHeader('Status', '404 Not Found');

      $this->smarty = new stSmarty($this->getModuleName());
   }

   public function executeClearFilter()
   {
      $filter = $this->getRequestParameter('filter');
      $scope = $this->getRequestParameter('scope');

      $this->loadCategoryFromRequest();

      if ($scope == 'filter')
      {
         stProductFilter::clearFilters($this->getContext(), $filter);
      }

      $this->postExecute();

      if ($this->getRequest()->isXmlHttpRequest())
      {
         return $this->renderUpdateFilters();
      }

      return $this->redirect($this->getRequest()->getReferer()); 
   }

   public function executeFilter()
   {
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $this->loadCategoryFromRequest();

         $fields = $this->getRequestParameter('fields');

         if ($fields)
         {
            $data = $this->getRequestParameter('product_filter', array());
            $filters = stProductFilter::getFilters($this->getContext());

            foreach (explode(',', $fields) as $field)
            {
               $field = trim($field);
               $filters[$field] = isset($data[$field]) ? $data[$field] : null;
            }

            stProductFilter::setFilters($this->getContext(), $filters);            
         }

         $this->postExecute();

         stFastCacheController::disable();

         if ($this->getRequest()->isXmlHttpRequest())
         {
            return $this->renderUpdateFilters();
         }
      }

      return $this->redirect(appProductAttributeHelper::getFilterUrl($this->getRequest()->getReferer()));
   }

   /**
    * Strona nieznalezionej grupy produktów
    *
    */
   public function executeProductGroupNotFound()
   {

      $this->getResponse()->setStatusCode(404);

      $this->getResponse()->setHttpHeader('Status', '404 Not Found');

      $this->smarty = new stSmarty($this->getModuleName());
   }

   public function postExecute()
   {
      if (isset($this->smarty))
      {
         $this->smarty->register_function('st_product_image_tag', 'st_product_smarty_image_tag');
      }

      parent::postExecute();
   }

   /**
    *
    * Pobiera nowy obiekt stPropelPager dla produktu
    * @author Marcin Butlak <marcin.butlak@sote.pl>
    *
    */
   protected function productPagerInit(Criteria $c)
   {
      $this->product_pager = new stPropelPager('Product');

      $c = clone $c;

      $this->processFilters();

      $this->addType();

      if (null !== $this->query) 
      {
         $this->revelance = $this->addSearchCriteria($c, $this->query);
      }

      $this->addSort($c);

      $this->product_pager->setPage($this->page);

      $this->product_pager->setCriteria($c);

      $this->product_pager->setPeerMethod('doSelectForPager');

      if (null !== $this->query)
      {
         $this->product_pager->setPeerCountMethod(array('ProductSearchTagPeer', 'doCountProduct')); 
      }

      ProductPeer::addFilterCriteria($this->getContext(), $c, true, false);

      $this->addProducerCriteria($c);

      $this->addFiltersCriteria($c);

      $this->getUser()->setParameter('pre_filter_criteria', clone $c, 'soteshop/stProduct'); 

      stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stProductActions.preProductPagerInit', array('pager_criteria' => $this->product_pager->getCriteria())));

      ProductPeer::addPriceFilterCriteria($this->getContext(), $c);

      appProductAttributeHelper::addProductPagerCriteria($this->product_pager);

      $this->product_pager->init();
   }

   protected function processProducerFriendlyUrl($url = null)
   {
      if (!isset($this->producer) && $this->getRequest()->getParameter('url', $url))
      {
         if (null === $url)
         {
            $url = $this->getRequest()->getParameter('url');
         }

         $this->producer = ProducerPeer::retrieveByUrl($url);

         if ($this->producer)
         {
            $this->getUser()->setParameter('selected', $this->producer, 'soteshop/stProducer');
            $this->producer->setCulture($this->getUser()->getCulture());

            if ($url != $this->producer->getFriendlyUrl())
            {
               sfLoader::loadHelpers(array('Helper', 'stUrl'));

               $r = sfRouting::getInstance();

               list(, $redirect) = $this->getController()->convertUrlStringToParameters($r->getCurrentInternalUri());

               $redirect['url'] = $this->producer->getFriendlyUrl();

               $this->redirect(st_url_for($redirect, true), 301);
            }
         }
         else
         {
            return false;
         }
      }

      return true;
   }   

   /**
    *
    * Obsluga przyjaznych linkow dla kategorii
    * @author Marcin Butlak <marcin.butlak@sote.pl>
    *
    */
   protected function processCategoryFriendlyUrl()
   {

      if ($this->getRequest()->hasParameter('url'))
      {
         $url = $this->getRequest()->getParameter('url');

         $category = CategoryPeer::retrieveByUrl($url);
  
         if ($category && $category->getIsActive())
         {
            $this->category = $category;

            $this->category->setCulture($this->getUser()->getCulture());

            if ($url != $this->category->getFriendlyUrl())
            {
               sfLoader::loadHelpers(array('Helper', 'stUrl'));

               $r = sfRouting::getInstance();

               list(, $redirect) = $this->getController()->convertUrlStringToParameters($r->getCurrentInternalUri());

               $redirect['url'] = $this->category->getFriendlyUrl();

               $this->redirect(st_url_for($redirect, true), 301);
            }

            $this->getUser()->setParameter('selected', $this->category, 'soteshop/stCategory');   
            $this->getUser()->setAttribute('selected', $this->category, 'soteshop/stCategory');         
         }
         else
         {
            return false;
         }
      }

      return true;
   }

   /**
    *
    * Obluga przyjaznych linkow dla grup produktow
    * @author Marcin Butlak <marcin.butlak@sote.pl>
    *
    */
   protected function processGroupFriendlyUrl()
   {
      if ($this->getRequest()->hasParameter('url'))
      {
         $url = $this->getRequest()->getParameter('url');

         $this->product_group = ProductGroupPeer::retrieveByUrl($url);

         if ($this->product_group)
         {
            $this->product_group->setCulture($this->getUser()->getCulture());

            $this->getUser()->setParameter('selected', $this->product_group, 'soteshop/stProductGroup');  

            if ($url != $this->product_group->getFriendlyUrl())
            {
               sfLoader::loadHelpers(array('Helper', 'stUrl'));

               $r = sfRouting::getInstance();

               list(, $redirect) = $this->getController()->convertUrlStringToParameters($r->getCurrentInternalUri());

               $redirect['url'] = $this->product_group->getFriendlyUrl();

               $this->redirect(st_url_for($redirect, true), 301);
            }
         }
         else
         {
            return false;
         }
      }

      return true;
   }

   protected function processProductFriendlyUrl()
   {
      if ($this->getRequest()->hasParameter('url'))
      {
         $url = $this->getRequest()->getParameter('url');

         $this->product = ProductPeer::retrieveByUrl($url);

         if ($this->product && $this->product->isActive(true))
         {
            $this->product->setCulture($this->getUser()->getCulture());

            $this->getUser()->setParameter('selected', $this->product, 'soteshop/stProduct');  

            if ($url != $this->product->getFriendlyUrl())
            {
               sfLoader::loadHelpers(array('Helper', 'stUrl'));

               $r = sfRouting::getInstance();

               list(, $redirect) = $this->getController()->convertUrlStringToParameters($r->getCurrentInternalUri());

               $redirect['url'] = $this->product->getFriendlyUrl();

               $this->redirect(st_url_for($redirect, true), 301);
            }
         }
         else
         {
            return false;
         }
      }

      return true;
   }

   /**
    *
    * Obsluga przekierowan dla starych linkow
    * @author Marcin Butlak <marcin.butlak@sote.pl>
    *
    */
   protected function processCategory301Redirects()
   {
      if ($this->hasRequestParameter('id_category'))
      {
         sfLoader::loadHelpers(array('Helper', 'stUrl'));

         $category_id = $this->getRequestParameter('id_category');

         $category = CategoryPeer::retrieveByPK($category_id);

         if (is_null($category))
         {
            return false;
         }

         $category->setCulture($this->getUser()->getCulture());

         if ($this->page)
         {
            $this->redirect(st_url_for('stProduct/list?url=' . $category->getFriendlyUrl() . '&page=' . $this->page, true), 301);
         }
         else
         {
            $this->redirect(st_url_for('stProduct/list?url=' . $category->getFriendlyUrl(), true), 301);
         }
      }

      return true;
   }

   protected function processGroup301Redirects()
   {
      if ($this->hasRequestParameter('group_id'))
      {
         sfLoader::loadHelpers(array('Helper', 'stUrl'));

         $produt_group_id = $this->getRequestParameter('group_id');

         $product_group = ProductGroupPeer::retrieveByPK($produt_group_id);

         if (is_null($product_group))
         {
            return false;
         }

         $product_group->setCulture($this->getUser()->getCulture());

         if ($this->page)
         {
            return $this->redirect(st_url_for('stProduct/groupList?url=' . $product_group->getFriendlyUrl() . '&page=' . $this->page, true), 301);
         }
         else
         {
            return $this->redirect(st_url_for('stProduct/groupList?url=' . $product_group->getFriendlyUrl(), true), 301);
         }
      }

      return true;
   }

   protected function processNew301Redirects()
   {
      if ($this->hasRequestParameter('new'))
      {
         sfLoader::loadHelpers(array('Helper', 'stUrl'));

         $c = new Criteria();

         $c->add(ProductGroupPeer::PRODUCT_GROUP, 'NEW');

         $product_group = ProductGroupPeer::doSelectOne($c);

         if (is_null($product_group))
         {
            return false;
         }

         $product_group->setCulture($this->getUser()->getCulture());

         if ($this->page)
         {
            return $this->redirect(st_url_for('stProduct/groupList?url=' . $product_group->getFriendlyUrl() . '&page=' . $this->page, true), 301);
         }
         else
         {
            return $this->redirect(st_url_for('stProduct/groupList?url=' . $product_group->getFriendlyUrl(), true), 301);
         }
      }

      return true;
   }

   protected function processProduct301Redirects()
   {
      if ($this->hasRequestParameter('id'))
      {
         sfLoader::loadHelpers(array('Helper', 'stUrl'));

         $product_id = $this->getRequestParameter('id');

         $product = ProductPeer::retrieveByPK($product_id);

         if (is_null($product))
         {
            return false;
         }

         $product->setCulture($this->getUser()->getCulture());

         return $this->redirect(st_url_for('stProduct/show?url=' . $product->getFriendlyUrl(), true), 301);
      }

      return true;
   }

   /**
    * Typ wyświetlanej listy
    *
    * @param        object      $pager
    */
   protected function addType()
   {
      $view_types = $this->getViewTypes('view_names');

      if ($this->hasRequestParameter('type'))
      {
         $this->getUser()->setAttribute('view_type', $this->getRequestParameter('type'), 'soteshop/stProduct');
      }

      $this->type_list_url = $this->getUser()->getAttribute('view_type', $this->config->get('list_type'), 'soteshop/stProduct');

      if ($this->getTheme()->getVersion() >= 7)
      {
          if($this->type_list_url=="short"){
              $this->type_list_url = "description";
          }
      }

      if (!isset($view_types[$this->type_list_url]))
      {
         $this->type_list_url = $this->config->get('list_type');
      }
        

      if (isset($view_types[$this->type_list_url]))
      {
         $this->list_type = $view_types[$this->type_list_url];
         
        if ($this->getTheme()->getVersion() >= 7 && $this->type_list_url=="description")
        {              
            $this->product_pager->setMaxPerPage($this->config->get("short" . '_list'));              
        }else{
            $this->product_pager->setMaxPerPage($this->config->get($this->type_list_url . '_list'));    
        }
         
      }
   }

   /**
    * Wyświetla nowości
    *
    * @param      Criteria    $c
    */
   protected function addNew(Criteria $c)
   {
      $config = stConfig::getInstance(sfContext::getInstance(), 'stProduct');

      $c->add(ProductPeer::CREATED_AT, $config->get('new_product_date'), Criteria::GREATER_THAN);

      $this->new = $this->getRequestParameter('new');
   }

   /**
    * Wyświetla daną grupę produktów
    *
    * @param      Criteria    $c
    */
   protected function addProductGroup(Criteria $c)
   {
      $c->addJoin(ProductGroupHasProductPeer::PRODUCT_ID, ProductPeer::ID);
      $c->add(ProductGroupHasProductPeer::PRODUCT_GROUP_ID, $this->product_group->getId());
   }

   /**
    * Dodaje Sortowanie
    *
    * @param      Criteria    $c
    */
   protected function addSort(Criteria $c)
   {
      $sort_columns = $this->getSortColumns('table_names');

      if ($this->hasRequestParameter('sort_order'))
      {
         $this->getUser()->setAttribute('sort_order', $this->getRequestParameter('sort_order'), 'soteshop/stProduct');
      }

      if ($this->hasRequestParameter('sort_by'))
      {
         $this->getUser()->setAttribute('sort_by', $this->getRequestParameter('sort_by'), 'soteshop/stProduct');
      }
      elseif (null !== $this->query && $this->revelance)
      {
         $this->getUser()->setAttribute('sort_order', 'desc', 'soteshop/stProduct');
         $this->getUser()->setAttribute('sort_by', 'accuracy', 'soteshop/stProduct');         
      }

      $this->sort_order = $this->getUser()->getAttribute('sort_order', $this->config->get('sort_asc_desc'), 'soteshop/stProduct');

      $this->sort_by = $this->getUser()->getAttribute('sort_by', $this->config->get('sort_type'), 'soteshop/stProduct');

      if (!isset($sort_columns[$this->sort_by]))
      {
         $this->sort_by = $this->config->get('sort_type');
         $this->sort_order = $this->config->get('sort_asc_desc');
         $this->getUser()->setAttribute('sort_by', $this->sort_by, 'soteshop/stProduct');
         $this->getUser()->setAttribute('sort_order', $this->sort_order, 'soteshop/stProduct');
      }

      if (isset($sort_columns[$this->sort_by]))
      {
         if ($this->sort_order == "asc")
         {
            $c->addAscendingOrderByColumn($sort_columns[$this->sort_by]);
            $c->addAscendingOrderByColumn(ProductPeer::ID);
         }
         else
         {
            $c->addDescendingOrderByColumn($sort_columns[$this->sort_by]);
            $c->addAscendingOrderByColumn(ProductPeer::ID);
         }

         if ($this->sort_by == "priority")
         {

           if ($this->sort_order == "asc")
           {
              $c->addAscendingOrderByColumn(ProductI18nPeer::NAME);
           }
           else
           {
              $c->addDescendingOrderByColumn(ProductI18nPeer::NAME);
           }

         }
         
      }
   }

   /**
    * Zakładki
    */
   protected function addTabs()
   {
      $version = $this->getController()->getTheme()->getVersion();

      $for_product = array(
         'id' => $this->product->getId(),
      );

      if ($this->category && $this->category->getId())
      {
         $for_product['id_category'] = $this->category->getId();
      }

      if ($this->product->getProducerId())
      {
         $for_product['id_producer'] = $this->product->getProducerId();
      }

      $config = stConfig::getInstance(sfContext::getInstance(), 'stProduct');

      $show_description = $config->get('show_description');

      $show_recommended_products = $config->get('show_other_products');
      
      $show_review=$config->get('show_review');

      if ($show_recommended_products)
      {
         $show_recommended_products = $this->product->countProductHasRecommendsRelatedByProductId() > 0;
         

         if (!$show_recommended_products && $this->category)
         { 
            if ($this->category->hasChildren())
            {
               $c = new Criteria();
               $c->addSelectColumn(CategoryPeer::ID);
               $c->addSelectColumn(CategoryPeer::LFT);
               $c->addSelectColumn(CategoryPeer::SCOPE);
               $c->add(ProductHasCategoryPeer::PRODUCT_ID, $this->product->getId());
               $c->addJoin(ProductHasCategoryPeer::CATEGORY_ID, CategoryPeer::ID);
               
               $rs = CategoryPeer::doSelectRS($c);
               
               $ids = array();

               while($rs->next())
               {
                  list($id, $lft, $scope) = $rs->getRow();

                  if ($lft >= $this->category->getLft() && $lft <= $this->category->getRgt() && $scope == $this->category->getScope())
                  {
                     $ids[] = $id;
                  }
               }

               if ($ids)
               {
                  $c = new Criteria();
                  $c->addJoin(ProductHasCategoryPeer::PRODUCT_ID, ProductPeer::ID);
                  $c->add(ProductHasCategoryPeer::CATEGORY_ID, $ids, Criteria::IN);
                  $c->add(ProductPeer::ID, $this->product->getId(), Criteria::NOT_EQUAL);
                  $this->addProductFilterCriteria($c);
                  $show_recommended_products = ProductPeer::doCount($c) > 0;

                  $for_product['category_ids'] = implode(',', $ids);
               }
            }
            else
            {
               $c = new Criteria();
               $c->addJoin(ProductHasCategoryPeer::PRODUCT_ID, ProductPeer::ID);
               $c->add(ProductHasCategoryPeer::CATEGORY_ID, $this->category->getId());
               $c->add(ProductPeer::ID, $this->product->getId(), Criteria::NOT_EQUAL);
               $this->addProductFilterCriteria($c);
               $show_recommended_products = ProductPeer::doCount($c) > 0;
            }
         }
      }

      $c = new Criteria();
      $c->add(ProductHasAttachmentPeer::IS_ACTIVE, true);
      $c->add(ProductHasAttachmentPeer::OPT_CULTURE, $this->getUser()->getCulture());
      $show_attachments = $this->product->countProductHasAttachments($c) > 0;  

      if ($version < 7)
      {  
         $this->productList = stTabNavigator::getInstance($this->getContext(), 'product_list', 'product/show?id=' . $this->product->getId());

         if ($show_recommended_products)
         {
            $this->productList->addTab('Polecamy produkty', 'stProduct', 'recommendProducts', $for_product);
         }

         $this->productList->setTab($this->getRequestParameter('product_list'));

         $this->productDescription = stTabNavigator::getInstance($this->getContext(), 'product_description', 'product/show?id=' . $this->product->getId());

         if ($version < 2)
         {
            if ($show_description == 1 )
            {
               $this->productDescription->addTab('Opis', 'stProduct', 'productDescription', $for_product);
            }
         }

         if ($show_attachments)
         {
            $this->productDescription->addTab('Załączniki', 'stProduct', 'attachmentList', $for_product);
         }

         $this->productDescription->setTab($this->getRequestParameter('product_description', 0));
      }
      else
      {
         $this->tabNavigator = stTabNavigator::getInstance($this->getContext(), null, null);

         if ($config->get('show_accessories'))
         {            
            $c = new Criteria();
            $c->addJoin(ProductHasAccessoriesPeer::ACCESSORIES_ID, ProductPeer::ID);
            $this->addProductFilterCriteria($c);

            if ($this->product->countProductHasAccessoriessRelatedByProductId($c) > 0)
            {               
               $this->tabNavigator->addTab('Akcesoria', 'stAccessoriesFrontend', 'accessoriesList',array('id' => $this->product->getId()));
            }
         }

         if ($show_recommended_products)
         {
            $this->tabNavigator->addTab('Polecamy produkty', 'stProduct', 'recommendProducts', $for_product);
         }

         if ($show_attachments)
         {
            $this->tabNavigator->addTab('Załączniki', 'stProduct', 'attachmentList', $for_product);
         }

         if ($version > 7)
         { 
            $c = new Criteria();
            $c->add(ReviewPeer::PRODUCT_ID, $this->product->getId());
            $c->add(ReviewPeer::ACTIVE, 1);
            $c->add(ReviewPeer::IS_PIN_REVIEW, 0);
            $criterion = $c->getNewCriterion(ReviewPeer::AGREEMENT, 1);
            $criterion->addOr($c->getNewCriterion(ReviewPeer::USER_IP, $this->getRequest()->getHttpHeader ('addr','remote')));
            $c->add($criterion);
            $c->add(ReviewPeer::DESCRIPTION, "", Criteria::NOT_IN);
         }
         else
         {
            $c = new Criteria();
            $c->add(ReviewPeer::PRODUCT_ID, $this->product->getId());
            $c->add(ReviewPeer::ACTIVE, 1);
            $criterion = $c->getNewCriterion(ReviewPeer::AGREEMENT, 1);
            $criterion->addOr($c->getNewCriterion(ReviewPeer::USER_IP, $this->getRequest()->getHttpHeader ('addr','remote')));
            $c->add($criterion);
            $c->add(ReviewPeer::DESCRIPTION, "", Criteria::NOT_IN);
         }
         
         if ($show_review==1 && ReviewPeer::doCount($c))
         {
            $this->tabNavigator->addTab('Recenzje', 'stReview', 'listReviews', $for_product);
         }
      }
   }

   protected function getSortColumns($type = null, $columns = array())
   {
      $defaults = array(
          'label_names' => array(
              'name' => 'Nazwie',
              'price' => 'Cenie',
              'created_at' => 'Najnowszym',
              'priority' => 'Kolejność',
          ),
          'table_names' => array(
              'name' => ProductI18nPeer::NAME,
              'price' => ProductPeer::OPT_PRICE_BRUTTO,
              'created_at' => ProductPeer::CREATED_AT,
              'priority' => ProductPeer::PRIORITY,
          ),
      );

      if ($this->hasRequestParameter('query'))
      {
         $cmp = ProductPeer::getSearchSortCriteria($this->getRequestParameter('query'), $this->getUser()->getCulture());

         $defaults['label_names']['accuracy'] = "Trafność";
         $defaults['table_names']['accuracy'] = 'SUM('.ProductHasProductSearchTagPeer::TAG_VALUE.($cmp ? ' * '.implode(" + ", $cmp) : '').')'; 
      }

      $columns = $columns ? array_merge_recursive($defaults, $columns) : $defaults;

      return $type ? $columns[$type] : $columns;
   }

   protected function getViewTypes($type = null, $types = array())
   { 
      if ($this->getTheme()->getVersion() >= 7)
      {

         $defaults = array(
            'label_names' => array(
            'long' => 'Pełna lista',
            'description' => 'Opisowa lista',
            'other' => 'Lista alternatywna',
            ),
            'view_names' => array(
            'long' => 'listLongProduct',
            'description' => 'listDescriptionProduct',
            'other' => 'listOther',
            ),
         );

      }
      else
      {
         $defaults = array(
            'label_names' => array(
            'long' => 'Pełna lista',
            'short' => 'Skrócona lista',
            'other' => 'Lista alternatywna',
            ),
            'view_names' => array(
            'long' => 'listLongProduct',
            'short' => 'listShortProduct',
            'other' => 'listOther',
            ),
         );
      }

      $types = $types ? array_merge_recursive($defaults, $types) : $defaults;

      return $type ? $types[$type] : $types;
   }

   protected function processFilters()
   {
      $default = stProducer::getSelectedProducerId() ? stProducer::getSelectedProducerId() : 0;

      $request = $this->getRequest();

      if ($request->hasParameter('horizontal'))
      {
         stProducer::clearSelectedProducerId();
      }      
      
      if ($this->hasRequestParameter('producer_filter'))
      {
         $producer_filter = $this->getRequestParameter('producer_filter');

         $this->getUser()->setAttribute('producer_filter', $producer_filter, stProductFilter::getNamespace($this->getContext(), 'soteshop/stProduct'));
      }
      elseif (!$request->hasParameter('filter') && $request->getHttpHeader('X-Moz') != 'prefetch')
      {
         $this->getUser()->getAttributeHolder()->remove('producer_filter', stProductFilter::getNamespace($this->getContext(), 'soteshop/stProduct'));
      }

      $this->producer_filter = $this->getUser()->getAttribute('producer_filter', $default, stProductFilter::getNamespace($this->getContext(), 'soteshop/stProduct'));

      if (stProductFilter::hasFilters($this->getContext()) && !$request->hasParameter('filter') && $request->getHttpHeader('X-Moz') != 'prefetch') 
      {
         stProductFilter::clearFilters($this->getContext());
      }
   }

   protected function addProductFilterCriteria($c)
   {
      ProductPeer::addFilterCriteria($this->getContext(), $c, false);
   }   

   protected function addSearchCriteria($c, $query)
   {
      if ($query && mb_strlen($query) >= 3)
      {
         $analyzer = stTextAnalyzer::getInstance($this->getUser()->getCulture());
         $keywords = array_keys($analyzer->analyze($query));

         return ProductPeer::addSearchCriteria($c, $keywords, $this->getUser()->getCulture());
      }
      
      return 0;
   }

   protected function addRelLinks($action, $url)
   {
      sfLoader::loadHelpers(array('Helper', 'stUrl', 'stProduct'), 'stProduct');

      $params = array(
         'url' => $url
      );

      if ($this->hasRequestParameter('producer') && !in_array($action, array('producerList'))  && stProducer::getSelectedProducer())
      {
         $params['producer'] = $this->getRequestParameter('producer');
      }

      $domain = stLanguage::getInstance($this->getContext())->getDomain();

      $page = $this->product_pager->getPage();

      if ($this->product_pager->haveToPaginate())
      {
         $last_page = $this->product_pager->getLastPage();
        
         if ($page == 2)
         {
            $product_url = _st_product_link_to($action, $params);
            $this->getResponse()->addLink(st_url_for($product_url, true, null, $domain), "prev");

            if ($last_page != 2)
            {
               $product_url = _st_product_link_to($action, $params, array('page' => $this->product_pager->getNextPage()));
               $this->getResponse()->addLink(st_url_for($product_url, true, null, $domain), "next");
            }

         }
         elseif ($page > 1 && $page <= $last_page)
         {
            $product_url = _st_product_link_to($action, $params, array('page' => $this->product_pager->getPreviousPage()));
            $this->getResponse()->addLink(st_url_for($product_url, true, null, $domain), "prev");
         }
         
         if ($page >= 1 && $page < $last_page)
         {
            $product_url = _st_product_link_to($action, $params, array('page' => $this->product_pager->getNextPage()));
            $this->getResponse()->addLink(st_url_for($product_url, true, null, $domain), "next");
         }
      }

      if ($page > 1)
      {
         $product_url = _st_product_link_to($action, $params, array('page' => $page));
      }
      else
      {
         $product_url = _st_product_link_to($action, $params);
      }

      $this->getResponse()->setCanonicalLink(st_url_for($product_url, true, null, $domain));
       
      if ($this->hasRequestParameter('sort_by') || $this->hasRequestParameter('filter'))
      {
         $this->getResponse()->addMeta('robots', "noindex, nofollow");     
      } 

      // if (!$this->product_pager->getCntResults())
      // {
      //    $this->getResponse()->setStatusCode(404);
      // }
   }

   protected function renderUpdateFilters()
   {
      $this->loadCategoryFromRequest();

      $c = new Criteria();

      ProductPeer::addFilterCriteria($this->getContext(), $c);

      $this->addProducerCriteria($c);

      $this->getDispatcher()->notify(new sfEvent($this, 'stProductActions.renderUpdateFiltersCriteria', array('criteria' => $c)));

      if (isset($this->product_group))
      {
         $gc = new Criteria();
         $gc->add(ProductGroupHasProductPeer::PRODUCT_GROUP_ID, $this->product_group->getId());
         if (ProductGroupHasProductPeer::doCount($gc))
         {
            $this->addProductGroup($c);
         }
         else
         {
            $config = stConfig::getInstance('stProduct');
            $c->add(ProductPeer::CREATED_AT, $config->get('new_product_date'), Criteria::GREATER_THAN);            
         }
      }

      return $this->renderText($this->getRenderComponent('stProduct', 'filters', array('criteria' => $c)));      
   }

   protected function loadCategoryFromRequest()
   {
      $category_id = $this->getRequestParameter('category_id');
      $group_id = $this->getRequestParameter('group_id');  

      if ($category_id && !$this->getUser()->getParameter('selected', null, 'soteshop/stCategory'))
      {
         $category = CategoryPeer::retrieveByPK($category_id);

         if ($category)
         {
            $this->getUser()->setParameter('selected', $category, 'soteshop/stCategory');
         }
      } 
      elseif ($group_id && !$this->getUser()->getParameter('selected', null, 'soteshop/stProductGroup'))
      {
         $group = ProductGroupPeer::retrieveByPK($group_id);            
         $this->getUser()->setParameter('selected', $group, 'soteshop/stProductGroup');
         $this->product_group = $group;
      }
   }

   protected function forLinkInit($url, $page)
   {
      $this->for_link = array(
         'type' => $this->type_list_url,
         'sort_by' => $this->sort_by,
         'sort_order' => $this->sort_order,
         'page' => $page,
      );

      $action = $this->getModuleName().'/'.$this->getActionName();

      if ($action != 'stProduct/producerList' && $this->hasRequestParameter('producer')) 
      {
         $this->for_link['producer'] = $this->getRequestParameter('producer');
      }
      elseif ($action != 'stProduct/producerList')
      {
         $this->for_link['producer_filter'] = $this->producer_filter;
      }

      if (null !== $url)
      {
         $this->for_link['url'] = $url;
      }
   }

   protected function getImagesInOptions()
   {
      $results = array();
      
      $c = new Criteria();
      $c->addSelectColumn(ProductOptionsValuePeer::SF_ASSET_ID);
      $c->add(ProductOptionsValuePeer::PRODUCT_ID, $this->product->getId());
      $c->addGroupByColumn(ProductOptionsValuePeer::SF_ASSET_ID);

      $rs = ProductOptionsValuePeer::doSelectRS($c); 

      while($rs->next()) 
      {
         $row = $rs->getRow();
         $results[$row[0]] = $row[0];
      }

      return $results;        
   }

   protected function processSearchQuery()
   {
      $this->query = null;    

      $this->searchLink = null;

      $response = $this->getResponse();
      
      if ($this->hasRequestParameter('query'))
      {
         $query = strip_tags($this->getRequestParameter('query'));
         $this->query = stXssSafe::clean($query);
         $response->addMeta('robots', 'noindex');
      }
      elseif ($this->hasRequestParameter(('query_url')))
      {
         $query_url = $this->getRequestParameter('query_url');
         $this->searchLink = SearchLinkPeer::retrieveByUrl($query_url, $this->getUser()->getCulture());

         if (null !== $this->searchLink)
         {
            $this->getRequest()->setParameter('query', $this->searchLink->getSearchKeywords());
            $this->query = $this->searchLink->getSearchKeywords();

            $response->setTitle($this->searchLink->getMetaTitle());
            $response->addMeta('keywords', $this->searchLink->getMetaKeywords());
            $response->addMeta('description', $this->searchLink->getMetaDescription());
         }
         else
         {
            $this->getRequest()->setParameter('query', $query_url);
            $this->query = stXssSafe::clean($query_url);

            $response->addMeta('robots', 'noindex');
         }
      }
   }
}