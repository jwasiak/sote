<?php

use_helper('stJQueryTools');

function app_blue_media_channel_list($name, $selected)
{
    $api = appBlueMedia::getInstance();

    $options = array();

    $gateways = $api->getGatewayList();

    foreach ($gateways as $id => $channel)
    {
        $options[] = array('id' => $id, 'name' => $channel['name']);
    }

    $defaults = array();

    foreach ($selected as $id => $activeGateway)
    {
        if (isset($gateways[$id]))
        {
            $defaults[] = array('id' => $id, 'name' => $gateways[$id]['name']);
        }
    }

    return st_tokenizer_input_tag($name, $options, $defaults, array('tokenizer' => array(
        'preventDuplicates' => true, 
        'hintText' => __('Wpisz lub wybierz kanał płatności'), 
        'sortable' => false, 
    )));
}