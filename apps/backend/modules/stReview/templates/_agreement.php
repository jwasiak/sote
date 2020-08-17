<?php if ($review->getSfGuardUser()): ?>
    <?php if ($sf_request->hasError('review{agreement}')): ?>
        <?php echo form_error('review{agreement}', array('class' => 'form-error-msg')) ?>
    <?php endif; ?>
    <?php $value = object_checkbox_tag($review, 'getAgreement', array (
        'control_name' => 'review[agreement]',
        'disabled' => true,
    )); echo $value ? $value : '&nbsp;' ?>
<?php else: ?>
    <?php if ($sf_request->hasError('review{active}')): ?>
        <?php echo form_error('review{active}', array('class' => 'form-error-msg')) ?>
    <?php endif; ?>
    <?php $value = object_checkbox_tag($review, 'getActive', array (
        'control_name' => 'review[active]',
    )); echo $value ? $value : '&nbsp;' ?>
<?php endif; ?>