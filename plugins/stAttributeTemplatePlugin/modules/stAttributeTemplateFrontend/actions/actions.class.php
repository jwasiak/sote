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
 * stAttributeTemplateFrontend actions.
 *
 * @author Marcin Butlak <marcin#butlak.sote.pl>
 *
 * @package     stAttributeTemplatePlugin
 * @subpackage  actions
 */
class stAttributeTemplateFrontendActions extends sfActions
{
    /** 
     * Pokazuje liste atrybutów z wybranego szablonu
     */
    public function executeAttributeList()
    {
        $this->setLayout(false);
        
        $product_id = $this->getRequestParameter('product_id');

        $c = new Criteria();

        $c->addAscendingOrderByColumn(AttributeFieldPeer::RANK);
        $c->add(ProductHasAttributeFieldPeer::PRODUCT_ID, $product_id);
        $this->attributes = ProductHasAttributeFieldPeer::doSelectJoinAttributeField($c);
     
    }
}
