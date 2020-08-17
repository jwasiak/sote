<?php echo input_password_tag('config[client_secret]', $config->get('client_secret'), array('size' => 60)) ?>
<?php if (!$config->get('access_token')): ?>
    <script>
    jQuery(function($) {
        $('#sf_fieldset_warunki_reklamacji___gwarancji___zwrot__w').hide();
    });
    </script>
<?php endif ?>