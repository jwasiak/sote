<?php if ($review->getSfGuardUser()): ?>
    <?php echo st_link_to($user_data->getName().' '.$user_data->getSurname(),'stUser/edit?id='.$review->getSfGuardUserId()); ?>
    <br />
    <?php echo $review->getSfGuardUser() ?>
<?php else: ?>
    <?php if ($sf_request->hasError('review{admin_name}')): ?>
        <?php echo form_error('review{admin_name}', array('class' => 'form-error-msg')) ?>
    <?php endif; ?>
    <?php $value = object_input_tag($review, 'getAdminName', array (
        'control_name' => 'review[admin_name]',
        'size' => 75,
    )); echo $value ? $value : '&nbsp;' ?>
<?php endif; ?>