<?php 
$group['new_price'] = "";
if($sf_request->hasParameter('group[new_price]')){
$group['new_price'] = $sf_request->getParameter('group[new_price]');    
}
 
?>

<?php if ($sf_request->hasError('group{new_price}')): ?>
<?php echo form_error('group{new_price}', array('class' => 'form-error-msg')) ?>
<?php endif; ?>

<?php echo input_tag('group[new_price]', '', array('control_name' => 'group[new_price]', 'value' => $group['new_price'], 'style'=> 'width: 150px' , 'class' => form_has_error('group{new_price}') ? 'st_form-error' : '')); ?>
