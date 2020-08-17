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
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id$
 * @author      Daniel Mendalka <daniel.mendalka@sote.pl>
 */

/** 
 * Akcje modułu stAttributeTemplateBackend
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stAttributeTemplatePlugin
 * @subpackage  actions
 */
class stAttributeTemplateBackendActions extends autostAttributeTemplateBackendActions
{
    /** 
     * Wyświetla menadżera atrybutów
     */
    public function executeAttributeManager()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $attribute_template_id = $this->getRequestParameter('attribute_template_id');
            $attribute_fields = $this->getRequestParameter('attribute_field');
            $product_id = $this->getRequestParameter('product_id');
            
            $c = new Criteria();
            $c->add(ProductHasAttributeFieldPeer::PRODUCT_ID, $product_id);
            ProductHasAttributeFieldPeer::doDelete($c);
            if (is_array($attribute_fields))
            {
                foreach ($attribute_fields as $id => $value)
                {
                    $product_has_attribute_field = new ProductHasAttributeField();
                    $product_has_attribute_field->setValue($value);
                    $product_has_attribute_field->setProductId($product_id);
                    $product_has_attribute_field->setAttributeFieldId($id);
                    $product_has_attribute_field->save();
                    $this->setFlash('notice','Zmiany zostały zapisane');
                }
            }
            
            $this->redirect('product/attributeTemplate?id='.$product_id);
        }
    
    }
    
    /** 
     * Wyświetla listę atrybutów
     */
    public function executeAttributeList()
    {
        $product_id = $this->getRequestParameter('product_id');
        
        $c = new Criteria();
        $baseCriteria = $c->getNewCriterion(AttributeFieldPeer::ATTRIBUTE_TEMPLATE_ID, $this->getRequestParameter('template_id'));
        
        $c->add($baseCriteria);
        $c->addAscendingOrderByColumn(AttributeFieldPeer::RANK);
        $c->add(ProductHasAttributeFieldPeer::PRODUCT_ID, $product_id);
        $this->attributes = ProductHasAttributeFieldPeer::doSelectJoinAttributeField($c);
        
        $c->clear();
        $c->add($baseCriteria);
        $c->addAscendingOrderByColumn(AttributeFieldPeer::RANK);
        $this->attribute_fields = AttributeFieldPeer::doSelect($c);
    }
}