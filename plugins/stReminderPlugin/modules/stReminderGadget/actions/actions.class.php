<?php
class stReminderGadgetActions extends stGadgetActions 
{
    public function executeIndex()
    {
		stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stReminderBackend.beforeReminderCount', array()));
        $c = new Criteria();
        $c->add(BackendAlertPeer::DISPLAY,1);
        $c->addDescendingOrderByColumn(BackendAlertPeer::CREATED_AT);
        $this->items = BackendAlertPeer::doSelect($c);
    }
}
