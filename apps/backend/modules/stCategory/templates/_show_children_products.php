<?php echo checkbox_tag('category[show_children_products]', 1, $category->getShowChildrenProducts(), array (
  'disabled' => stConfig::getInstance('stCategory')->get('show_children_products'),
)); ?>