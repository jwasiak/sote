<?php
use_helper('Validation', 'stCaptchaGD');
st_theme_use_stylesheet('stNewsletterPlugin.css');
use_javascript('jquery.infieldlabel.js', 'last');

$smarty->assign("form_start", form_tag('stNewsletterFrontend/addToList', array('class' => 'st_form_ver6')));

$smarty->assign("label_email", label_for('email',__('E-mail')));

$smarty->assign("error_email", form_error('newsletter[email]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')));

$smarty->assign("input_email", input_tag('newsletter[email]',$sf_params->get('newsletter[email]'), array('id'=>'email','class'=>form_has_error('newsletter{email}') ? 'st_form-error' : '')));

$smarty->assign('checkbox_privacy', checkbox_tag('newsletter[privacy]', 1, $sf_params->get('newsletter[privacy]'), array('id'=>'st_form-user-privacy','class'=>form_has_error('newsletter{privacy}') ? 'st_form-error checkobox' : 'checkobox')));

$smarty->assignPartial('link_to_privacy', 'stUser', 'privacy');

$smarty->assign('error_privacy', $sf_request->getError('error_privacy'));

$smarty->assign('register_text_title', $newsletter_config->get('register_text_title', null, true));

$smarty->assign('register_text_description', $newsletter_config->get('register_text_description', null, true));

$smarty->assign('register_text_under_register', $newsletter_config->get('register_text_under_register', null, true));


if($config->get('captcha_on', stConfig::INT)==1)
{
     $smarty->assign('captcha_on', $config->get('captcha_on', stConfig::INT)==1);

	 $smarty->assign('error_captcha', form_error('captcha', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')));

     $smarty->assign('get_captcha', get_captcha('270'));

     $smarty->assign('label_captcha', label_for('captcha_img',__('Cyfry z obrazka')));

     $smarty->assign('input_captcha', input_tag('captcha', '', array('id'=>'captcha_img','class'=>form_has_error('captcha') ? 'st_form-error' : '')));
}


if(stTheme::is_responsive()):
    $smarty->assign('input_email', input_tag('newsletter[email]',  $sf_params->get('newsletter[email]'), array('id'=>'email', 'placeholder'=>"* ".__('E-mail (login)'), 'maxlength'=>'255', 'class'=>'form-control')));
    $smarty->assign('input_captcha', input_tag('captcha', '', array('id'=>'captcha_img', 'placeholder'=>"* ".__('Cyfry z obrazka'), 'maxlength'=>'255', 'class'=>'form-control')));
endif;


$smarty->assign("newsletterGroup", $newsletterGroup);
if ($newsletterGroup)
{
    $results=array();
    foreach ($newsletterGroup as $group)
    {
        $checked = 0;
        if($group->getIsDefault()==1)
        {
            $checked = 1;
        }
        $row['input']=checkbox_tag('newsletter[group]['.$group->getId().']', 1, $checked);
        $row['name']=$group->getName();
        $row['description']=$group->getDescription();
        $results[]=$row;
    }
    $smarty->assign('results',$results);
}


$compatibility_config = stConfig::getInstance('stCompatibilityBackend');

//if(stCompatibilityLaw::isSection("terms_privacy_newsletter_countrys",stCompatibilityLaw::getIsoCountry($sf_user->getCulture())) && $compatibility_config->get('terms_privacy_newsletter_show')==1){

$smarty->assign("terms_privacy_show", 1);
$terms_privacy_text = $compatibility_config->get('terms_privacy_newsletter_text', null, true);


if(stTheme::is_responsive()):
    $terms_text = $terms_privacy_text;
    
    $terms_text = preg_replace('/{LINK_TO_PRIVACY}/', '$', $terms_text);
    $terms_text = preg_replace('/{\/LINK_TO_PRIVACY}/', '$', $terms_text);    
    $terms_text = preg_replace('/{LINK_TO_TERMS}/', '%', $terms_text);
    $terms_text = preg_replace('/{\/LINK_TO_TERMS}/', '%', $terms_text);
            
    $tmp_string_terms_privacy = explode("$",$terms_text);
    $tmp_string_terms_shop = explode("%",$terms_text);    
    
    $terms_privacy = $tmp_string_terms_privacy[1];
    $terms_shop = $tmp_string_terms_shop[1];
    
    
    $terms_text = $terms_privacy_text;
    
    $terms_text = preg_replace('/{LINK_TO_PRIVACY}/', '%', $terms_text);
    $terms_text = preg_replace('/{\/LINK_TO_PRIVACY}/', '%', $terms_text);
    $terms_text = preg_replace('/{LINK_TO_TERMS}/', '%', $terms_text);
    $terms_text = preg_replace('/{\/LINK_TO_TERMS}/', '%', $terms_text);
    
    
    $tmp_string = explode("%",$terms_text);
    
    $string = '';

    foreach ($tmp_string as $value) {
        
        if($value==$terms_privacy){
            $string .= st_get_component('stWebpageFrontend', 'link', array('state'=>'PRIVACY', 'label'=>$terms_privacy));
        }elseif($value==$terms_shop){
            $string .= st_get_component('stWebpageFrontend', 'link', array('state'=>'TERMS', 'label'=>$terms_shop));            
        }else{
            $string .= $value;    
        }   
    }    
     
    $smarty->assign("terms_privacy_newsletter_text", $string);
else:    
    $terms_right_2_cancel_text = preg_replace('/{RIGHT_TO_CANCEL}/', '<a id="active_right_2_cancel_overlay" class="label_terms_confirm" href="#active_right_2_cancel_overlay">', $terms_right_2_cancel_text);
    $terms_right_2_cancel_text = preg_replace('/{\/RIGHT_TO_CANCEL}/', '</a>', $terms_right_2_cancel_text);
    $terms_right_2_cancel_text = preg_replace('/{TERMS_AND_CONDITIONS}/', '<a id="active_terms_overlay" class="label_terms_confirm" href="#active_terms_overlay">', $terms_right_2_cancel_text);
    $terms_right_2_cancel_text = preg_replace('/{\/TERMS_AND_CONDITIONS}/', '</a>', $terms_right_2_cancel_text);
    $smarty->assign("terms_right_2_cancel_text", $terms_right_2_cancel_text);    
     
endif;



//}


$smarty->assign("submit_button", submit_tag(__('Dodaj')));

$smarty->display("newsletter_index.html");
?>