<?php
/** 
 * SOTESHOP/stTextPlugin 
 * 
 * Ten plik należy do aplikacji stTextPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stTextPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: config.php 617 2009-04-09 13:02:31Z michal $
 * @author      Krzysztof Beblo <krzysztof.beblo@sote.pl>
 */

/** 
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('stTextBackend', 'backend');

/** 
 * Dodawanie routingów
 */
stPluginHelper::addRouting('stTextPlugin', '/text/:action/*', 'stTextBackend', 'list', 'backend');

/** 
 * usuwanie cachy
 */
sfMixer::register('BaseText:save:post', array('stTextCache', 'deleteCacheText'));
sfMixer::register('BaseText:delete:post', array('stTextCache', 'deleteCacheText'));