<?php echo select_tag('config[order_status_type]', options_for_select($select_options, $config->get("order_status_type")), array('class' => 'support')) ?>