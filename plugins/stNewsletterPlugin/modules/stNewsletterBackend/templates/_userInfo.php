<?php if($no_account == 1): ?>
    <?php echo __("Klient bez konta") ?>
<?php else: ?>

    <?php if($name!="" && $surname!=""): ?>
        <?php echo link_to($name." ".$surname,'user/edit?id='.$user_id); ?>
    <?php else: ?>
        <?php echo link_to($email,'user/edit?id='.$user_id); ?>
    <?php endif; ?>
    
<?php endif; ?>