<?php
$smarty->assign("product_group_name", $product_group);
$smarty->assign("list", st_get_partial("stProduct/listOther", array('product_pager' => $pager, 'smarty' => $smarty, 'config' => $config, 'in_basket' => 1)));
$smarty->display("product_in_basket_group.html");
?>