<?php 
if ($paczkomaty_pack->isEditable())
{
    echo st_admin_optional_input('paczkomaty_pack[cash_on_delivery]', $paczkomaty_pack->getCashOnDelivery() ? $paczkomaty_pack->getCashOnDelivery() : $paczkomaty_pack->getCashOnDelivery(true), array('size' => 7, 'disabled' => !$paczkomaty_pack->getCashOnDelivery() && ($sf_request->getMethod() == sfRequest::POST || !$paczkomaty_pack->hasCashOnDelivery())));
}
else
{
    echo stPrice::round($paczkomaty_pack->getCashOnDelivery());
}
?> PLN

<script type="text/javascript" language="javascript">
    jQuery(function($) {
        $('#paczkomaty_pack_cash_on_delivery').change(function() {
            $(this).val(stPrice.fixNumberFormat($(this).val()));
        });
    });
</script>