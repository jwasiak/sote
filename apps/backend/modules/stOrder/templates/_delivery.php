<?php $edit_mode = $sf_user->getAttribute('edit_mode', false, 'soteshop/stOrder'); ?>
<?php use_helper('stCurrency', 'stDelivery');?>

<div class="row">
   <span class="label"><?php echo __('Rodzaj') ?>:</span>
   <div class="field">
      <?php
         if ($edit_mode && !$order->isAllegroOrder())
         {
            if ($order->getOrderDelivery()->getDeliveryId())
            {
               echo object_select_tag($order->getOrderDelivery()->getDelivery(), 'getId', array('related_class' => 'Delivery', 'control_name' => 'order[delivery][type_id]'));
            }
            else
            {
               echo input_tag('order[delivery][type]', $order->getOrderDelivery()->getName());
            }
         } 
         else
         {
            echo $order->getOrderDelivery()->getDelivery() ?  $order->getOrderDelivery()->getDelivery() : $order->getOrderDelivery()->getName();
            echo stSocketView::openComponents('stOrder.backend.delivery', array('order' => $order));
         } 
      ?>
   </div>
</div>
<div class="row">
   <label for="order_delivery_number"><?php echo __('Koszt') ?>:</label>
   <div class="field">
      <?php 
         if ($edit_mode)
         {
            echo input_tag("order[delivery][cost]", stPrice::round($order->getOrderDelivery()->getCostBrutto(true), 2) ,array("size"=>"10px"));
         }
         else
         {
            echo st_order_delivery_cost($order, true);
         }
      ?>
   </div>
</div>
<?php if (!stTheme::hideOldConfiguration()): ?>
<div class="row">
   <span class="label"><?php echo __('Termin dostawy') ?>:</span>
   <div class="field">
      <?php 
         if ($edit_mode)
         {
            echo input_date_tag('order[delivery][delivery_date]', $order->getOrderDelivery()->getDeliveryDate(), _parse_attributes(array(
               'rich' => true,
               'withtime' => true,
               'calendar_button_img' => '/sf/sf_admin/images/date.png',
               'size' => 11,
               'readonly'=>'readonly'
            )));
         }
         else
         {
            echo $order->getOrderDelivery()->getDeliveryDate() ? getDeliveryDateFormat($order->getOrderDelivery()->getDeliveryDate()) : __('Brak');
         }
      ?>
   </div>
</div>
<?php endif; ?>
<?php if (!$sf_user->getParameter('hide', false,'stOrder/edit/fields/delivery/number')): ?>
<div class="row">
   <label for="order_delivery_number"><?php echo __('Numer przesyłki') ?>:</label>
   <div class="field">
     <?php echo input_tag('order[delivery][number]', $order->getOrderDelivery()->getNumber()) ?>
   </div>
</div>
<?php endif ?>
<?php if ($edit_mode): ?>
<script type="text/javascript">
   $('order_delivery_cost').observe('change', function(){
      this.value = stPrice.fixNumberFormat(this.value);
   });
</script>
<?php endif; ?>