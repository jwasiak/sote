<?php
/**
 * SOTESHOP/stShopInfoPlugin
 *
 * Ten plik należy do aplikacji stShopInfoPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stShopInfoPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 4651 2009-02-04 12:51:04Z pawel $
 * @author      Paweł Byszewski <pawel.byszewski@sote.pl>
 */

if (SF_APP == 'backend')
{
	/**
	 * Włączanie modułu
	 */
	stPluginHelper::addEnableModule('stShopInfoBackend', 'backend');

	/**
	 * Dodanie routingu
	 */
	stPluginHelper::addRouting('stShopInfoPlugin','/shop_info/:action/*','stShopInfoBackend', 'index','backend');
	stPluginHelper::addRouting('shop_info', '/shop_info/:action/*', 'stShopInfoBackend', 'index', 'backend');
	stPluginHelper::addRouting('shop_info/register', '/shop_info/:action/*', 'stShopInfoBackend', 'index', 'backend');
}

if (SF_APP == 'frontend')
{
    /**
     * Włączanie modułu
     */
    stPluginHelper::addEnableModule('stShopInfoFrontend', 'frontend');

    /**
     * Dodanie routingu
     */
    stPluginHelper::addRouting('stShopInfoPlugin','/shop_info/:action/*','stShopInfoFrontend', 'index','frontend');
    
}