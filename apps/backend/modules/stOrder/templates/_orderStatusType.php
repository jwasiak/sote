<?php echo select_tag('order_status[order_status_type]', options_for_select($select_options, $order_status->getType()), array('disabled' => $order_status->getIsSystemDefault())) ?>

<script type="text/javascript">
    $('order_status_order_status_type').observe('change', function()
    {
        var is_default_field = $('order_status_is_default');

        is_default_field.disabled = this.options[this.selectedIndex].value != 'ST_PENDING';

        if (is_default_field.disabled)
        {
            is_default_field.checked = false;
        }

    });
</script>