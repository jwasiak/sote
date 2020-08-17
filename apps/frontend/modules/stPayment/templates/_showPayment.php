<?php
$smarty->assign("show_payment", st_get_component($paymentType.'Frontend', 'showPayment', array('order' => $order)));
$smarty->assign("payment_name", $paymentTypeName);
$smarty->display("payment_show.html");
