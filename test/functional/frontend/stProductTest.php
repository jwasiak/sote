<?php
/** 
 * SOTESHOP/stProduct 
 * 
 * Ten plik należy do aplikacji stProduct opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stProduct
 * @subpackage  tests
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stProductTest.php 617 2009-04-09 13:02:31Z michal $
 */

/** 
 * Test stProduct
 */
include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$browser = new stTestBrowser();
$browser->initialize();

/** 
 * Sprawdza wyświetlanie produktów na liście
 */
$browser->get('/product/list');

$c = new Criteria();
$product = ProductPeer::doSelectOne($c);
if (!$product){
    $browser->test()->fail('Nie znaleziono produktów');
    return 0;
}
$product_id=$product->getId();
$browser->test()->diag('Skorzystaj z produktu o id '.$product_id);

/** 
 * Szuka kategorii produktów
 */
$c = new Criteria();
$c->add(ProductHasCategoryPeer::PRODUCT_ID,$product_id);
$category = ProductHasCategoryPeer::doSelectOne($c);
if (!$category){
    $browser->test()->diag('Produkt nie znajduje się w żadnej kategorii');
}else{
    $category_id=$category->getCategoryId();
    $browser->test()->diag('Skorzystaj z kategorii o id '.$category_id);

    // if categories found sumerating pages of category until product found
    $found_product=false;
    $i = 0;
    do{
        $i++;
        $browser->get('/product/list/id_category/'.$category_id.'/page/'.$i);        
        if (strpos($browser->getResponse()->getContent(),$product->getName())!==false)
        {
            $found_product=true;
            break;
        }
    }while (strpos($browser->getResponse()->getContent(),'<span>'.$i.'</span>')!==false);
    
    // echo a test message
    if ($found_product){
        $browser->test()->pass('Found product in category');
    }else{
        $browser->test()->fail('Failed to find product in category');
    }
}

// check for existence of product webpage and checking for its name and price (with vat)
$browser->get('/product/show/id/'.$product_id)->isStatusCode(200);
$browser->responseContains($product->getName());
$browser->responseContains(number_format($product->getPrice()*(1+$product->getVat()/100),2,',', ''));

// get DOM and find product image path
//$dom=$browser->getResponseDom();
//$image=$dom->getElementById('st_product-show_success_image');
//$file_path=SF_ROOT_DIR.DIRECTORY_SEPARATOR.'web'.$image->childNodes->item(0)->childNodes->item(0)->getAttribute(src);
//
//if (!file_exists($file_path)){
//    $browser->test()->fail('Image for product not found: '.$file_path);
//}else{
//    $browser->test()->pass('Image for product found');
//}