<?php
use_helper('stCurrency', 'stText', 'stProductImage', 'stUrl');
$row = array();
foreach ($results as $result) {
    $result_url = st_url_for('stProduct/show?url=' . $result->getFriendlyUrl());

    //desc     
    $desc = $result->getShortDescription();
    if (empty($desc)) $desc = $result->getDescription();
    $desc = strip_tags($desc); 
    if (preg_match('/^.{1,250}\b/s', $desc, $match))   {   $desc=trim($match[0])."...";  }
    $desc = stNewSearch::str_highlight($desc,implode(' ',$search->getQueryKeywords()));

    $image = $result->getOptImage();
    if (!empty($image)) $image = content_tag('a', st_product_image_tag($result, 'thumb'), array('href' => $result_url));

    if ($result->isPriceVisible())
    {
        $check_price  = false;     
    }else{
        $check_price = true;
    }

    // manufacturer
    $manufacturer = '';
    if (is_object($result->getProducer())) $manufacturer = $result->getProducer()->getName();
    $row[] = array(
        'name'=>                content_tag('a',$result->getName(),  array('href' => $result_url)),
        'description' =>        $desc,
        'image' =>              $image,
        'manufacturer' =>       $manufacturer, 
        'check_price' =>        $check_price,
        'price_net' =>          st_currency_format($result->getPriceNetto(true)), 
        'price_gross'=>         st_currency_format($result->getPriceBrutto(true)), 
        'basket' =>             st_get_component('stBasket', 'add', array('product' => $result)),
        'more' =>               content_tag('a',__('Więcej',null,'stSearchFrontend'),  array('href' => $result_url)),
        'instance' =>           $result,
        'points_value' =>       $result->getPointsValue(),
        'points_earn' =>        $result->getPointsEarn(),
        'points_only' =>        $result->getPointsOnly(),
    );
}

//points system
$smarty->assign('points_system_is_active', stPoints::isPointsSystemActive());
$smarty->assign('show_points', $config_points->get('product_alternative_list_show_points'));
$smarty->assign('display_type', $config_points->get('product_alternative_list_display_type'));
$smarty->assign('points_shortcut', $config_points->get('points_shortcut', null, true));
$smarty->assign('points_login_status', stPoints::getLoginStatusPoints());
$smarty->assign('is_authenticated', sfContext::getInstance() -> getUser() -> isAuthenticated());
$smarty->assign('is_release', stPoints::isReleasePointsSystemForUser());

$smarty->assign('results',$row );
$smarty->display('search_list.html');
