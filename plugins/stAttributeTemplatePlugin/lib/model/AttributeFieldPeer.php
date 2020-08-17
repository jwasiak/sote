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
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id$
 * @author      Daniel Mendalka <daniel.mendalka@sote.pl>
 */

/** 
 * Rozszerzenie stPluginAttributeFieldPeer
 *
 * @author Marcin Butlak <marcin@butlak.sote.pl>
 *
 * @package     stAttributeTemplatePlugin
 * @subpackage  libs
 */
class AttributeFieldPeer extends BaseAttributeFieldPeer
{
    public static function doDelete($values, $con = null)
    {
        $fieldToDelete = AttributeFieldPeer::retrieveByPK($values);
        $c = new Criteria();
        $c->add(AttributeFieldPeer::ATTRIBUTE_TEMPLATE_ID, $fieldToDelete->getAttributeTemplateId());
        $c->add(AttributeFieldPeer::RANK, $fieldToDelete->getPosition(), '>');
        $fieldsToModify = AttributeFieldPeer::doSelect($c);
        foreach($fieldsToModify as $field)
        {
            $field->setPosition($field->getPosition()-1);
            $field->save();
        }
        parent::doDelete($values, $con);
    }
    
}