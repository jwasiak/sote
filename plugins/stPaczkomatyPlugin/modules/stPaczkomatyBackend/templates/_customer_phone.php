<?php 
if ($paczkomaty_pack->isEditable())
{
    echo input_tag('paczkomaty_pack[customer_phone]', $paczkomaty_pack->getCustomerPhone(), array('size' => 80));
}
else
{
    echo $paczkomaty_pack->getCustomerPhone();
}
?>