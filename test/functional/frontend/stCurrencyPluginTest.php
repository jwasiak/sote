<?php
/** 
 * Test currency
 */
include(dirname(__FILE__).'/../../bootstrap/functional.php');

//include(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'stCurrencyPlugin'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.'Currency.php');
//include(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'stCurrencyPlugin'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.'CurrencyPeer.php');

// create a new test browser
$browser = new sfTestBrowser();
$browser->initialize();

    // check is delivery
    $browser->
      get('/stFrontendMain')->
      isStatusCode(200)->
      isRequestParameter('action', 'index')->
      responseContains('PLN');
     
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();  
     
    $c = new Criteria();
    $c->add(CurrencyPeer::SHORTCUT,'PLN',Criteria::NOT_EQUAL);
    $currency=CurrencyPeer::doSelectOne($c);
    if($currency){ 
        
        $browser->post('currency/addCurrency',array('currency'=>$currency->getId()));
        $browser->isRedirected()->followRedirect()->isStatusCode(200);  
        $c = new Criteria();
        $product = ProductPeer::doSelectOne($c);
        if ($product){
            
            $browser->get('stProduct/show/id/'.$product->getId());
            $browser->isStatusCode(200);
            $browser->responseContains($currency->getFrontSymbol());
            $browser->responseContains($currency->getBackSymbol());
            
        }else{
            
            $browser->test()->diag('No products found - unable to chceck display currency');
            
        }
        
    }else{
        $browser->test()->diag('No currencies other than PLN found - unable to test currency module');
    }
    