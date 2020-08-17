<?php
/** 
 * SOTESHOP/stDelivery 
 * 
 * Ten plik należy do aplikacji stDelivery opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stDelivery
 * @subpackage  tests
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stDeliveryTest.php 28 2009-08-24 13:56:06Z marcin $
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
 * Sprawdza wyświetlanie dostaw w koszyku
 */
$browser->test()->diag('Sprawdza wyświetlanie dostaw w koszyku');
$browser->get('/product/show/id/5')->isStatusCode(200);
$browser->click('Dodaj do koszyka');
$browser->isRedirected()->followRedirect();
$browser->responseContains('Dostawa');
$browser->responseContains('Poczta Polska');
$browser->responseContains('Odbiór osobisty');
?>