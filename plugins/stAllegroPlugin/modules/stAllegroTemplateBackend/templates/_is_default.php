<?php 

echo checkbox_tag('allegro_template[is_default]', TRUE, $allegro_template->getIsDefault(), array('disabled' => $allegro_template->getIsDefault()));

if ($allegro_template->getIsDefault())
    echo input_hidden_tag('allegro_template[is_default]', TRUE);
