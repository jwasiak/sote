<?php if ($review->getSfGuardUser()): ?>
    <?php echo link_to($review->getSfGuardUser(),'stUser/edit?id='.$review->getSfGuardUserId()); ?>
<?php else : ?>
    <?php if($review->getAdminName()): ?>
        <p style="color: red">
            <?php echo $review->getAdminName(); ?>
        </p>
    <?php else: ?>
        <p style="color: red">
            <?php echo __('Administrator'); ?>
        </p>
    <?php endif; ?>
<?php endif;?>