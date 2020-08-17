<?php
sfLoader::loadHelpers('stProduct', 'stProduct');

$smarty->assign('stock', content_tag('span', $stock, array('id' => 'st_depository_stock_amount-value', 'style' => 'float: none')));

$smarty->assign('show_depository', null !== $stock ? $show_depository : false);

$smarty->assign('uom', st_product_uom($product));

$smarty->assign('show_availability', $show_availability);

if ($show_availability)
{
    $smarty->assign('availability', st_get_component('stAvailabilityFrontend','availability',array('product'=>$product, 'smarty'=>$smarty)));
}

$smarty->display('depository.html');
?>

