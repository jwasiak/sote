<?php

use_helper('stCurrency', 'stText', 'stProductImage', 'stUrl');

sfLoader::loadHelpers('stProduct', 'stProduct');

st_theme_use_stylesheet('stProduct.css');

$results = array();

if(isset($in_basket)) 
{
    $smarty->assign("in_basket", $in_basket);
}

$smarty->assign("show_name", $config->get('show_name_other'));

$smarty->assign("show_image", $config->get('show_image_other'));

$smarty->assign("show_price", $config->get('show_price_other'));

$smarty->assign("show_old_price", $config->get('show_old_price_other'));

$smarty->assign("show_discount", $config->get('show_discount_other'));

$smarty->assign("price_view", $config->get('price_view_other'));

$photo_max_height = st_asset_thumbnail_setting('height', 'thumb');

$cut_name = $config->get('cut_name_other');

$max_name_length = $config->get('cut_name_num_other');

$config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');
$config_points->setCulture(sfContext::getInstance()->getUser()->getCulture());

//points system
$smarty->assign('points_system_is_active', stPoints::isPointsSystemActive());
$smarty->assign('show_points', $config_points->get('product_alternative_list_show_points'));
$smarty->assign('display_type', $config_points->get('product_alternative_list_display_type'));
$smarty->assign('points_shortcut', $config_points->get('points_shortcut', null, true));

$url_params = array(
    'module' => 'stProduct',
    'action' => 'show', 
);

if ($sf_request->hasParameter('producer')) 
{    
    $url_params['producer'] = $sf_request->getParameter('producer');
}

foreach ($product_pager->getResults() as $index => $product)
{
    if (!$product->isActive())
    {
        continue;
    }    

    $url_params['url'] = $product->getUrl();

    $product_url = st_url_for($url_params);

    $product_name = $product->getName();

    $results[$index]['instance'] = $product;

    if ($cut_name && st_check_strlen($product_name) > $max_name_length)
    {
        $results[$index]['name'] = '<span title="'.$product_name.'"  class="hint">' . content_tag('a', st_truncate_text($product_name, $max_name_length, '...'), array('href' => $product_url, 'class' => 'product_name')) . "</span>";
    }
    else
    {
        $results[$index]['name'] = content_tag('a', $product_name, array('href' => $product_url, 'class' => 'product_name'));
    }

    $results[$index]['id'] = $product->getId();

    $results[$index]['photo'] = content_tag('a', st_product_image_tag($product, 'thumb'), array('href' => $product_url));
    $results[$index]['photo_small'] = content_tag('a', st_product_image_tag($product, ''), array('href' => $product_url));

    $results[$index]['photo_max_height'] = $photo_max_height;

    if ($product->isPriceVisible())
    {
        if ($config->get('show_uom_other') && $product->getUom())
        {
            $uom = " / ".$product->getUom();
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

        $results[$index]['basket'] = st_get_component('stBasket', 'add', array('product' => $product));

        $results[$index]['check_price'] = false;
    }
    else
    {
        $results[$index]['check_price'] = true;
    }
    
    $results[$index]['points_value'] = $product->getPointsValue();
    
    $results[$index]['points_earn'] = $product->getPointsEarn();
    
    $results[$index]['points_only'] = $product->getPointsOnly();

    $results[$index]['name_without_link'] = $product_name;

    $results[$index]['link'] = $product_url;

    $results[$index]['my_groups'] = st_product_group_labels($product, $product_url, $sf_user->getCulture());
}

$smarty->assign('results', $results);

$smarty->display('product_list_other.html');
?>