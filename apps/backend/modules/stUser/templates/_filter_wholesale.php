<?php
use_helper('stWholesale');

echo wholesale_group_select_tag('filters[wholesale_list]', isset($filters['wholesale_list']) ? $filters['wholesale_list'] : null, array('include_custom' => '---'));