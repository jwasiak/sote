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
 * @author      Lukasz Andrzejak <lukasz.andrzejak@sote.pl>
 */

/** 
 * Załączamy wymagane do testu biblioteki
 */
include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$browser = new sfTestBrowser();
$browser->initialize();

$browser->
    get('stProducer')->
    isStatusCode(200)->
    isRequestParameter('module', 'stProducer')->
    isRequestParameter('action', 'index')->
    responseContains('Sote Demo Company');
$browser->
    get('/stProducer/show/id/1')->
    isStatusCode(200)->
    responseContains('Sote Demo Company')->
    responsecontains('Powrót do listy');

$browser->
    get('/producer/100')->
    isStatusCode(404);

$browser->
    get('/producer/abc')->
    isStatusCode(404);

/** 
 * Sprawdzamy filtrowanie po producentach i wykrywane kategorie :)
 */
//
//$browser->
//  get('product/list/id_producer/1')->
//  isStatusCode(200)->
//  isRequestParameter('module','product')->
//  responseContains('W innych kategoriach:')->
//  responseContains('Audio')->
//  responseContains('Video')->
//  responseContains('Ekskluzywne')->
//  responseContains('Romantyczne');
//   
//$browser->
//  get('product/list/id_producer/5')->
//  isStatusCode(200)->
//  isRequestParameter('module','product')->
//  checkResponseElement('body','!/W innych kategoriach/');
  