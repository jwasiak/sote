<?php
if ($order->getOrderUserDataBillingId())
{
    if ($order->getOptClientName())
    {
        echo "<p>".$order->getOptClientName()."</p>";
    }
    elseif($order->getsfGuardUser())
    {
        echo "<p>".$order->getsfGuardUser()->getUsername()."</p>";
    }
}

if ($order->getsfGuardUserId())
{
    if ($order->getOptClientEmail())
    {
        echo st_external_link_to($order->getOptClientEmail(), 'user/edit?id=' . $order->getsfGuardUserId());
    }
    elseif($order->getsfGuardUser())
    {
        echo st_external_link_to($order->getsfGuardUser()->getUsername(), 'user/edit?id=' . $order->getsfGuardUserId());
    }
}
?>