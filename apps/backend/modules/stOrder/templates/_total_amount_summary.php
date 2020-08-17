<?php 
use_helper('stOrder');
?>

<?php if ($order->getDiscountCouponCode()): ?>
<div class="row">
   <span class="label"><?php echo __('Kod rabatowy') ?>:</span>
   <div class="field">
      &nbsp;<?php echo st_external_link_to($order->getDiscountCouponCode()->getCode(), 'stDiscountBackend/couponCodeEdit?id='.$order->getDiscountCouponCode()->getId()) ?> (<?php echo $order->getDiscountCouponCode()->getDiscount() ?>%)
   </div>
</div>
<?php endif; ?>
<?php if (!$sf_user->getAttribute('edit_mode', false, 'soteshop/stOrder')): ?>
   <?php if ($order->hasDiscount()): $discount = $order->getTotalProductDiscountAmount(true, true) ?>
      <div class="row">
         <span class="label"><?php echo __('Łączna wartość') ?>:</span>
         <div class="field">
            &nbsp;<span id="order-total-amount-container"><?php echo st_order_total_amount($order, true, true, false) ?></span>
         </div>
      </div>

   
      <div class="row">
         <span class="label"><?php echo __('Udzielony rabat') ?>:</span>
         <div class="field">
            -<?php echo st_order_price_format($discount, $order->getOrderCurrency()) ?>
            <?php if ($order->getDiscount()): ?>
            (<a target="_blank" href="<?php echo st_url_for('@stDiscountPlugin?action=edit&id='.$order->getDiscountId()) ?>"><?php echo $order->getDiscount()->getName() ?></a>)
            <?php endif ?>
         </div>
      </div>
   <?php endif ?>
<?php else: 
   $discounts = DiscountPeer::doSelectActiveCached(); 
   $options = '<option value="">---</option>';
   $currency = $order->getOrderCurrency();
   
   if ($discounts && isset($discounts['O']))
   {
      foreach ($discounts['O'] as $discount) 
      {
         $type = $discount->getPriceType();
         $from_amount = $currency->exchange($discount->getCondition('from_amount'));

         if ($type == '%')
         {
            $discount_value = $discount->getValue();
         }
         else
         {
            $discount_value = $currency->exchange($discount->getValue());
         }

         $label = $discount->getName().' ('.__('Rabat %discount% od kwoty: %amount%', array('%discount%' => $type == '%' ? $discount_value.'%' : st_order_price_format($discount_value, $currency),'%amount%' => st_order_price_format($from_amount, $currency))).')';

         if ($discount->getId() == $order->getDiscountId())
         {
            $options .= '<option value="'.$discount->getId().'" data-discount-value="'.$discount_value.'" data-discount-type="'.$type.'" selected>'.$label.'</option>';
         } 
         else
         {
            $options .= '<option value="'.$discount->getId().'" data-discount-value="'.$discount_value.'" data-discount-type="'.$type.'">'.$label.'</option>';
         }

      }
   }
?>
   <div class="row">
      <span class="label"><?php echo __('Łączna wartość') ?>:</span>
      <div class="field">
         &nbsp;<span id="order-total-amount-container"><?php echo st_order_total_amount($order, true, true, false) ?></span>
      </div>
   </div>

   <div class="row">
      <span class="label"><?php echo __('Udzielony rabat') ?>:</span>
      <div class="field">
         <?php echo select_tag('order[discount]', $options); ?>
      </div>
   </div>
<?php endif ?>

<div class="row">
   <span class="label"><?php echo __('Razem do zapłaty', null, 'stInvoiceBackend') ?>:</span>
   <div class="field">
      &nbsp;<strong id="order-to-pay-amount-container"><?php echo st_order_total_amount($order) ?></strong>
   </div>
</div>

<div class="row">
   <span class="label"><?php echo __('Zapłacono', null, 'stInvoiceBackend') ?>:</span>
   <div class="field" style="color: #54903E; font-weight: bold">
      &nbsp;<span id="order-paid-amount-container" data-amount="<?php echo $order->getPaidAmount() ?>"><?php echo st_order_price_format($order->getPaidAmount(), $order->getOrderCurrency()); ?></span>
   </div>
</div>

<div class="row" style="display: none">
   <span class="label"><?php echo __('Do zwrotu', null, 'stInvoiceBackend') ?>:</span>
   <div class="field" style="color: #C62929; font-weight: bold">
      &nbsp;<span id="order-refund-amount-container"></span>
   </div>
</div>

<div class="row">
   <span class="label"><?php echo __('Pozostało do zapłaty', null, 'stInvoiceBackend') ?>:</span>
   <div class="field" style="color: #C62929; font-weight: bold">
      &nbsp;<span id="order-left-to-pay-amount-container"><?php echo st_order_price_format($order->getUnpaidAmount(), $order->getOrderCurrency()); ?></span>
   </div>
</div>