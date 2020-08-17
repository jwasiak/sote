<?php
/**
 * SOTESHOP/stEcardPlugin
 *
 * Ten plik należy do aplikacji stEcardPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stEcardPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 8027 2010-08-31 12:22:15Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Dodanie informacji o istnieniu płatności
 */
stPluginHelper::addConfigValue('stPaymentType', 'stEcardPlugin', array('name' => 'stEcard', 'description' => 'Płatność przez serwis ecard.pl'));

/**
 * Włączanie modułu
 */
stPluginHelper::addEnableModule('stEcardBackend', 'backend');
stPluginHelper::addEnableModule('stEcardFrontend', 'frontend');

/**
 * Dodawania routingu
 */
stPluginHelper::addRouting('stEcardPlugin', '/ecard', 'stEcardBackend', 'index', 'backend');
stPluginHelper::addRouting('stEcardPlugin', '/ecard/:action/*', 'stEcardFrontend', 'config', 'frontend');
stPluginHelper::addRouting('stEcardSecure', '/ecard/statusReport/:hash', 'stEcardFrontend', 'statusReport', 'frontend');

/**
 * Dodanie do konfiguracji
 */
stConfiguration::addModule('stEcardPlugin', 'group_3', 1);

/**
 * Wyłącznie modułu w trybie open 
 */
stLicenseTypeHelper::addCommercialModule('stEcardPlugin');