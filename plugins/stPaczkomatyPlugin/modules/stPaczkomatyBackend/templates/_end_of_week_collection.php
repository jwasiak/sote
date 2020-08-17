<?php 
    if ($paczkomaty_pack->isEditable())
    {
        echo st_admin_checkbox_tag('paczkomaty_pack[end_of_week_collection]', true, $paczkomaty_pack->getEndOfWeekCollection());
    }
    else
    {
        echo $paczkomaty_pack->getEndOfWeekCollection() ? __("Tak", null, "stAdminGeneratorPlugin") : __("Nie", null, "stAdminGeneratorPlugin"); 
    } 
?>