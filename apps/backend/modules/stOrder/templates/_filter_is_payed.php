<?php echo select_tag('filters[is_payed]', 
    options_for_select(array(1 => __('tak', array(), 'stAdminGeneratorPlugin'), 0 => __('nie', array(), 'stAdminGeneratorPlugin')), isset($filters['is_payed']) ? $filters['is_payed'] : null, array (
  'include_custom' => __("---", null, 'stAdminGeneratorPlugin'),
)), array (
)) ?>  