<?php
/** 
 * SOTESHOP/stProductGroup 
 * 
 * Ten plik należy do aplikacji stProductGroup opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stProductGroup
 * @subpackage  tests
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stProductGroupTest.php 445 2009-09-10 10:04:14Z pawel $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/** 
 * Test ProductGroup
 */
include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$browser = new stTestBrowser();
$browser->initialize();

$browser->test()->diag('Sprawdzam wyświetlanie elementów grup produktu na stronie głównej');
$browser->get('/');
$browser->isStatusCode(200);
$browser->responseContains('Promocje');   
$browser->responseContains('Wyprzedaż'); 

$browser->test()->diag('Sprawdzam czy wyświetlane są produkty na stronie głównej');
$browser->get('/');
$browser->isStatusCode(200);
$browser->checkResponseElement('st_product-main_products_name','');
$browser->checkResponseElement('st_component-st_product-main_products','');

$browser->test()->diag('Sprawdzam wyświetlanie grup produktów na listach');
$browser->get('/product/list/group_id/2');
$browser->isStatusCode(200);
$browser->responseContains('Kamera HDD');
$browser->responseContains('Torebka damska');
$browser->checkResponseElement('<h1 class="st_title">Promocje</h1>', '');
$browser->click("Cenie");
$browser->isStatusCode(200);
$browser->responseContains('Torebka damska');
$browser->click("Cenie");
$browser->isStatusCode(200);
$browser->click("Nazwie");
$browser->isStatusCode(200);
//$browser->click("Skrócona lista");
//$browser->isStatusCode(200);
//$browser->responseContains('Widzisz');
//$browser->click("Lista alternatywna");
//$browser->isStatusCode(200);
//$browser->responseContains('Widzisz');
//$browser->click("Cenie");
//$browser->isStatusCode(200);
//$browser->click("Nazwie");
//$browser->isStatusCode(200);
//$browser->responseContains('Widzisz');
//$browser->click("Pełna lista");
//$browser->responseContains('Widzisz');
?>