<?php use_helper('stUrl'); ?>
<?php st_theme_use_stylesheet('stUser.css') ?>

<?php $smarty = new stSmarty('stUser') ?>
<?php $smarty->assign('culture', $sf_user->getCulture());?>
<?php $smarty->assign('privacy_only', $privacy_only); ?>
<?php $smarty->assign('new_window', isset($new_window) ? $new_window : null); ?>

<?php
$compatibility_config = stConfig::getInstance('stCompatibilityBackend');

//if(stCompatibilityLaw::isSection("terms_privacy_countrys",stCompatibilityLaw::getIsoCountry($sf_user->getCulture())) && $compatibility_config->get('terms_privacy_show')==1){

$smarty->assign("terms_privacy_show", 1);
$terms_privacy_text = $compatibility_config->get('terms_privacy_text', null, true);


if(stTheme::is_responsive()):
    $terms_text = $terms_privacy_text;
    
    $terms_text = preg_replace('/{LINK_TO_PRIVACY}/', '$', $terms_text);
    $terms_text = preg_replace('/{\/LINK_TO_PRIVACY}/', '$', $terms_text);    
    $terms_text = preg_replace('/{LINK_TO_TERMS}/', '%', $terms_text);
    $terms_text = preg_replace('/{\/LINK_TO_TERMS}/', '%', $terms_text);
            
    $tmp_string_terms_privacy = explode("$",$terms_text);
    $tmp_string_terms_shop = explode("%",$terms_text);    
    
    $terms_privacy = $tmp_string_terms_privacy[1];
    $terms_shop = isset($tmp_string_terms_shop[1]) ? $tmp_string_terms_shop[1] : null;
    
    
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
     
    $smarty->assign("terms_privacy_text", $string);
else:    
    $terms_right_2_cancel_text = preg_replace('/{RIGHT_TO_CANCEL}/', '<a id="active_right_2_cancel_overlay" class="label_terms_confirm" href="#active_right_2_cancel_overlay">', $terms_right_2_cancel_text);
    $terms_right_2_cancel_text = preg_replace('/{\/RIGHT_TO_CANCEL}/', '</a>', $terms_right_2_cancel_text);
    $terms_right_2_cancel_text = preg_replace('/{TERMS_AND_CONDITIONS}/', '<a id="active_terms_overlay" class="label_terms_confirm" href="#active_terms_overlay">', $terms_right_2_cancel_text);
    $terms_right_2_cancel_text = preg_replace('/{\/TERMS_AND_CONDITIONS}/', '</a>', $terms_right_2_cancel_text);
    $smarty->assign("terms_right_2_cancel_text", $terms_right_2_cancel_text);    
     
endif;



//}

?>

<?php 

 $webpage = WebpagePeer::getPrivacyWebpage();
 if($webpage){
    $smarty->assign('privacy_url', st_url_for('stWebpageFrontend/index?url='.$webpage->getFriendlyUrl()));    
 }else{
     $smarty->assign('privacy_url', "/");
 }
  
 
?>

<script type="text/javascript" language="javascript">
jQuery(function ($)
{
    $(document).ready(function ()
    {
        $('#active_overlay_1, #active_overlay_2').click(function()
        {
            var api = $('#privacy_overlay').data('overlay');

            if (!api)
            {
                $('#privacy_overlay').overlay(
                {

                    onBeforeLoad: function()
                    {
                        var wrap = this.getOverlay().find('.privacy_overlay_content');
                        $.get('<?php echo url_for('stUser/showPrivacy') ?>', function(data)
                        {
                            wrap.html(data);
                        });
                    },
                    load: true
                });
            }
            else
            {
                api.load();
            }
        });

        $('#active_terms_overlay').click(function() {
            var api = $('#terms_overlay').data('overlay');
            if (!api) {
                $('#terms_overlay').overlay({
                    onBeforeLoad: function() {
                        var wrap = this.getOverlay().find('.terms_overlay_content');
                        $.get('<?php echo url_for('stUser/showTerms') ?>', function(data) {
                            wrap.html(data);
                        });
                    },
                    load: true
                });
            } else {
                api.load();
            }
        });
    });
});
</script>

<?php $smarty->display('user_privacy.html') ?>