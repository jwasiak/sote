 <?php echo object_checkbox_tag($category, 'getMainPage', array (
  'control_name' => 'category[main_page]',
  'disabled' => $category->isRoot(),
)); ?>
