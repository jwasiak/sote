<?php
/** 
 * SOTESHOP/stRegister 
 * 
 * Ten plik należy do aplikacji stRegister opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stRegister
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 613 2009-04-09 12:34:35Z michal $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/** 
 * Dodanie routingu
 */
stPluginHelper::addRouting('stRegister','/stRegister/:action/*','stRegister','index','backend');