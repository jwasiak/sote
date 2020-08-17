<?php
/** 
 * SOTESHOP/stGoogleAnalyticsPlugin
 * 
 * Ten plik należy do aplikacji stGoogleAnalyticsPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stGoogleAnalyticsPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: config.php 1321 2009-05-22 10:56:56Z krzysiek $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */


if (SF_APP == 'frontend'){
	stPluginHelper::addEnableModule('stGoogleAnalyticsFrontend', 'frontend');
}

if (SF_APP == 'backend'){
	stPluginHelper::addEnableModule('stGoogleAnalyticsBackend', 'backend');
	stPluginHelper::addRouting('stGoogleAnalyticsPlugin', '/google_analytics/:action/*', 'stGoogleAnalyticsBackend', 'index', 'backend');
	stPluginHelper::addRouting('google_analytics', '/google_analytics/:action/*', 'stGoogleAnalyticsBackend', 'index', 'backend');
}

