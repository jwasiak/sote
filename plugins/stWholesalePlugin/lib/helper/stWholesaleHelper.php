<?php

function wholesale_group_select_tag($name, $value, array $htmlOptions = array())
{
    $options = array(
        '0' => __('Brak', null, 'stUser'), 
        'a' => __('Hurtownik poziom cen A', array(), 'stUser'),
        'b' => __('Hurtownik poziom cen B', array(), 'stUser'),
        'c' => __('Hurtownik poziom cen C', array(), 'stUser'),
    );

    return select_tag($name, options_for_select($options, $value, $htmlOptions));
}