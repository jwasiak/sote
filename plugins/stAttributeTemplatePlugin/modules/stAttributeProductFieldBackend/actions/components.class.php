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
 * Komponenty dla modułu stAttributeProductFieldBackend
 *
 * @author Daniel Mendalka <daniel.mendalka@sote.pl>
 *
 * @package     stAttributeTemplatePlugin
 * @subpackage  actions
 */
class stAttributeProductFieldBackendComponents extends sfComponents
{
    public function executeEditProductAttribute()
    {
        $c = new Criteria();
        $c->add(AttributeFieldPeer::ATTRIBUTE_TEMPLATE_ID, null, Criteria::ISNULL);
        $c->addAscendingOrderByColumn(AttributeFieldPeer::RANK);
        $this->attributes = AttributeFieldPeer::doSelect($c);
        
        if($attributes = $this->getRequestParameter('attributes'))
        {
            foreach($attributes as $index => $value)
            {
                $values[$index] = new ProductHasAttributeField();
                $values[$index]->setAttributeFieldId($index);
                $values[$index]->setValue($value);
            }
        }
        else
        {
              foreach($this->attributes as $attribute)
               {
                $c = new Criteria();
                   $c->add(ProductHasAttributeFieldPeer::ATTRIBUTE_FIELD_ID, $attribute->getId());
                $c->add(ProductHasAttributeFieldPeer::PRODUCT_ID, $this->getRequestParameter('id'));
                $values[$attribute->getId()] = ProductHasAttributeFieldPeer::doSelectOne($c);
            }
        }
        $this->values = !empty($values) ? $values : null;
    }
}