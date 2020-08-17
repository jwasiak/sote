<?php
/**
 * SOTESHOP/stBoxPlugin
 *
 * Ten plik należy do aplikacji stBoxPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stBoxPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id$
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/**
 * Klasa stBoxFrontendComponents
 *
 * @package     stBoxPlugin
 * @subpackage  actions
 */
class stBoxFrontendComponents extends sfComponents
{
    public function executeBoxes()
    {
        $c = new Criteria();
        $c->add(BoxPeer::ACTIVE,1);
        $this->boxes = BoxPeer::doSelect($c);
        if (!$this->boxes)
        {
            return sfView::NONE;
        }
        $this->smarty = new stSmarty('stBoxFrontend');
    }

    public function executeBoxSingle()
    {
        if ($this->webmaster_id || $this->id)
        {
            $c = new Criteria();
            if ($this->webmaster_id)
            {
                $c->add(BoxPeer::WEBMASTER_ID, $this->webmaster_id);
            }
            elseif ($this->id)
            {
                $c->add(BoxPeer::ID, $this->id);
            }
            $c->add(BoxPeer::ACTIVE, 1);
            stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stBoxFrontendComponents.preBoxQuery', array('criteria' => $c)));
            $this->box = BoxPeer::doSelectOne($c);
        }

        if (!$this->box)
        {
            return sfView::NONE;
        }
        $this->smarty = new stSmarty('stBoxFrontend');

    }

    public function executeBoxGroup()
    {
        if (!$this->box_group)
        {
            return sfView::NONE;
        }

        $c = new Criteria();
        $c->add(BoxGroupPeer::BOX_GROUP,$this->box_group);
        $c->addJoin(BoxGroupPeer::ID, BoxPeer::BOX_GROUP_ID);
        $c->add(BoxPeer::ACTIVE, 1);
        stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stBoxFrontendComponents.preBoxQuery', array('criteria' => $c)));
        $this->boxes = BoxPeer::doSelect($c);
        if (!$this->boxes)
        {
            return sfView::NONE;
        }
        $this->smarty = new stSmarty('stBoxFrontend');
    }
}
