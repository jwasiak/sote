<?php
$basket_ajax = stConfig::getInstance('stBasket')->get('ajax');
stConfig::getInstance('stBasket')->set('ajax', false);

use_helper('stCurrency', 'stText', 'stProductImage', 'stUrl');

sfLoader::loadHelpers('stProduct', 'stProduct');

st_theme_use_stylesheet('stProduct.css');

$results = array();

$photo_max_height = st_asset_thumbnail_setting('height', 'small');

$photo_max_width = st_asset_thumbnail_setting('width', 'small');

$description_type = $config->get('description_type_long');

$cut_description = $config->get('cut_description_long');

$max_desc_length = $config->get('cut_description_num_long');

$cut_name = $config->get('cut_name_long');

$max_name_length = $config->get('cut_name_num_long');

$cut_code = $config->get('cut_code_long');

$max_code_length = $config->get('cut_code_num_long');

$theme_version = stTheme::getInstance($sf_context)->getVersion();

foreach ($products as $index => $product)
{
    if (!$product->getActive())
    {
        continue;
    }    

    $product_name = $product->getName();

    $results[$index]['instance'] = $product;

    if ($cut_name && st_check_strlen($product_name) > $max_name_length)
    {
        $results[$index]['name'] = "<span title=\"" . $product_name . "\">" . st_truncate_text($product_name, $max_name_length, '...') . "</span>";
    }
    else
    {
        $results[$index]['name'] = $product_name;
    }

    $results[$index]['photo'] = st_product_image_tag($product, 'thumb');
    $results[$index]['large_photo'] = st_product_image_tag($product, 'small');

    $results[$index]['link'] = st_url_for('stProduct/show?url=' . $product->getFriendlyUrl());

    $results[$index]['price'] = st_currency_format($product->getPriceBrutto(true));
    $old_price = $product->getOldPriceBrutto(true);

    $results[$index]['old_price'] = $old_price > 0 ? st_currency_format($old_price) : false;

    if ($theme_version < 3)
    {
        $results[$index]['basket'] = st_get_component('stBasket', 'add', array('product' => $product));
    }
    else
    {
        $results[$index]['basket'] = st_basket_add_link('basket_gift_'.isset($overlay), $product);
    }

    if ($description_type == 'short')
    {
        if ($cut_description && st_check_strlen($product->getShortDescription()) > $max_desc_length)
        {
            $results[$index]['description'] = st_truncate_text($product->getShortDescription(), $max_desc_length, '...');
        }
        else
        {
            $results[$index]['description'] = strip_tags($product->getShortDescription());
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
            $results[$index]['description'] = strip_tags($product->getDescription());
        }
    }
}

$smarty->assign('more', $count > $limit && $overlay);
$smarty->assign('max', $limit);
$smarty->assign('results', $results);

$smarty->display('show.html');

stConfig::getInstance('stBasket')->set('ajax', $basket_ajax);
?>
