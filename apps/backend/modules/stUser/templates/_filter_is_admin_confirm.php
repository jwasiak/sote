<?php echo select_tag('filters[is_admin_confirm]', options_for_select(array(1 => __('tak', array(), 'stAdminGeneratorPlugin'), 0 => __('nie', array(), 'stAdminGeneratorPlugin')), isset($filters['is_admin_confirm']) ? $filters['is_admin_confirm'] : null, array (
  'include_custom' => __("---", null, 'stAdminGeneratorPlugin'),
)), array (
)) ?>