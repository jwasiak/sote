<?php
/** 
 * SOTESHOP/stAvailabilityPlugin 
 * 
 * Ten plik należy do aplikacji stAvailabilityPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stAvailabilityPlugin
 * @subpackage  tests
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stAvailabilityPluginTest.php 617 2009-04-09 13:02:31Z michal $
 * @author      Pawel Byszewski <pawel.byszewski@sote.pl>
 */

/** 
 * Konfiguracja i inicjacja środowiska testów. 
 */
include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$browser = new stTestBrowser();
$browser->initialize();

/** 
 * Sprawdza wyświetlanie dostępności w karcie produktu
 */
$browser->test()->diag('Sprawdza wyświetlanie dostępności w karcie produktu');
//$browser->get('/product/show/id/4')->isStatusCode(200);
//$browser->responseContains('Dostępność');
//$browser->responseContains('Jest');
?>