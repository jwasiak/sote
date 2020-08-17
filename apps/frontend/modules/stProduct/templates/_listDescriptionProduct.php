<?php

use_helper('stCurrency', 'stText', 'stProductImage', 'stUrl');

sfLoader::loadHelpers('stProduct', 'stProduct');

st_theme_use_stylesheet('stProduct.css');

$results = array();

$smarty->assign("show_name", $config->get('show_name_long'));

$smarty->assign("show_image", $config->get('show_image_long'));

$smarty->assign("show_code", $config->get('show_code_long'));

$smarty->assign("show_price", $config->get('show_price_long'));

$smarty->assign("show_old_price", $config->get('show_old_price_long'));

$smarty->assign("show_discount", $config->get('show_discount_long'));

$smarty->assign("show_basket", $config->get('show_basket_long'));

$smarty->assign("price_view", $config->get('price_view_long'));

$smarty->assign("show_description", $config->get('show_description_long'));

$smarty->assign('show_weight', $config->get('show_weight_short'));

//points system
$smarty->assign('points_system_is_active', stPoints::isPointsSystemActive());
$smarty->assign('show_points', $config_points->get('product_full_list_show_points'));
$smarty->assign('display_type', $config_points->get('product_full_list_display_type'));
$smarty->assign('points_shortcut', $config_points->get('points_shortcut', null, true));
$smarty->assign('points_login_status', stPoints::getLoginStatusPoints());
$smarty->assign('is_authenticated', sfContext::getInstance() -> getUser() -> isAuthenticated());
$smarty->assign('is_release', stPoints::isReleasePointsSystemForUser());

$weight_unit = $config->get('weight_unit');


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
        $results[$index]['name'] = '<span title="'.$product_name.'"  class="hint">' . content_tag('a', st_truncate_text($product_name, $max_name_length, '...'), array('href' => $product_url, 'class' => 'product_name')) . '</span>';
    }
    else
    {
        $results[$index]['name'] = content_tag('a', $product_name, array('href' => $product_url, 'class' => 'product_name'));
    }

    if ($cut_code && st_check_strlen($product->getCode()) > $max_code_length)
    {
        $results[$index]['code'] = '<span title="'.$product->getCode().'" class="hint">' . content_tag('a', st_truncate_text($product->getCode(), $max_code_length, '...'), array('href' => $product_url, 'class' => 'product_name')) . '</span>';
    }
    else
    {
        $results[$index]['code'] = content_tag('a', $product->getCode(), array('href' => $product_url));
    }
    
    $results[$index]['producer'] = $product->getProducer() ? $product->getProducer()->getName() : null;
    
    $results[$index]['id'] = $product->getId();

    $results[$index]['photo'] = content_tag('a', st_product_image_tag($product, 'small'), array('href' => $product_url));

    $results[$index]['photo_max_height'] = $photo_max_height;

    $results[$index]['colors'] = st_get_component('stProductOptionsFrontend', 'colors', array('product' => $product));

    if ($product->isPriceVisible())
    {

        if ($config->get('show_uom_long') && $product->getUom())
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

        if ($theme_version < 3)
        {
            $results[$index]['basket'] = st_get_component('stBasket', 'add', array('product' => $product));
        }

        $results[$index]['discount'] = $product->getDiscountInPercent();

        $results[$index]['check_price'] = false;

        if ($config->get('show_basic_price_long') && $product->hasBasicPrice() && $product->getBasicPriceBrutto()!=0)
        {
            $results[$index]['basic_price'] = array(
                'netto' => st_currency_format($product->getBasicPriceNetto(true)),
                'brutto' => st_currency_format($product->getBasicPriceBrutto(true)),
                'quantity' => st_product_basic_price_quantity($product),
                'for_quantity' => st_product_basic_price_for_quantity($product),
            );
        }         

    }
    else
    {
        $results[$index]['check_price'] = true;
    }
    
    $results[$index]['points_value'] = $product->getPointsValue();
    
    $results[$index]['points_earn'] = $product->getPointsEarn();
    
    $results[$index]['points_only'] = $product->getPointsOnly();

// 7

    if ($description_type == 'short')
    {
        if ($cut_description && st_check_strlen($product->getShortDescription()) > $max_desc_length)
        {
            $results[$index]['description'] = st_truncate_text($product->getShortDescription(), 1000, '...');
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
            $results[$index]['description'] = st_truncate_text($product->getDescription(), 1000, '...');
        }
        else
        {
            $results[$index]['description'] = strip_tags($product->getDescription());
        }
    }
    

    $results[$index]['name_without_link'] = $product_name;

    $results[$index]['link'] = $product_url;
    
    $results[$index]['my_groups'] = st_product_group_labels($product, $product_url, $sf_user->getCulture());

    $results[$index]['weight'] = $config->get('show_weight_short') && $product->getWeight() ? $product->getWeight().' '.$weight_unit : '';
}

$smarty->assign('results', $results);

$smarty->display('product_list_description.html');
?>
