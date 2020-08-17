<?php 
use_helper('stWholesale');
echo wholesale_group_select_tag('sf_guard_user[wholesale]', $sf_guard_user->getWholesale());
    // echo select_tag('sf_guard_user[wholesale]',options_for_select(array('0'=>__("Brak"), 'a'=>__("Hurtownik poziom cen A"), 'b'=>__("Hurtownik poziom cen B"), 'c'=>__("Hurtownik poziom cen C")),$sf_guard_user->getWholesale()));
?>