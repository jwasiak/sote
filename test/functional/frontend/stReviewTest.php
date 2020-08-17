<?php
/** 
 * SOTESHOP/stReview 
 * 
 * Ten plik należy do aplikacji stReview opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stReview
 * @subpackage  tests
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stReviewTest.php 1153 2009-10-07 08:24:35Z pawel $
 * @author      Paweł Byszewski <pawel.byszewski@sote.pl>
 */

/** 
 * Test stReview
 */
include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$browser = new stTestBrowser();
$browser->initialize();

/** 
 * Recenzje dodawane sa dopiero po złożeniu zamówienia i dopiero wtedy będzie można sprawdzić funkcjonalność dodawania
 */

/** 
 * Sprawdza mozliwosc dodania recenzji
 */
//$browser->test()->diag('Sprawdzam brak możliwości dodania recenzji z karty produktu');
//$browser->get('/review/add/product_id/5')->isStatusCode(404);

/** 
 * Sprawdza wyświetlanie recenzji w karcie produktu w zakładce recenzje
 */
$browser->test()->diag('Sprawdzam wyświetlanie zakładki Recenzje, jeśli recenzja jest przypisana dla produktu');
$browser->get('/product/show/id/5')->isStatusCode(200);
$browser->responseContains('Recenzje');
$browser->test()->diag('Sprawdzam wyświetlanie elementów recenzji');
$browser->get('/product/show/id/5')->isStatusCode(200);
$browser->click('Recenzje');
$browser->responseContains('Ocena');
$browser->responseContains('Dodano');
$browser->responseContains('Autor');
$browser->responseContains('Powściągliwość i stanowczość marki. Zegareki kształtują dzisiejszego mężczyznę. Oczyszczony kształt i symetria łączą w sobie ujarzmioną technikę.');

$browser->test()->diag('Sprawdzam czy jeśli nie ma recenzji dodanej do produktu to zakładka Recenzje nie wyświetla się');
$browser->get('/product/show/id/19')->isStatusCode(200);
$browser->responseContains('Recenzje');
