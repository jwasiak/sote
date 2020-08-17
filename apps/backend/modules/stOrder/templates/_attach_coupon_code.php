<?php if ($order_status->isCouponCodeEnabled()): ?>
<?php echo checkbox_tag('order_status[attach_coupon_code]', true, $order_status->getAttachCouponCode(), array('disabled' => !$order_status->getHasMailNotification() || $order_status->getType() != 'ST_COMPLETE'))?>
<script type="text/javascript">
   var attach_coupon_code = $('order_status_attach_coupon_code');

   var has_email_notification = $('order_status_has_mail_notification');

   var order_status_type = $('order_status_order_status_type');

   attach_coupon_code.observe('click', function() {

      $$('.coupon_code_field').each(function(i) {
         if (i.id != attach_coupon_code.id)
         {
            i.disabled = !attach_coupon_code.checked;
         }
      });
   });

   has_email_notification.observe('click', function() {

      attach_coupon_code.disabled = !has_email_notification.checked;

      $$('.coupon_code_field').each(function(i) {
         i.disabled = !has_email_notification.checked || !attach_coupon_code.checked;
      });
   });

   order_status_type.observe('change', function() {

      var value = this.options[this.selectedIndex].value;

      attach_coupon_code.disabled = !has_email_notification.checked || value != 'ST_COMPLETE';

      $$('.coupon_code_field').each(function(i) {
         i.disabled = !has_email_notification.checked || !attach_coupon_code.checked || value != 'ST_COMPLETE';
      });
   });
</script>
<?php else: ?>
<?php echo __('Kody rabatowe są wyłączone') ?> <?php echo st_external_link_to(__('Włącz kody rabatowe'), 'stDiscountBackend/config') ?>
<?php endif; ?>
