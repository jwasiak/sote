<?php

/** 
 * SOTESHOP/stAllegroPlugin
 *
 * Ten plik należy do aplikacji stAllegroPlugin opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stAllegroPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 17433 2012-03-15 11:34:25Z piotr $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>,
 */

/** 
 * Klasa zawierajaca akcje dla modulu allegro
 *
 * @package     stAllegroPlugin
 * @subpackage  actions
 */
class stAllegroBackendActions extends autostAllegroBackendActions
{
    public function preExecute()
    {
        $config = stConfig::getInstance('stAllegroBackend');

        $i18n = $this->getContext()->getI18N();

        if ($config->get('access_token') && !$this->hasRequestParameter('code'))
        {
            try
            {
                $api = stAllegroApi::getInstance();
                $api->getShippingRates();
            }
            catch(stAllegroException $e)
            {
                $messages = array();

                foreach (stAllegroApi::getLastErrors() as $error)
                {
                    $messages[] = $error->userMessage;
                }

                $message = implode('<br>', $messages);

                if (strpos($message, 'Invalid refresh token') !== false)
                {
                    $message = $this->getContext()->getI18N()->__('Token dostępu nie może zostać odświeżony automatycznie proszę ponownie zalogować się do Allegro');
                }

                $this->setFlash('warning', $message, $this->getActionName() != 'config');
                
                if ($this->getActionName() != 'config')
                {
                    return $this->redirect('@stAllegroPlugin?action=config');
                }
            }
        }
    }

    public function executeAjaxCategoryTree()
    {
        $this->path = $this->getRequestParameter('path') ? explode(",", $this->getRequestParameter('path')) : array();

        $params = array('status' => 'open', 'children' => $this->getAjaxTreeChildren());

        $this->tree = stJQueryToolsHelper::getJsTreeHtmlRow(0, $this->getContext()->getI18N()->__('Kategorie'), $params);
    }

    public function executeAjaxCategoryToken()
    {
        $query = $this->getRequestParameter('q');

        $api = stAllegroApi::getInstance();

        if (is_numeric($query))
        {
            try
            {
                $response = $api->getCategory($query);

                if (!$response->leaf)
                {
                    return $this->renderJson(array());
                }

                $path = array();

                $ids = array();

                foreach ($api->getCategoryPath($response->id) as $category)
                {
                    $path[] = $category->name;
                    $ids[] = $category->id;
                }

                return $this->renderJson(array(
                    array('id' => $response->id, 'name' => implode(' / ', $path), 'ids' => implode(",", $ids))
                ));
            }
            catch(stAllegroException $e)
            {
                
            }
        }

        return $this->renderJson(array());
    }

    public function executeAjaxCategoryChildren()
    {
        $this->path = $this->getRequestParameter('path') ? explode(",", $this->getRequestParameter('path')) : array();
        $this->id = $this->getRequestParameter('id');

        return $this->renderText($this->getAjaxTreeChildren($this->id));
    }

    public function getAjaxTreeChildren($parentId = null) 
    {
        $api = stAllegroApi::getInstance();

        $categories = $api->getCategories($parentId);

        $tree = '';

        foreach ($categories as $category) {
            $id = $category->id;
            if (!$category->leaf) {
                if (!empty($this->path) && in_array($id, $this->path))
                    $params = array(
                        'status' => 'open',
                        'content' => stJQueryToolsHelper::getJsTreeHtmlDefaultControl("jstree-category-id", $id, false, true),
                        'children' => $this->getAjaxTreeChildren($id),
                    );
                else 
                    $params = array(
                        'status' => 'closed',
                        'content' => stJQueryToolsHelper::getJsTreeHtmlDefaultControl("jstree-category-id", $id, false, true),
                    );
                $name = $category->name;
            } else {
                $params = array(
                    'status' => 'leaf',
                    'content' => stJQueryToolsHelper::getJsTreeHtmlDefaultControl("jstree-category-id", $id, in_array($id, $this->path)),
                );

                $name = $category->name . ' (' . $id . ')';
            }

            $tree .= stJQueryToolsHelper::getJsTreeHtmlRow($id, htmlspecialchars(strtr($name, array("\n" => "", "\r" => "")), ENT_QUOTES), $params);
        }

        return $tree;
    }

