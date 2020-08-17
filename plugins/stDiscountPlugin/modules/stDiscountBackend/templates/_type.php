<?php echo select_tag('discount[type]', options_for_select(DiscountPeer::getDiscountTypes(), $discount->getType()), array('class' => 'support')) ?>

<script type="text/javascript">
jQuery(function($) {
    var discount_type = $('#discount_type');
    var discount_all_clients = $('#discount_all_clients');
    var discount_allow_anonymous_clients = $('#discount_allow_anonymous_clients');
    var discount_auto_active = $('#discount_auto_active');

    discount_type.change(function() {
        var value = this.options[this.selectedIndex].value;

        if (value == 'S')
        {
            $('.row_product').show();
        }
        else
        {
            $('.row_product').hide();
        }

        if (value == 'S' || value == 'O')
        {
            $('#sf_fieldset_kategorie_i_producenci').hide();
        }
        else
        {
            $('#sf_fieldset_kategorie_i_producenci').show();
        }

        var all_products = $('#discount_all_products');

        if (value != 'O') {
            $('.row_conditions').hide();
            all_products.attr('disabled', value == 'S').attr('checked', value != 'S' ? all_products.get(0).defaultChecked : false);
        } else {
            $('.row_conditions').show();
            $('#discount_all_products').attr('checked', true).attr('disabled', true);
        }
    });

    discount_all_clients.change(function() {
        discount_auto_active.prop('disabled', this.checked);
    });

    discount_allow_anonymous_clients.change(function() {
        discount_auto_active.prop('disabled', this.checked);
    });

    discount_auto_active.change(function() {
        discount_all_clients.prop('disabled', this.checked);
        discount_allow_anonymous_clients.prop('disabled', this.checked);
    });

    discount_all_clients.change();
    discount_allow_anonymous_clients.change();
    discount_auto_active.change();
    discount_type.change();
});
</script>