<?php echo input_date_tag('config[new_product_date]', $config->get('new_product_date', null, false), array (
  'rich' => true,
  'withtime' => true,
  'calendar_button_img' => '/sf/sf_admin/images/date.png',
  'readonly' => 'readonly',
)); ?>   