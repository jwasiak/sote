<?php
/** 
 * SOTESHOP/stCategoryTreePlugin 
 * 
 * Ten plik należy do aplikacji stCategoryTreePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stCategoryTreePlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: config.php 10617 2011-01-28 13:04:18Z marcin $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/** 
 * Włącza moduł w backendzie i frontendzie
 */
stPluginHelper::addEnableModule('stCategoryTree', 'frontend');
stPluginHelper::addEnableModule('stCategoryTree', 'backend');
stPluginHelper::addRouting('stCategoryTreeJS', '/stCategoryTreePlugin/js/generated.js', 'stCategoryTree', 'javascript', 'backend');
?>