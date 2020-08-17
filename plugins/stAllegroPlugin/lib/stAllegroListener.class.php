<?php

class stAllegroListener {

    public static function generateStProduct(sfEvent $event) {
        $event->getSubject()->attachAdminGeneratorFile('stAllegroPlugin', 'stProductAllegro.yml');
    }

    public static function generateStOrder(sfEvent $event) {
        $event->getSubject()->attachAdminGeneratorFile('stAllegroPlugin', 'stOrderAllegro.yml');
    }

    public static function postExecuteAllegroCustom(sfEvent $event) {
        $productId = $event->getSubject()->forward_parameters['product_id'];

        $c = new Criteria();
        $c->add(AllegroAuctionPeer::PRODUCT_ID, $productId);
        $hasAuctions = (bool) AllegroAuctionPeer::doCount($c);

        if (!$hasAuctions) {
            $config = stConfig::getInstance('stAllegroPlugin');
            if ($config->get('allegro_pl_api_key', null) && (!$config->get('sandbox_api_key') || !$config->get('sandbox_enabled'))) {
                $category = new stAllegroCategory('AllegroPl');

                if ($category->checkStatus() == 1)
                    return $event->getSubject()->redirect('stProduct/allegroEdit?product_id='.$productId.'&environment=allegro-pl');
            }
        }
    }

    public static function preExecuteAllegroEdit(sfEvent $event) {
        $auction = null;
        if ($id = $event->getSubject()->getRequestParameter('id')) {
            $auction = AllegroAuctionPeer::retrieveByPK($id);
        }

        $env = (is_object($auction) && $auction->getEnvironment() != '') ? $auction->getEnvironment() : $event->getSubject()->getRequestParameter('environment');

        if (stAllegro::getInstance($env)->testConnection() == false)
            return $event->getSubject()->redirect('stAllegroBackend/connectionError?environment='.$env);
    }

    public static function preDeleteAllegro(sfEvent $event) {
        $productId = $event->getSubject()->allegro_auction->getProductId();
        $event->getSubject()->allegro_auction->delete();
        return $event->getSubject()->redirect('stProduct/allegroCustom?product_id='.$productId);
    }

    public static function taskScheluderInitialize(sfEvent $event)
    {
        $config = stConfig::getInstance('stAllegroBackend');

        if (!$config->get('task_scheluder_initialized') && $config->get('access_token'))
        {
            /**
             * @var stTaskInterface[] $tasks
             */
            $tasks = $event['tasks'];

            $allegroImportTask = $tasks['allegro_order_import']->getTask();
            $allegroImportTask->setIsActive(true);
            $allegroImportTask->save();

            $allegroSyncTask = $tasks['allegro_sync']->getTask();
            $allegroSyncTask->setIsActive(true);
            $allegroSyncTask->save();

            $config->set('task_scheluder_initialized', true);

            $config->save();
        }
    }

    public static function validateAllegroEdit(sfEvent $event, $ok)
    {
        $action = $event->getSubject();
        $i18n = $action->getContext()->getI18N();

        if ($action->getRequest()->getMethod() != sfRequest::POST)
        {
            

            $id = $action->getRequestParameter('id');
            $auction = AllegroAuctionPeer::retrieveByPK($id);

            if (null !== $auction && $auction->getAllegroCategoryId())
            {
                $allegro = stAllegro::getInstance($auction->getSite());
                $allegro->doLogin();
                
                try
                {
                    $response = $allegro->call('doGetCategoryPath', array(
                        'sessionId' => $allegro->getSessionHandle(),
                        'categoryId' => $auction->getAllegroCategory()->getCatId(),
                    ));

                    $response = stAllegroHelper::objectToArray($response);

                    $last = $response['categoryPath'] ? end($response['categoryPath']['item']) : array();

                    if (!$last)
                    {
                        $action->getRequest()->setError('allegro_auction{allegro_category_id}', $i18n->__('Wybrana kategoria nie istnieje już na allegro lub zmieniła swoją lokalizacje (Wykonaj import kategorii z allegro i wybierz nową kategorię)', null, 'stAllegroBackend'));
                        $ok = false;
                    }
                    elseif (!$last['catIsLeaf'])
                    {
                        $action->getRequest()->setError('allegro_auction{allegro_category_id}', $i18n->__('Wybrana kategoria zawiera dodatkowe podkategorie (Jeżeli nie widzisz dodatkowych podkategorii wykonaj import kategorii z allegro wybierz nową podkategorię)', null, 'stAllegroBackend'));
                        $ok = false;
                    }
                    
                }
                catch (Exception $e)
                {
                    $action->getRequest()->setError('allegro_auction{allegro_category_id}', $e->getMessage());
                    $ok = false;
                }
            } 
        }
        else
        {
            $data = $action->getRequest()->getParameter('allegro_auction');

            $text = stJQueryToolsHelper::parseTokensFromRequest($data['text']);

            if (empty($text))
            {
                $action->getRequest()->setError('allegro_auction{text}', $i18n->__('Uzupełnij opis', null, 'stAllegroBackend'));
            }
            else
            {
                $error = false;

                foreach ($text as $section)
                {
                    foreach ($section['content'] as $content)
                    {
                        if (empty($content['value']))
                        {
                            $error = true;
                        }
                    }
                }

                if ($error)
                {
                    $action->getRequest()->setError('allegro_auction{text}', $i18n->__('Uzupełnij opis', null, 'stAllegroBackend'));
                    $ok = false;
                }
            }

        }


        return $ok;
        
    }

