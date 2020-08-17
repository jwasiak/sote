<?php use_helper('stProgressBar'); ?>

<?php if($countUncryptInvoiceCustomer != 0): ?>
<?php echo __('Trwa kodowanie danych klientów:', null, 'stSecurityBackend') ?>
<?php echo progress_bar('st_invoice_customer_encrypt','Crypt','executeCryptAllInvoiceCustomer',$countUncryptInvoiceCustomer); ?> 
<?php endif; ?>