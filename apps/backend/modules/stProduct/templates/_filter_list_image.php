<?php
echo select_tag('filters[list_image]', 
        options_for_select(array(1 => __('tak', array(), 'stAdminGeneratorPlugin'), 0 => __('nie', array(), 'stAdminGeneratorPlugin')),
        isset($filters['list_image']) ? $filters['list_image'] : null, array ('include_custom' => '---')))
?>