<?php
use_helper('stCurrency', 'stText', 'stProductImage', 'stUrl');
st_theme_use_stylesheet('stProduct.css');

$results = array();
$smarty->assign('show_name', $config->get('show_name_other'));
$smarty->assign('show_image', $config->get('show_image_other'));
$smarty->assign('show_price', $config->get('show_price_other'));
$smarty->assign('show_old_price', $config->get('show_old_price_other'));
$smarty->assign('show_discount', $config->get('show_discount_other'));
$smarty->assign('price_view', $config->get('price_view_other'));

$photo_max_height = st_asset_thumbnail_setting('height', 'thumb');
$photo_max_width = st_asset_thumbnail_setting('width', 'small');

$cut_name = $config->get('cut_name_other');
$max_name_length = $config->get('cut_name_num_other');

foreach ($products as $index => $product) {
    $product_url = st_url_for('stProduct/show?url=' . $product->getFriendlyUrl());
    $product_name = $product->getName();

    $results[$index]['instance'] = $product;

    if ($cut_name && st_check_strlen($product_name) > $max_name_length)
        $results[$index]['name'] = '<span title="'.$product_name.'"  class="hint">' . content_tag('a', st_truncate_text($product_name, $max_name_length, '...'), array('href' => $product_url, 'class' => 'product_name')) . "</span>";
    else
        $results[$index]['name'] = content_tag('a', $product_name, array('href' => $product_url, 'class' => 'product_name'));

    $results[$index]['id'] = $product->getId();
    $results[$index]['photo'] = content_tag('a', st_product_image_tag($product, 'thumb'), array('href' => $product_url));
    $results[$index]['photo_small'] = content_tag('a', st_product_image_tag($product, 'small'), array('href' => $product_url));
    $results[$index]['photo_max_height'] = $photo_max_height;

    if ($product->isPriceVisible()) {
        if ($config->get('show_uom_other') && $product->getUom())
            $uom = " / ".$product->getUom();
        else
            $uom = "";

        $results[$index]['price'] = st_currency_format($product->getPriceBrutto(true)).$uom;
        $results[$index]['price_net'] = st_currency_format($product->getPriceNetto(true)).$uom;
        $results[$index]['price_brutto_pure'] = $product->getPriceBrutto(true).$uom;
        $results[$index]['price_netto_pure'] = $product->getPriceNetto(true).$uom;

        $currency = stCurrency::getInstance(sfContext::getInstance());
        
        if ($currency->getFrontSymbol())
            $results[$index]['currency'] = $currency->getFrontSymbol();
        else
            $results[$index]['currency'] = $currency->getBackSymbol();

        $old_price_brutto = $product->getOldPriceBrutto(true);
        $results[$index]['check_old_price'] = $old_price_brutto != 0;
        $results[$index]['old_price'] = st_currency_format($old_price_brutto);
        $results[$index]['old_price_net'] = st_currency_format($product->getOldPriceNetto(true));
        $results[$index]['discount'] = $product->getDiscountInPercent();
        $results[$index]['basket'] = st_get_component('stBasket', 'add', array('product' => $product));
        $results[$index]['check_price'] = false;

        if ($config->get('show_basic_price_long') && $product->hasBasicPrice() && $product->getBasicPriceBrutto()!=0) {  
            $results[$index]['basic_price'] = array(
                'netto' => st_currency_format($product->getBasicPriceNetto(true)),
                'brutto' => st_currency_format($product->getBasicPriceBrutto(true)),
                'quantity' => st_product_basic_price_quantity($product),
                'for_quantity' => st_product_basic_price_for_quantity($product),
            );  
            
        } 
    } else
        $results[$index]['check_price'] = true;
    
    $results[$index]['points_value'] = $product->getPointsValue();
    $results[$index]['points_earn'] = $product->getPointsEarn();
    $results[$index]['points_only'] = $product->getPointsOnly();
    $results[$index]['name_without_link'] = $product_name;
    $results[$index]['link'] = st_url_for('stProduct/show?url=' . $product->getFriendlyUrl());
}

$smarty->assign('points_system_is_active', stPoints::isPointsSystemActive());
$smarty->assign('show_points', $config_points->get('product_group_show_points'));
$smarty->assign('display_type', $config_points->get('product_group_display_type'));
$smarty->assign('points_shortcut', $config_points->get('points_shortcut', null, true));
$smarty->assign('config_points',$config_points);
$smarty->assign('results', $results);

$smarty->display('crosselling_show_in_product_tab.html');
