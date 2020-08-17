<?php
/** 
 * SOTESHOP/stTabNavigatorPlugin 
 * 
 * Ten plik należy do aplikacji stTabNavigatorPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stTabNavigatorPlugin
 * @subpackage  tests
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stTabNavigatorPluginTest.php 1475 2009-10-14 12:23:20Z marcin $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/** 
 * Test stTabNavigatorPlugin
 */
include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$browser = new sfTestBrowser();
$browser->initialize();

/** 
 * Sprawdza istnienie pluginu
 */

$browser->
  get('/stTabNavigatorDemo')->
  isStatusCode(200)->
  responseContains('Właśnie otworzyłeś zakładkę ')->
  responseContains('Truskawki');

// testing usage of tabs in non-javascript environment  

$browser->
  get('stTabNavigatorDemo/index/navtab1/1')->
  responseContains('Truskawki');

$browser->
  get('stTabNavigatorDemo/index/navtab1/2')->
  responseContains('Pomarańczy');
  
$browser->
  get('stTabNavigatorDemo/index/navtab1/3')->
  responseContains('Banana');