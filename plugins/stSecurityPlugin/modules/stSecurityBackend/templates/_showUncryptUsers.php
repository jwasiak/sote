<?php use_helper('stProgressBar'); ?>

<?php if($countUncryptUsers != 0): ?>
<?php echo __('Trwa kodowanie danych klientów:', null, 'stSecurityBackend') ?>
<?php echo progress_bar('stUser_encrypt','Crypt','executeCryptAllUsers',$countUncryptUsers); ?> 
<?php endif; ?>