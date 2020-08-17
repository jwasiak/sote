<?php
$options = array("" => "---", 1 => __('tak', null, 'stAdminGeneratorPlugin'), 0 => __('nie', null, 'stAdminGeneratorPlugin'));

echo select_tag('filters[allegro]', options_for_select($options, isset($filters['allegro']) ? $filters['allegro'] : null));
?>