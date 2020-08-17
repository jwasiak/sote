 <?php echo object_input_tag($allegro_template, 'getName', array (
  'size' => 80,
  'control_name' => 'allegro_template[name]',
  'disabled' => null !== $allegro_template->getTheme(),
)); ?>

<?php if (null !== $allegro_template->getTheme()): ?>
    <?php echo input_hidden_tag('allegro_template[name]', $allegro_template->getName()) ?>
<?php endif ?> 