<?php 
    $options = array('A' => 'A (8 x 38 x 64 cm)', 'B' => 'B (19 x 38 x 64 cm)', 'C' => 'C (41 x 38 x 64 cm)');
    
    if ($paczkomaty_pack->isEditable())
    {
        echo select_tag('paczkomaty_pack[pack_type]', options_for_select($options, !$sf_request->hasParameter('paczkomaty_pack[pack_type]') ? $paczkomaty_pack->getPackType() : $sf_request->getParameter('paczkomaty_pack[pack_type]')));
    }
    else
    {
        echo $options[$paczkomaty_pack->getPackType()];
    }
?>