<?php

class stPlatnosciPlListener
{
	public static function postOrderSummary(sfEvent $event)
	{		
		if (stConfig::getInstance('stPlatnosciPlBackend')->get('autoredirect'))
		{
			// $action = $event->getSubject();

			// if ($action->order->showPayment())
			// {
			// 	sfLoader::loadHelpers(array('Helper', 'stUrl'));
			// 	sfContext::getInstance()->getController()->redirect(st_url_for('@stPaymentPay?id='.$action->id.'&hash_code='.$action->hash_code));
			// }
		}
	}
}