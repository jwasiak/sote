<?php if ($currency->getSystem()!=1):?>
<?php if ($sf_request->hasError('currency{name}')): ?>
    <?php echo form_error('currency{name}', array('class' => 'form-error-msg')) ?>
<?php endif; ?>
  <?php $value = object_input_tag($currency, 'getName', array (
  'size' => 50,
  'control_name' => 'currency[name]',
)); echo $value ? $value : '&nbsp;' ?>
<?php else:?>
<?php echo $currency->getName()?>
<?php echo input_hidden_tag('currency[name]', $currency->getName()) ?>
<?php endif;?>