<?php
use_helper('stAdminGenerator');

function st_paypal_order_link($paypal_txn_id)
{
    $c = new Criteria();

    $c->addJoin(OrderHasPaymentPeer::PAYMENT_ID, PaymentPeer::ID);

    $c->addJoin(OrderHasPaymentPeer::ORDER_ID, OrderPeer::ID);

    $c->add(PaymentPeer::HASH, 'PAYPAL-' . $paypal_txn_id);

    $order = OrderPeer::doSelectOne($c);

    if ($order)
    {
        return st_external_link_to($order->getNumber(), 'stOrder/edit?id=' . $order->getId());
    }
    else
    {
        return '-';
    }
}
