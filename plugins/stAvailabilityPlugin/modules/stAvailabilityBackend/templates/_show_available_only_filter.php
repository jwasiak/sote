<?php echo checkbox_tag('config[show_available_only_filter]', 1, $config->get('show_available_only_filter', null, false), array (
)); ?>  

<script>
    jQuery(function($) {
        $('#config_show_available_only_filter').change(function() {
            $('#config_hide_products_avail_on').prop('disabled', $(this).prop('checked'));
        }).change();
    });
</script>