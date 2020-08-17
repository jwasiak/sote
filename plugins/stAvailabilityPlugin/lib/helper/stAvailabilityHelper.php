<?php

use_helper('stAvailabilityImage');

function st_availability_show(Product $product)
{
    $availability = $product->getFrontendAvailability();

    if (!$availability)
    {
        return null;
    }
    
    $imgage = '';

    $label = $availability->getAvailabilityName();


    if ($availability->getOptImage())
    {
        $image = st_availability_image_tag($availability, 'full');
    }

    return $image.'<span class="product-availability-label">'.$label.'</span>';
}