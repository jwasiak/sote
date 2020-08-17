<?php if ($sf_request->hasError('config{show_product_recomandation}')):?>
    <?php echo form_error('config{show_product_recomandation}', array('class' => 'form-error-msg'));?>
<?php endif;?>
<?php echo checkbox_tag('config[show_product_recomandation]', 1, $config->get('show_product_recomandation', true, false));?>


<?php if (stRegisterSync::getPackageVersion('stRecommendPlugin') === null):?>
    <script type="text/javascript">
        jQuery(function($) {
            $(document).ready(function() {
                $("#config_show_product_recomandation").parent().parent().css("display", "none");
            });
        });
    </script>
<?php endif;?>
