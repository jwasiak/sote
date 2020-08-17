<?php
/** 
 * SOTESHOP/stPlatnosciPlPlugin 
 * 
 * Ten plik należy do aplikacji stPlatnosciPlPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stPlatnosciPlPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 16126 2011-11-15 14:11:22Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Dodanie informacji o istnieniu płatności
 */
stPluginHelper::addConfigValue('stPaymentType', 'stPlatnosciPlPlugin', array('name' => 'stPlatnosciPl', 'description' => 'Płatność przez serwis PayU'));

/** 
 * Włączanie modułu
 */
stPluginHelper::addEnableModule('stPlatnosciPlBackend', 'backend');
stPluginHelper::addEnableModule('stPlatnosciPlFrontend', 'frontend');

/** 
 * Dodawania routingu
 */
stPluginHelper::addRouting('stPlatnosciPlPlugin', '/platnoscipl', 'stPlatnosciPlBackend', 'index', 'backend');
stPluginHelper::addRouting('stPlatnosciPlPlugin', '/platnoscipl/:action/*', 'stPlatnosciPlFrontend', 'config', 'frontend');

stLicenseTypeHelper::addCommercialModule('stPlatnosciPlPlugin');