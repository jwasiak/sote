<?php if ($review->getSfGuardUser()): ?>
<?php if ($sf_request->hasError('review{description}')): ?>
    <?php echo form_error('review{description}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>
  <?php $value = object_textarea_tag($review, 'getDescription', array (
  'control_name' => 'review[description]',
  'size' => '40x5',
  'rich' => true,
  'tinymce_options' => 'height:300,width:400,theme:simple',
)); echo $value ? $value : '&nbsp;' ?>
<?php else: ?>
<?php endif; ?>