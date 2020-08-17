<?php
/**
 * SOTESHOP/stPriceCompare
 *
 * Ten plik należy do aplikacji stPriceCompare opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPriceCompare
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stPriceCompareListener.class.php 8244 2010-09-09 14:32:00Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa słuchacza stPriceCompareListener
 *
 * @package     stPriceCompare
 * @subpackage  libs
 */
class stPriceCompareListener
{
    /**
     * Funkcja generate przeciążająca generator modułu stProduct
     *
     * @param sfEvent $event
     */
    public static function generate(sfEvent $event)
    {
        $event->getSubject()->attachAdminGeneratorFile('stPriceCompare', 'stPriceComparePluginInProduct.yml');
    }


    /**
     * Funkcja generate przeciążająca generator pluginu stCeneoPlugin
     *
     * @param sfEvent $event
     */
    public static function generateStCeneoBackend(sfEvent $event)
    {

        $generator = $event->getSubject();

        $generator->insertParameterBefore('list.menu.display[list]', 'st_product_compare');

        $generator->setValueForParameter('list.menu.fields.st_product_compare', array(
            'name' => 'Porównywarki cen',
            'action' => '@stPriceCompareDefault',
            'i18n_catalogue' => 'stPriceCompare'
        ));  

    }

    /**
     * Funkcja generate przeciążająca generator pluginu stNokautPlugin
     *
     * @param sfEvent $event
     */
    public static function generateStNokautBackend(sfEvent $event)
    {

        $generator = $event->getSubject();

        $generator->insertParameterBefore('list.menu.display[list]', 'st_product_compare');

        $generator->setValueForParameter('list.menu.fields.st_product_compare', array(
            'name' => 'Porównywarki cen',
            'action' => '@stPriceCompareDefault',
            'i18n_catalogue' => 'stPriceCompare'
        ));  

    }


    /**
     * Funkcja generate przeciążająca generator pluginu stOkazjePlugin
     *
     * @param sfEvent $event
     */
    public static function generateStOkazjeBackend(sfEvent $event)
    {

        $generator = $event->getSubject();

        $generator->insertParameterBefore('list.menu.display[list]', 'st_product_compare');

        $generator->setValueForParameter('list.menu.fields.st_product_compare', array(
            'name' => 'Porównywarki cen',
            'action' => '@stPriceCompareDefault',
            'i18n_catalogue' => 'stPriceCompare'
        ));  

    }

    /**
     * Funkcja generate przeciążająca generator pluginu stRadarPlugin
     *
     * @param sfEvent $event
     */
    public static function generateStRadarBackend(sfEvent $event)
    {

        $generator = $event->getSubject();

        $generator->insertParameterBefore('list.menu.display[list]', 'st_product_compare');

        $generator->setValueForParameter('list.menu.fields.st_product_compare', array(
            'name' => 'Porównywarki cen',
            'action' => '@stPriceCompareDefault',
            'i18n_catalogue' => 'stPriceCompare'
        ));  

    }

    /**
     * Funkcja generate przeciążająca generator pluginu stSkapiecPlugin
     *
     * @param sfEvent $event
     */
    public static function generateStSkapiecBackend(sfEvent $event)
    {

        $generator = $event->getSubject();

        $generator->insertParameterBefore('list.menu.display[list]', 'st_product_compare');

        $generator->setValueForParameter('list.menu.fields.st_product_compare', array(
            'name' => 'Porównywarki cen',
            'action' => '@stPriceCompareDefault',
            'i18n_catalogue' => 'stPriceCompare'
        ));  

    }

    /**
     * Funkcja generate przeciążająca generator pluginu stSklepy24Plugin
     *
     * @param sfEvent $event
     */
    public static function generateStSklepy24Backend(sfEvent $event)
    {

        $generator = $event->getSubject();

        $generator->insertParameterBefore('list.menu.display[list]', 'st_product_compare');

        $generator->setValueForParameter('list.menu.fields.st_product_compare', array(
            'name' => 'Porównywarki cen',
            'action' => '@stPriceCompareDefault',
            'i18n_catalogue' => 'stPriceCompare'
        ));  

    }


    /**
     * Funkcja przeciaża zapisywania zamówienia
     *
     * @param sfEvent $event
     */
    public static function filterOrderSave(sfEvent $event)
    {
        if ($event->getSubject()->getUser()->hasAttribute('name', stPriceCompare::SESSION_NAMESPACE))
        {
            $event['order']->setOrderType($event->getSubject()->getUser()->getAttribute('name', null, stPriceCompare::SESSION_NAMESPACE));
        }
    }
}