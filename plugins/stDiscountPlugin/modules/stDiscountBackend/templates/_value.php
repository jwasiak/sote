<?php if ($type == 'edit'): use_helper('stPrice') ?>
<?php echo input_tag('discount[value]', $discount->getValue(), array('size' => 8)) ?>
&nbsp;<?php echo st_discount_type_select_tag('discount[price_type]', $discount->getPriceType(), array('class' => 'support')) ?>
<?php else: use_helper('stCurrency') ?>
<?php echo $discount->getPriceType() == '%' ? $discount->getValue().'%' : st_back_price($discount->getValue()) ?>
<?php endif ?>

<script>
jQuery(function($) {
    $('#discount_value').change(function() {
        var input = $(this);
        var value = input.val();

        value = stPrice.fixNumberFormat(value, $('#discount_price_type').val() == '%' ? 0 : 2);

        input.val(value);
        
    });

    $('#discount_price_type').change(function() {
        $('#discount_value').change();
    });
});
</script>