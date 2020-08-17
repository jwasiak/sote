<?php echo input_hidden_tag('countries[is_default]', $countries->getIsDefault()) ?>
<?php echo checkbox_tag('countries[is_default]', 1, $countries->getIsDefault(), array('disabled' => $countries->getIsDefault())) ?>
