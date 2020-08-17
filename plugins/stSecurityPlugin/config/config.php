<?php
/** 
 * SOTESHOP/stSecurityPlugin 
 * 
 * Ten plik należy do aplikacji stSecurityPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stSecurityPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 617 2009-04-09 13:02:31Z michal $
 * @author      Krzysztof Beblo <krzysztof.beblo@sote.pl>
 */

/** 
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('stSecurityBackend', 'backend');

/** 
 * Dodawanie routingów
 */
stPluginHelper::addRouting('stSecurityPlugin', '/security/:action/*', 'stSecurityBackend', 'index', 'backend');