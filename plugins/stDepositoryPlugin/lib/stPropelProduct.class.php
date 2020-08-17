<?php
/** 
 * SOTESHOP/stDepositoryPlugin 
 * 
 * Ten plik należy do aplikacji stDepositoryPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stDepositoryPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stPropelProduct.class.php 1942 2009-06-30 14:19:44Z krzysiek $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl> 
 */

/** 
 * stDepositoryFrontend
 *
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl> 
 * @package     stDepositoryPlugin
 * @subpackage  libs
 */
class stPropelProduct
{
    /** 
     * statyczna funkcje pobierania stanu magazynowego dla importu eksportu
     *
     * @param        Product      $product
     * @return   string
     */
    public static function getProductDepository(Product $product) 
    {
        
        if (!$product->hasStockManagmentWithOptions())
        {
            $stock = $product->getStock();
        }
        else
        {
            $c = new Criteria();
            $c->addSelectColumn('SUM('.ProductOptionsValuePeer::STOCK.')');
            $c->add(ProductOptionsValuePeer::PRODUCT_ID, $product->getId());
            $c->add(ProductOptionsValuePeer::LFT, sprintf('%s - %s = 1', ProductOptionsValuePeer::RGT, ProductOptionsValuePeer::LFT) , Criteria::CUSTOM);
    
            $rs = ProductOptionsValuePeer::doSelectRS($c);
    
            $stock = $rs->next() ? $rs->get(1) : 0;
        }

        return stPrice::round($stock);
    }

    /** 
     * statyczna funkcje pobierania stanu magazynowego dla importu eksportu
     *
     * @param        Product      $product
     * @param        string      $value
     */
    public static function setProductDepository(Product $product, $value = '') 
    {      
        if (!$product->hasStockManagmentWithOptions())
        { 
            if (is_numeric($value))
            {
                $product->setStock($value);
            }
            else
            {
                $product->setStock(NULL);   
            }
        }
    }    
}
?>