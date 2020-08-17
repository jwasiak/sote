<?php

/**
 * SOTESHOP/stBasket
 *
 * Ten plik należy do aplikacji stBasket opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stBasket
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 17428 2012-03-14 14:17:02Z marcin $
 */

/**
 * Akcje dla koszyka
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stBasket
 * @subpackage  actions
 */
class stBasketActions extends stActions {

    public function preExecute()
    {
        $ret = parent::preExecute();

        if ($this->hasSessionExpired() && !$this->getRequest()->isXmlHttpRequest() && $this->getRequest()->getMethod() == sfRequest::POST && !in_array($this->getActionName(), array('addReferer')))
        {
            return $this->redirect('@stBasket?action=index&session_expired=true');
        }

        $user = $this->getUser();

        $user->setVatEx(stTax::hasEx($user->isAuthenticated() && $user->getUserDataDefaultBilling() ? $user->getUserDataDefaultBilling()->getCountries()->getId() : null)); 

        return $ret;
    }

    /**
     * Zwraca obiekt obsługi zdarzeń
     *
     * @return   stEventDispatcher
     */
    public function getDispatcher() {
        return stEventDispatcher::getInstance();
    }

    /**
     * Zapamietuje poprzednią stronę i przekazuje żądanie do stBasket/index
     */
    public function executeIndexReferer() {
        $this->remmemberRerefer();

        return $this->redirect('@stBasket');
    }

    /**
     * Zapamiętuje poprzednią stronę i przekazuje żądanie do stBasket/add
     */
    public function executeAddReferer() {
        $request = $this->getRequest();

        stFastCacheController::disable();

        if (stConfig::getInstance('stBasket')->get('ajax') && $request->isXmlHttpRequest()) {
            $this->remmemberRerefer();

            $this->responseUpdateElement('basket_show', array('module' => 'stBasket', 'component' => 'show', 'params' => array('cache_id' => stBasket::cacheId())));
            $this->responseUpdateElement('login_status_container', array('module' => 'stUser', 'component' => 'loginStatus'));
            
            $result = $this->getRenderComponent('stBasket', 'ajaxAddedProductPreview');

            return $this->renderText($result);
        } else {
            $this->remmemberRerefer();

            return $this->redirect('@stBasket');
        }
    }

    /**
     * Indeks koszyka
     */
    public function executeIndex() 
    {
        $this->getUser()->setAttribute('is_blocked', false, stBasket::SESSION_NAMESPACE);

        $this->smarty = new stSmarty($this->getModuleName());

        $this->basket = stBasket::getInstance($this->getUser());

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->basket->refresh();
            $this->basket->save();
        }

        $this->delivery = stDeliveryFrontend::getInstance($this->basket);

        if ($this->hasRequestParameter('submit_save'))
        {
            $user_data_billing =  $this->getRequestParameter('user_data_billing');

            if (isset($user_data_billing['different_delivery']) && $user_data_billing['different_delivery'])
            {
                $user_data_delivery = $this->getRequestParameter('user_data_delivery');
                $this->delivery->setDefaultDeliveryCountry($user_data_delivery['country']); 
            }
            else
            {
                $this->delivery->setDefaultDeliveryCountry($user_data_billing['country']);
            }

            $user = $this->getUser();
            $user->setVatEx(stTax::hasEx($user->isAuthenticated() && $user->getUserDataDefaultBilling() ? $user->getUserDataDefaultBilling()->getCountries()->getId() : null)); 
        }

        $this->basket_config = stConfig::getInstance('stBasket');

        $this->config_points = stConfig::getInstance('stPointsBackend');

        $this->referer = $this->getReferer();