    public function executeList()
    {
        $this->config = stConfig::getInstance('stAllegroBackend');

        try
        {
            $this->api = stAllegroApi::getInstance();

            $this->processFilters();
        
            $this->filters = $this->getUser()->getAttributeHolder()->getAll('soteshop/stAdminGenerator/stAllegroBackend/list/filters');

            $maxPerPage = $this->getUser()->getAttribute('list.max_per_page', 20, 'soteshop/stAdminGenerator/stAllegroBackend/config');

            $page = $this->getRequestParameter('page', 1);

            $productId = $this->getRequestParameter('product_id');

            if ($productId)
            {
                $this->product = ProductPeer::retrieveByPK($productId);
            }

            $pager = new stAllegroPager($page, $maxPerPage);

            $offerFilters = array(
                'publication.status' => isset($this->filters['status']) && $this->filters['status'] ? $this->filters['status'] : 'INACTIVE,ACTIVE,ACTIVATING,ENDED',  
                'limit' => $pager->getMaxPerPage(),
                'offset' => $pager->getOffset(),
                'sellingMode.format' => 'BUY_NOW'
            );

            if (isset($this->filters['name']) && trim($this->filters['name']))
            {
                $offerFilters['name'] = trim($this->filters['name']);
            }

            if (isset($this->filters['product_code']) && trim($this->filters['product_code']))
            {
                $c = new Criteria();
                $c->add(ProductPeer::CODE, '%'.trim($this->filters['product_code']).'%', Criteria::LIKE);
                $c->setLimit(100);
                $ids = ProductPeer::doSelectIds($c);

                if ($ids)
                {
                    foreach ($ids as $product_id)
                    {
                        $offerFilters['external.id'][] = $product_id;
                    }   
                }
            }

            if (isset($this->product))
            {
                $offerFilters['external.id'] = $this->product->getId();
            }

            if (isset($this->filters['price']))
            {
                if ($this->filters['price']['from'])
                {
                    $offerFilters['sellingMode.price.amount.gte'] = trim($this->filters['price']['from']);
                }

                if ($this->filters['price']['to'])
                {
                    $offerFilters['sellingMode.price.amount.lte'] = trim($this->filters['price']['to']);
                }
            }

            if (isset($this->filters['product_code']) && trim($this->filters['product_code']) && !isset($offerFilters['external.id']))
            {
                $this->offers = array();
                $pager->setTotalCount(0);
            }
            elseif (isset($this->filters['number']) && "" !== $this->filters['number'])
            {
                try
                {
                    $offer = $this->api->getOffer($this->filters['number']);

                    $this->offers = stAllegroApi::arrayToObject(array(
                        'offers' => array(
                            array(
                                'id' => $offer->id,
                                'name' => $offer->name,
                                'primaryImage' => array(
                                    'url' => isset($offer->images) && $offer->images ? $offer->images[0]->url : null,
                                ),
                                'stock' => array(
                                    'available' => $offer->stock->available,
                                    'sold' => '-'
                                ),
                                'publication' => $offer->publication,
                                'sellingMode' => $offer->sellingMode,
                            )
                        )
                    ));

                    $pager->setTotalCount(1);
                }
                catch(stAllegroException $e)
                {
                    $this->offers = array();
                    $pager->setTotalCount(0);
                }
            }
            else
            {
                $this->offers = $this->api->getOffers($offerFilters); 

                $pager->setTotalCount($this->offers->totalCount);
            }

            $this->pager = $pager;
        } 
        catch(stAllegroException $e)
        {
            $messages = array();

            foreach (stAllegroApi::getLastErrors() as $error)
            {
                $messages[] = $error->userMessage;
            }

            $this->setFlash('warning', implode('<br>', $messages));

            return $this->redirect('@stAllegroPlugin?action=config');           
        }
    }

    public function executeAjaxUploadOfferImages()
    {
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $images = $this->getRequestParameter('images');
            $api = stAllegroApi::getInstance();

            $results = array();
            $errors = array();

            foreach ($images as $image)
            {
                try
                {
                    $response = $api->uploadImage($image);

                    $results[] = $response->location;
                }
                catch (stAllegroException $e)
                {
                    foreach (stAllegroApi::getLastErrors() as $error)
                    {
                        $errors[] = $error->userMessage;
                    }
        
                    $this->setFlash('warning', implode('<br>', $errors), false);                    
                }
            }

            if (!$errors)
            {
                return $this->renderJSON(array(
                    'images' => $results,
                ));
            }
        }
      
