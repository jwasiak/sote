<?php

/**
 * Subclass for performing query and update operations on the 'st_backend_alert' table.
 *
 * 
 *
 * @package plugins.stReminderPlugin.lib.model
 */ 
class BackendAlertPeer extends BaseBackendAlertPeer
{
	public static function retrieveByCode($code)
	{
		$c = new Criteria();
		$c->add(BackendAlertPeer::CODE, $code);
		
		return BackendAlertPeer::doSelectOne($c);
	}
	
	public static function getActiveAlerts($codes = array())
	{
		$c = new Criteria();
		$c2 = $c->getNewCriterion(BackendAlertPeer::DISPLAY, 1);
		$c3 = $c->getNewCriterion(BackendAlertPeer::CODE, $codes, Criteria::IN);
		$c2->addOr($c3);
		$c->add($c2);
		return BackendAlertPeer::doSelect($c);
	}

	public static function doSelectActive()
	{
		$codes = stReminder::getCodes();
		$c = new Criteria();
		$c2 = $c->getNewCriterion(BackendAlertPeer::DISPLAY, 1);
		$c3 = $c->getNewCriterion(BackendAlertPeer::CODE, $codes, Criteria::IN);
		$c2->addOr($c3);
		$c->add($c2);
		return BackendAlertPeer::doSelect($c);
	}

	public static function doCountActive()
	{
		$codes = stReminder::getCodes();
		$c = new Criteria();
		$c2 = $c->getNewCriterion(BackendAlertPeer::DISPLAY, 1);
		$c3 = $c->getNewCriterion(BackendAlertPeer::CODE, $codes, Criteria::IN);
		$c2->addOr($c3);
		$c->add($c2);
		return BackendAlertPeer::doCount($c);
	}
	
}
