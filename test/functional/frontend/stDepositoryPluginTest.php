<?php
/** 
 * SOTESHOP/stDepositoryPlugin 
 * 
 * Ten plik należy do aplikacji stDepositoryPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stDepositoryPlugin
 * @subpackage  tests
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stDepositoryPluginTest.php 617 2009-04-09 13:02:31Z michal $
 * @author      Paweł Byszewski <pawel.byszewski@sote.pl>
 */

/** 
 * Konfiguracja i inicjacja środowiska testów. 
 */
include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$browser = new stTestBrowser();
$browser->initialize();

/** 
 * Sprawdza wyświetlanie stanu magazynowego w karcie produktu
 */
$browser->test()->diag('Sprawdza wyświetlanie stanu magazynowego w karcie produktu');
//$browser->get('/product/show/id/4')->isStatusCode(200);
//$browser->responseContains('W magazynie');
//$browser->responseContains('5 szt.');
?>