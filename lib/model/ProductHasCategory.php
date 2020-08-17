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
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: ProductHasCategory.php 661 2009-04-16 07:01:00Z michal $
 */

/** 
 * Klasa reprezentujaca wiersz dla tabeli st_product_has_category
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stProduct
 * @subpackage  libs
 */
class ProductHasCategory extends BaseProductHasCategory
{
    public function isDefaultForCategory($category_id)
    {
        return $this->getCategoryId() == $category_id && $this->getIsDefault();
    }
    
    public function isProductInCategory($product_id, $category_id)
    {
        return $this->getProductId() == $product_id && $this->getCategoryId() == $category_id;
    }
    
    /** 
     * Sprawdza czy kategoria jest kategorią główną
     *
     * @param   array       $product_categories tablica obiektów modelu ProductHasCategory  
     * @param   integer     $category_id        id kategorii
     * @return   bool
     */
    public static function checkDefaultCategory($product_categories = array(), $category_id)
    {
        foreach ($product_categories as $product_category)
        {
            if ($product_category->isDefaultForCategory($category_id))
            {
                return true;
            }
        }
        
        return false;
    }

    /** 
     * Sprawdza czy kategoria jest kategorią główną
     *
     * @param   array       $product_categories tablica obiektów modelu ProductHasCategory  
     * @param   integer     $product_id         id produktu
     * @param   integer     $category_id        id kategorii
     * @return   bool
     */
    public static function checkProductInCategory($product_categories = array(), $product_id, $category_id)
    {
        foreach ($product_categories as $product_category)
        {
            if ($product_category->isProductInCategory($product_id, $category_id))
            {
                return true;
            }
        }
        
        return false;        
    }
    
    public function save($con = null)
    {
        if ($this->getIsDefault())
        {
            $c = new Criteria();
            
            $c->add(ProductHasCategoryPeer::PRODUCT_ID, $this->getProductId());
            
            $c->add(ProductHasCategoryPeer::IS_DEFAULT, true);
            
            $c->add(ProductHasCategoryPeer::ID, $this->getId(), Criteria::NOT_EQUAL);
            
            $category = ProductHasCategoryPeer::doSelectOne($c);
            
            if ($category)
            {
                $category->setIsDefault(false);
                
                $category->save();
            }
        }

        if ($this->isNew())
        {
            ProductHasCategoryPeer::cleanCache();
        }
        
        parent::save($con);
    }

    public function delete($con = null)
    {
        parent::delete($con);

        ProductHasCategoryPeer::cleanCache();
    }
}













