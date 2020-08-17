<?php echo select_tag('config[newsletter_default_culture]', options_for_select($languages, 
$config->get('newsletter_default_culture', null, false) ? $config->get('newsletter_default_culture', null, false) : 0)); ?>           

