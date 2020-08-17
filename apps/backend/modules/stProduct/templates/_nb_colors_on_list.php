<?php

echo input_tag('config[nb_colors_on_list]', $config->get('nb_colors_on_list',4), array('size'=>4, 'maxlength'=>4));
