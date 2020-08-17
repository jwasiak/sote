<?php use_helper('stProgressBar'); ?>

<?php if($countUncryptOrderBillingUsers != 0): ?>
<?php echo __('Trwa kodowanie danych billingowych klientów:', null, 'stSecurityBackend') ?>
<?php echo progress_bar('st_user_order_billing_encrypt','Crypt','executeCryptAllOrderUsersBilling',$countUncryptOrderBillingUsers); ?> 
<?php endif; ?>