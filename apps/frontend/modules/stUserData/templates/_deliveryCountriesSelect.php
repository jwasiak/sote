<?php use_helper('Object') ?>
<?php use_javascript('stUser.js', 'last') ?>
<div id="st_form-user_delivery-country">
    <?php echo select_tag('user_data_delivery[country]', options_for_select(_get_options_from_objects($delivery_countries), $default_delivery_country_id) ,array('id'=>'st_form-user_delivery-country-select', 'class'=>'form-control')) ?>
</div>       

<script type="text/javascript">
    $('st_form-user_delivery-country-select').observe('change', function()
    {
        var params = new Hash();

        params.set('disable_user_form_update', true);

        $('st_basket-delivery-form').scrollTo();

        stDelivery.executeAjaxUpdate(this, '<?php echo url_for('stDeliveryFrontend/ajaxDeliveryCountryUpdate') ?>', params);

    });

<?php if (isset($update_delivery_view)): ?>
    stUser.updateUserDeliveryView();
<?php endif ?>
</script>