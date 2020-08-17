<?php 
if ($paczkomaty_pack->isEditable())
{
    echo input_tag('paczkomaty_pack[customer_email]', $paczkomaty_pack->getCustomerEmail(), array('size' => 80));
}
else
{
    echo $paczkomaty_pack->getCustomerEmail();
}
?>