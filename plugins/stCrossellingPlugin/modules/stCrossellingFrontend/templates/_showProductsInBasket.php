<?php
st_theme_use_stylesheet('stPromoteProductsInBasket.css');
$smarty->assign('products', get_partial("stProduct/listOther", array('product_pager' => $pager, 'smarty' => $productSmarty, 'config' => $productConfig)));
$smarty->display('crosselling_show_products_in_basket.html');
?>