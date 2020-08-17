<?php
if ($paczkomaty_pack->isEditable())
{ 
    echo input_tag('paczkomaty_pack[description]', !$sf_request->hasParameter('paczkomaty_pack[description]') ? $paczkomaty_pack->getDescription() : $sf_request->getParameter('paczkomaty_pack[description]'), array('size' => 80));
}
else
{
    echo $paczkomaty_pack->getDescription();
}
?>