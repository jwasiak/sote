<?php
/** 
 * SOTESHOP/stFrontend 
 * 
 * Ten plik należy do aplikacji stFrontend opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stFrontend
 * @subpackage  tests
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stFrontendTest.php 9 2009-08-24 09:31:16Z michal $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/** 
 * Test stFrontend
 */
include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$browser = new stTestBrowser();
$browser->initialize();

/** 
 * Sprawdzam wyświetlanie strony frontend
 */

$browser->test()->diag('Sprawdzam wyświetlanie strony frontend');
$browser->get('/');
$browser->isStatusCode(200);
$browser->isRequestParameter('module','stFrontendMain');
$browser->isRequestParameter('action','index');
$browser->checkResponseElement('st_container', '');
$browser->checkResponseElement('st_container_head', '');
$browser->checkResponseElement('st_navigation_bar-1', '');
$browser->checkResponseElement('div#st_navigation_bar', '');
$browser->checkResponseElement('div#st_dynamic_content', '');
$browser->checkResponseElement('st_navigation_bar-2', '');
$browser->checkResponseElement('div#st_navigation_bar2', '');
$browser->checkResponseElement('st_navigation_bar-2_left', '');
$browser->checkResponseElement('st_navigation_bar-2_middle', '');
$browser->checkResponseElement('div#icon_home a[href] img#st_home', '');
$browser->checkResponseElement('st_navigation_bar-2_right', '');
$browser->checkResponseElement('st_container_body', '');
$browser->checkResponseElement('st_foot_copyright', '');
$browser->checkText('Strona główna');

/** 
 * Sprawdzam przeładowanie strony frontend
 */
$browser->test()->diag('Sprawdzam przeładowanie strony frontend');
$browser->reload(); 
$browser->isStatusCode(200);
$browser->isRequestParameter('module','stFrontendMain');
$browser->isRequestParameter('action','index');
$browser->checkResponseElement('div#icon_home a[href] img#st_home', '');
$browser->checkText('Strona główna');

/** 
 * Sprawdzam działanie linku Strona główna
 */
//$browser->test()->diag('Sprawdzam działanie linku Strona główna');
//$browser->click(iconv(sfConfig::get('sf_charset'), 'utf-8', 'Strona główna'));
//$browser->isStatusCode(200);
//$browser->isRequestParameter('module','stFrontendMain');
//$browser->isRequestParameter('action','index');
//$browser->checkResponseElement('div#icon_home a[href] img#st_home', '');
//$browser->checkText('Strona główna');
//$browser->back();
//$browser->forward();
//$browser->isStatusCode(200);
//$browser->isRequestParameter('module','stFrontendMain');
//$browser->isRequestParameter('action','index');
//$browser->checkResponseElement('div#icon_home a[href] img#st_home', '');
//$browser->checkText('Strona główna');

/** 
 * Sprawdzam działanie linku Home
 */
$browser->test()->diag('Sprawdzam działanie linku Home');
$browser->get('/index.php');
$browser->isStatusCode(200);
$browser->isRequestParameter('module','stFrontendMain');
$browser->isRequestParameter('action','index');
$browser->checkResponseElement('div#icon_home a[href] img#st_home', '');
$browser->checkText('Strona główna');