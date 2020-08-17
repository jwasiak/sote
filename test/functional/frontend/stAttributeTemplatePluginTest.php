<?php
/** 
 * SOTESHOP/stAttributeTemplatePlugin 
 * 
 * Ten plik należy do aplikacji stAttributeTemplatePlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stAttributeTemplatePlugin
 * @subpackage  tests
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id$
 * @author      Pawel Byszewski <pawel.byszewski@sote.pl>
 */

/** 
 * Testy stAttributeTemplatePlugin
 */
include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$browser = new sfTestBrowser();
$browser->initialize();

$browser->get('/');

$c = new Criteria();
$c->addJoin(ProductHasAttributeFieldPeer::PRODUCT_ID,ProductPeer::ID);
$c->addJoin(ProductHasAttributeFieldPeer::ATTRIBUTE_FIELD_ID,AttributeFieldPeer::ID);
$combined = ProductHasAttributeFieldPeer::doSelectOne($c);
if (!$combined){
    $browser->test()->diag('Unable to test attribute templates - no attributes found');
} else {
    $combined_id = $combined->getId();
    $product_id = $combined->getProductId();

    $browser->
        get('/stProduct/show/id/'.$product_id.'/product_description/3')->
        isStatusCode(200)->
        responseContains($combined->getProduct()->getName())->
        responseContains($combined->getAttributeField()->getName())->
        responseContains($combined->getValue());
}
?>