    public static function GetAllegroOrCreate(sfEvent $event) {
        if (!$event->getSubject()->getRequestParameter('id')) {
            $auction = $event->getSubject()->allegro_auction;
            $productId = $event->getSubject()->getRequestParameter('product_id');
            $environment = $event->getSubject()->getRequestParameter('environment');

            $environment = stAllegro::parseEnvironment($environment);

            $product = ProductPeer::retrieveByPK($productId);

            if ($product) {
                $auction->setProductId($productId);
                $auction->setEan($product->getManCode());
                $auction->setAllegroCategoryId(0);
                $auction->setName($product->getName());
                $auction->setText(preg_replace('/<\/?(html|body|meta|head|!doctype).*>/i', '', $product->getDescription()));
                $auction->setShortText(preg_replace('/<\/?(html|body|meta|head|!doctype).*>/i', '', $product->getShortDescription()));
                $auction->setSite($environment);
                $auction->setAuctionType(0);
                $auction->setWhoPay(1);
                $auction->setPriceBuyNow($product->getOptPriceBrutto());
                $auction->setStock(1);
                $auction->setHowLong(7);
            }
        }
    }

    public static function postUpdateAllegroFromRequest(sfEvent $event) {
        $auction = $event->getSubject()->allegro_auction;
        $request = $event->getSubject()->getRequestParameter('allegro_auction');

        $fields = array('auction_type', 'price_buy_now', 'price_start', 'price_min', 'stock', 'stock_type', 'how_long', 'allegro_template_id', 'shipping_time',
                        'who_pay', 'other_text', 'short_text', 'attributes', 'depository_on_sale', 'resumption', 'ean');

        foreach ($fields as $field)
            if (isset($request[$field])) {
                $auction->{sfInflector::camelize('set_'.$field)}($request[$field]);
            }

        if ($request['text'])
        {
            if ($auction->hasNewDescriptionFormat())
            {
                $auction->setText(stJQueryToolsHelper::parseTokensFromRequest($request['text']));
            }
            else
            {
                $auction->setText($request['text']);
            }
        }

        if (!isset($request['depository_on_sale'])) {
            $auction->setDepositoryOnSale(false);

        }

        if (isset($request['allegro_category_id'])) {
            $category = json_decode(json_decode($request['allegro_category_id']), true);

            if (isset($category[0]['id'])) {
                $category = AllegroCategoryPeer::doSelectByCatId($category[0]['id'], $auction->getEnvironment());
                if (is_object($category))
                    $auction->setAllegroCategoryId($category->getId());
            }
        }

        if (isset($request['15'])) {
            $options = 0;
            foreach ($request['15']['value'] as $v)
                $options = $options+$v;
            $auction->setOtherOption($options);
        } else {
            $auction->setOtherOption(0);
        }

        if (isset($request['14'])) {

            $options = 0;
            foreach ($request['14']['value'] as $v)
                $options = $options+$v;
            $auction->setPayOption($options);
        } else {
            $auction->setPayOption(0);
        }

        if (isset($request['delivery']))
        {
            foreach ($request['delivery'] as $key => $value)
                if (!isset($request['delivery'][$key]['enabled']))
                    $request['delivery'][$key]['enabled'] = false;
                else
                    $request['delivery'][$key]['enabled'] = true;

            $auction->setDelivery($request['delivery']);
        }
    }

    public static function postSaveAllegro(sfEvent $event) {
        $t = $event->getSubject();
        if ($t->getRequest()->getMethod() == sfRequest::POST) { 
            $auction = $event['modelInstance'];

            if (stAllegro::getInstance($auction->getEnvironment())->testConnection()) {
                if ($t->getRequestParameter('validate_auction')) {
                    try {
                        $response = stAllegro::getInstance($auction->getEnvironment())->checkAuction($auction);

                        if (is_object($response))
                            $event->getSubject()->setFlash('allegro-validate-message', stAllegroHelper::objectToArray($response));
                        else
                            $event->getSubject()->setFlash('allegro-validate-error', stAllegro::getInstance($auction->getEnvironment())->getLastError());
                    } catch (AllegroValidationException $e) {
                        $event->getSubject()->setFlash('allegro-error', $e->getMessage());
                    } catch (AllegroException $e) {
                        $event->getSubject()->setFlash('allegro-validate-error', $e->getMessage());
                    }
                }

                if ($t->getRequestParameter('create_auction')) {
                    return $t->redirect('stAllegroBackend/sale?id='.$auction->getId());
                }
            }
        }
    }

    public static function addAllegroFiltersCriteria(sfEvent $event) {
        $action = $event->getSubject();
        /**
         * @var Criteria $c
         */
        $c = $event['criteria'];

        if ((!isset($action->filters['order_auctions']) || "" === $action->filters['order_auctions']) && (!isset($action->filters['opt_allegro_checkout_form_id']) || "" === $action->filters['opt_allegro_checkout_form_id']))
        {
            $c->addJoin(OrderPeer::ID, AllegroAuctionHasOrderPeer::ORDER_ID, Criteria::LEFT_JOIN);
            $cc = $c->getNewCriterion(OrderPeer::OPT_ALLEGRO_CHECKOUT_FORM_ID, null, Criteria::ISNOTNULL);
            $cc->addOr($c->getNewCriterion(AllegroAuctionHasOrderPeer::ORDER_ID, null, Criteria::ISNOTNULL));
            $c->add($cc);
            $c->addGroupByColumn(OrderPeer::ID);
        }
        elseif (isset($action->filters['order_auctions']) && "" !== $action->filters['order_auctions'])
        {
            $c->addJoin(OrderProductPeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);
            $c->add(OrderProductPeer::ALLEGRO_AUCTION_ID, $action->filters['order_auctions']);
        }
    }
}
