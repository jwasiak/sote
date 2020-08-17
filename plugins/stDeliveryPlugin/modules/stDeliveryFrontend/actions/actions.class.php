<?php
/** 
 * SOTESHOP/stDelivery 
 * 
 * Ten plik należy do aplikacji stDelivery opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stDeliveryPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 312 2009-09-04 14:28:53Z marcin $
 */

/** 
 * Akcje komponentu produktu
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stDeliveryPlugin
 * @subpackage  actions
 */
class stDeliveryFrontendActions extends stActions 
{
    /**
     * Aktualizowanie dostawy za pomocą Ajax
     */
    public function executeAjaxDeliveryCountryUpdate()
    {
        $this->check404();

        $basket = stBasket::getInstance($this->getUser());

        $delivery = stDeliveryFrontend::getInstance($basket);

        // $delivery->clearSession();

        $country_id = $this->getRequestParameter('id', $this->getRequestParameter('delivery[country]'));

        $delivery->setDefaultDeliveryCountry($country_id);

        $this->getUser()->setVatEx(stTax::hasEx($this->getRequestParameter('billing_country')));

        foreach ($basket->getItems() as $item)
        {
            $item->updateVatEu();
        }       

        $basket->clearProductTotals(); 

        $basket_params = array('basket' => $basket, 'basket_config' => stConfig::getInstance('stBasket'), 'config_points' => stConfig::getInstance('stPointsBackend'));

        if ($this->getTheme()->getVersion() < 7)
        {
            $this->responseUpdateElement('basket_products_table', array('module' => 'stBasket', 'partial' => 'product_list', 'params' => $basket_params));
            $this->responseUpdateElement('st_basket-delivery', array('module' => 'stDeliveryFrontend','component'=> 'basketDeliveryList', 'params' => $basket_params));
            $this->responseUpdateElement('st_basket-payment', array('module' => 'stDeliveryFrontend','component'=> 'basketPaymentList', 'params' => $basket_params));
            $this->responseUpdateElement('st_basket-summary', array('module' => 'stDeliveryFrontend','component'=> 'basketSummary', 'params' => $basket_params));
        }
        else
        {
            $this->responseUpdateElement('#shopping-cart .items', array('module' => 'stBasket', 'partial' => 'product_list', 'params' => $basket_params));
            $this->responseUpdateElement('shopping-cart-delivery', array('module' => 'stDeliveryFrontend','component'=> 'basketDeliveryList', 'params' => $basket_params));
            $this->responseUpdateElement('shopping-cart-payment', array('module' => 'stDeliveryFrontend','component'=> 'basketPaymentList', 'params' => $basket_params));
            $this->responseUpdateElement('shopping-cart-summary', array('module' => 'stDeliveryFrontend','component'=> 'basketSummary', 'params' => $basket_params));    
            $this->responseEvalJs('jQuery(window).resize()');        
        }

        if ($this->getUser()->isAnonymous()) 
        {
           $this->responseEvalJs("stUser.updateAnonymousForms($country_id)");
        }
        else
        {
           $this->responseEvalJs("stUser.updateAnonymousForms($country_id)");

           $this->responseUpdateElement('user_delivery_profile_container', array('module' => 'stUserData', 'component' => 'profileList', 'params' => array(
               'country_id' => $country_id, 
               'type' => 'delivery', 
               'selected' => false
           )));           
        }

        return $this->renderResponse();
    }

    /** 
     * Aktualizowanie dostawy za pomocą Ajax
     */
    public function executeAjaxDeliveryUpdate()
    {
        $this->check404();

        $basket = stBasket::getInstance($this->getUser());

        $delivery = stDeliveryFrontend::getInstance($basket);

        // $delivery->clearSession();

        $delivery->setDefaultDelivery($this->getRequestParameter('id', $this->getRequestParameter('delivery[default_delivery]')));

        $basket_params = array('basket' => $basket);

        if ($this->getTheme()->getVersion() < 7)
        {
            $this->responseUpdateElement('st_basket-payment', array('module' => 'stDeliveryFrontend','component'=> 'basketPaymentList', 'params' => $basket_params));
            $this->responseUpdateElement('st_basket-summary', array('module' => 'stDeliveryFrontend','component'=> 'basketSummary', 'params' => $basket_params));
        }
        else
        {
            $this->responseUpdateElement('shopping-cart-payment', array('module' => 'stDeliveryFrontend','component'=> 'basketPaymentList', 'params' => $basket_params));
            $this->responseUpdateElement('shopping-cart-summary', array('module' => 'stDeliveryFrontend','component'=> 'basketSummary', 'params' => $basket_params)); 
            $this->responseEvalJs('jQuery(window).resize()');                       
        }
        return $this->renderResponse();
    }

    public function executeAjaxPaymentUpdate()
    {
        $this->check404();

        $basket = stBasket::getInstance($this->getUser());

        $delivery = stDeliveryFrontend::getInstance($basket);

        $delivery->getDefaultDelivery()->setDefaultPayment($this->getRequestParameter('id', $this->getRequestParameter('delivery[default_payment]')));
        
        $basket_params = array('basket' => $basket);

        if ($this->getTheme()->getVersion() < 7)
        {
            $this->responseUpdateElement('st_basket-summary', array('module' => 'stDeliveryFrontend','component'=> 'basketSummary', 'params' => $basket_params));
        }
        else 
        {
            $this->responseUpdateElement('shopping-cart-summary', array('module' => 'stDeliveryFrontend','component'=> 'basketSummary', 'params' => $basket_params));   
            $this->responseEvalJs('jQuery(window).resize()');                                 
        }   
        return $this->renderResponse();
    }

    public function check404(){

        if(!$this->getRequest()->isXmlHttpRequest() && $this->getController()->getRenderMode() != sfView::RENDER_VAR){  

        $this->getResponse()->setStatusCode(404);

        $this->getResponse()->setHttpHeader('Status', '404 Not Found');

        sfContext::getInstance()->getResponse()->addMeta('robots', "noindex");

        return $this->forward('stErrorFrontend', 'error404');
     }


    }  
}