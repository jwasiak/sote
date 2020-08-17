<?php use_helper('stProgressBar'); ?>

<?php if($countUncryptInvoiceSeller != 0): ?>
<?php echo __('Trwa kodowanie danych sprzedawcy:', null, 'stSecurityBackend') ?>
<?php echo progress_bar('st_invoice_seller_encrypt','Crypt','executeCryptAllInvoiceSeller',$countUncryptInvoiceSeller); ?> 
<?php endif; ?>