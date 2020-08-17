<?php
use_helper('Validation', 'stCaptchaGD', 'stUrl');

$smarty->assign('form_start', form_tag('stAvailabilityFrontend/showAddOverlay', array('id' => 'form_availability_alert')));


$smarty->assign('label_description', label_for('question[description]',__('Treść')));

$smarty->assign('input_description', textarea_tag('question[description]',  $question['description'], array('id'=>'st_form-question-description','class'=>form_has_error('question{description}') ? 'st_form-error' : '')));


$smarty->assign('label_username', label_for('question[username]',__('E-mail')));

$smarty->assign('error_username', form_error('question[username]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')));

$smarty->assign('input_username', input_tag('question[username]',  $question['username'], array('id'=>'st_form-question-email','class'=>form_has_error('question{username}') ? 'st_form-error' : '')));

if($config->get('captcha_on', stConfig::INT)==1)
{

    $smarty->assign('captcha_on', $config->get('captcha_on', stConfig::INT)==1);

    $smarty->assign('error_captcha', form_error('captcha', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')));

    $smarty->assign('get_captcha', get_captcha(328));

    $smarty->assign('label_captcha', label_for('captcha',__('Cyfry z obrazka')));

    $smarty->assign('input_captcha', input_tag('captcha', '', array('id'=>'st_form-question-captcha','class'=>form_has_error('captcha') ? 'st_form-error' : '')));
}

$smarty->assign('checkbox_privacy', checkbox_tag('question[privacy]', 1, $sf_params->get('question[privacy]'), array('id'=>'st_form-user-privacy','class'=>form_has_error('question{privacy}') ? 'st_form-error checkobox' : 'checkobox')));

$smarty->assign('is_authenticated', $is_authenticated);

$smarty->assign('hidden_product_id', input_hidden_tag('product_id', $product_id));

$smarty->assign('hidden_option_name', input_hidden_tag('option_name', $option_name));


$smarty->assign('product_name', $product->getName()." ".$option_name);

if(stTheme::is_responsive()){
    if($sf_params->get('question[description]')==""){
        $smarty->assign('description', $question['description']);    
    }else{
        $smarty->assign('description', $sf_params->get('question[description]'));    
    }
    
    if($sf_params->get('question[username]')==""){
        if(sfContext::getInstance()->getUser()->isAuthenticated()){
            $username = sfContext::getInstance()->getUser()->getGuardUser()->getUsername();    
        }            
    }else{
        $username = $sf_params->get('question[username]');    
    }
    
    
    $smarty->assign('error_username', $sf_request->getError('question{username}'));
    $smarty->assign('input_username', input_tag('question[username]', $username, array('id'=>'st_form-question-email', 'placeholder'=> '* '.__('Nadawca (e-mail)'), 'maxlength'=>'255', 'class'=>'form-control')));
    $smarty->assign('input_captcha', input_tag('captcha', '', array('id'=>'st_form-question-captcha', 'placeholder'=> '* '.__("Cyfry z obrazka"), 'class'=>'form-control')));
    $smarty->assign('error_captcha', $sf_request->getError('captcha'));
    
}
$smarty->assign('error_privacy', $sf_request->getError('error_privacy'));


$smarty->display('availability_alert_show_add_overlay.html');

?>

     <script type="text/javascript" language="javascript">
        jQuery(function ($) {
            $('#form_availability_alert').submit(function() {

                <?php if(stTheme::is_responsive()): ?>
                    $.post($(this).attr('action'), $(this).serialize(), function(data) { $('#availability_alert').html(data); });
                <?php else: ?>
                    $.post($(this).attr('action'), $(this).serialize(), function(data) { $('#availability_alert_overlay').find('.availability_alert_overlay_content').html(data); });
                <?php endif; ?>

                return false;
            });
        });
    </script>

    <?php if($close): ?>

    <script type="text/javascript" language="javascript">
        jQuery(function ($) {
            
        <?php if(stTheme::is_responsive()): ?>
                            
            $('.modal-footer').hide();
            $('.modal-form').hide();            
            $('.modal-send').show();
            
            setTimeout(function(){
                $('#availability_alert_modal').modal('hide');  
            }, 2000);
            
        <?php else: ?>
            $('#availability_alert_overlay').overlay().close();
            location.reload();
        <?php endif; ?>
            
        });

    </script>

    <?php endif; ?>