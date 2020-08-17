<?php use_helper('stOrder') ?>

<?php echo st_order_status_select_tag('config[order_status]', $config->get('order_status'), array('include_custom' => true)) ?>