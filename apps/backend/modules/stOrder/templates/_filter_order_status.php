<?php echo st_order_status_filter_select_tag(
   'filters[filter_order_status]', 
   isset($filters['filter_order_status']) ? $filters['filter_order_status'] : null,
   array('style' => 'max-width: 140px')
) ?>