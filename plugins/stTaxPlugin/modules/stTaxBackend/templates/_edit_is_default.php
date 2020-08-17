<?php echo input_hidden_tag('tax[edit_is_default]', $tax->getIsDefault()) ?>
<?php echo checkbox_tag('tax[edit_is_default]', 1, $tax->getIsDefault(), array('disabled' => $tax->getIsDefault())) ?>
