<?php
if ($product)
{
    use_helper('stProductImage', 'stText','stUrl');
    st_theme_use_stylesheet('stProduct.css');
    $smarty->assign("photo",st_link_to(st_product_image_tag($product, 'small'), 'stProduct/show?url='.$product->getFriendlyUrl()));
    $smarty->assign("show_name", $config->get('show_name'));
    $smarty->assign("show_code", $config->get('show_code'));
    $smarty->assign("show_short_description", $config->get('show_short_description'));
    $smarty->assign("show_photo", $config->get('show_photo'));
    $smarty->assign("code", st_truncate_text($product->getCode(),25,'...'));
    $smarty->assign("name", st_truncate_text($product->getName(),50,'...'));
    if ($product->getShortDescription())
    {
        $smarty->assign("short_desc", st_truncate_text($product->getShortDescription(),100,'...'));
    }
    else
    {
        $smarty->assign("short_desc", st_truncate_text($product->getDescription(),100,'...'));
    }
    $smarty->display('product_small_info.html');
}
?>