        $this->product = ProductPeer::retrieveByPK($this->getRequestParameter('product'));
    }

    public function executeAjaxUpdateOfferForm()
    {
        $api = stAllegroApi::getInstance();

        $options = $this->getRequestParameter('options');
        
        if ($this->getRequestParameter('id'))
        {
            $offer = $api->getOffer($this->getRequestParameter('id'));

            $offer->category->id = $this->getRequestParameter('category_id');

            $auction = AllegroAuctionPeer::retrieveByAuctionNumber($offer->id);
            
            if ($options) {
                $auction->setProductOptions($options);
            }

            $auction->getProductOptionsArray();

            $product = $auction->getProduct();
        }
        elseif ($this->getRequestParameter('product_id'))
        {
            $product = ProductPeer::retrieveByPK($this->getRequestParameter('product_id'));

            $config = stConfig::getInstance('stAllegroBackend');

            $auction = new AllegroAuction();
            $auction->setProduct($product);

            if ($options) {
                $auction->setProductOptions($options);
            }

            $auction->getProductOptionsArray();

            $offer = $this->getDefaultOffer($product);
            
            $offer->category = stAllegroApi::arrayToObject(array(
                'id' => $this->getRequestParameter('category_id'),
            ));
        }

        $this->getUser()->setParameter('auction', $auction, 'soteshop/stAllegroPlugin');

        if (!isset($offer->promotion))
        {
            $offer->promotion = stAllegroApi::arrayToObject(array(
                "bold" => false,
                "departmentPage" => false,
                "emphasized" => false,
                "emphasizedHighlightBoldPackage" => false,
                "highlight" => false,
            ));
        }

        $content = $this->getRenderComponent('stAllegroBackend', 'offerForm', array('offer' => $offer, 'product' => $product, 'category_id' => $this->getRequestParameter('category_id')));

        return $this->renderText($content);
    }

    public function executeDuplicate()
    {
        try
        {
            $api = stAllegroApi::getInstance();

            $config = stConfig::getInstance('stAllegroBackend');

            $this->labels = $this->getLabels();
            
            $id = $this->getRequestParameter('id');

            $offer = $api->getOffer($id);

            unset($offer->id);

            $offer->publication = stAllegroApi::arrayToObject(array(
                'duration' => $offer->publication->duration,
            ));

            unset($offer->validation);
            unset($offer->updatedAt);
            unset($offer->createdAt);
        

            $auction = AllegroAuctionPeer::retrieveByAuctionNumber($id);

            $response = $api->createOffer($offer);

            $duplicate = new AllegroAuction();
            $duplicate->setName($response->name);
            $duplicate->setAuctionId($response->id);
            
            if (null !== $auction)
            {
                $duplicate->setProduct($auction->getProduct());
                $duplicate->setProductOptions($auction->getProductOptions());
            }

            $duplicate->save();

            return $this->redirect('@stAllegroPlugin?action=edit&id=' . $response->id);
        } 
        catch (stAllegroException $e)
        {
            $messages = array();

            foreach (stAllegroApi::getLastErrors() as $error)
            {
                $messages[] = $error->userMessage;
            }

            $this->setFlash('warning', implode('<br>', $messages));

            return $this->redirect('@stAllegroPlugin?action=list');
        }        
    }

    public function executeAjaxGetProductOptionsPicker()
    {
        $id = $this->getRequestParameter('id');
        $product = ProductPeer::retrieveByPK($id);

        $content = '';

        if ($product && $product->getOptHasOptions() > 1)
        {
            $content = $this->getRenderComponent('stProductOptionsBackend', 'optionPicker', array('product' => $product, 'namespace' => 'bind[product_options]', 'selected' => null));
        }

        return $this->renderText($content);
    }

    public function executeBindProduct()
    {
        try
        {
            $this->api = stAllegroApi::getInstance();

            $config = stConfig::getInstance('stAllegroBackend');

            $this->config = $config;

            $this->labels = $this->getLabels();
            
            $id = $this->getRequestParameter('id');

            $this->offer = $this->api->getOffer($id);

            $i18n = $this->getContext()->getI18N();

            $this->auction = AllegroAuctionPeer::retrieveByAuctionNumber($this->offer->id);

            if (null === $this->auction)
            {
                $this->auction = new AllegroAuction();
            }

            $this->getUser()->setParameter('auction', $this->auction, 'soteshop/stAllegroPlugin');

            if ($this->getRequest()->getMethod() == sfRequest::POST)
            {
                $bind = $this->getRequestParameter('bind');

                $tokens = stJQueryToolsHelper::parseTokensFromRequest($bind['product']);
                
                if (!$tokens)
                {
                    $this->getRequest()->setError('bind{product}', $i18n->__('Musisz wybrać produkt'));
                }
                else
                {
                    $productId = $tokens[0]['id'];

                    $product = ProductPeer::retrieveByPK($productId);

                    try
                    {
                        $this->offer->external = stAllegroApi::arrayToObject(array(
                            'id' => $product->getId(),
                        ));

                        $this->auction->setName($this->offer->name);
                        $this->auction->setProduct($product);
                        $this->auction->setAuctionId($this->offer->id);

                        if (isset($bind['product_options']))
                        {
                            $this->auction->setProductOptions($bind['product_options']);
                        }   

                        $this->auction->save();

                        $this->auction->getProductOptionsArray();

                        $priceModifiers = $product->getPriceModifiers();

                        /**
                         * @see BasketProduct::setPriceModifiers()
                         **/
                        foreach ($priceModifiers as $index => $value) {
                            if (isset($value['custom']['label'])) {
                                $label = $value['custom']['label'];
        
                                unset($value['custom']['label']);
        
                                $value['label'] = $label;
        
                                $priceModifiers[$index] = $value;
                            }
                        }
    
                        $stmt = Propel::getConnection()->prepareStatement(sprintf('UPDATE %s SET %s = ?, %s = ?, %s = ?, %s = ?, %s = ? WHERE %s = ?', OrderProductPeer::TABLE_NAME, OrderProductPeer::CODE, OrderProductPeer::IMAGE, OrderProductPeer::NAME, OrderProductPeer::PRODUCT_ID, OrderProductPeer::PRICE_MODIFIERS, OrderProductPeer::ALLEGRO_AUCTION_ID));
                        $stmt->setString(1, $product->getCode());
                        $stmt->setString(2, $product->getOptImage());
                        $stmt->setString(3, $config->get('import_product_name', 'offer') == 'offer' ? $this->offer->name : $product->getName());
                        $stmt->setInt(4, $product->getId());
                        $stmt->setString(5, serialize($priceModifiers));
                        $stmt->setString(6, $this->offer->id);
    
                        $stmt->executeQuery();

                        $this->api->updateOffer($id, $this->offer);
                    }
                    catch (stAllegroException $e)
                    {
                        $messages = array();
            
                        foreach (stAllegroApi::getLastErrors() as $error)
                        {
                            $messages[] = $error->userMessage;
                        }
            
                        $this->setFlash('warning', implode('<br>', $messages));
                    }

                    return $this->redirect('@stAllegroPlugin?action=edit&id=' . $this->offer->id);
                }
            }
        } 
        catch (stAllegroException $e)
        {
            $messages = array();

            foreach (stAllegroApi::getLastErrors() as $error)
            {
                $messages[] = $error->userMessage;
            }

            $this->setFlash('warning', implode('<br>', $messages), false);
        }
    }

    public function executeEnd()
    {
        try
        {
            $api = stAllegroApi::getInstance();
            $i18n = $this->getContext()->getI18N();
            $id = $this->getRequestParameter('id');
            $product_id = $this->getRequestParameter('product_id');

            $api->publishOffers(array($id), false);

            sleep(1);

            $this->setFlash('notice', $i18n->__('Twoja oferta zostanie wkrótce zakończona', null, 'stAdminGeneratorPlugin'));

            return $this->redirect('@stAllegroPlugin?action=edit&id='.$id.'&product_id='.$product_id);
        }
        catch(stAllegroException $e)
        {
            $messages = array();

            foreach (stAllegroApi::getLastErrors() as $error)
            {
                $messages[] = $error->userMessage;
            }

            $this->setFlash('warning', implode('<br>', $messages));

            return $this->redirect('@stAllegroPlugin?action=edit&id='.$id.'&product_id='.$product_id);
        }

    }

    public function executeAjaxFeePreviewUpdate()
    {
        $id = $this->getRequestParameter('id');
        $status = $this->getRequestParameter('status');
        $offer = $this->getRequestParameter('offer');

        $category = stJQueryToolsHelper::parseTokensFromRequest($offer['category']);

        $content = $this->getRenderComponent('stAllegroBackend', 'pricingFeePreview', array(
            'category' => $category[0]['id'],
            'quantity' => $offer['stock']['available'],
            'price' => $offer['selling_mode']['price']['amount'],
            "bold" => isset($offer['promotion']['bold']),
            "highlight" => isset($offer['promotion']['highlight']),
            "departmentPage" => isset($offer['promotion']['department_page']),
            "emphasized" => isset($offer['promotion']['emphasized']),
            "emphasizedHighlightBoldPackage" => isset($offer['promotion']['emphasized_highlight_bold_package']),
            "offerId" => $id ? $id : null,
            "status" => $status ? $status : null, 
        ));

        return $this->renderText($content);
    }

    public function executeEdit()
    {
        $this->api = stAllegroApi::getInstance();

        $config = stConfig::getInstance('stAllegroBackend');

        $this->config = $config;

        $this->labels = $this->getLabels();

        try
        {
            $productId = $this->getRequestParameter('product_id');
            $id = $this->getRequestParameter('id');

            $this->product = null;
            $this->auction = null;

            if ($productId)
            {
                $this->product = ProductPeer::retrieveByPK($productId);
            }
            
            if ($id)
            {
                $id = $this->getRequestParameter('id');

                $this->offer = $this->api->getOffer($id);

                $this->auction = AllegroAuctionPeer::retrieveByAuctionNumber($id);

                if ($this->auction)
                {
                    $commands = $this->auction->getCommands();

                    if ($commands && $this->offer->publication->status == 'INACTIVE') {
                        try
                        {
                            $response = $this->api->getPublishOffersReport($commands['publish']);

                            if ($response && $response[0]->status == 'FAIL')
                            {
                                $this->setFlash('warning', $response[0]->message, false);
                            }
                        }
                        catch(stAllegroException $e) 
                        {
                            
                        }
                    }
                }
                
                if ($this->auction && $this->auction->getProduct())
                {
                    $this->product = $this->auction->getProduct();
                }
                else
                {
                    return $this->redirect('@stAllegroPlugin?action=bindProduct&id=' . $this->offer->id);
                }
            }
            elseif ($this->product)
            {
                $this->auction = new AllegroAuction();
                $this->auction->setProduct($this->product);
                $this->offer = $this->getDefaultOffer($this->product);
            }

            $this->getUser()->setParameter('auction', $this->auction, 'soteshop/stAllegroPlugin');

            if (null === $this->offer->description)
            {
                $this->offer->description = stAllegroApi::arrayToObject(array(
                    'sections' => array(
                        array(
                            'items' => array(
                                array(
                                    'type' => 'TEXT',
                                    'content' => '',
                                )
                            )
                        )
                    )
                ));
            }

            $this->offer->external = stAllegroApi::arrayToObject(array(
                'id' => $this->product->getId(),
            ));

       
            $this->offer->location = stAllegroApi::arrayToObject(array(
                'city' => $config->get('allegro_pl_city'),
                'countryCode' => 'PL',
                'postCode' => $config->get('allegro_pl_post_code'),
                'province' => strtoupper($config->get('allegro_pl_state')),
            ));


            if ($this->getRequest()->getMethod() == sfRequest::POST)
            {
                $i18n = $this->getContext()->getI18N();
                $offerData = $this->getRequestParameter('offer');
                $auctionData = $this->getRequestParameter('auction', array());

                if (!$this->auction->getProductId()) {
                    $this->auction->setProduct($this->product);
                }

                $this->offer->promotion = stAllegroApi::arrayToObject(array(
                    "bold" => false,
                    "departmentPage" => false,
                    "emphasized" => false,
                    "emphasizedHighlightBoldPackage" => false,
                    "highlight" => false,
                ));

                $this->updateOfferFromRequest($this->offer, $offerData);
                
                if ($this->auction)
                {
                    $this->updateAuctionFromRequest($this->auction, $auctionData);

                    $this->auction->getProductOptionsArray();
                }

                if ($this->offer->stock->available > $this->product->getStock() || !$this->product->getStock())
                {
                    $this->getRequest()->setError('offer{stock}', $i18n->__("Zwiększ stan magazynowy produktu"));
                }

                if (!isset($this->offer->category->id) && !$this->offer->category->id)
                {
                    $this->getRequest()->setError('offer{category}', $i18n->__("Musisz wybrać kategorię"));
                }

                if ($this->getRequest()->hasErrors())
                {
                    return;
                }
        
                if (isset($this->offer->id))
                {
                    $response = $this->api->updateOffer($id, $this->offer);
                }
                else
                {
                    $response = $this->api->createOffer($this->offer);

                    $this->auction->setAuctionId($response->id);
                }

                if ($this->offer->publication->status == 'ACTIVE')
                {
                    $this->auction->setEnded(null);
                    $this->auction->setEndedAt(null);
                }

                $this->auction->save();

                if (!$response->validation->errors) {
                    if ($this->hasRequestParameter('publish'))
                    {
                        $publishResponse = $this->api->publishOffers(array($response->id));
                        
                        sleep(1);
                        
                        $this->auction->addCommand($publishResponse->id, 'publish');

                        $this->auction->setEnded(null);
                        $this->auction->setEndedAt(null);

                        $this->auction->save();

                        $this->setFlash('notice', $i18n->__('Oferta została przekazana do publikacji', null, 'stAdminGeneratorPlugin'));
                    }
                    else
                    {
                        $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin')); 
                        
                        if ($this->auction->getProduct()->getOptHasOptions() > 1)
                        {
                            $selectedOptions = $this->auction->getProductOptionsArray();
                            AllegroAuctionPeer::updateRequiresSync($this->auction->getProductId(), end($selectedOptions));
                        }
                        else
                        {
                            AllegroAuctionPeer::updateRequiresSync($this->auction->getProductId());
                        }
                    }              
                }  
                else
                {
                    $messages = array();

                    foreach ($response->validation->errors as $error)
                    {
                        $messages[] = $error->userMessage;
                    }

                    $this->setFlash('warning', implode('<br>', $messages), true);   
                }

                return $this->redirect('@stAllegroPlugin?action=edit&id='.$response->id.'&product_id='.$productId);
            }
            elseif (!$this->auction->isNew() && isset($this->offer->publication) && $this->offer->publication->status == 'ACTIVE')
            {
                $this->api->updateOffer($id, $this->offer);
            }
        }
        catch (stAllegroException $e)
        {
            $messages = array();

            $errors = stAllegroApi::getLastErrors();

            foreach ($errors as $error)
            {
                $messages[] = $error->userMessage;
            }

            $this->setFlash('warning', implode('<br>', $messages), false);

            if ($errors[0]->code == 'NOT_FOUND')
            {
                return $this->redirect('@stAllegroPlugin?action=list');
            }
        }
    }

    public function executeImportOrder() {
        $api = stAllegroApi::getInstance();

        $forms = $api->getOrderCheckoutForms();

        $this->count = $forms->totalCount;
    }

    protected function getDefaultOffer(Product $product)
    {
        $config = stConfig::getInstance('stAllegroBackend');

        $allegroCommission = new AllegroCommission();

        $offer = stAllegroApi::arrayToObject(array(
            'name' => $product->getName(),
            'external' => array(
                'id' => $product->getId(),
            ),
            'sellingMode' => array(
                'format' => 'BUY_NOW',
                'price' => array(
                    'amount' => $allegroCommission->calculatePrice($product->getPriceBrutto()),
                    'currency' => 'PLN',
                ),
            ),
            'stock' => array(
                'available' => $product->getStock(),
                'unit' => 'UNIT',
            ),
            'description' => array(
                'sections' => array(
                    array(
                        'items' => array(
                            array(
                                'type' => 'TEXT',
                                'content' => $product->getDescription() ? $product->getDescription() : $product->getShortDescription(),
                            )
                        )
                    )
                )
            ),
            'delivery' => array(
                'shippingRates' => array(
                    'id' => $config->get('delivery_shipping_rates_id')
                ),
                'handlingTime' => $config->get('delivery_handling_time'),
            ),
            'payments' => array(
                'invoice' => $config->get('payments_invoice'),
            ),
        )); 

        $afterSalesServices = array();

        if ($config->get('return_policy'))
        {
            $afterSalesServices['returnPolicy'] = array(
                'id' => $config->get('return_policy'),
            );
        }

        if ($config->get('implied_warranty'))
        {
            $afterSalesServices['impliedWarranty'] = array(
                'id' => $config->get('implied_warranty'),
            );
        }

        if ($config->get('warranty'))
        {
            $afterSalesServices['warranty'] = array(
                'id' => $config->get('warranty'),
            );
        }

        if ($afterSalesServices) 
        {
            $offer->afterSalesServices = stAllegroApi::arrayToObject($afterSalesServices);
        }

        return $offer;
    }


    protected function getLabels()
    {
        return array(
            'offer{stock}' => "Ilość",
            'bind{product}' => "Produkt",
            'offer{category}' => "Kategoria",
        );
    }

    protected function updateAuctionFromRequest(AllegroAuction $auction, array $data)
    {
        if (isset($data['product_options']))
        {
            $auction->setProductOptions($data['product_options']);
        }   

        if ($this->offer->name)
        {
            $auction->setName($this->offer->name);
        }

        $this->dispatcher->notify(new sfEvent($this, 'stAllegroBackendActions.updateAuctionFromRequest', array('auction' => $auction)));
    }

    protected function updateOfferFromRequest(stdClass &$offer, array $data, $parentProperty = null)
    {
        foreach ($data as $name => $value)
        {
            $property = lcfirst(sfInflector::camelize($name));

            if ($name == 'parameters' && null === $parentProperty)
            {
                $this->updateOfferParameters($offer, $value);
            }
            elseif ($name == 'category')
            {
                $tokens = stJQueryToolsHelper::parseTokensFromRequest($value);

                if (!isset($offer->category))
                {
                    $offer->category = new stdClass();
                }
                
                $offer->category->id = $tokens ? $tokens[0]['id'] : null;
            }
            elseif (in_array($name, array('images', 'description')))
            {                
                $offer->$property = json_decode($value);

                // if ($name == 'description')
                // {
                //     foreach ($offer->description->sections as $si => $section)
                //     {
                //         foreach ($section->items as $ii => $item)
                //         {
                //             if ($item->type == "TEXT")
                //             {
                //                 $item->content = preg_replace(array('#((&nbsp;|[ ])*<b>(&nbsp;|[ ])*)+#', '#((&nbsp;|[ ])*</b>(&nbsp;|[ ])*)+#'), array(' <b>', '</b> '), $item->content);
                //             }
                //         }
                //     }
                // }
            }
            elseif (is_array($value)) 
            {
                if (!isset($offer->$property) || null === $offer->$property)
                {
                    $offer->$property = new stdClass();

                    // die($property);
                }

                $this->updateOfferFromRequest($offer->$property, $value, $property);
            }
            else
            {
                if ("" !== $value || in_array($property, array('duration', 'ean')) || in_array($parentProperty, array('promotion')))
                {
                    if ("" === $value)
                    {
                        $value = null;
                    }

                    if (is_bool($value))
                    {
                        $value = $value == "true";
                    }

                    $offer->$property = $value;
                }
                else
                {
                    $offer = null;
                }
            }
        }
    }

    protected function updateOfferParameters(stdClass $offer, array $data)
    {
        $offer->parameters = array();

        foreach ($data as $type => $values)
        {
            switch($type)
            {
                case 'dictionary':
                    foreach ($values as $id => $value)
                    {
                        if ($value)
                        {
                            $parameter = new stdClass();
                            $parameter->id = $id;
                            $parameter->valuesIds = is_array($value) ? $value : array($value);
                            $offer->parameters[$id] = $parameter;
                        }
                    }
                break;
                case 'float':
                case 'integer':
                    foreach ($values as $id => $value)
                    {
                        $parameter = new stdClass();
                        $parameter->id = $id;
                        
                        if (is_array($value))
                        {
                            $parameter->rangeValue = new stdClass();
                            $parameter->rangeValue->from = $value['from'];
                            $parameter->rangeValue->to = $value['to'];
                            
                            if ($value['from'] !== "" || $value['to'] !== "")
                            {
                                $offer->parameters[$id] = $parameter;
                            }
                        }
                        else
                        {
                            $parameter->values = array($value);

                            if ($value !== "")
                            {
                                $offer->parameters[$id] = $parameter;
                            }
                        }
                    }
                break;
                case 'string':
                    foreach ($values as $id => $value)
                    {
                        $parameter = new stdClass();
                        $parameter->id = $id;
                        
                        if (is_array($value))
                        {
                            $parameter->values = array();

                            foreach ($value as $v)
                            {
                                if ($v)
                                {
                                    $parameter->values[] = $v;
                                }
                            }

                            
                            if ($parameter->values)
                            {
                                $offer->parameters[$id] = $parameter;
                            }
                        }
                        else
                        {
                            $parameter->values = array($value);

                            if ($value)
                            {
                                $offer->parameters[$id] = $parameter;
                            }
                        }
                    }
                break;
            }
        }
    }

    public function executeDelete()
    {
        $api = stAllegroApi::getInstance();

        $id = $this->getRequestParameter('id');

        $i18n = $this->getContext()->getI18N();

        try
        {
            $response = $api->deleteDraftOffer($id);

            $auction = AllegroAuctionPeer::retrieveByAuctionNumber($id);
                
            if ($auction)
            {
                $auction->delete();
            }

            $this->setFlash('notice', $i18n->__('Szkic został usunięty'));
        }
        catch(Exception $e)
        {
            $this->setFlash('warning', $e->getMessage());
        }

        sleep(2);

        return $this->redirect('@stAllegroPlugin?action=list');
    }

    public function executeConfig() 
    {
        $i18n = $this->getContext()->getI18N();
        
        $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStAllegroBackend/forward_parameters');
        
        $this->config = $this->loadConfigOrCreate();

        $this->labels = $this->getConfigLabels();
        
        if ($this->getRequest()->getMethod() == sfRequest::POST) 
        {  
            $offer_product_commission = $this->config->get('offer_product_commission');
            
            $this->updateConfigFromRequest();
        
            $this->saveConfig();

            if ($offer_product_commission != $this->config->get('offer_product_commission'))
            {
                AllegroAuctionPeer::updateRequiresSync();
            }
            
            if (floatval(phpversion()) >= 7.1)
            {
                stTaskScheluder::forceTaskInitialization();
            }
            
            $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));

            if ($this->hasRequestParameter('login'))
            {
                return $this->redirect(AllegroRestApi::getAuthLink($this->config->get('client_id'), stAllegroApi::redirectAuthUri(), $this->config->get('sandbox')));
            }
            else
            {
                return $this->redirect('stAllegroBackend/config');
            }
        } 

        if ($this->hasRequestParameter('code'))
        {
            try
            {
                $response = AllegroRestApi::generateToken($this->getRequestParameter('code'), $this->config->get('client_id'), $this->config->get('client_secret'), stAllegroApi::redirectAuthUri(), $this->config->get('sandbox'));

                if ($response)
                {
                    $this->config->set('access_token', $response->access_token);  
                    $this->config->set('refresh_token', $response->refresh_token);
                    $this->config->set('expires', $response->expires_in + time());
                    $this->config->set('seller_id', $response->seller_id);
                    $this->config->save(true);

                    $this->setFlash('warning', null);

                    return $this->redirect('stAllegroBackend/config');
                }
            }
            catch(stAllegroException $e)
            {
                $errors = AllegroRestApi::getLastErrors();

                $this->setFlash('warning', $errors[0]->userMessage);
                $this->setFlash('notice', null);

                return $this->redirect('stAllegroBackend/config'); 
            }
        }
    }

    protected function getConfigLabels()
    {
        $labels = parent::getConfigLabels();
        $i18n = $this->getContext()->getI18N();

        $labels['API'] = $i18n->__('Allegro REST API');

        return $labels;
    }

    public function handleErrorConfig()
    {
        $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStAllegroBackend/forward_parameters');
        
        $this->config = $this->loadConfigOrCreate();

        $this->labels = $this->getConfigLabels();

        return sfView::SUCCESS;
    }

    public function validateConfig() 
    {
        $i18n = $this->getContext()->getI18N();

        if ($this->getRequest()->getMethod() == sfRequest::POST) 
        { 
            $config = $this->getRequestParameter('config');

            if (!$config['client_id'])
            {
                $this->getRequest()->setError('config{client_id}', $i18n->__('Uzupełnij Client Id'));
            }

            if (!$config['client_secret'])
            {
                $this->getRequest()->setError('config{client_secret}', $i18n->__('Uzupełnij Client Secret'));
            }

            if (!$config['allegro_pl_state'])
            {
                $this->getRequest()->setError('config{allegro_pl_state}', $i18n->__('Uzupełnij region'));
            }
            
            if (!$config['allegro_pl_city'])
            {
                $this->getRequest()->setError('config{allegro_pl_city}', $i18n->__('Uzupełnij miasto'));
            }

            if (!$config['allegro_pl_post_code'])
            {
                $this->getRequest()->setError('config{allegro_pl_post_code}', $i18n->__('Uzupełnij kod pocztowy'));
            }
        }

        return !$this->getRequest()->hasErrors();
    }

    public function executeConnectionError() {
        $this->environment = $this->getRequestParameter('environment');
    }
}
