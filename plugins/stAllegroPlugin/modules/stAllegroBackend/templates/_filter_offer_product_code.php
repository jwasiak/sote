<?php echo input_tag('filters[product_code]', isset($filters['product_code']) ? $filters['product_code'] : null, array('disabled' => isset($filters['number']) && $filters['number'])); ?>