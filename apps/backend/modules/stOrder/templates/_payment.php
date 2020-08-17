<?php use_helper('stCurrency', 'stAllegro'); ?>
<div id="st_component-stOrderEdit_Payment"> 
   <?php if (!$sf_user->getAttribute('edit_mode', false, 'soteshop/stOrder')): ?>
      <table class="st_record_list" cellspacing="0" width="100%">
         <thead>
            <tr>
               <th><?php echo __('Data dokonania płatności') ?></th>
               <th><?php echo __('Typ płatności') ?></th>
               <th><?php echo __('Kwota') ?></th>
               <th><?php echo __('Rozliczona') ?></th>
            </tr>
         </thead>
         <tbody>
            <?php foreach ($payments as $index => $ohp): $payment = $ohp->getPayment(); $transaction_id = $payment->getTransactionId(); ?>
               <tr>
                  <td>
                     <?php echo $payment->getPayedAt() ? st_format_date($payment->getPayedAt()) : '-' ?>
                     <?php echo input_hidden_tag('order[payment][' . $index . '][payment_id]', $payment->getId()) ?>
                  </td>
                  <?php if ($payment->getGiftCard()): ?>
                     <td><?php echo st_external_link_to(__('Bon zakupowy: %code%', array('%code%' => $payment->getGiftCard()->getCode())), 'stGiftCardBackend/edit?id=' . $payment->getGiftCard()->getId()) ?></td>
                  <?php else: ?>
                     <td>
                        <?php echo $payment->getPaymentType() ?>
                        <?php if ($payment->getAllegroPaymentType()): ?>
                           - <?php echo st_allegro_payment_type($payment->getAllegroPaymentType()) ?>
                        <?php endif ?>
                        <?php if ($transaction_id): ?>
                           <p style="color: #848484"><?php echo __('Numer transakcji', null, 'stPayment') ?>: <?php echo $transaction_id ?></p>
                        <?php endif ?>
                     </td>
                  <?php endif; ?>
                  <td><?php echo st_order_price_format($payment->getAmount(), $order->getOrderCurrency()) ?></td>
                  <td>
                     <?php echo checkbox_tag('order[payment][' . $index . '][payment_status]', 1, $payment->getStatus(), array('disabled' => $payment->getGiftCard(), 'style' => 'vertical-align: middle')); ?>
                     <?php if ($payment->getGiftCard()): ?>
                        <?php echo input_hidden_tag('order[payment][' . $index . '][payment_status]', true); ?>               
                     <?php endif; ?>
                     <?php if ($payment->getStatus() && !$payment->isValid()): ?>
                     <?php echo image_tag('/images/backend/icons/warning.png', array('title' => __('Status płatności został zmieniony bezpośrednio w bazie danych', null, 'stPayment'), 'class' => 'list_tooltip', 'style' => 'vertical-align: middle')) ?>
                     <?php endif ?>
                  </td>
               </tr>
            <?php endforeach; ?>
         </tbody>
      </table>
   <?php else: ?>
      <table id="st_record_manager-payment" class="st_record_list st_record_manager" cellspacing="0" width="100%">
         <thead>
            <tr>
               <th><?php echo __('Data dokonania płatności') ?></th>
               <th><?php echo __('Typ') ?></th>
               <th><?php echo __('Kwota') ?></th>
               <th><?php echo __('Rozliczona') ?></th>
               <th>&nbsp;</th>
            </tr>
            <tr class="template">
               <th>&nbsp;<?php echo input_hidden_tag('payment_id', null) ?></th>
               <th><?php echo select_tag("payment_type", options_for_select($paymentsType)) ?></th>
               <th><?php echo input_tag("payment_amount", '0.00', array('class' => 'price-field')) ?></th>
               <th><?php echo checkbox_tag("payment_status", true, false, array('class' => 'payment-status')) ?></th>
               <th class="actions">
                  <?php echo link_to(image_tag('backend/icons/add.png'), "#", array('class' => 'create')) ?>
                  <?php echo link_to(image_tag('backend/icons/delete.png'), "#", array('class' => 'remove')) ?>
               </th>            
            </tr>        
         </thead>
         <tbody>
            <?php foreach ($payments as $index => $ohp): $payment = $ohp->getPayment() ?>
               <tr>
                  <td>
                     <?php echo $payment->getPayedAt() ? st_format_date($payment->getPayedAt()) : '-' ?>
                     <?php echo input_hidden_tag('order[payment][' . $index . '][payment_id]', $payment->getId()) ?>
                  </td>
                  <?php if ($payment->getAllegroPaymentType()): ?>
                     <td>
                        <?php echo input_hidden_tag('order[payment][' . $index . '][payment_type]', $payment->getPaymentTypeId()) ?>
                        <?php echo $payment->getPaymentType() ?> - <?php echo st_allegro_payment_type($payment->getAllegroPaymentType()) ?>    
                     </td>
                  <?php elseif ($payment->getGiftCard()): ?>
                     <td><?php echo st_external_link_to($payment->getGiftCard()->getCode(), 'stGiftCardBackend/edit?id=' . $payment->getGiftCard()->getId()) ?></td>
                  <?php else: ?>            
                     <td><?php echo select_tag("order[payment][" . $index . "][payment_type]", options_for_select($paymentsType, $payment->getPaymentTypeId())) ?></td>
                  <?php endif; ?> 
                  <td>
                     <?php echo input_tag('order[payment][' . $index . '][payment_amount]', stPrice::round($payment->getAmount()), array('disabled' => $payment->getGiftCard() || $payment->getStatus(), 'class' => 'price-field', 'data-gift-card' => null !== $payment->getGiftCard())) ?>   
            
                     <?php echo input_hidden_tag('order[payment][' . $index . '][payment_amount]', stPrice::round($payment->getAmount()), array('disabled' => !$payment->getStatus(), 'id' => 'order_payment_' . $index . '_payment_amount_hidden')) ?>            
                  </td>
                  <td>               
                     <?php echo checkbox_tag('order[payment][' . $index . '][payment_status]', 1, $payment->getStatus(), array('disabled' => $payment->getGiftCard(), 'class' => 'payment-status')); ?>
                  </td>
                  <td class="actions">
                     <?php if (!$payment->getGiftCard()): ?>               
                        <?php echo link_to(image_tag('backend/icons/delete.png'), '#', array('class' => 'remove')) ?>
                     <?php endif; ?>
                  </td>            
               </tr>
            <?php endforeach; ?>
         </tbody>
      </table>
