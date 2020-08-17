<?php
/** 
 * SOTESHOP/stProducer 
 * 
 * Ten plik należy do aplikacji stProducer opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stProducer
 * @subpackage  tests
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stProducerTest.php 617 2009-04-09 13:02:31Z michal $
 * @author      Łukasz Andrzejak <lukasz.andrzejak@sote.pl>
 */

/** 
 * Konfiguracja i inicjacja środowiska testów. 
 */
include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$browser = new stTestBrowser();
$browser->initialize();
$browser->login();

$browser->test()->diag('Checking whether Producer module exists');
$browser->get('/producer');
$browser->isRequestParameter('module', 'stProducer');
$browser->isRequestParameter('action', 'list');

$c = new Criteria();
$producer = ProducerPeer::doSelectOne($c);

if (!$producer)
{
    $browser->responseContains('Brak rekordów');
} else {
    $browser->responseContains($producer->getName());
}

//testing modify
$browser->get('/producer/edit/id/1')->isStatusCode(200);
$browser->responseContains($producer->getName());
$browser->setField('producer[name]','Sote Demo Company - modified');
$browser->click('Zapisz i dodaj');
$browser->isRedirected()->followRedirect()->isStatusCode(200);
$browser->checkText('Twoje zmiany zostały zapisane');

//testing add
$browser->setField('producer[name]','F');
$browser->click('Zapisz');
$browser->responseContains('Zbyt krótka');
$browser->setField('producer[name]','Testowy producent');
$browser->setField('producer[link]','www.google.pl');
$browser->click('Zapisz')->isRedirected()->followRedirect()->isStatusCode(200);
$browser->get('/producer')->isStatusCode(200);

//testing delete
$browser->click('Testowy producent')->isStatusCode(200);
$browser->click('Usuń')->isRedirected()->followRedirect()->isStatusCode(200);
$browser->isRequestParameter('module', 'stProducer');
$browser->isRequestParameter('action', 'list');

//rollback
$browser->get('/producer/edit/id/1')->isStatusCode(200);
$browser->setField('producer[name]', 'Sote Demo Company');
$browser->click('Zapisz')->isRedirected()->followRedirect()->isStatusCode(200);

//testing not specified urls
$browser->get('/producer/edit/id/100')->isStatusCode(404);
$browser->get('/producer/buka')->isStatusCode(404);