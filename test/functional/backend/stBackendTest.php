<?php
/** 
 * SOTESHOP/stBackend 
 * 
 * Ten plik należy do aplikacji stBackend opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stBackend
 * @subpackage  tests
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stBackendTest.php 9 2009-08-24 09:31:16Z michal $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */
       
/** 
 * Konfiguracja i inicjacja środowiska testów. 
 */
include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$browser = new stTestBrowser();
$browser->initialize();

/** 
 * Loguje się i sprawdzam wyświetlanie strony backend
 */
$browser->test()->diag('Loguje się i sprawdzam wyświetlanie strony backend');
$browser->login();
$browser->isRedirected();
$browser->followRedirect();
$browser->isStatusCode(200);
$browser->checkRequestParameter('module', 'stBackendMain');
$browser->checkRequestParameter('action','list');
$browser->checkText('Home', 'Wyloguj');

/** 
 * Klikam link Home
 */
$browser->test()->diag('Klikam link Home');
$browser->click('Home');
$browser->checkRequestParameter('module', 'stBackendMain');
$browser->checkRequestParameter('action','list');
$browser->checkText('Home', 'Wyloguj');

$c = new Criteria();
$user_logged = sfGuardUserPeer::doSelectOne($c);

$browser->responseContains($user_logged->getUsername());

/** 
 * Wylogowuje się
 */
$browser->test()->diag('Wylogowuje się');
$browser->get('logout');
$browser->isRedirected();
$browser->followRedirect();