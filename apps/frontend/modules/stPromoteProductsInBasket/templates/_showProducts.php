<?php
st_theme_use_stylesheet('stPromoteProductsInBasket.css');
$smarty->assign('products', st_get_component($moduleName, $componentName));
$smarty->display('show_products.html');
?>