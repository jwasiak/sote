<?php echo input_tag('config[company]', $config->get('company')); ?>
<script type="text/javascript">
    jQuery(function($) {
        $('#config_is_company').change(function() {

            if ($(this).prop('checked')) {
                   console.log("show");
                $('.row_company').show();
                $('.row_name label, .row_surname label').removeClass('required');
            } else {
                 console.log("hide");
                $('.row_company').hide();
                $('.row_name label, .row_surname label').addClass('required');
            }
        }).change();
    });
</script>