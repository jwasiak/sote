<?php if($user_data->getIsDefault()==1): ?>
<?php echo object_checkbox_tag($user_data, 'getIsDefault', array ('control_name' => 'user_data[is_default]','disabled'=>'disabled')); ?>
<?php echo input_hidden_tag('user_data[is_default]', '1'); ?>
<?php else: ?>
<?php echo object_checkbox_tag($user_data, 'getIsDefault', array ('control_name' => 'user_data[is_default]',)); ?>
<?php endif; ?>