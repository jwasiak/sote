<?php 
$api = stInPostApi::getInstance();
try
{
    if ($paczkomaty->getInPostShipmentId())
    {
        $shipment = $api->getShipment($paczkomaty->getInPostShipmentId());
    }
    else
    {
        $shipment = $api->getShipmentByTrackingNumber($paczkomaty->getTrackingNumber());
    }

    $api->getStatusTitleByName($shipment->status);
}