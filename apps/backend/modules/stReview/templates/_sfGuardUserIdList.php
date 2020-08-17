<?php if ( !is_null($review->getSfGuardUserId()) && $review->getSfGuardUserId()!=0): ?>

    <?php if($user_data): ?>
        <?php if($user_data->getFullName()==""): ?>
          <?php $name = $review->getSfGuardUser(); ?>
        <?php else: ?>
          <?php $name = $user_data->getFullName(); ?>
        <?php endif; ?>

        <?php echo st_link_to($name,'stUser/edit?id='.$review->getSfGuardUserId()); ?>
        <br />
    <?php endif; ?>
        
    <?php echo $review->getSfGuardUser() ?>
<?php else : ?>
    <?php if($review->getAdminName()): ?>
        <p style="color: red">
            <?php echo $review->getAdminName(); ?>
        </p>
    <?php else: ?>
            <?php if ($review->getUsername()): ?>

                <?php echo $review->getUsername(); ?>

            <?php else: ?>

                <?php echo __('Brak'); ?>

            <?php endif; ?>
    <?php endif; ?>
<?php endif;?>