<?php 
$smarty->assign('id', $product->getId());
$smarty->assign('product', $product);
$smarty->assign('amount', $product->getPriceBrutto(true));
$smarty->display('payment_show_info_in_product.html');
?>