        $this->checkMinOrderAmount();
    }

    public function executeSetProduct() {
        return $this->redirect('@stBasket');
    }

    /**
     * Dodawanie koszyka
     */
    public function executeAddBasket() {
        $basket = stBasket::getInstance($this->getUser());

        $basket->addBasket(true);

        return $this->redirect('@stBasket');
    }

    /**
     * Ustawia domyślny koszyk
     */
    public function executeSetBasket() {
        $basket = stBasket::getInstance($this->getUser());

        $this->forward404Unless(stBasket::validateBasket($this->getRequestParameter('id'), $this->getUser()));

        $basket->set($this->getRequestParameter('id'));

        return $this->redirect('@stBasket');
    }

    /**
     * Usuwa koszyk
     */
    public function executeDeleteBasket() {
        $basket = stBasket::getInstance($this->getUser());

        $this->forward404Unless(stBasket::validateBasket($this->getRequestParameter('id'), $this->getUser()));

        $basket->deleteBasket($this->getRequestParameter('id'));

        return $this->redirect('@stBasket');
    }

    /**
     * Zdejmuje produkt z koszyka
     */
    public function executeRemove() {
        $basket = stBasket::getInstance($this->getUser());

        $basket->removeItem($this->getRequestParameter('product_id'));  

        $basket->save();

        return $this->redirect($this->getRequest()->getReferer());
    }

    public function validateAjaxAddProduct() {
        return $this->validateAddReferer();
    }

    /**
     * Weryfikuje poprawność wprowadzanych danych dla akcji SetProduct
     *
     * @return   bool
     */
    public function validateSetProduct() {
        $error_exists = false;

        $i18n = $this->getContext()->getI18N();

        if ($this->hasRequestParameter('product_id')) {
            sfLoader::loadHelpers(array('Helper', 'stProduct'), 'stProduct');

            $id = $this->getRequestParameter('product_id');

            $basket = stBasket::getInstance($this->getUser());

            $item = $basket->getItem($id);

            $quantity = $this->getRequestParameter('quantity', 1);

            $product = ProductPeer::retrieveByPK($id);

            $uom = st_product_uom($item->getProduct());

            $request = $this->getRequest();

            if (!$this->validateQuantity($quantity, $error, $item->getProductStockInDecimals())) {
                $this->getRequest()->setError('basket{products}{' . $id . '}', $error);

                $this->getRequest()->setParameter('basket[products][' . $id . ']', $quantity);

                $error_exists = true;
            } else {
                $item = $basket->updateItem($id, $quantity, $error);

                if ($item->getQuantity() > 0) {
                    
                    stPoints::refreshLoginStatusPoints();
                    
                    $basket->save();
                }

                if ($error == stBasket::ERR_MAX_QTY) {
                    $request->setError('basket{products}{' . $item->getItemId() . '}', $i18n->__('Maksymalna ilość jaką możesz zamówić w ramach jednego zamówienia to %quantity% %uom%', array('%quantity%' => $item->getProductMaxQty(), '%uom%' => $uom)));

                    $error_exists = true;
                }
                elseif ($error == stBasket::ERR_OUT_OF_STOCK) {
                    $request->setError('basket{products}{' . $item->getItemId() . '}', $i18n->__('Brak wymaganej ilości towaru w magazynie (dostępnych: %stock% %uom%)', array('%stock%' => $item->getMaxQuantity(), '%uom%' => $uom)));

                    $error_exists = true;
                } elseif ($error == stBasket::ERR_MIN_QTY) {
                    $request->setError('basket{products}{' . $item->getItemId() . '}', $i18n->__('Minimalna ilość to %quantity% %uom%', array('%quantity%' => $item->getProductMinQty(), '%uom%' => $uom)));

                    $error_exists = true;
                 } elseif ($error == stBasket::ERR_POINTS) {
                    $request->setError('basket{products}{' . $item->getItemId() . '}', $i18n->__('Brak wymaganej ilości punktów'));

                    $error_exists = true;
                }
            }
        }

        $this->getUser()->setAttribute('is_blocked', $error_exists, stBasket::SESSION_NAMESPACE);

        return false == $error_exists;
    }

    /**
     * Weryfikuje poprawność wprowadzanych danych dla akcji addReferer
     *
     * @return   bool
     */
    public function validateAddReferer() {
        $error_exists = false;

        $request = $this->getRequest();

        if ($request->hasParameter('product_id') && ($request->getMethod() == sfRequest::GET || $request->getMethod() == sfRequest::POST)) {

            $product_id = $this->getRequestParameter('product_id');

            $quantity = $this->getRequestParameter('quantity', 1);

            $product = ProductPeer::retrieveByPK($product_id);

            $basket = stBasket::getInstance($this->getUser());

            $error = null;

            $i18n = $this->getContext()->getI18N();

            sfLoader::loadHelpers(array('Helper', 'stProduct'), 'stProduct');

            $uom = st_product_uom($product);

            if (!$this->validateQuantity($quantity, $error, $product ? $product->getStockInDecimals() : false)) {
                $item = $basket->addItem($product_id, 0);

                $item->setItemId($product_id);

                $request->setError('basket{products}{' . $product_id . '}', $error);

                $request->setParameter('basket[products][' . $product_id . ']', $quantity);

                $error_exists = true;
            } else {
                $item = $basket->addItem($product_id, $quantity, $error, $request->isXmlHttpRequest());

                if ($error == stBasket::ERR_MAX_QTY) {
                    $request->setError('basket{products}{' . $item->getItemId() . '}', $i18n->__('Maksymalna ilość jaką możesz zamówić w ramach jednego zamówienia to %quantity% %uom%', array('%quantity%' => $item->getProductMaxQty(), '%uom%' => $uom)));

                    $error_exists = true;
                }
                elseif ($error == stBasket::ERR_OUT_OF_STOCK) {
                    $request->setError('basket{products}{' . $item->getItemId() . '}', $i18n->__('Brak wymaganej ilości towaru w magazynie (dostępnych: %stock% %uom%)', array('%stock%' => $item->getMaxQuantity(), '%uom%' => $uom)));

                    $error_exists = true;
                } elseif ($error == stBasket::ERR_MIN_QTY) {
                    $request->setError('basket{products}{' . $item->getItemId() . '}', $i18n->__('Minimalna ilość to %quantity% %uom%', array('%quantity%' => $item->getProductMinQty(), '%uom%' => $uom)));

                    $error_exists = true;
                 } elseif ($error == stBasket::ERR_POINTS) {
                    $request->setError('basket{products}{' . $item->getItemId() . '}', $i18n->__('Brak wymaganej ilości punktów'));

                    $error_exists = true;
                }
            }

            
            stPoints::refreshLoginStatusPoints();

            if (!(stConfig::getInstance('stBasket')->get('ajax') && $request->isXmlHttpRequest()) || $item->getQuantity() > 0)
            {
                $basket->save();
            }
        }

        $this->getUser()->setAttribute('is_blocked', $error_exists, stBasket::SESSION_NAMESPACE);

        return false == $error_exists;
    }

    /**
     * Weryfikuje poprawność wprowadzanych danych dla akcji index
     *
     * @return   bool
     */
    public function validateIndex() {                
        $error_exists = false;

        $themeVersion = sfContext::getInstance()->getController()->getTheme()->getVersion();

        $basket = stBasket::getInstance($this->getUser());

        if ($this->getRequestParameter('submit_save'))
        {
            $basket->refresh();
            $basket->save();
        }        

        $request = $this->getRequest();

        $i18n = $this->getContext()->getI18N();

        $product_config = stConfig::getInstance('stProduct');

        $this->config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');

        $this->config_points->setCulture(sfContext::getInstance()->getUser()->getCulture());
        
        stPoints::refreshLoginStatusPoints();

        sfLoader::loadHelpers(array('Helper', 'stProduct'), 'stProduct');

        if ($request->getMethod() == sfRequest::POST && !$request->getParameter('submit_save')) {

            $products = $this->getRequestParameter('basket[products]', array());

            $vat_eu = $this->getRequestParameter('basket[vat_eu]');

            $this->getUser()->setVatEu($vat_eu);

            $error_exists = false;

            foreach ($products as $id => $value) {
                $item = $basket->getItem($id);

                $uom = st_product_uom($item->getProduct());

                $item->updateVatEu();

                if ($item && (!$item->productValidate() || $product_config->get('show_without_price') && !$item->getIsGift() && $item->getPrice() == 0 && (($item->getProduct()->getPointsOnly()!=1) && ($themeVersion < 7)))) {
                    $request->setParameter('basket[products][' . $id . ']', $value);

                    $request->setError('basket{products}{' . $id . '}', $i18n->__('Product wycofany z oferty'));

                    $error_exists = true;
                } elseif (!$this->validateQuantity($value, $error, $item->getProductStockInDecimals())) {
                    $error_exists = true;

                    $basket->addItem($id, 0);

                    $request->setError('basket{products}{' . $id . '}', $error);

                    $request->setParameter('basket[products][' . $id . ']', $value);
                } else {
                    
                    $item = $basket->updateItem($id, $value, $error);

                    if (!$item) {
                        $item = $basket->addItem($id, $value, $error);
                    }

                    if ($error == stBasket::ERR_MAX_QTY) {
                        $request->setError('basket{products}{' . $item->getItemId() . '}', $i18n->__('Maksymalna ilość jaką możesz zamówić w ramach jednego zamówienia to %quantity% %uom%', array('%quantity%' => $item->getProductMaxQty(), '%uom%' => $uom)));
    
                        $error_exists = true;
                    }
                    elseif ($error == stBasket::ERR_OUT_OF_STOCK) {
                        $request->setError('basket{products}{' . $item->getItemId() . '}', $i18n->__('Brak wymaganej ilości towaru w magazynie (dostępnych: %stock% %uom%)', array('%stock%' => $item->getMaxQuantity(), '%uom%' => $uom)));
    
                        $error_exists = true;
                    } elseif ($error == stBasket::ERR_MIN_QTY) {
                        $request->setError('basket{products}{' . $item->getItemId() . '}', $i18n->__('Minimalna ilość to %quantity% %uom%', array('%quantity%' => $item->getProductMinQty(), '%uom%' => $uom)));
    
                        $error_exists = true;
                     } elseif ($error == stBasket::ERR_POINTS) {
                        $request->setError('basket{products}{' . $item->getItemId() . '}', $i18n->__('Brak wymaganej ilości punktów'));
    
                        $error_exists = true;
                    }
                    
                 
                }
            }

            if (!$error_exists) {
                
                $basket->save();
            }
        } else {
            
            foreach ($basket->getItems() as $item) {    
                $uom = st_product_uom($item->getProduct());
                $error = $basket->validateQuantity($item);

                if (!$item->productValidate() || $product_config->get('show_without_price') && !$item->getIsGift() && $item->getPrice() == 0 && (($item->getProduct()->getPointsOnly()!=1) && ($themeVersion < 7))) {
                    $request->setParameter('basket[products][' . $item->getItemId() . ']', $item->getQuantity());

                    $request->setError('basket{products}{' . $item->getItemId() . '}', $i18n->__('Produkt wycofany z oferty'));

                    $error_exists = true;
                } elseif ($error == stBasket::ERR_MAX_QTY) {
                    $request->setError('basket{products}{' . $item->getItemId() . '}', $i18n->__('Maksymalna ilość jaką możesz zamówić w ramach jednego zamówienia to %quantity% %uom%', array('%quantity%' => $item->getProductMaxQty(), '%uom%' => $uom)));

                    $error_exists = true;
                }
                elseif ($error == stBasket::ERR_OUT_OF_STOCK) {
                    $request->setError('basket{products}{' . $item->getItemId() . '}', $i18n->__('Brak wymaganej ilości towaru w magazynie (dostępnych: %stock% %uom%)', array('%stock%' => $item->getMaxQuantity(), '%uom%' => $uom)));

                    $error_exists = true;
                } elseif ($error == stBasket::ERR_MIN_QTY) {
                    $request->setError('basket{products}{' . $item->getItemId() . '}', $i18n->__('Minimalna ilość to %quantity% %uom%', array('%quantity%' => $item->getProductMinQty(), '%uom%' => $uom)));

                    $error_exists = true;
                } elseif ($error == stBasket::ERR_POINTS) {
                    $request->setError('basket{products}{' . $item->getItemId() . '}', $i18n->__('Brak wymaganej ilości punktów'));

                    $error_exists = true;
                }            
            }
        }

        foreach (stGiftCardPlugin::get() as $giftCard)
        {
            if (!stGiftCardPlugin::hasValidBasketProducts($giftCard, $invalidItemIds))
            {
                foreach ($invalidItemIds as $id)
                {
                    $this->getRequest()->setError('basket{products}{' . $id . '}', $this->getContext()->getI18N()->__('Usuń produkt z koszyka, aby zrealizować zamówienie z aktualnym bonem zakupowym', null, 'stGiftCardFrontend'));
                }

                $error_exists = true;
            }
            elseif (!$giftCard->isValidOrderAmount($this->getUser()->getBasket()->getTotalAmount(true, true)))
            {
                $error_exists = true;
            }
        }
        
        $this->getUser()->setAttribute('is_blocked', $error_exists, stBasket::SESSION_NAMESPACE);

        return false == $error_exists;
    }

    /**
     * Czysci koszyk
     */
    public function executeClear() {
        stBasket::getInstance($this->getUser())->clearItems();

        return $this->redirect('@stBasket');
    }

    public function handleErrorSetProduct() {
        $this->smarty = new stSmarty($this->getModuleName());

        $this->basket = stBasket::getInstance($this->getUser());

        $this->delivery = stDeliveryFrontend::getInstance($this->basket);

        $this->referer = $this->getReferer();

        $this->basket_config = stConfig::getInstance('stBasket');
        $this->config_points = stConfig::getInstance('stPointsBackend');

        $this->setTemplate('index');

        return sfView::SUCCESS;
    }

    /**
     * Obsługa błędu w akcji index
     *
     * @return   sfView
     */
    public function handleErrorIndex() {
        $this->smarty = new stSmarty($this->getModuleName());

        $this->basket = stBasket::getInstance($this->getUser());

        $this->delivery = stDeliveryFrontend::getInstance($this->basket);

        $this->referer = $this->getReferer();

        $this->basket_config = stConfig::getInstance('stBasket');
        $this->config_points = stConfig::getInstance('stPointsBackend');

        $this->checkMinOrderAmount();

        return sfView::SUCCESS;
    }

    /**
     * Obsługa błędu w akcji addReferer
     */
    public function handleErrorAddReferer() {
        $request = $this->getRequest();

        stFastCacheController::disable();

        if (stConfig::getInstance('stBasket')->get('ajax') && $request->isXmlHttpRequest()) {
            $result = $this->getRenderComponent('stBasket', 'ajaxAddedProductPreview');

            return $this->renderText($result);
        } else {
            $this->remmemberRerefer();

            $this->smarty = new stSmarty($this->getModuleName());

            $this->basket = stBasket::getInstance($this->getUser());

            $this->delivery = stDeliveryFrontend::getInstance($this->basket);

            $this->referer = $this->getReferer();

            $this->basket_config = stConfig::getInstance('stBasket');
            $this->config_points = stConfig::getInstance('stPointsBackend');

            $this->setTemplate('index');

            $this->checkMinOrderAmount();

            return sfView::SUCCESS;
        }
    }

    /**
     * Zapamiętuje poprzednia strone
     */
    protected function remmemberRerefer() {
        $referer = $this->getRequest()->getReferer();

        // chcemy zapamiętywać wyłącznie strony z produktami lub wywołano akcje 'addReferer'
        if (strpos($referer, '/basket') === false && (strpos($referer, '/product/') !== false || $this->getActionName() == 'addReferer' || $referer == '/')) {
            $this->getUser()->setAttribute('referer', $referer, stBasket::SESSION_NAMESPACE);
        }
    }

    /**
     * Zwraca poprzednia stronevalidateQuantity
     *
     * @return   string
     */
    protected function getReferer() {
        $referer = $this->getUser()->getAttribute('referer', null, stBasket::SESSION_NAMESPACE);

        return $referer ? $referer : $this->getController()->genUrl('@homepage');
    }

    protected function validateQuantity($quantity, &$error, $allow_decimals = false) {
        $validator = new sfNumberValidator();

        $i18n = $this->getContext()->getI18n();

        $nan_error = $allow_decimals ? $i18n->__('Podana wartość musi być liczbą...') : $i18n->__('Podana wartość musi być liczbą całkowitą...');

        $validator->initialize($this->getContext(), array('nan_error' => $nan_error, 'type_error' => $nan_error, 'min' => $allow_decimals ? 0.01 : 1, 'min_error' => $i18n->__('Podana wartość musi być większa od 0.'), 'type' => $allow_decimals ? 'any' : 'integer'));

        $ret = $validator->execute($quantity, $error);

        if (!$error)
        {
            $error = false;
        }

        return $ret;
    }

    protected function checkMinOrderAmount() {
        $config = stConfig::getInstance($this->getContext(), 'stOrder');

        $min_amount = $config->get('min_amount', 0);

        if ($min_amount > 0 && !$this->basket->isEmpty() && $min_amount > $this->basket->getTotalAmount(true)) {

            sfLoader::loadHelpers(array('Helper', 'stCurrency'));

            $this->getUser()->setAttribute('is_blocked', true, stBasket::SESSION_NAMESPACE);

            $this->setFlash('warning', $this->getContext()->getI18N()->__('Minimalna wartość zamówienia wynosi %min_amount%', array('%min_amount%' => st_price($min_amount, true, true)), 'stOrder'), false);
        } elseif (!$this->getRequest()->hasErrors()) {
            $this->getUser()->setAttribute('is_blocked', false, stBasket::SESSION_NAMESPACE);
        }
    }

    /**
     * Indeks koszyka
     */
    public function executePayByPoints() {

        $basket = $this->getUser()->getBasket();

        $item = $basket->getItem($this->getRequestParameter('item_id'));
        if ($item) {
            if (!$this->hasRequestParameter('clear')) {
                
                if(!$item->getProductForPoints()){
                    if ($item->getProduct()->getPointsValue() > 0){
                    
                     stPoints::addItemByPoints($item->getItemId());
                     $item->setProductForPoints(true);
                     $basket->save();
                        
                    }
                }
                
            } else {
                if($item->getProductForPoints()){
                    
                stPoints::removeItemByPoints($item->getItemId());
                $basket->refresh($item->getItemId());
                $item->setProductForPoints(false);
                $basket->save();
                
                }
            }
            
            
            $basket->clearProductTotals();
            
        }

        return $this->redirect('@stBasket');
    }

}
