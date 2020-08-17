<?php
st_theme_use_stylesheet('stNewsletterPlugin.css');
if($loginUser)
{
    $smarty->assign("newsletter_header", link_to(__("Zapisz się na newsletter"),"stNewsletterFrontend/newsletterList"));
    $smarty->assign("form_start", form_tag('stNewsletterFrontend/addLoginUserToNewsletter', array('class' => 'st_form_ver6')));
}
else
{
    $smarty->assign("newsletter_header", link_to(__("Zapisz się na newsletter"),"stNewsletterFrontend"));
    $smarty->assign("form_start", form_tag('stNewsletterFrontend/add', array('class' => 'st_form_ver6')));
}
$smarty->assign("hidden_new_user", input_hidden_tag('newsletter[new_user]', $new_user));
$smarty->assign("hidden_privacy", input_hidden_tag('newsletter[privacy]', 1));
$smarty->assign("input_email", input_tag('newsletter[email]', '', array('class' => 'form-control', 'placeholder' => __('Twój email...'))));
$smarty->assign("submit_button",submit_tag(__('Dodaj'), array('class' => 'btn btn-primary')));

$smarty->assign('register_text_widget_title', $config->get('register_text_widget_title', null, true));
$smarty->assign('register_text_widget_description', $config->get('register_text_widget_description', null, true));


$smarty->display("newsletter_box.html");
?>