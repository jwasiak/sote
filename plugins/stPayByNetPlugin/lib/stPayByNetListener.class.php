<?php

class stPayByNetListener {

    public static function postExecuteOrderSave(sfEvent $event) {
        $order = $event->getSubject()->order;

        $payByNetId = $event->getSubject()->getRequestParameter('user_data_billing[paybynet]');

        $c = new Criteria();
        $c->add(PaybynetHasOrderPeer::ORDER_ID, $order->getId());
        $paybynet = PaybynetHasOrderPeer::doSelectOne($c);

        if (!is_object($paybynet)) {
            $paybynet = new PaybynetHasOrder();
            $paybynet->setOrderId($order->getId());
        }

        if (!empty($payByNetId))
            $paybynet->setPaymentType($payByNetId);

        $paybynet->save();
    }
}
