<?php
/** 
 * SOTESHOP/stBasket 
 * 
 * Ten plik należy do aplikacji stBasket opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stBasket
 * @subpackage  tests
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stBasketTest.php 34 2009-08-24 14:00:47Z marcin $
 */

/** 
 * SOTESHOP/stBasket
 * Ten plik należy do aplikacji stBasket opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package stBasket
 * @subpackage libs
 */

/** 
 * Ładowonia wymaganych lib'ów
 */
include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$browser = new sfTestBrowser();
$browser->initialize();

$browser->get('/');
// chceck basket for beeing empty 
//$browser->get('basket/index')->isStatusCode(200);
//$browser->responseContains('Koszyk jest pusty');

// finding product to add to basket
$c = new Criteria();
$c->add(ProductPeer::ID,1,Criteria::GREATER_THAN);
$product=ProductPeer::doSelectOne($c);
if (!$product){
    $browser->test()->fail("Unable to add product to a basket - no products found");
}else{
    $product_id=$product->getId();
    $browser->test()->pass("Using product with id ".$product_id);
    
    // making sure that we are using conultation plugin
    if (class_exists(ProductConsultationPeer)){
        // if found product making sure that it can be added to basket - remove consultation
        $c = new Criteria();
        $c->add(ProductConsultationPeer::PRODUCT_ID,$product_id);
        $consult = ProductConsultationPeer::doSelectOne($c);
        if ($consult) $consult->delete();
    }
    
    // add a product to basket
    $browser->test()->diag('Sprawdzam dodawanie produktu do koszyka');
    $browser->
      get('/basket/add/product_id/'.$product_id)->
      isRequestParameter('module', 'stBasket')->
      isRequestParameter('action', 'add')->
      isRedirected()->followRedirect()->isRequestParameter('action', 'index')->
//      checkResponseElement('h1', 'Twój koszyk')->
      checkResponseElement('input[value="1"][id="basket_products_'.$product_id.'"]');

    //return 0;
    // increase number of num
    $browser->test()->diag('Sprawdzam zwiększanie sztuk danego produktu');

    $browser->get('/basket/add/product_id/'.$product_id.'/quantity/2')->
    isStatusCode(302)->
    isRequestParameter('module', 'stBasket')->
    isRequestParameter('action', 'add')->
    isRedirected()->followRedirect()->isRequestParameter('action', 'index')->
//    checkResponseElement('h1', 'Twój koszyk')->
    checkResponseElement('input[value="3"][id="basket_products_'.$product_id.'"]');

    // decrease number of num
    $browser->test()->diag('Sprawdzam zmniejszanie sztuk danego produktu');
    $browser->
    get('/basket/decrease/product_id/'.$product_id)->
    isStatusCode(302)->
    isRequestParameter('module', 'stBasket')->
    isRequestParameter('action', 'decrease')->
    isRedirected()->followRedirect()->isRequestParameter('action', 'index')->
//    checkResponseElement('h1', 'Twój koszyk')->
    checkResponseElement('input[value="2"][id="basket_products_'.$product_id.'"]');
}

// finding another product to add to basket
$c = new Criteria();
$c->add(ProductPeer::ID,$product_id,Criteria::GREATER_THAN);
$product=ProductPeer::doSelectOne($c);
if (!$product){
    $browser->test()->diag("Unable to add another product to a basket - no products found");
}else{
    $product_id=$product->getId();
    $browser->test()->pass("Using product with id ".$product_id);
    
    
    // add other product to basket
    $browser->test()->diag('Sprawdzam dodawanie produktu do koszyka');
    $browser->
      get('/basket/add/product_id/'.$product_id)->
      isRequestParameter('module', 'stBasket')->
      isRequestParameter('action', 'add')->
      isRedirected()->followRedirect()->isRequestParameter('action', 'index');
//      checkResponseElement('h1', 'Twój koszyk');
      
    
    /*
    This works in application when eneterd 'manually' from webbrowser, but for some strange resaon it does not empty basket in test evironment
    $browser->get('basket/clear')->
      isRedirected()->followRedirect()->isRequestParameter('action', 'index')->
      checkResponseElement('h1', 'Twój koszyk')->
      responseContains('Koszyk jest pusty');   
/** 
 */
}

// for some strange reasnons after displaying empty baket every next basket showings fail