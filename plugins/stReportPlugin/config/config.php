<?php
/** 
 * SOTESHOP/stReportPlugin 
 * 
 * Ten plik należy do aplikacji stReportPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stReportPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 12100 2013-02-01 07:18:36Z bartek $
 * @author      Bartosz Alejski bartosz.alejski@sote.pl
 */

if (SF_APP == 'backend') {
	stPluginHelper::addEnableModule('stReportBackend', 'backend');
    stPluginHelper::addRouting('stReportPlugin', '/report/:action/*', 'stReportBackend', 'product', 'backend');   
    stPluginHelper::addRouting('report', '/report/:action/*', 'stReportBackend', 'product', 'backend');    
}