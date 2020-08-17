<?php
use_helper('stProductImage', 'stReview', 'stPhotoGallery', 'stText', 'Validation', 'stUrl');

if($reviewed_products_without_agreement)
{
    $smarty->assign('reviewed_products_without_agreement', $reviewed_products_without_agreement);
}

$smarty->assign('form_start', form_tag('review/saveProductWithoutAgreement?order_id='.$order->getId().'&hash_code='.$order->getHashCode()));
$results=array();

foreach ($reviewed_products_without_agreement as $order_product_reviewed_without_agreement)
{
    $row['input_hidden_product_id']=input_hidden_tag('review_product['.$order_product_reviewed_without_agreement->getProductId().'][id]', $order_product_reviewed_without_agreement->getProductId(), array());
    $row['product_name_link']="<span ".get_tooltip($order_product_reviewed_without_agreement->getProduct()->getName(),3).">".st_link_to(st_truncate_text($order_product_reviewed_without_agreement->getProduct()->getName(),40,'...'), 'stProduct/show?url='.$order_product_reviewed_without_agreement->getProduct()->getFriendlyUrl(),array('class'=>'product_name'))."</span>";
    $row['product_image_link']=st_link_to(st_product_image_tag($order_product_reviewed_without_agreement->getProduct(), 'thumb'), 'stProduct/show?url='.$order_product_reviewed_without_agreement->getProduct()->getFriendlyUrl());
    $row['product_score']=$order_product_reviewed_without_agreement->getScore();
    $row['product_description']=$order_product_reviewed_without_agreement->getDescription();
    $row['input_hidden_agreement']=input_hidden_tag('$order_product_reviewed_without_agreement_id[id]['.$order_product_reviewed_without_agreement->getId().']', $order_product_reviewed_without_agreement->getId());
    $row['agreement_checkbox']=checkbox_tag("agreement", 1, false);

    $results[]=$row;
}

if($reviewed_products_without_agreement)
{
    $smarty->assign('reviewed_products_without_agreement', $reviewed_products_without_agreement);
    $smarty->assign('save_submit', submit_tag(__('Zapisz')));
}

$smarty->assign('results',$results);
$smarty->display('review_list_products_reviewed_without_agreement.html');
?>