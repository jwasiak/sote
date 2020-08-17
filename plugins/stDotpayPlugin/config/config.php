<?php
/** 
 * SOTESHOP/stDotpayPlugin 
 * 
 * Ten plik należy do aplikacji stDotpayPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stDotpayPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 8015 2010-08-31 11:32:34Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Dodanie informacji o istnieniu płatności
 */
stPluginHelper::addConfigValue('stPaymentType', 'stDotpayPlugin', array('name' => 'stDotpay', 'description' => 'Płatność przez serwis dotpay.pl'));

/** 
 * Włączanie modułu
 */
stPluginHelper::addEnableModule('stDotpayBackend', 'backend');
stPluginHelper::addEnableModule('stDotpayFrontend', 'frontend');

/** 
 * Dodawania routingu
 */
stPluginHelper::addRouting('stDotpayPlugin', '/dotpay/:action/*', 'stDotpayBackend', 'index', 'backend');
stPluginHelper::addRouting('stDotpayPlugin', '/dotpay/:action/*', 'stDotpayFrontend', 'config', 'frontend');

/**
 * Dodanie do konfiguracji
 */
stConfiguration::addModule('stDotpayPlugin', 'group_3', 1);

/**
 * Wyłącznie modułu w trybie open 
 */
stLicenseTypeHelper::addCommercialModule('stDotpayPlugin');