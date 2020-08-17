<?php
use_helper('Validation', 'stCaptchaGD', 'stUrl');

use_javascript('/stCategoryTreePlugin/js/jquery-1.3.2.min.js', 'first'); 
use_javascript('/stCategoryTreePlugin/js/jquery-no-conflict.js', 'first'); 
use_javascript('/js/jquery.rating.js', 'first'); 

st_theme_use_stylesheet('stReview.css');

$smarty->assign('form_start', form_tag('stReview/showAddOverlay', array('id' => 'form_stars', 'data-recording-ignore'=>'mask')));

$smarty->assign('label_description', label_for('review[description]',__('Recenzja')));
$smarty->assign('input_description', textarea_tag('review[description]',  $sf_params->get('review[description]'), array('id'=>'st_form-review-description','class'=>form_has_error('review{description}') ? 'st_form-error' : '')));


if($order){
    $name = $order->getOptClientName();
}else{
    $name =  $sf_params->get('review[username]');
}

$smarty->assign('label_username', label_for('review[username]',__('Podpis')));
$smarty->assign('error_username', form_error('review[username]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')));
$smarty->assign('input_username', input_tag('review[username]', $name, array('id'=>'st_form-review-email','class'=>form_has_error('review{username}') ? 'st_form-error' : '')));

if($config->get('captcha_on', stConfig::INT)==1 && !$order && !$no_captcha)
{
    $smarty->assign('captcha_on', $config->get('captcha_on', stConfig::INT)==1);
    $smarty->assign('error_captcha', form_error('captcha', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error', 'style'=>'margin-left:110px;padding:0px;')));
    $smarty->assign('get_captcha', get_captcha(320));
    $smarty->assign('label_captcha', label_for('captcha',__('Cyfry z obrazka')));
    $smarty->assign('input_captcha', input_tag('captcha', '', array('id'=>'st_form-review-captcha','class'=>form_has_error('captcha') ? 'st_form-error' : '')));
}

if(stTheme::is_responsive()){
    
    $smarty->assign('description', $sf_params->get('review[description]'));
    $smarty->assign('get_captcha', get_captcha(328));
    $smarty->assign('error_username', $sf_request->getError('review{username}'));
    $smarty->assign('input_username', input_tag('review[username]', $name, array('id'=>'st_form-review-email', 'placeholder'=> '* '.__('Podpis'), 'maxlength'=>'255', 'class'=>'form-control')));
    $smarty->assign('input_captcha', input_tag('captcha', '', array('id'=>'st_form-review-captcha', 'placeholder'=> '* '.__("Cyfry z obrazka"), 'class'=>'form-control')));
    $smarty->assign('error_captcha', $sf_request->getError('captcha'));
    $smarty->assign('checkbox_privacy', checkbox_tag('privacy', 1, $sf_params->get('privacy'), array('id'=>'st_form-privacy','class'=>form_has_error('privacy') ? 'st_form-error checkobox' : 'checkobox')));
}else{
    $smarty->assign('checkbox_privacy', checkbox_tag('privacy', 1, $sf_params->get('privacy'), array('id'=>'st_form-user-privacy','class'=>form_has_error('privacy') ? 'st_form-error checkobox' : 'checkobox')));
}


$smarty->assign('error_privacy', $sf_request->getError('error_privacy'));

$smarty->assign('review_submit', submit_tag(__('Dodaj recenzję'), array('id'=>'st_button_review_add'))); 

$smarty->assign('is_authenticated', $is_authenticated); 

$smarty->assign('hidden_product_id', input_hidden_tag('product_id', $product_id));

$smarty->assign('hidden_hash_code', input_hidden_tag('hash_code', $hash_code));

$smarty->assign('my_star_raiting', $my_star_raiting); 

$smarty->assign('image_path', st_product_image_path($product, 'thumb', true, false, true));

$smarty->assign('product_name', $product->getName());

$smarty->assign('review_description', $review_config -> get('description', null, true));

$smarty->display('review_show_add_overlay.html');
?>
<script type="text/javascript" language="javascript">
    jQuery(function ($) {

        $(document).ready(function () {
            
            $('#st_form-privacy').click(function() {                                    
                $("#captcha_form").toggle();
            });
    
            if ($('#st_form-privacy').attr('checked')) {
                $("#captcha_form").show()
            } else {
                $("#captcha_form").hide();
            }
            
            $('#form_stars').submit(function() {

            <?php if(stTheme::is_responsive()): ?>
                $.post($(this).attr('action'), $(this).serialize(), function(data) { $('#star_raiting').html(data); });
            <?php else: ?>
                $.post($(this).attr('action'), $(this).serialize(), function(data) { $('#star_raiting_overlay').find('.overlay_content').html(data); });
            <?php endif; ?>

            return false;
            });
            
            
            $('.submit-star').rating({
                callback: function(value, link){

                    //   $(this.form).ajaxSubmit();
                }
            });
        });
    });
</script>

<?php if($close): ?>
    
<script type="text/javascript" language="javascript">
    jQuery(function ($) {
        
         <?php if(stTheme::is_responsive()): ?>
            $('#star_raiting_modal').modal('hide');            
            var url = location.href.split('?');                                  
            window.location = url[0];                                   
        <?php else: ?>
            $('#star_raiting_overlay').overlay().close();
            var url = location.href.split('?');                      
            window.location = url[0];
        <?php endif; ?>

    });

</script>

<?php endif; ?>

