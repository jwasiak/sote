<?php echo select_tag('filters[list_assigned]', options_for_select(array(1 => __('tak'), 0 => __('nie')), isset($filters['list_assigned']) ? $filters['list_assigned'] : null, array (
  'include_custom' => __("---"),
)), array (
)) ?>