<?php
/**
 * SOTESHOP/stNavigationPlugin
 *
 * Ten plik należy do aplikacji stNavigationPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package stNavigationPlugin
 * @subpackage libs
 * @copyright SOTE (www.sote.pl)
 * @license http://www.sote.pl/license/sote (Professional License SOTE)
 * @version $Id: stNavigationListener.class.php 17362 2012-03-07 14:20:17Z piotr $
 * @author Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stNavigationListener
 *
 * @package stNavigationPlugin
 * @subpackage libs
 */
class stNavigationListener
{
    /**
     * Dodanie ścieżki do karty produktu
     *
     * @param $event sfEvent
     */
    public static function addProductShow(sfEvent $event)
    {
        $stNavigation = stNavigation::getInstance($event->getSubject()->getContext());
        $stNavigation->addProduct($event->getSubject()->product);
        $stNavigation->addLastViewedProduct($event->getSubject()->product);
    }

    /**
     * Dodanie ścieżki do listy produktów
     *
     * @param $event sfEvent
     */
    public static function addProductList(sfEvent $event)
    {
        if($event->getSubject()->category)
        {
            stNavigation::getInstance($event->getSubject()->getContext())->addCategory($event->getSubject()->category);
        }
    }

    /**
     * Dodanie ścieżki do stron www
     *
     * @param $event sfEvent
     */
    public static function addWebpageIndex(sfEvent $event)
    {
        $webpage = $event->getSubject()->webpage;
        stNavigation::getInstance($event->getSubject()->getContext())->addNavigationPathElement($webpage->getName(), 'stWebpageFrontend/index?url='.$webpage->getFriendlyUrl(), true);
    }

    /**
     * Dodanie ścieżki do wyszukiwania
     *
     * @param $event sfEvent
     */
    public static function addSearchSearch(sfEvent $event)
    {
        if (!empty($event->getSubject()->what))
        {
            stNavigation::getInstance($event->getSubject()->getContext())->addNavigationPathElement($event->getSubject()->getContext()->getI18n()->__('Szukaj', array(), 'stNavigationFrontend'), 'search');
            stNavigation::getInstance($event->getSubject()->getContext())->addNavigationPathElement(htmlspecialchars(htmlspecialchars_decode($event->getSubject()->what)), false, true);
        } else {
            stNavigation::getInstance($event->getSubject()->getContext())->addNavigationPathElement($event->getSubject()->getContext()->getI18n()->__('Szukaj', array(), 'stNavigationFrontend'), false, true);
        }
    }

    /**
     * Dodanie ścieżki do koszyka
     *
     * @param $event sfEvent
     */
    public static function addBasketIndex(sfEvent $event)
    {
        $stNavigation = stNavigation::getInstance($event->getSubject()->getContext());
        $stNavigation->addNavigationPathElement($event->getSubject()->getContext()->getI18n()->__('Koszyk', null, 'stNavigationFrontend'), false, true);

        if ($event->getSubject()->basket->hasItems())
        {
            $stNavigation->addNavigationPathElement($event->getSubject()->getContext()->getI18n()->__('Potwierdzenie zamówienia', null, 'stNavigationFrontend'), false);
            $stNavigation->addNavigationPathElement($event->getSubject()->getContext()->getI18n()->__('Podsumowanie zamówienia', null, 'stNavigationFrontend'), false);
        }
    }

    /**
     * Dodanie ścieżki do potwierdzenia zamówienia
     *
     * @param $event sfEvent
     */
    public static function addOrderConfirm(sfEvent $event)
    {
        $stNavigation = stNavigation::getInstance($event->getSubject()->getContext());
        $stNavigation->addNavigationPathElement($event->getSubject()->getContext()->getI18n()->__('Koszyk', null, 'stNavigationFrontend'), false);
        $stNavigation->addNavigationPathElement($event->getSubject()->getContext()->getI18n()->__('Potwierdzenie zamówienia', null, 'stNavigationFrontend'), false, true);
        $stNavigation->addNavigationPathElement($event->getSubject()->getContext()->getI18n()->__('Podsumowanie zamówienia', null, 'stNavigationFrontend'), false);
        
        if (stDeliveryFrontend::getInstance($event->getSubject()->basket)->getDefaultDelivery()->getDefaultPayment()->getPaymentType()->getModuleName() != 'stStandardPayment') {
            $stNavigation->addNavigationPathElement($event->getSubject()->getContext()->getI18n()->__('Płatność', null, 'stNavigationFrontend'), false);
        }
    }

    /**
     * Dodanie ścieżki do podsumowania zamówienia
     *
     * @param $event sfEvent
     */
    public static function addOrderSummary(sfEvent $event)
    {
        $stNavigation = stNavigation::getInstance($event->getSubject()->getContext());
        $stNavigation->addNavigationPathElement($event->getSubject()->getContext()->getI18n()->__('Koszyk', null, 'stNavigationFrontend'), false);
        $stNavigation->addNavigationPathElement($event->getSubject()->getContext()->getI18n()->__('Potwierdzenie zamówienia', null, 'stNavigationFrontend'), false);
        $stNavigation->addNavigationPathElement($event->getSubject()->getContext()->getI18n()->__('Podsumowanie zamówienia', null, 'stNavigationFrontend'), false, true);
        
        if (stPayment::hasPaymentToShow($event->getSubject()->id)) {
            $stNavigation->addNavigationPathElement($event->getSubject()->getContext()->getI18n()->__('Płatność', null, 'stNavigationFrontend'), false);
        }
    }
    
    /**
    * Dodanie ścieżki do płatności
    *
    * @param $event sfEvent
    */
    public static function addPaymentPay(sfEvent $event)
    {
        $stNavigation = stNavigation::getInstance($event->getSubject()->getContext());
        $stNavigation->addNavigationPathElement($event->getSubject()->getContext()->getI18n()->__('Koszyk', null, 'stNavigationFrontend'), false);
        $stNavigation->addNavigationPathElement($event->getSubject()->getContext()->getI18n()->__('Potwierdzenie zamówienia', null, 'stNavigationFrontend'), false);
        $stNavigation->addNavigationPathElement($event->getSubject()->getContext()->getI18n()->__('Podsumowanie zamówienia', null, 'stNavigationFrontend'), false);
        $stNavigation->addNavigationPathElement($event->getSubject()->getContext()->getI18n()->__('Płatność', null, 'stNavigationFrontend'), false, true);
    }

    /**
     * Dodanie ścieżki do wybranego producenta
     *
     * @param sfEvent $event
     */
    public static function addProducerList(sfEvent $event)
    {
        $stNavigation = stNavigation::getInstance($event->getSubject()->getContext());
        $producer = $event->getSubject()->producer;
        if ($producer)
        {
            stNavigation::getInstance($event->getSubject()->getContext())->addProducer($producer);
        }
    }

    /**
     * Dodanie ścieżki do wybranej grupy produktów
     *
     * @param sfEvent $event
     */
    public static function addGroupList(sfEvent $event)
    {
        $stNavigation = stNavigation::getInstance($event->getSubject()->getContext());
        $product_group = $event->getSubject()->product_group;
        if ($product_group)
        {
            stNavigation::getInstance($event->getSubject()->getContext())->addGroup($product_group);
        }
    }
}
