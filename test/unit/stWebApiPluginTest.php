<?php
/** 
 * SOTESHOP/stWebApiPlugin 
 * 
 * Ten plik należy do aplikacji stWebApiPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stWebApiPlugin
 * @subpackage  tests
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stWebApiPluginTest.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michał Prochowski <michal.prochowski@sote.pl>
 */

$modules = array (
//                   "webapi" => array( "HelloWorld" => NULL,
//                                      "Test" => array ("Text" => "qwertyuiopasdfghjklzxcvbnmęóąśłżźćń") ),
//                   "stProduct" => array( "GetProduct" => array ( "id" => 1 ),
//                                       "GetProductList" => array ( "_offset" => 0, "_limit" => 0 ),
//                                       "CountProduct" => NULL,
//                                       "AddProduct" => array ( "name" => "Testowy produkt - Webapi", "price" => 10.0, "category_id" => 1, "producer_id" => 1, "vat" => 22, "description" => "Opis produktu testowego.", "code"=>rand(0,1000), "active"=>"1" ),
//                                       "UpdateProduct" => array ( "id" => 0, "name" => "Testowy produkt - Webapi 2" ),
//                                       "AssignProductToCategory" => array( "id" => 0, "category_id" => 5),
//                                       "RemoveProductFromCategory" => array( "id" => 0, "category_id" => 5),
//                                       "DeleteProduct" => array ( "id" => 0 ),
//),
//                   "stCategory" => array( "GetCategory" => array ( "id" => 1 ),
//                                        "GetCategoryList" => array ( "_offset" => 0, "_limit" => 0 ),
//                                        "CountCategory" => NULL,
//                                        "AddCategory" => array ( "name" => "Testowa kategoria - Webapi", "parent_id"=>3 ),
//                                        "UpdateCategory" => array ( "id" => 0, "name" => "Testowa kategoria - Webapi 2" ),
//                                        "DeleteCategory" => array ( "id" => 0 ),
//),
//                   "stProducer" => array("GetProducer" => array ( "id" => 1 ),
//                                        "GetProducerList" => array ( "_offset" => 0, "_limit" => 0 ),
//                                        "CountProducer" => NULL,
//                                        "AddProducer" => array ( "name" => "Testowy producent - Webapi" ),
//                                        "UpdateProducer" => array ( "id" => 0, "Name" => "Testowy producent - Webapi 2" ),
//                                        "DeleteProducer" => array ( "id" => 0 ),
//),
//                   "stOrder" => array( //"GetOrder" => array ( "id" => 1 ),
//                                     "GetOrderList" => array ( "_offset" => 0, "_limit" => 0 ),
//                                     "CountOrder" => NULL,
//"AddOrder" => array ( "UserDataId" => 1),
//"UpdateOrder" => array ( "id" => 0, "UserId" => 1, "TotalAmount" => "5", "TotalAmountBrutto" => "6.10" ),
//"DeleteOrder" => array ( "id" => 0 ),
//),
//                   "stUserData" => array( "GetUser" => array ( "id" => 1 ),
//                                        "GetUserList" => array ( "_offset" => 0, "_limit" => 0 ),
//                                      "CountUser" => NULL,
//                                      "AddUser" => array ( "Email" => "michal@sote.pl", "Password" => "qwerty", "Active" =>1),
//                                      "UpdateUser" => array ( "id" => 0, "Email" => "michal.prochowski@sote.pl" ),
//                                      "DeleteUser" => array ( "id" => 0 ),
//),
//                   "stAvailability" => array( "GetAvailability" => array ( "id" => 1 ),
//                                      "GetAvailabilityList" => array ( "_offset" => 0, "_limit" => 0 ),
//                                      "CountAvailability" => NULL,
//                                      "AddAvailability" => array ( "AvailabilityName" => "Testowa", "StockFrom" => 20, "Symbol" =>1),
//                                      "UpdateAvailability" => array ( "id" => 0, "AvailabilityName" => "Testowa1" ),
//                                      "DeleteAvailability" => array ( "id" => 0 ),
//),
//                   "stDepository" => array( "GetDepository" => array ( "id" => 1 ),
//                                      "GetDepositoryList" => array ( "_offset" => 0, "_limit" => 0 ),
//                                      "CountDepository" => NULL,
//                                      "AddDepository" => array ( "ProductId" => "1", "Stock" => 312),
//                                      "UpdateDepository" => array ( "id" => 0, "AvailabilityName" => "Testowa1" ),
//                                      "DeleteDepository" => array ( "id" => 0 ),
//),
);
/** 
 * Wymagane pliku do testow
 */
//require(dirname(__FILE__).'/../bootstrap/unit.php');
//
//$t = new lime_test(24, new lime_output_color());
//
//$t->diag('Webapi module unit test');
//
//$t->diag(" ");
//$t->diag("PHP info test:");
//$t->diag(" ");
//
////$t->is(0, ini_get("soap.wsdl_cache"), "WSDL caching in php - soap.wsdl_cache = 0");
//$t->is(0, ini_get("soap.wsdl_cache_enabled"), "WSDL caching in php - soap.wsdl_cache_enabled = 0");
//
//foreach ($modules as $module => $methodList)
//{
//    $t->diag(" ");
//    $t->diag($module." test:");
//    $t->diag(" ");
//
//    $tab = array( 'trace' => 1 );
//
//    $addId = 0;
//    
//    try {
//        @$client = new SoapClient("http://soteshop/backend.php/".$module."/soap?wsdl", $tab);
//        $t->pass("Connect");
//
//        foreach ($methodList as $methodName => $methodParam)
//        {
//            try {
//                $obj = new stdClass();
//                if (is_array($methodParam)) {
//                    foreach ($methodParam as $methodParamName => $methodParamValue)
//                    {
//                        $obj->$methodParamName = $methodParamValue;
//                    }
//
//                    if (ereg("^Update", $methodName) || ereg("^Delete", $methodName) || ereg("^Assign", $methodName) || ereg("^Remove", $methodName) )
//                    {
//                        $obj->id = $addId;
//                    }
//                }
//
//                $responseApi = @$client->$methodName($obj);
//
//                if (ereg("^Add", $methodName)) {
//                    $addId = $responseApi->id;
//                }
//
//                $t->pass($methodName);
//
//                if ($module == "webapi" && $methodName == "Test") {
//                    $t->is($responseApi->Text, $obj->Text, "Test encoding");
//                }
//
//            } catch (SoapFault $fault) {
//                $t->fail($methodName."\n".$fault);
//            }
//        }
//    } catch (SoapFault $fault) {
//        $t->fail("Connect \nError string: \n".$fault);
//    }
//}
?>