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
 * @version     $Id: stPriceComare.class.php 8244 2010-09-09 14:32:00Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stPriceCompare
 *
 * @package    stPriceCompare
 * @subpackage libs
 */
class stPriceCompare
{
    const SESSION_NAMESPACE = 'soteshop/price_compare';
    
    /**
     * Dodanie modułu do menu porównywarek cen
     *
     * @param $module string nazwa modułu
     */
    public static function addToMenu($module)
    {
        stPluginHelper::addConfigValue('stPriceCompare', $module, array('name' => '', 'peerName'=> ''));
    }

    /**
     * Dodanie porównywarki cen
     *
     * @param $module string moduł porównywarki 
     * @param $name string nazwa porównywarki
     */
    public static function add($module, $name)
    {
        stPluginHelper::addConfigValue('stPriceCompare', $module, array('name' => $name, 'peerName'=> $name."Peer"));
    }

    /**
     * Pobieranie porównywarek
     * @return array lista porównywarek w tablicy
     */
    public static function getPriceCompares()
    {
        return stPluginHelper::getConfigValue('stPriceCompare');
    }

    /**
     * Tworzenie listy menu dla porównywarek cen
     */
    public static function generatePriceComparesMenu()
    {
        $priceCompares = stPriceCompare::getPriceCompares();

        foreach ($priceCompares as $key => $priceCompare)
        {
            $priceCompareHeadApplicationsArray = array();

            foreach ($priceCompares as $key_2 => $priceCompare_2)
            {
                if ($key != $key_2) $priceCompareHeadApplicationsArray[] = $key_2;
            }

            stMenuModifier::addHeadApplications($key, $priceCompareHeadApplicationsArray);
        }
    }

    /**
     * Inicjalizacja porównywarki cen
     *
     * @param $priceCompareName nazwa porównywarki
     */
    public static function initPriceCompare($priceCompareName, $isOpen = false)
    {
        $priceCompareName = ucfirst($priceCompareName);
        $routingName = strtolower($priceCompareName);

        if (SF_APP == 'backend')
        {
            /**
             * Dodawanie inforacji o nowym module, który jest porównywarką cen 
             */
            stPluginHelper::addConfigValue('stPriceCompare', 'st'.$priceCompareName.'Plugin', array('name' => $priceCompareName, 'peerName'=> $priceCompareName."Peer"));

            /**
             * Włączanie modułów
             */
            stPluginHelper::addEnableModule('st'.$priceCompareName.'Backend', 'backend');

            /**
             * Dodawanie routingów
             */
            stPluginHelper::addRouting('st'.$priceCompareName.'Plugin', '/'.$routingName.'/:action/*', 'st'.$priceCompareName.'Backend', 'list', 'backend');
            stPluginHelper::addRouting('st'.$priceCompareName.'PluginDefault', '/'.$routingName, 'st'.$priceCompareName.'Backend', 'list', 'backend');

            /**
             * Dodawanie socketów
             */
            stSocketView::addComponent('st'.$priceCompareName.'Backend.generateCustom.Content', 'st'.$priceCompareName.'Backend', 'generateXml');

            /**
             * Włączenie importu/eksportu
             */
            $dispatcher = stEventDispatcher::getInstance();
            $dispatcher->connect('stAdminGenerator.generateStProduct', array('st'.$priceCompareName.'PluginListener', 'generate'));
        }
    }
}
