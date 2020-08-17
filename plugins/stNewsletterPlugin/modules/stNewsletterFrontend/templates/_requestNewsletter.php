<?php
if($config->get('newsletter_on', stConfig::INT)==1 && $config->get('newsletter_enable', stConfig::INT)!=1)
{
    
    $smarty->assign('checkbox_newsletter', checkbox_tag('user_data_billing[newsletter]', 1, $newsletterRequest, array('id'=>'st_form-user-newsletter')));
    $smarty->assign('newsletter_text', __('Zapisz mnie na newsletter'));
}
$smarty->display('newsletter_request_newsletter.html');
?>