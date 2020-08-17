<?php echo input_tag('filters[list_stock][from]', isset($filters['list_stock']['from']) ? $filters['list_stock']['from'] : null, array (
  'size' => 4,
  'class' => 'float',
)) . ' - ' . input_tag('filters[list_stock][to]', isset($filters['list_stock']['to']) ? $filters['list_stock']['to'] : null, array (
  'size' => 4,
  'class' => 'float',
)) ?>  