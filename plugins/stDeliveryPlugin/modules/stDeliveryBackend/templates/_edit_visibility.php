<?php use_javascript('stPrice.js') ?>
<table class="st_record_list" cellspacing="0" id="st_delivery-visibility">
   <thead>
      <tr>
         <th colspan="2"><?php echo __('Waga') ?></th>
         <th colspan="2"><?php echo __('Ilość sztuk') ?></th>
         <th colspan="2"><?php echo __('Kwota zamówienia') ?></th>
      </tr>
      <tr>
         <th><?php echo __('Od') ?></th>
         <th><?php echo __('Do') ?></th>
         <th><?php echo __('Od') ?></th>
         <th><?php echo __('Do') ?></th>
         <th><?php echo __('Od') ?></th>
         <th><?php echo __('Do') ?></th>
      </tr>
   </thead>
   <tbody>
      <tr>
         <td><?php echo input_tag('delivery[min_order_weight]', $delivery->getMinOrderWeight(), array('size' => 8, 'class' => 'float')) ?></td>
         <td><?php echo input_tag('delivery[max_order_weight]', $delivery->getMaxOrderWeight(), array('size' => 8, 'class' => 'float')) ?></td>
         <td><?php echo input_tag('delivery[min_order_quantity]', $delivery->getMinOrderQuantity(), array('size' => 8, 'class' => 'integer')) ?></td>
         <td><?php echo input_tag('delivery[max_order_quantity]', $delivery->getMaxOrderQuantity(), array('size' => 8, 'class' => 'integer')) ?></td>
         <td><?php echo input_tag('delivery[min_order_amount]', $delivery->getMinOrderAmount(), array('size' => 8, 'class' => 'float')) ?></td>
         <td><?php echo input_tag('delivery[max_order_amount]', $delivery->getMaxOrderAmount(), array('size' => 8, 'class' => 'float')) ?></td>
      </tr>
   </tbody>
</table>
<script type="text/javascript">
   $$('#st_delivery-visibility input').each(function(input){
      if (input.hasClassName('float'))
      {
         input.observe('change', function() {
            this.value = stPrice.fixNumberFormat(this.value);
         });
      }
      else
      {
         input.observe('change', function() {
            this.value = stPrice.fixNumberFormat(this.value, 0);
         });
      }
   });
</script>