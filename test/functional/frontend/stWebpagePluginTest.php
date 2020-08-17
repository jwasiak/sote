<?php
/** 
 * SOTESHOP/stWebpagePlugin 
 * 
 * Ten plik należy do aplikacji stWebpagePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stWebpagePlugin
 * @subpackage  tests
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stWebpagePluginTest.php 392 2009-09-08 14:55:35Z michal $
 * @author      Maricn Olejniczak <marcin.olejniczak@sote.pl>
 */

/** 
 * Test stWebpagePLugin
 */
include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$browser = new stTestBrowser();
$browser->initialize();

/** 
 * Sprawdzam wyświetlanie stron webpage na stronie frontend
 */

$browser->test()->diag('Sprawdzam wyświetlanie elementów webpage na stronie frontend');
$browser->get('/');
$browser->checkText('O firmie', 'Regulamin', 'Kontakt', 'Tekst na stronie', 'dodatkowa informacja od sprzedawcy do oferty itp.');

//Jeśli pojawi się problem to znaczy, że nadal nie ma ustawionej poprawnej konfiguracji tinyMCE, należy dodać parametr entity_encoding:"raw"

/** 
 * Sprawdzam wyświetlanie elementów lewej kolumny webpage na stronie frontend
 */
$browser->test()->diag('Sprawdzam wyświetlanie elementów lewej kolumny webpage na stronie frontend');
$browser->checkResponseElement('st_container_left', '');
$browser->checkResponseElement('div#st_dynamic_content', '');
$browser->checkResponseElement('st_f_text_container', '');
$browser->checkResponseElement('div#st_f_text_frame', '');
$browser->checkResponseElement('div#st_f_text_frame_container', '');
$browser->checkResponseElement('div#st_f_text_frame_header', '');
$browser->checkResponseElement('div#st_f_text_frame_left', '');
$browser->checkResponseElement('div#st_f_text_frame_right', '');
$browser->checkResponseElement('div#st_f_text_frame_content', '');
$browser->checkResponseElement('div#st_txt_frame', '');
$browser->checkResponseElement('div#st_f_text_frame_footer', '');
$browser->checkResponseElement('div#st_f_text_frame_left', '');
$browser->checkResponseElement('div#st_f_text_frame_right', '');

/** 
 * Sprawdzam wyświetlanie elementów środkowej kolumny webpage na stronie frontend
 */
$browser->test()->diag('Sprawdzam wyświetlanie elementów środkowej kolumny webpage na stronie frontend');
$browser->checkResponseElement('st_container_content', '');
$browser->checkResponseElement('div#st_dynamic_content', '');
$browser->checkResponseElement('st_application-st_frontend_main-index', '');
$browser->checkResponseElement('st_application-st_frontend_main-main_index', '');
$browser->checkResponseElement('st_f_text_container', '');
$browser->checkResponseElement('div#st_f_text_frame', '');
$browser->checkResponseElement('div#st_f_text_frame_container', '');
$browser->checkResponseElement('div#st_f_text_frame_header', '');
$browser->checkResponseElement('div#st_f_text_frame_left', '');
$browser->checkResponseElement('div#st_f_text_frame_right', '');
$browser->checkResponseElement('div#st_f_text_frame_content', '');
$browser->checkResponseElement('div#st_txt_frame', '');
$browser->checkResponseElement('div#st_f_text_frame_footer', '');
$browser->checkResponseElement('div#st_f_text_frame_left', '');
$browser->checkResponseElement('div#st_f_text_frame_right', '');


/** 
 * Sprawdzam wyświetlanie elementów prawej kolumny webpage na stronie frontend
 */
$browser->test()->diag('Sprawdzam wyświetlanie elementów prawej kolumny webpage na stronie frontend');
$browser->checkResponseElement('st_container_right', '');
$browser->checkResponseElement('div#st_dynamic_content', '');
$browser->checkResponseElement('div#st_f_text_frame', '');
$browser->checkResponseElement('div#st_f_text_frame_container', '');
$browser->checkResponseElement('div#st_f_text_frame_header', '');
$browser->checkResponseElement('div#st_f_text_frame_left', '');
$browser->checkResponseElement('div#st_f_text_frame_right', '');
$browser->checkResponseElement('div#st_f_text_frame_content', '');
$browser->checkResponseElement('div#st_txt_frame', '');
$browser->checkResponseElement('div#st_f_text_frame_footer', '');
$browser->checkResponseElement('div#st_f_text_frame_left', '');
$browser->checkResponseElement('div#st_f_text_frame_right', '');

/** 
 * Sprawdzam wyświetlanie stron na stronie webpage
 */
$browser->test()->diag('Sprawdzam wyświetlanie stron na stronie webpage');
$browser->get('/webpage');
$browser->isStatusCode(200);
$browser->isRequestParameter('module','stWebpageFrontend');
$browser->isRequestParameter('action','list');
$browser->checkText('Lista stron www:', 'O firmie', 'Regulamin', 'Kontakt', 'Strona');

/** 
 * Sprawdzam poprawności linku O firmie
 */
$browser->test()->diag('Sprawdzam poprawności linku O firmie');
$browser->get('/');
$browser->click('O firmie');
$browser->isStatusCode(200);
$browser->isRequestParameter('webpage_id', '1');
$browser->checkText('To jest strona o firmie....', 'O firmie');

/** 
 * Sprawdzam wyświetlanie strony O firmie
 */
$browser->test()->diag('Sprawdzam wyświetlanie strony O firmie');
$browser->get('/webpage/index/webpage_id/1');
$browser->isStatusCode(200);
$browser->checkText('To jest strona o firmie....', 'O firmie');

/** 
 * Sprawdzam poprawności linku Regulamin
 */
$browser->test()->diag('Sprawdzam poprawności linku Regulamin');
$browser->get('/');
$browser->click('Regulamin');
$browser->isStatusCode(200);
$browser->isRequestParameter('webpage_id', '2');
$browser->checkText('To jest strona regulamin...', 'Regulamin');

/** 
 * Sprawdzam wyświetlanie strony Regulamin
 */
$browser->test()->diag('Sprawdzam wyświetlanie strony Regulamin');
$browser->get('/webpage/index/webpage_id/2');
$browser->isStatusCode(200);
$browser->checkText('To jest strona regulamin...', 'Regulamin');

/** 
 * Sprawdzam poprawności linku Kontakt
 */
$browser->test()->diag('Sprawdzam poprawności linku Kontakt');
$browser->get('/');
$browser->click('Kontakt');
$browser->isStatusCode(200);
$browser->isRequestParameter('webpage_id', '3');
$browser->checkText('To jest strona kontakt...', 'Kontakt');

/** 
 * Sprawdzam wyświetlanie strony Kontakt
 */
$browser->test()->diag('Sprawdzam wyświetlanie strony kontakt');
$browser->get('/webpage/index/webpage_id/3');
$browser->isStatusCode(200);
$browser->checkText('To jest strona kontakt...', 'Kontakt');

/** 
 * Sprawdzam istnienie strony webpage
 */
$browser->test()->diag('Sprawdzam istnienie strony webpage');
$c = new Criteria();
$webpage=WebpagePeer::doSelectOne($c);  
if ($webpage){
    $browser->
      responseContains($webpage->getName())->
      click($webpage->getName())->
      responseContains($webpage->getName())->
      isRequestParameter('webpage_id',$webpage->getId());
}else{
    $browser->test()->diag('No webpages found - unable to test webpage');
}



?>