<?php use_helper('stProgressBar'); ?>

<?php if($countUncryptOrderDeliveryUsers != 0): ?>
<?php echo __('Trwa kodowanie danych dostawy klientów:', null, 'stSecurityBackend') ?>
<?php echo progress_bar('st_user_order_delivery_encrypt','Crypt','executeCryptAllOrderUsersDelivery',$countUncryptOrderDeliveryUsers); ?> 
<?php endif; ?>