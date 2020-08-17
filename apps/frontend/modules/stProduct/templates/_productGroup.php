<?php

use_helper('stCurrency', 'stProductImage', 'stText', 'stUrl', 'stAvailability');

sfLoader::loadHelpers('stProduct', 'stProduct');

st_theme_use_stylesheet('stProduct.css');


$smarty->assign("show_name", $config->get('show_name_group'));

$smarty->assign("show_image", $config->get('show_image_group'));

$smarty->assign("show_price", $config->get('show_price_group'));

$smarty->assign("show_basket", $config->get('show_basket_long'));

$smarty->assign("show_description", $config->get('show_description_group'));

$smarty->assign("show_old_price", $config->get('show_old_price_group'));

$smarty->assign("show_discount", $config->get('show_discount_group'));

$smarty->assign('show_weight', $config->get('show_weight_group'));

$smarty->assign("price_view", $config->get('price_view_group'));

$smarty->assign("product_group", $product_group);

$smarty->assign('group_name_title', st_link_to($group_name, 'stProduct/groupList?url=' . $group_url));

$smarty->assign('group_name_link', st_url_for('stProduct/groupList?url=' . $group_url));

$description_type = $config->get('description_type_group');

$show_description = $config->get('show_description');

$cut_description = $product_group == 'MAIN_PAGE' ? $config->get('cut_description_group') : false;

$max_desc_length = $config->get('cut_description_num_group');

$cut_name = $product_group == 'MAIN_PAGE' ? $config->get('cut_name_group') : false;

$max_name_length = $config->get('cut_name_num_group');

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

    $product_url = st_url_for('stProduct/show?url=' . $product->getFriendlyUrl());

    $product_name = $product->getName();

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

    if ($cut_name && st_check_strlen($product_name) > $max_name_length + 1)
    {
        $results[$index]['name'] = '<span title="'.$product_name.'"  class="hint">' . content_tag('a', st_truncate_text($product_name, $max_name_length, '...'), array('href' => $product_url, 'class' => 'product_name')) . "</span>";
    }
    else
    {
        $results[$index]['name'] = content_tag('a', $product_name, array('href' => $product_url, 'class' => 'product_name'));
    }

    $results[$index]['instance'] = $product;

    $results[$index]['id'] = $product->getId();

    $results[$index]['photo'] = content_tag('a', st_product_image_tag($product, 'small'), array('href' => $product_url));

    $results[$index]['point'] = st_theme_image_tag('circle_list_product.gif', array('alt' => '', 'width'=>'11', 'height'=>'11'));

    $results[$index]['colors'] = st_get_component('stProductOptionsFrontend', 'colors', array('product' => $product));

    $results[$index]['uom'] = st_product_uom($product);

    $results[$index]['stock'] = $product->getStock();

    if ($product->isPriceVisible())
    {
        if ($config->get('show_uom_group') && $product->getUom())
        {
            $uom = " / ".$results[$index]['uom'];
        }else{
            $uom = "";
        }

        $results[$index]['price'] = st_currency_format($product->getPriceBrutto(true)).$uom;

        $results[$index]['price_net'] = st_currency_format($product->getPriceNetto(true)).$uom;

        $results[$index]['price_brutto_pure'] = $product->getPriceBrutto(true).$uom;

        $results[$index]['price_netto_pure'] = $product->getPriceNetto(true).$uom;

        $currency = stCurrency::getInstance(sfContext::getInstance());
        
        if ($currency->getFrontSymbol())
        {
            $results[$index]['currency'] = $currency->getFrontSymbol();
        }
        else
        {
            $results[$index]['currency'] = $currency->getBackSymbol();
        }

        $old_price_brutto = $product->getOldPriceBrutto(true);

        $results[$index]['check_old_price'] = $old_price_brutto != 0;

        $results[$index]['old_price'] = st_currency_format($old_price_brutto);

        $results[$index]['old_price_net'] = st_currency_format($product->getOldPriceNetto(true));

        $results[$index]['discount'] = $product->getDiscountInPercent();

        if ($theme_version < 3)
        {
            $results[$index]['basket'] = st_get_component('stBasket', 'add', array('product' => $product));
        }

        $results[$index]['check_price'] = false;
    }
    else
    {
        $results[$index]['check_price'] = true;
    }

    $results[$index]['points_value'] = $product->getPointsValue();
    
    $results[$index]['points_earn'] = $product->getPointsEarn();
    
    $results[$index]['points_only'] = $product->getPointsOnly();

    if ($show_description)
    {
        if ($description_type == 'short')
        {
            if ($cut_description && st_check_strlen($product->getShortDescription()) > $max_desc_length)
            {
                $results[$index]['description'] = st_truncate_text($product->getShortDescription(), $max_desc_length, '...');
            }
            else
            {
                $results[$index]['description'] = $product->getShortDescription();
            }
        }
        elseif ($description_type == 'full')
        {
            if ($cut_description && st_check_strlen($product->getDescription()) > $max_desc_length)
            {
                $results[$index]['description'] = st_truncate_text($product->getDescription(), $max_desc_length, '...');
            }
            else
            {
                $results[$index]['description'] = $product->getDescription();
            }
        }
    }

    $results[$index]['name_without_link'] = $product->getName();

    $results[$index]['link'] = st_url_for('stProduct/show?url=' . $product->getFriendlyUrl());

    $results[$index]['code'] = $product->getCode();

    $results[$index]['my_groups'] = st_product_group_labels($product, $product_url, $sf_user->getCulture());

    $results[$index]['weight'] = $config->get('show_weight_group') && $product->getWeight() ? $product->getWeight().' '.$weight_unit : '';
    
    if ($config->get('show_basic_price_group') && $product->hasBasicPrice() && $product->getBasicPriceBrutto()!=0)
    {
        $results[$index]['basic_price'] = array(
            'netto' => st_currency_format($product->getBasicPriceNetto(true)),
            'brutto' => st_currency_format($product->getBasicPriceBrutto(true)),
            'quantity' => st_product_basic_price_quantity($product),
            'for_quantity' => st_product_basic_price_for_quantity($product),
        );
    }   
    
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
$smarty->assign('points_login_status', stPoints::getLoginStatusPoints());
$smarty->assign('is_authenticated', sfContext::getInstance() -> getUser() -> isAuthenticated());
$smarty->assign('is_release', stPoints::isReleasePointsSystemForUser());

$smarty->assign("results", $results);

if ($product_group == 'MAIN_PAGE')
{
    $smarty->display('product_main.html');
}
else
{
    $smarty->display('product_group.html');
}
