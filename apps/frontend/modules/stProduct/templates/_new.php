<?php

use_helper('stCurrency', 'stProductImage', 'stText', 'stUrl', 'stAvailability');

sfLoader::loadHelpers('stProduct', 'stProduct');

st_theme_use_stylesheet('stProduct.css');

$smarty->assign("show_name", $config->get('show_name_group'));

$smarty->assign("show_image", $config->get('show_image_group'));

$smarty->assign("show_price", $config->get('show_price_group'));

$smarty->assign("show_description", $config->get('show_description_group'));

$smarty->assign("show_old_price", $config->get('show_old_price_group'));

$smarty->assign("show_discount", $config->get('show_discount_group'));

$smarty->assign("price_view", $config->get('price_view_group'));

$smarty->assign('show_weight', $config->get('show_weight_group'));

if ($group_url)
{
    $smarty->assign('new_products_title', st_link_to($group_name, 'stProduct/groupList?url=' . $group_url));

    $smarty->assign('new_products_link', st_url_for('stProduct/groupList?url='.$group_url));
}
else
{
    $smarty->assign('new_products_title', __("Nowości"));

    $smarty->assign('new_products_link', "#");
}

$photo_max_height = st_asset_thumbnail_setting('height', 'small');
$photo_max_width = st_asset_thumbnail_setting('width', 'small');

$results = array();

$i = 0;

$theme_version = stTheme::getInstance($sf_context)->getVersion();

$weight_unit = $config->get('weight_unit');

foreach ($products as $index => $product)
{
    if (!$product->isActive())
    {
        continue;
    }
        
    $i++;
    if ($i == 1)
    {
        $results[$index]['class'] = 'st_component-st_product-product_main_box_first';
    }
    elseif ($i == 3)
    {
        $results[$index]['class'] = 'st_component-st_product-product_main_box_last';
        $i = 0;
    }
    else
    {
        $results[$index]['class'] = 'st_component-st_product-product_main_box_middle';
    }

    $product_url = st_url_for('stProduct/show?url=' . $product->getFriendlyUrl());

    $results[$index]['instance'] = $product;

    $results[$index]['id'] = $product->getId();

    $results[$index]['photo'] = content_tag('a', st_product_image_tag($product, 'small', array('style' => 'max-width: '.$photo_max_width.'px')), array('href' => $product_url));

    $results[$index]['photo_max_height'] = $photo_max_height;

    $results[$index]['name'] = content_tag('a', $product->getName(), array('href' => $product_url));

    $results[$index]['image_list'] = st_theme_image_tag('circle_list_product.gif', array('alt' => ''));

    $results[$index]['point'] = st_theme_image_tag('circle_list_product.gif', array('alt' => '', 'width'=>'11', 'height'=>'11'));

    $results[$index]['colors'] = st_get_component('stProductOptionsFrontend', 'colors', array('product' => $product));

    $results[$index]['uom'] = st_product_uom($product);

    $results[$index]['stock'] = $product->getStock();

    if ($product->isPriceVisible())
    {
        $results[$index]['price'] = st_currency_format($product->getPriceBrutto(true));

        $results[$index]['price_net'] = st_currency_format($product->getPriceNetto(true));

        $old_price_brutto = $product->getOldPriceBrutto(true);

        $results[$index]['check_old_price'] = $old_price_brutto != 0;

        $results[$index]['old_price'] = st_currency_format($old_price_brutto);

        $results[$index]['old_price_net'] = st_currency_format($product->getOldPriceNetto(true));

        $results[$index]['discount'] = $product->getDiscountInPercent();

        $results[$index]['check_price'] = false;

        if ($theme_version < 3)
        {
            $results[$index]['basket'] = st_get_component('stBasket', 'add', array('product' => $product));
        }
    }
    else
    {
        $results[$index]['check_price'] = true;
    }
    
    $results[$index]['points_value'] = $product->getPointsValue();
    
    $results[$index]['points_earn'] = $product->getPointsEarn();
    
    $results[$index]['points_only'] = $product->getPointsOnly();

    $results[$index]['description'] = $product->getShortDescription() ? $product->getShortDescription() : $product->getDescription();

    $results[$index]['name_without_link'] = $product->getName();

    $results[$index]['link'] = 'stProduct/show?url=' . $product->getFriendlyUrl();

    $results[$index]['code'] = $product->getCode();

    $results[$index]['weight'] = $config->get('show_weight_group') && $product->getWeight() ? $product->getWeight().' '.$weight_unit : '';

    $results[$index]['my_groups'] = st_product_group_labels($product, $product_url, $sf_user->getCulture());
    $results[$index]['availability'] = st_availability_show($product);
}

$smarty->assign('show_stock', $config->get('show_depository_group'));
$smarty->assign('show_availability', $config->get('show_availability_group'));

//points system
$smarty->assign('points_system_is_active', stPoints::isPointsSystemActive());
$smarty->assign('show_points', $config_points->get('product_group_show_points'));
$smarty->assign('display_type', $config_points->get('product_group_display_type'));
$smarty->assign('points_shortcut', $config_points->get('points_shortcut', null, true));
$smarty->assign('config_points',$config_points);

$smarty->assign("results", $results);


$smarty->display('product_new.html');
