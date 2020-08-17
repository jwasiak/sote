<?php
if ($hasProducts)
{
    use_helper('stCurrency', 'stProductPrice', 'stProductImage', 'stText', 'stUrl');

    st_theme_use_stylesheet('stProduct.css');

    $smarty->assign('title', st_link_to(__('Ostatnio oglądane'), 'navigation/showHistory'));

    $smarty->assign('price_view', $productConfig->get('price_view_group'));

    $results = array();

    foreach ($products as $index => $product)
    {
        $url = st_url_for('stProduct/show?url='.$product->getFriendlyUrl());

        $results[$index]['instance'] = $product;

        $results[$index]['id'] = $product->getId();

        $results[$index]['photo'] = content_tag('a', st_product_image_tag($product, 'small'), array('href' => $url));

        $results[$index]['name'] = content_tag('a', $product->getName(), array('href' => $url));

        $results[$index]['name_without_link'] = $product->getName();
        
        $results[$index]['link'] = $url;

        $results[$index]['image_list'] = st_theme_image_tag('circle_list_product.gif', array('alt' => ''));

        $results[$index]['point'] = st_theme_image_tag('circle_list_product.gif', array('alt' => '', 'width'=>'11', 'height'=>'11'));
        
        if ($product->isPriceVisible())
        {
            $results[$index]['check_price'] = false;

            $results[$index]['price'] = st_currency_format($product->getPriceBrutto(true));

            $results[$index]['price_net'] = st_currency_format($product->getPriceNetto(true));

            $results[$index]['basket'] = st_get_component('stBasket', 'add', array('product' => $product));
        }
        else
        {
            $results[$index]['check_price'] = true;
        }

        if ($product->getShortDescription())
        {
            $results[$index]['description'] = $product->getShortDescription();
        }
        else
        {
            $results[$index]['description'] = st_truncate_text($product->getDescription(), 140, '...');
        }
    }

    $smarty->assign('products', $results);

    $smarty->display('navigation_products_box.html');
}
?>