<?php if (null === $base_themes): ?>
<?php echo select_tag('theme[base_theme_list]', array('' => __('Brak')), array('disabled' => true)); ?>
<?php else: ?>
<?php echo select_tag('theme[base_theme_list]', options_for_select(_get_options_from_objects($base_themes), $selected, array('include_custom' => __('Brak')))); ?>
<?php endif; ?>


