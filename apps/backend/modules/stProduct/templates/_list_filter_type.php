<?php 
    $filters = array(1=>__('Zwykły filtr'), 2=>__('Filtr koloru'), 3=>__('Filtr ceny'));
    echo $filters[$product_options_filter->getFilterType()];

