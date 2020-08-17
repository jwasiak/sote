<?php
class stOrderObservePaymentBehavior
{
    public function postSave($payment, $con)
    {        
        OrderPeer::updateOptIsPayedByPayment($payment, $con);
    }
}
?>