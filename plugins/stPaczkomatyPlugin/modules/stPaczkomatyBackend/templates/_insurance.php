<?php 
    if ($paczkomaty_pack->isEditable())
    {
        echo st_admin_optional_input('paczkomaty_pack[insurance]', $paczkomaty_pack->getInsurance() ? $paczkomaty_pack->getInsurance() : $paczkomaty_pack->getInsurance(true), array('size' => 7, 'disabled' => !$paczkomaty_pack->getInsurance() && !$paczkomaty_pack->hasAllegroInsurance()));
    }
    else
    {
        echo stPrice::round($paczkomaty_pack->getInsurance());
    } 
?> PLN

<script type="text/javascript" language="javascript">
    jQuery(function($) {
        $('#paczkomaty_pack_insurance').change(function() {
            $(this).val(stPrice.fixNumberFormat($(this).val()));
        });
    });
</script>