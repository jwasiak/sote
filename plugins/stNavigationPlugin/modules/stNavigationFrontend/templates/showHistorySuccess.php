<?php
st_theme_use_stylesheet('stProduct.css');
use_helper('stCurrency', 'stImageSize', 'stProductPrice', 'stProductPhoto');
sfLoader::loadHelpers('stProduct', 'stProduct');
$smarty->assign('pager', st_get_partial('pager', array('for_link' => array('page' => $page), 'pager' => $products, 'smarty' => $smarty, 'page' => $page)));
$smarty->assign('product', st_get_partial('stProduct/'.$listType, array('product_pager' => $products, 'smarty' => $smarty_product, 'config' => $config, 'config_points' => $config_points))); 
$smarty->assignPartial('list_type', 'stProduct', 'view_type', array('for_link' => $for_link, 'view_labels' => $view_labels, 'smarty' => $smarty_product, 'action' => 'showHistory'));
$smarty->assignPartial('sort', 'stProduct', 'sort', array('for_link' => $for_link, 'smarty' => $smarty_product, 'sort_labels' => $sort_labels, 'action' => 'showHistory'));
$smarty->assignComponent('producer_filter', 'stProduct', 'producerFilter', array('related_object' => $related, 'for_link' => $for_link, 'action' => 'showHistory'));

$smarty->display('navigation_show_history.html');
?>
