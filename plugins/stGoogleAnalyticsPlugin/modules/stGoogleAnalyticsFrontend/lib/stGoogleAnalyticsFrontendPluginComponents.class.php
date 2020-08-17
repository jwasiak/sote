<?php
/** 
 * SOTESHOP/stGoogleAnalyticsPlugin
 *
 * Ten plik należy do aplikacji stDelivery opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stGoogleAnalyticsPlugin
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stGoogleAnalyticsFrontendPluginComponents.class.php 1637 2009-06-08 13:13:29Z krzysiek $
 */

/**
 * Akcje stGoogleAnalyticsFrontend
 *
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>, Paweł Byszewski <pawel.byszewski@sote.pl>,
 * @package     stGoogleAnalyticsPlugin
 */
class stGoogleAnalyticsFrontendPluginComponents extends sfComponents
{
    /**
     * Włącza google analytics w sklepie, jeśli konfiguracja na to pozwala
     */
    public function executeStandard()
    {

        $config = stConfig::getInstance(sfContext::getInstance(), 'stGoogleAnalyticsBackend');

        if ($config->get('analytics')!= 1)
        {
            return sfView::NONE;
        }
        
        // standard

        $this->analytics_part2 = $config->get('analytics_part2');
        
        $this->analytics_part3 = $config->get('analytics_part3');
        
        $this->analytics = $config->get('analytics');
        
        $this->ecommerce = $config->get('ecommerce');

        if ($this->ecommerce &&  ((sfContext::getInstance()->getActionName()=='summary') && (sfContext::getInstance()->getModuleName()=='stOrder'))){

            // ecommerce

            if ($this->hasFlash('send_analytics'))
            {
                $this->ecommerce_check = 1;
            }

            $google_shopping_config = stConfig::getInstance(sfContext::getInstance(), 'stGoogleShoppingBackend');

            $this->type_id = $google_shopping_config->get('type_id');

            $this->order = sfContext::getInstance()->getActionStack()->getLastEntry()->getActionInstance()->order;

            $this->host = $this->getRequest()->getHost();

            $this->order_delivery = OrderDeliveryPeer::retrieveByPK($this->order->getOrderDeliveryId());

            $user_id = $this->order->getSfGuardUserId();
        
            $c = new Criteria();
            
            $c->add(UserDataPeer::SF_GUARD_USER_ID, $user_id);
        
            $this->user = UserDataPeer::doSelectOne($c);
        
            $country_id = $this->user->getCountriesId();

            $this->country_name = CountriesPeer::retrieveByPK($country_id);

        }

        $this->smarty = new stSmarty('stGoogleAnalyticsFrontend');
    }

    /*
    ** Old E-commerce 
    */
    public function executeEcommerce()
    {
        return sfView::NONE;
    }

}