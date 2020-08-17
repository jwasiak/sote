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
 * @subpackage configs
 * @copyright SOTE (www.sote.pl)
 * @license http://www.sote.pl/license/sote (Professional License SOTE)
 * @version $Id: config.php 5860 2010-06-29 14:00:20Z krzysiek $
 * @author Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Włączanie modułu
 */
stPluginHelper::addEnableModule('stNavigationBackend', 'backend');
stPluginHelper::addEnableModule('stNavigationFrontend', 'frontend');

/**
 * Dodawania routingu
 */
stPluginHelper::addRouting('stNavigationPlugin', '/navigation/:action/*', 'stNavigationBackend', 'index', 'backend');
stPluginHelper::addRouting('stNavigationPlugin', '/navigation/:action/*', 'stNavigationFrontend', 'showHistory', 'frontend');

/**
 * Dodanie do konfiguracji
 */
stConfiguration::addModule('stNavigationPlugin', 'group_2', 2);

/**
 * Dodanie ścieżki do karty produktu
 */
stEventDispatcher::getInstance()->connect('stProductActions.postExecuteShow', array('stNavigationListener', 'addProductShow'));

/**
 * Dodanie ścieżki do listy produktów
 */
stEventDispatcher::getInstance()->connect('stProductActions.postExecuteList', array('stNavigationListener', 'addProductList'));

/**
 * Dodanie ścieżki do stron www
 */
stEventDispatcher::getInstance()->connect('stWebpageFrontendActions.postExecuteIndex', array('stNavigationListener', 'addWebpageIndex'));

/**
 * Dodanie ścieżki do wyszukiwania
 */
stEventDispatcher::getInstance()->connect('stSearchFrontendActions.postExecuteSearch', array('stNavigationListener', 'addSearchSearch'));

/**
 * Dodanie ścieżki do koszyka
 */
stEventDispatcher::getInstance()->connect('stBasketActions.postExecuteIndex', array('stNavigationListener', 'addBasketIndex'));

/**
 * Dodanie ścieżki do potwierdzenia zamówienia
 */
stEventDispatcher::getInstance()->connect('stOrderActions.postExecuteConfirm', array('stNavigationListener', 'addOrderConfirm'));

/**
 * Dodanie ścieżki do podsumowania zamówienia
 */
stEventDispatcher::getInstance()->connect('stOrderActions.postExecuteSummary', array('stNavigationListener', 'addOrderSummary'));

/**
* Dodanie ścieżki do płatności
*/
stEventDispatcher::getInstance()->connect('stPaymentActions.postExecutePay', array('stNavigationListener', 'addPaymentPay'));

/**
 * Dodanie ścieżki producenta
 */
stEventDispatcher::getInstance()->connect('stProductActions.postExecuteProducerList', array('stNavigationListener', 'addProducerList'));
/**
 * Dodanie ścieżki grupy produktu
 */
stEventDispatcher::getInstance()->connect('stProductActions.postExecuteGroupList', array('stNavigationListener', 'addGroupList'));