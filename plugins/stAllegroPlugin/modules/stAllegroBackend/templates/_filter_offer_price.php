<?php
echo input_tag('filters[price][from]', isset($filters['price']['from']) ? $filters['price']['from'] : null, array('size' => 10, 'class' => 'number-type', 'disabled' => isset($filters['number']) && $filters['number']));
echo ' - ';
echo input_tag('filters[price][to]', isset($filters['price']['to']) ? $filters['price']['to'] : null, array('size' => 10, 'class' => 'number-type', 'disabled' => isset($filters['number']) && $filters['number']));
