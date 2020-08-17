<?php
use_helper('stProductImage', 'stCurrency', 'stUrl');
st_theme_use_stylesheet('stProductsComparePlugin.css');

$smarty->assign("products_compare", $productsWithoutTemplate);
$smarty->assign("show_price", $showPrice);
if($productsWithoutTemplateOn)
{
    $results = array();
    foreach ($productsWithoutTemplate as $product)
    {
        $row['photo'] = st_link_to(st_product_image_tag($product, 'thumb'), 'stProduct/show?id='.$product->getId());
        $row['delete'] = st_link_to(__('usuń'), 'productsCompare/removeProductInCompare?id='.$product->getId());
        $row['delete_link'] = st_url_for('productsCompare/removeProductInCompare?id='.$product->getId());
        $row['name'] = $product->getName();
        is_object($product->getProducer()) ? $row['producer'] = $product->getProducer()->getName() : $row['producer'] = '-';
        $row['price_netto'] = $product->getPriceNetto(true);
        $row['price_brutto'] = $product->getPriceBrutto(true);
        $row['hide_price'] = $product->getHidePrice();
        $row['vat'] = $product->getVat();
        $row['instance'] = $product;
        $results[] = $row;
    }
    $smarty->assign('results', $results);
}
$smarty->assign("hasLastViewedProduct", $hasLastViewedProduct);
$smarty->assign("lastViewedProduct", st_link_to(__('Wróć do ostatnio oglądanego produktu'), $lastViewedProduct['link']));
$smarty->assign("last_viewed_link", st_url_for($lastViewedProduct['link']));
$smarty->display('product_compare_index.html');
?>