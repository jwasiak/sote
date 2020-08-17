<?php
use_helper('stApplication', 'stProductImage', 'stUrl');
$smarty->assign('host', $sf_request->getHost());
$smarty->assign('question_head', $head);
$smarty->assign('question_foot', $foot);
$smarty->assign('product_id', $product_id);
$smarty->assign('product_photo', st_link_to(st_product_image_tag($product, 'small', array('absolute' => true, 'style' => 'border: none;')), 'stProduct/show?url='.$product->getFriendlyUrl(), array('absolute' => true, 'style' => 'border: none;')));
$smarty->assign('product_name', st_link_to($product_name, 'stProduct/show?url='.$product->getFriendlyUrl(), array('absolute' => true, 'style' => 'text-decoration: none; color: #576278; font-size:16px; font-weight:bold;')));

if ($product_code) $smarty->assign('product_code', $product_code);
if ($product_producer) $smarty->assign('product_producer', $product_producer);
if ($product_category) $smarty->assign('product_category', $product_category);
 
$smarty->assign('about', $about);
$smarty->assign('text', $text);
$smarty->assign('from', $from);
$smarty->assign('mail_subject', $mail_subject);


$smarty->assign('question_link', st_url_for('@stGoToQuestion?question='.$id, true, 'backend'));

$smarty->assign('bg_header_color', $mail_config->get('bg_header_color'));
$smarty->assign('bg_footer_color', $mail_config->get('bg_footer_color'));
$smarty->assign('bg_action_color', $mail_config->get('bg_action_color'));
$smarty->assign('bg_action_link_color', $mail_config->get('bg_action_link_color'));
$smarty->assign('link_color', $mail_config->get('link_color'));
$smarty->assign('logo', $mail_config->get('logo'));
$smarty->assign('date', date("d-m-Y H:i"));

$smarty->display('question_shop_html_mail.html');
?>