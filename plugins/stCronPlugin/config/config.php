<?php
/** 
 * SOTESHOP/stCronPlugin 
 * 
 * Ten plik należy do aplikacji stCronPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stCronPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: config.php 3018 2008-12-09 17:15:25Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Wywołanie metody testFunction z klasy stCronDemo, w dowolnym dniu o godzinie 17:42
 */
stCron::addMethod('stCronDemo', 'testFunction', array(), array("h" => "17", "m" => "42"));

/** 
 * Wywołanie strony http://sote.pl we wtorki o godzienie 17:48
 */
stCron::addUri('http://sote.pl', array('d' => "2", 'h' => "17", 'm' => "48"));