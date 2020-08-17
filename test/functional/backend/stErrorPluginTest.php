<?php
/** 
 * SOTESHOP/stErrorPlugin 
 * 
 * Ten plik należy do aplikacji stErrorPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stErrorPlugin
 * @subpackage  tests
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stErrorPluginTest.php 9 2009-08-24 09:31:16Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new stTestBrowser();
$browser->initialize();
$browser->login();
$browser->
  get('/abcdefghij')->
  isStatusCode(404)->
  responseContains('Strona o podanym adresie nie istnieje');