<script type="text/javascript">
   jQuery(function($) {
      function statusUpdate() {

         var status = $(this);
         var priceField = status.closest('tr').find('.price-field');

         if (priceField.data('gift-card')) {
            return;
         }

         priceField.prop('disabled', status.prop('checked'));
         
         var hiddenId = priceField.attr('id')+'_hidden';

         var hidden = $('#'+hiddenId);

         if (hidden.length) {
            hidden.prop('disabled', !status.prop('checked'));
            hidden.val(priceField.val());
         } else {
            hidden = $('<input type="hidden" id="'+hiddenId+'" name="'+priceField.attr('name')+'" value="'+priceField.val()+'">');
            priceField.after(hidden);
         }



         totalAmountUpdate(); 

    
      }

      function paymentAmountUpdate() {
         var input = $(this);
         input.val(stPrice.fixNumberFormat(input.val()));
         var value = Number(input.val());
         var payment = $('#st_record_manager-payment tbody tr .price-field').not('[data-gift-card=1]');

         var leftToPay = Number($('#st_order-product-list').data('total-amount'));

         payment.each(function() {
            var current = $(this);
            if (input.attr('id') !== current.attr('id')) {
               leftToPay -= Number(current.val());
            }
         });

         if (leftToPay < 0) {
            leftToPay = 0;
         }

         if (value > leftToPay) {
            value = leftToPay;
         }  

         input.val(value.toFixed(2));
      }

      function totalAmountUpdate()
      {
         manager = $('#st_record_manager-payment');
         manager.data('update', true);
         $('#order_discount').change();  
         manager.data('update', false);
      }

      $('#st_record_manager-payment').stTableRecordManager({ namespace: 'order[payment]', confirmMsg: '<?php echo __('Jesteś pewien?', null, 'stAdminGeneratorPlugin') ?>'});
      $('#payment_amount').change(paymentAmountUpdate);

      $('#st_record_manager-payment').on('postAdd', function(event, row, fields) {
         statusUpdate.call(fields.payment_status);
         totalAmountUpdate(); 
      }).on('postRemove', function() {
         totalAmountUpdate();
      });

      $('#st_record_manager-payment tbody')
         .on('change', '.price-field', paymentAmountUpdate)
         .on('change', '.payment-status', statusUpdate);
   });

</script>      
   <?php endif; ?>
</div>