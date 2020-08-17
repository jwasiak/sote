<?php echo select_tag('filters[is_confirmed]', 
    options_for_select(array(1 => __('tak', array(), 'stAdminGeneratorPlugin'), 0 => __('nie', array(), 'stAdminGeneratorPlugin')), isset($filters['is_confirmed']) ? $filters['is_confirmed'] : null, array (
  'include_custom' => __("---", null, 'stAdminGeneratorPlugin'),
)), array (
)) ?>  