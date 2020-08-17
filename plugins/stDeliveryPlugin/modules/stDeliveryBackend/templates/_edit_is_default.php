<?php echo input_hidden_tag('delivery[is_default]', $delivery->getIsDefault()) ?>
<?php echo checkbox_tag('delivery[is_default]', 1, $delivery->getIsDefault(), array('disabled' => $delivery->getIsDefault())) ?>
