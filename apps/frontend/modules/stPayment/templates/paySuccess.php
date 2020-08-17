<?php
$smarty->assign('show_payment', st_get_component('stPayment', 'showPayment', array('order' => $order)));
$smarty->display('payment_pay.html');