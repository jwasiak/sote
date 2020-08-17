<?php echo checkbox_tag('theme[active]', true, $theme->getActive(), array('disabled' => $theme->getActive())) ?>
<?php if ($theme->getActive()): ?>
<?php echo input_hidden_tag('theme[active]', true); ?>
<?php endif; ?>
