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
 * Komponenty dla modułu stAttributeTemplateBackend
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stAttributeTemplatePlugin
 * @subpackage  actions
 */
class stAttributeTemplateBackendComponents extends autostAttributeTemplateBackendComponents
{
    /** 
     * Wyświetla wybór szablonu i atrybuty
     */
    public function executeAttributeValueManager()
    {
        $this->product_id = $this->product->getId();

        $c = new Criteria();
                
        $c->addAscendingOrderByColumn(AttributeFieldPeer::RANK);
        
        $c->add(ProductHasAttributeFieldPeer::PRODUCT_ID, $this->product_id);

        $this->attributes = ProductHasAttributeFieldPeer::doSelectJoinAttributeField($c);

        if (isset($this->attributes[0]))
        {
            $this->attribute_template = $this->attributes[0]->getAttributeField()->getAttributeTemplate();
        }
        else
        {
            $this->attribute_template = new AttributeTemplate();
        }
       
        $c->clear();
        
        $c->addAscendingOrderByColumn(AttributeFieldPeer::RANK);
        
        $c->add(AttributeFieldPeer::ATTRIBUTE_TEMPLATE_ID, $this->attribute_template->getPrimaryKey());
        
        $this->attribute_fields =  AttributeFieldPeer::doSelect($c);

    }
}