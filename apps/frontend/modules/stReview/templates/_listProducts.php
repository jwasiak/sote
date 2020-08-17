<?php
use_helper('stProductImage', 'stReview', 'stPhotoGallery', 'stText', 'Validation', 'stUrl');
st_theme_use_stylesheet('stReview.css');

if($review_products)
{
    $smarty->assign('review_products', $review_products);
}

$smarty->assign('form_start', form_tag('review/saveProduct?order_id='.$order->getId().'&hash_code='.$order->getHashCode()));
$results=array();

foreach ($review_products as $order_product)
{
    $row['input_hidden_product_id']=input_hidden_tag('review_product['.$order_product->getProductId().'][id]', $order_product->getProductId(), array());
    $row['product_name_link']="<span".get_tooltip($order_product->getProduct()->getName(),3).">".st_link_to(st_truncate_text($order_product->getProduct()->getName(),40,'...'), 'stProduct/show?url='.$order_product->getProduct()->getFriendlyUrl(),array('class'=>'product_name'))."</span>";
    $row['product_image_link']=st_link_to(st_product_image_tag($order_product->getProduct(), 'thumb'), 'stProduct/show?url='.$order_product->getProduct()->getFriendlyUrl());
    $row['error_product_description']=form_error('review_product['.$order_product->getProduct()->getId().'][description]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'));
    $row['error_product_score']=form_error('review_product['.$order_product->getProduct()->getId().'][score]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'));
    $row['product_score']=select_tag('review_product['.$order_product->getProduct()->getId().'][score]', options_for_select(array('- ', '1', '2', '3', '4', '5'), $sf_request->getParameter('review_product['.$order_product->getProduct()->getId().'][score]')));
    $row['product_description']=textarea_tag('review_product['.$order_product->getProduct()->getId().'][description]', $sf_request->getParameter('review_product['.$order_product->getProduct()->getId().'][description]'), array ('size' => '39x12', 'rich' => false, 'tinymce_options' => "height:165,width:270,theme:'simple'"));
    $row['agreement_checkbox']=checkbox_tag('review_product['.$order_product->getProduct()->getId().'][agreement]', 1, true);

    $results[]=$row;
}
$smarty->assign('results',$results);

if($review_products)
{
    $smarty->assign('review_products', $review_products);
    $smarty->assign('save_submit', submit_tag(__('Zapisz')));
}

$smarty->display('review_list_products.html');
?>