<?php if ($countries->getCulture() == 'pl_PL'): ?>
<?php echo input_tag('countries[edit_name]', $countries->getName(), array('disabled' => true)) ?>
<?php echo input_hidden_tag('countries[edit_name]', $countries->getName()) ?>
<?php else: ?>
<?php echo input_tag('countries[edit_name]', $countries->getName()) ?>
<?php endif; ?>