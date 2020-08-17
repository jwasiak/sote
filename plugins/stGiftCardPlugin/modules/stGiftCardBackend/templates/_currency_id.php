<?php 
if ($type == 'list')
{
    echo $gift_card->getCurrency();
}
else
{
    echo object_select_tag($gift_card->getCurrency() ? $gift_card->getCurrency() : stCurrency::getInstance($sf_context)->getBackendMainCurrency(), 'getId', array('control_name' => 'gift_card[currency_id]', 'related_class' => 'Currency'));
}
?> 