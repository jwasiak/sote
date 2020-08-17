<?php 

echo checkbox_tag('allegro_delivery[is_default]', TRUE, $allegro_delivery->getIsDefault(), array('disabled' => $allegro_delivery->getIsDefault()));

if ($allegro_delivery->getIsDefault())
    echo input_hidden_tag('allegro_delivery[is_default]', TRUE);
