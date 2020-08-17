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
 * Rozszerzenie stPluginAttributeField
 *
 * @author Marcin Butlak <marcin@butlak.sote.pl>
 *
 * @package     stAttributeTemplatePlugin
 * @subpackage  libs
 */
class AttributeField extends BaseAttributeField
{
    public function __toString()
    {
        return $this->getName();
    }
    
    public function moveUp()
    {
        if($this->getPosition()==1)
        {
            return;
        }
        $c = new Criteria();
        $c->add(AttributeFieldPeer::ATTRIBUTE_TEMPLATE_ID, $this->getAttributeTemplateId());
        $c->add(AttributeFieldPeer::RANK, $this->getPosition()-1);
        if(!$nextSibling = AttributeFieldPeer::doSelectOne($c))
        {
            return;
        }
        $nextSibling->setPosition($this->getPosition());
        $this->setPosition($this->getPosition()-1);
        if($nextSibling->save())
        {
            $this->save();
        }
    }
    
    public function moveDown()
    {
        if($this->getPosition() == $this->getAttributeTemplate()->countAttributeFields())
        {
            return;
        }
        $c = new Criteria();
        $c->add(AttributeFieldPeer::ATTRIBUTE_TEMPLATE_ID, $this->getAttributeTemplateId());
        $c->add(AttributeFieldPeer::RANK, $this->getPosition()+1);
        if(!$prevSibling = AttributeFieldPeer::doSelectOne($c))
        {
            return;
        }
        $prevSibling->setPosition($this->getPosition());
        $this->setPosition($this->getPosition()+1);
        if($prevSibling->save())
        {
            $this->save();
        }
    }
}