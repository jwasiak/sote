<?php 
use_helper('stCurrency');
/**
 * @package    stOrder
 */
?>
<?php echo __('Data złożenia zamówienia:') ?> <?php echo $order->getCreatedAt(); ?>
  
<?php echo __('Zamówienie numer:') ?> <?php echo $order->getNumber(); ?>

<?php echo $head_content ?>

<?php echo $order->getOrderStatus()->getDescription(); ?>

<?php if ($order->getOrderStatus()->getHasInvoiceProforma()==1): ?>
<?php echo st_link_to(__('Pobierz fakturę proforma'), 'stOrder/downloadInvoice?id='.$order->getId().'&hash_code='.$order->getHashCode().'&proforma=1', array('absolute' => true, 'for_app' => 'frontend', 'for_lang' => $order->getClientCulture())) ?>
<?php endif; ?>

<?php if ($order->getOrderStatus()->getHasInvoice()==1 && $send_link == 1): ?>
<?php echo st_link_to(__('Pobierz fakturę'), 'stOrder/downloadInvoice?id='.$order->getId().'&hash_code='.$order->getHashCode().'&proforma=0', array('absolute' => true, 'for_app' => 'frontend', 'for_lang' => $order->getClientCulture())) ?>
<?php endif; ?>

<?php if ($coupon_code): ?>
<?php echo __('Kod rabatowy') ?>

<?php echo __('Kod') ?>: <?php echo $coupon_code->getCode() ?>

<?php echo __('Rabat') ?>: <?php echo $coupon_code->getDiscount().'%' ?>

<?php echo __('Ważny do') ?>: <?php echo $coupon_code->getValidTo('d-m-Y H:i') ?>
<?php endif; ?>

<?php echo __('Przejdź do zamówienia') ?>: <?php echo !$order->isAllegroOrder() ? st_url_for('stOrder/show?id='.$order->getId().'&hash_code='.$order->getHashCode(), true) : stAllegroApi::getOrderUrl($order->getOptAllegroCheckoutFormId()) ?>