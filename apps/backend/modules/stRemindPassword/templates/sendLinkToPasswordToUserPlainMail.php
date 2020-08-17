<?php echo __('Link do zmiany hasła dla konta').': '; ?>

<?php echo __('Data wysłania linku').': '; ?><?php echo $date; ?>

<?php echo __('Skorzystaj z linku poniżej aby dokonać zmiany hasła.'); ?>

<?php echo link_to(__('Zmień hasło'), '@stChangePassForAdmin?hash_code=' . $hashCode, 'absolute=true'); ?>