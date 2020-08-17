<?php
/**
 * SOTESHOP/stSearchPlugin
 *
 * Ten plik należy do aplikacji stSearchPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stSearchPlugin
 * @subpackage  tests
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stSearchPluginTest.php 10 2009-08-24 09:32:18Z michal $
 */


/**
 * Wymagane biblioteki.
 */
include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new stTestBrowser();
$b->initialize();

$b->get('stFrontendMain/index')->
isStatusCode(200)->
isRequestParameter('module', 'stFrontendMain')->
setField('search','sote')->
click('Szukaj')->isStatusCode(200)->
isRequestParameter('module', 'stSearchFrontend')->
responseContains('Wyszukiwanie: sote')->
responseContains('Diament');

$b->get('stFrontendMain/index')->
isStatusCode(200)->
isRequestParameter('module', 'stFrontendMain')->
setField('','sote')->
click('Szukaj')->isStatusCode(200)->
isRequestParameter('module', 'stSearchFrontend')->
responseContains('Proszę podać prawidłowe kryteria wyszukiwania, minialna ilość znaków 3.');
?>