<?php
/** 
 * SOTESHOP/stAccessoriesPlugin 
 * 
 * Ten plik należy do aplikacji stAccessoriesPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stAccessoriesPlugin
 * @subpackage  tests
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stAccessoriesPluginTest.php 305 2009-09-04 12:49:07Z michal $
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
 * Sprawdza wyświetlanie akcesoriów w karcie produktu
 */
$browser->test()->diag('Sprawdza wyświetlanie akcesoriów w karcie produktu');
$browser->get('/product/show/id/7')->isStatusCode(200);
$browser->click('Akcesoria');
$browser->responseContains('MP3 Player Gold');

?>