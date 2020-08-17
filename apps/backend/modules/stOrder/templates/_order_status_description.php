<?php echo textarea_tag('order_status[order_status_description]', $order_status->getDescription(), array(
    'size' => '80x20',
    'rich' => true,
    'tinymce_options' => "theme:'advanced'",
    'disabled' => !$order_status->getHasMailNotification())) ?>