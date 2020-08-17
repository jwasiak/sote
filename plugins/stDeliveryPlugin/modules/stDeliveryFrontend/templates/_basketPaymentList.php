<?php st_theme_use_stylesheet('stDelivery.css') ?>

<?php $smarty->assign('delivery_payments', $delivery_payments) ?>

<?php $smarty->assign('is_order_only_for_points', stPoints::isOrderOnlyForPoints()) ?>

<?php $smarty->display('basket_payment_list.html') ?>

<?php if ($sf_context->getController()->getTheme()->getVersion() < 7): ?>
<script type="text/javascript">
jQuery(function($) {
    $('input.st_delivery-payment_default').each(function() {
        if (this.checked) {
                stDelivery.deliveryPaymentChecked = this.id;
            }

        $(this).click(function() {
            if (stDelivery.deliveryPaymentChecked != this.id)
            {
                stDelivery.executeAjaxUpdate($(this), '<?php echo url_for('stDeliveryFrontend/ajaxPaymentUpdate') ?>');

                stDelivery.deliveryPaymentChecked = this.id;
            }
        });
    });
});
</script>
<?php endif ?>