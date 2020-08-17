<?php echo select_tag('config['.$environment.'_state]', options_for_select($states, $config['state']));
