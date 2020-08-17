<?php if ($review->getSfGuardUser()): ?>

    <?php if ($review->getUsername()): ?>
        <?php echo $review->getUsername() ?>
    <?php else: ?>

       <?php if ($user_data->getName()!="" || $user_data->getSurname()!=""): ?>

         <?php $name = $user_data->getName()." ".$user_data->getSurname(); ?>

      <?php else: ?>

         <?php $name = $review->getSfGuardUser(); ?>

      <?php endif; ?>

        <?php echo st_link_to($name,'stUser/edit?id='.$review->getSfGuardUserId()); ?>
        <br />
        <?php echo $review->getSfGuardUser() ?>
    <?php endif; ?>

<?php else: ?>

    <?php if ($review->getUsername() ): ?>
        <?php echo $review->getUsername() ?>
    <?php else: ?>

    <?php if ($sf_request->hasError('review{admin_name}')): ?>
        <?php echo form_error('review{admin_name}', array('class' => 'form-error-msg')) ?>
    <?php endif; ?>
    <?php $value = object_input_tag($review, 'getAdminName', array (
        'control_name' => 'review[admin_name]',
        'size' => 75,
    )); echo $value ? $value : '&nbsp;' ?>
        
    <?php endif; ?>
<?php endif; ?>