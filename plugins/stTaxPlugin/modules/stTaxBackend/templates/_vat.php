
  <?php $value = object_input_tag($tax, 'getVat', array (
  'size' => 7,
  'control_name' => 'tax[vat]',
)); echo $value ? $value : '&nbsp;' ?> %