<?php
use_helper('stProductImage', 'stReview', 'stPhotoGallery', 'stText', 'Validation', 'stUrl');
st_theme_use_stylesheet('stReview.css');

if($reviewed_products)
{
    $smarty->assign('reviewed_products', $reviewed_products);
}

$results=array();

foreach ($reviewed_products as $order_product_reviewed)
{
    $row['input_hidden_product_id']=input_hidden_tag('review_product['.$order_product_reviewed->getProductId().'][id]', $order_product_reviewed->getProductId(), array());
    $row['product_name_link']="<span ".get_tooltip($order_product_reviewed->getProduct()->getName(),3).">".st_link_to(st_truncate_text($order_product_reviewed->getProduct()->getName(),40,'...'), 'stProduct/show?url='.$order_product_reviewed->getProduct()->getFriendlyUrl(),array('class'=>'product_name'))."</span>";
    $row['product_image_link']=st_link_to(st_product_image_tag($order_product_reviewed->getProduct(), 'thumb'), 'stProduct/show?url='.$order_product_reviewed->getProduct()->getFriendlyUrl());
    $row['product_score']=$order_product_reviewed->getScore();
    $row['product_description']=$order_product_reviewed->getDescription();
    $row['agreement_checkbox']=checkbox_tag('review_product['.$order_product_reviewed->getProduct()->getId().'][agreement]', 1, true, array('disabled' => true));

    $results[]=$row;
}

$smarty->assign('results',$results);

$smarty->display('review_list_products_reviewed.html');
?>