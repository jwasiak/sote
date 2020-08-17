<?php echo input_hidden_tag('currency[edit_iso_code]', $currency->getEditIsoCode(), array('id' => 'currency_edit_iso_code_hidden')) ?>
<?php echo select_tag('currency[edit_iso_code]', options_for_select($currency_options, $selected), array('disabled' => !$currency->isNew())) ?>

<script type="text/javascript">
   var currencies = <?php echo json_encode($currencies) ?>;
    $('currency_edit_iso_code').observe('change', function() {

        var currency_shortcut = $('currency_shortcut');

        var currency_exchange = $('currency_exchange');

        var currency_front_symbol = $('currency_prefix_sign');

        var currency_back_symbol = $('currency_postfix_sign');

        var system_default = '<?php echo $system_default ?>';

        if (this.selectedIndex > 0)
        {
            var selected = this.options[this.selectedIndex];

            var data = currencies[selected.value];

            $('currency_name').value = data.label;

            if (data[0] != system_default)
            {
                currency_exchange.enable();
            }
            else
            {
                currency_exchange.disable();
            }

            currency_shortcut.value = selected.value;

            currency_front_symbol.value = data.prefix == undefined ? '' : data.prefix;

            currency_back_symbol.value = data.postfix == undefined ? '' : data.postfix;
        }
        else
        {
            currency_exchange.enable();
        }


    });
</script>