<?php
use_helper('stProductImage');
$smarty->assign("category", $category);
if ($product)
{
    $smarty->assign("product", $product);
    $smarty->assign('id',$product->getId());
    $smarty->assign('height', st_asset_thumbnail_setting('height', 'thumb'));
    $smarty->assign('photo', link_to(st_product_image_tag($product, 'thumb'), 'stProduct/list?url=' . $category->getFriendlyUrl()));
}
$smarty->display("product_tree_product.html");
?>