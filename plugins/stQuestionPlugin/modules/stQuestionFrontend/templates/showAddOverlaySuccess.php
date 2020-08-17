<?php
use_helper('Validation', 'stCaptchaGD', 'stUrl');

$smarty->assign('form_start', form_tag('stQuestionFrontend/showAddOverlay', array('id' => 'form_question_'.$question_type, 'data-recording-ignore'=>'mask')));


$smarty->assign('label_description', label_for('question[description]',__('Treść')));

$smarty->assign('input_description', textarea_tag('question[description]',  $question['description'], array('id'=>'st_form-question-description','class'=>form_has_error('question{description}') ? 'st_form-error' : '')));


$smarty->assign('label_username', label_for('question[username]',__('Nadawca (e-mail)')));

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

$smarty->assign('error_privacy', $sf_request->getError('error_privacy'));

// echo "<pre>";
// print_r(sfContext::getInstance()->getUser()->getGuardUser()->getUsername());

if(stTheme::is_responsive()){
    
    if($sf_params->get('question[username]')==""){
        if(sfContext::getInstance()->getUser()->isAuthenticated()){
            $username = sfContext::getInstance()->getUser()->getGuardUser()->getUsername();    
        }            
    }else{
        $username = $sf_params->get('question[username]');    
    }
    
    $smarty->assign('description', $sf_params->get('question[description]'));
    $smarty->assign('error_username', $sf_request->getError('question{username}'));
    $smarty->assign('input_username', input_tag('question[username]', $username, array('id'=>'st_form-question-email', 'placeholder'=> '* '.__('Nadawca (e-mail)'), 'maxlength'=>'255', 'class'=>'form-control')));
    $smarty->assign('input_captcha', input_tag('captcha', '', array('id'=>'st_form-question-captcha', 'placeholder'=> '* '.__("Cyfry z obrazka"), 'class'=>'form-control')));
    $smarty->assign('error_captcha', $sf_request->getError('captcha'));
}

$smarty->assign('question_submit', submit_tag(__('Wyślij'), array('id'=>'st_button_question_add')));

$smarty->assign('is_authenticated', $is_authenticated);

$smarty->assign('hidden_product_id', input_hidden_tag('product_id', $product_id));

$smarty->assign('hidden_question_type', input_hidden_tag('question_type', $question_type));

$smarty->assign('question_type', $question_type);


$smarty->display('question_show_add_overlay.html');

?>

<?php if($question_type=="price"): ?>
    <script type="text/javascript" language="javascript">
        jQuery(function ($) {
            $('#form_question_price').submit(function() {
                
                <?php if(stTheme::is_responsive()): ?>
                    $.post($(this).attr('action'), $(this).serialize(), function(data) { $('#price_question').html(data); });
                <?php else: ?>
                    $.post($(this).attr('action'), $(this).serialize(), function(data) { $('#price_question_overlay').find('.price_question_overlay_content').html(data); });
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
                $('#price_question_modal').modal('hide');  
            }, 2000);
                                                                         
        <?php else: ?>
            $('#price_question_overlay').overlay().close();
            location.reload();
        <?php endif; ?>
            
            
        });

    </script>

    <?php endif; ?>

<?php endif; ?>

<?php if($question_type=="depository"): ?>

    <script type="text/javascript" language="javascript">
        jQuery(function ($) {
            $('#form_question_depository').submit(function() {
                
                <?php if(stTheme::is_responsive()): ?>
                    $.post($(this).attr('action'), $(this).serialize(), function(data) { $('#depository_question').html(data); });
                <?php else: ?>
                    $.post($(this).attr('action'), $(this).serialize(), function(data) { $('#depository_question_overlay').find('.depository_question_overlay_content').html(data); });
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
                $('#depository_question_modal').modal('hide');  
            }, 2000);                            
            
        <?php else: ?>
            $('#depository_question_overlay').overlay().close();
            location.reload();
        <?php endif; ?>
            
            
        });

    </script>

    <?php endif; ?>

<?php endif; ?>