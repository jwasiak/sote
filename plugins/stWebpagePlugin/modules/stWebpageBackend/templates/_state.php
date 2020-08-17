<?php
$options = array(   NULL => '---',
                    'PRIVACY' => __('Polityka prywatności'),
                    'TERMS' => __('Regulamin'),
                    'SHIPPING' => __('Informacje o wysyłce'),
                    'RIGHT2CANCEL' => __('Prawo do odstąpienia od umowy'),
                    'CONTACT' => __('Kontakt'),
    );

echo select_tag('webpage[state]', options_for_select($options, $webpage->getState()));
?>

<script type="text/javascript">
    jQuery(function($) {
        var formatTerms = "<?php echo stConfig::getInstance('stCompatibilityBackend')->get('terms_in_mail_confirm_order_format') ?>";
        var formatRight2Cancel = "<?php echo stConfig::getInstance('stCompatibilityBackend')->get('right_2_cancel_in_mail_confirm_order_format') ?>";
        var terms_on = "<?php echo stConfig::getInstance('appTermsBackend')->get('terms_on') ?>";
        var privacy_on = "<?php echo stConfig::getInstance('appTermsBackend')->get('privacy_on') ?>";
        var right2cancel_on = "<?php echo stConfig::getInstance('appTermsBackend')->get('right2cancel_on') ?>";
        var culture = "<?php echo $webpage->getCulture() ?>"; 
        
        
        $('#webpage_state').change(function() {
            var value = $(this).val();
            if (value == 'TERMS' && formatTerms == 'pdf' || value == 'RIGHT2CANCEL' && formatRight2Cancel == 'pdf') {
                $('.row_attachment').show();
            } else {
                $('.row_attachment').hide();
                $('#sf_fieldset_regulamin').hide();
            }
            
            
            
            
            if(terms_on == 1 && value == 'TERMS' && culture == "pl_PL"){
                $('#sf_fieldset_regulamin').show();
            }else{
                $('#sf_fieldset_regulamin').hide();
            }
            
            if(privacy_on == 1 && value == 'PRIVACY' && culture == "pl_PL"){
                $('#sf_fieldset_polityka_prywatnosci').show();
            }else{
                $('#sf_fieldset_polityka_prywatnosci').hide();
            }
            
            if(right2cancel_on == 1 && value == 'RIGHT2CANCEL' && culture == "pl_PL"){
                $('#sf_fieldset_odstapienie_od_umowy').show();
            }else{
                $('#sf_fieldset_odstapienie_od_umowy').hide();
            }
            
            
            
        }).change();
    });
</script>