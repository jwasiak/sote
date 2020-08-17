jQuery(function($) {
    $('.stock_enabled').change(function() {
        var checkbox = $(this);
        var input = checkbox.prev('input');
        if (this.checked) {
            input.removeAttr('disabled');
            input.val(0);
        } else {
            input.attr('disabled', true);
        }   

        checkbox.next().val(!this.checked | 0);
    });

    $('.stock_decrement').click(function() {
        var stock_value = $(this).closest('tr').find('.stock_value');
        if (!stock_value.attr('disabled') && stock_value.val() > 0) {
            stock_value.val(Number(stock_value.val()) - 1);
        }
        return false;
    });

    $('.stock_increment').click(function() {
        var stock_value = $(this).closest('tr').find('.stock_value');
        if (!stock_value.attr('disabled')) {
            stock_value.val(Number(stock_value.val()) + 1);
        }
        return false;
    });

    $('.stock_reset').click(function() {
        var stock_value = $(this).closest('tr').find('.stock_value');
        if (!stock_value.attr('disabled')) {
            stock_value.val(0);
        }
        return false;
    }); 

    $('.stock_value').change(function() {
        var input = $(this);

        var value = stPrice.fixNumberFormat(input.val(), 2);

        if (value == Math.floor(value)) {
            input.val(Math.floor(value));
        } else {
            input.val(value);
        }
    });   
});