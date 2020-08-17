<?php
/**
 * SOTESHOP/stLukasPlugin
 *
 * Ten plik należy do aplikacji stLukasPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stLukasPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Dodanie informacji o istnieniu płatności
 */
stPluginHelper::addConfigValue('stPaymentType', 'stLukasPlugin', array('name' => 'stLukas', 'description' => 'Płatność Credit Agricole Raty'));

/**
 * Ładowanie konfiguracji dla backend'u
 */
if (SF_APP == 'backend')
{
    /**
     * Włączanie modułu
     */
    stPluginHelper::addEnableModule('stLukasBackend', 'backend');

    /**
     * Dodawania routingu
     */
    stPluginHelper::addRouting('stLukasPlugin', '/lukas', 'stLukasBackend', 'index', 'backend');

    /**
     * Dodanie modułu do konfiguracji
     */
    stConfiguration::addModule('stLukasPlugin', 'group_3', 1);

    /**
     * Wyłącznie modułu w trybie open 
     */
    stLicenseTypeHelper::addCommercialModule('stLukasPlugin');

    /**
     * Przeciążenia generowania akcji produtku
     */
    $dispatcher->connect('stAdminGenerator.generateStProduct', array('stLukasListener', 'generate'));
    $dispatcher->connect('autoStProductActions.postGetLukasOrCreate', array('stLukasListener', 'postGetLukasOrCreate'));
    $dispatcher->connect('autoStProductActions.postUpdateLukasFromRequest', array('stLukasListener', 'postUpdateLukasFromRequest'));
}

/**
 * Ładowanie konfiguracji dla frontend'u
 */
if (SF_APP == 'frontend')
{
    /**
     * Włączanie modułu
     */
    stPluginHelper::addEnableModule('stLukasFrontend', 'frontend');

    /**
     * Dodawania routingu
     */
    stPluginHelper::addRouting('stLukasPlugin', '/lukas/:action/*', 'stLukasFrontend', 'ewniosek', 'frontend');
    stPluginHelper::addRouting('stLukasPluginCA', '/credit-agricole/:action/*', 'stLukasFrontend', 'ewniosek', 'frontend');

    /**
     * Dodanie componetnu przy wyświetlaniu płatności w koszyku
     */
    stSocketView::addComponent('stPayment_show_stLukas_info', 'stLukasFrontend', 'calculateInBasket');
}
