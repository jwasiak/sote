<?php
use_helper('stApplication', 'stProductImage', 'stUrl');
$smarty->assign('host', $sf_request->getHost());
$smarty->assign('question_head', $head);
$smarty->assign('question_foot', $foot);
$smarty->assign('product_id', $product_id);
$smarty->assign('product_photo', st_link_to(st_product_image_tag($product, 'small', array('absolute' => true, 'style' => 'border: none;')), 'stProduct/show?url='.$product->getFriendlyUrl(), array('absolute' => true, 'style' => 'border: none;')));
if ($product_code)
{
    $smarty->assign('product_code', $product_code);
}
if ($product_producer)
{
    $smarty->assign('product_producer', $product_producer);
}
if ($product_category)
{
    $smarty->assign('product_category', $product_category);
}
$smarty->assign('product_name', $product_name);
$smarty->assign('about', $about);
$smarty->assign('text', $text);
$smarty->assign('from', $from);
$smarty->assign('question_link', st_link_to(__("Przejdź do zapytania"), '@stGoToQuestion?question='.$id, array('absolute' => true, 'for_app' => 'backend', 'style' => 'text-decoration: none; color: black; font-weight: bold; font-size: 13px;')));
$smarty->display('question_shop_plain_mail.html');
?>