<?php
/** 
 * SOTESHOP/stUser 
 * 
 * Ten plik należy do aplikacji stUser opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stUser
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 1307 2009-05-20 12:52:02Z bartek $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Dodanie routingu
 */
stPluginHelper::addRouting('stUser','/user/:action/*','stUser','list','backend');
stPluginHelper::addRouting('stRegisterUserWidget', '/user/registerUserWidget', 'stUser', 'registerUserWidget', 'backend');

