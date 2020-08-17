<?php
/** 
 * SOTESHOP/stSlideBannerPlugin
 * 
 * Ten plik należy do aplikacji stSearchPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stSlideBanner
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: config.php 3428 2010-02-10 11:48:32Z piotr $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/** 
 * Enabling frontend and backend modules
 */
stPluginHelper::addEnableModule('stSlideBannerFrontend', 'frontend');
stPluginHelper::addEnableModule('stSlideBannerBackend', 'backend');

/** 
 * Adding nessesary Routing
 */
stPluginHelper::addRouting('stSlideBannerPlugin', '/slideBanner/*', 'stSlideBannerFrontend', 'show', 'frontend');
stPluginHelper::addRouting('stSlideBannerPlugin', '/slideBanner/*', 'stSlideBannerBackend', 'list', 'backend');

stSocketView::addComponent('stSlideBannerBackend.configCustom.Content','stSlideBannerBackend','configContent');