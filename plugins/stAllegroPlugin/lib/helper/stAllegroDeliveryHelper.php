<?php

function st_allegro_delivery_times_select_tag($name, $value)
{
    return select_tag($name, options_for_select(stAllegroApi::getDeliveryTimes(), $value));
}

function st_allegro_shippin_rates_select_tag($name, $value)
{
    $options = array();
    
    try
    {
        $api = stAllegroApi::getInstance();
        
        foreach ($api->getShippingRates() as $rate)
        {
            $options[$rate->id] = $rate->name;
        }
    }
    catch(Exception $e)
    {
        if (SF_ENVIRONMENT == 'dev')
        {
            sfLogger::getInstance()->crit('{stAllegro} st_allegro_shippin_rates_select_tag: '. $e->getMessage());
        }
    }

    return select_tag($name, options_for_select($options, $value, array('include_custom' => __('Wybierz'))));
}