<?php echo input_tag('trusted_shops[username]', $trusted_shops->getUsername(), array('size' => 25, 'disabled' => ($trusted_shops->getType() == 'Classic') ? true : false));