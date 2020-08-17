<table class="st_record_list" cellspacing="0">
   <thead>
      <tr>
         <th><?php echo __('Waluta') ?></th>
         <th><?php echo __('Zablokuj kurs') ?> <?php echo checkbox_tag('product[has_fixed_currency_exchange]', true, $product->getHasFixedCurrency(), array('disabled' => $product->getCurrency()->getIsSystemCurrency())) ?></th>
      </tr>
   </thead>
   <tbody>
      <tr>
         <td><?php echo select_tag('product[edit_currency]', options_for_select($currency['select_options'], $product->getCurrency()->getId())) ?></td>
         <td><?php echo input_tag('product[fixed_currency_exchange]', $product->getHasFixedCurrency() ? $product->getFixedCurrencyExchangeBackend() : $product->getCurrency()->getExchangeBackend() , array('disabled' => !$product->getHasFixedCurrency(), 'size' => 6)) ?></td>
      </tr>
   </tbody>
</table>

<script type="text/javascript">
   var currency_exchange = <?php echo $currency['exchange_rates'] ?>;

   var fixed_currency_exchange = $('product_fixed_currency_exchange');

   var currency_fixed = $('product_has_fixed_currency_exchange');

   var currency = $('product_edit_currency');

   var prev_selected = currency.options[currency.selectedIndex].value;

   currency.observe('change', function()
   {
      var selected = this.options[this.selectedIndex].value;

      if (selected == '<?php echo $currency['system_currency_id']  ?>')
      {
         stPriceTaxManagment.instance.enablePriceFields();

         currency_fixed.disable();

         fixed_currency_exchange.disable();

         stPriceTaxManagment.instance.refreshPriceFields();
      }
      else
      {
         stPriceTaxManagment.instance.disablePriceFields();

         stPriceTaxManagment.instance.priceFields.each(function (f) {
            f.price.value = '';
         });

         currency_fixed.enable();

         fixed_currency_exchange[currency_fixed.checked ? 'enable' : 'disable']();
      }

      fixed_currency_exchange.value = currency_exchange[selected];
   });

   currency_fixed.observe('click', function() {
      fixed_currency_exchange[this.checked ? 'enable' : 'disable']();
   });

   fixed_currency_exchange.observe('change', function() {
      this.value = stPrice.fixNumberFormat(this.value, 4);
   });

</script>
