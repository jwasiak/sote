<?php
/** 
 * SOTESHOP/stOptimizationPlugin 
 * 
 * Ten plik należy do aplikacji stOptimizationPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stOptimizationPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: config.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Włączanie modułu
 */
stPluginHelper::addEnableModule('stOptimizationBackend', 'backend');

/** 
 * Dodawania routingu
 */
stPluginHelper::addRouting('stOptimizationPlugin', '/optimization/:action/*', 'stOptimizationBackend', 'index', 'backend');
