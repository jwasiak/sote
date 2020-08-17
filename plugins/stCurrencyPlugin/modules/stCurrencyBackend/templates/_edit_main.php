<?php echo input_hidden_tag('currency[edit_main]', $currency->getMain()) ?>
<?php echo checkbox_tag('currency[edit_main]', 1, $currency->getMain(), array('disabled' => $currency->getMain())) ?>
