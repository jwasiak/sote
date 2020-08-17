<?php
$options = array("" => "---");

$c = new Criteria();
$c->addAscendingOrderByColumn(DeliveryI18nPeer::NAME);

foreach (DeliveryPeer::doSelectWithI18n($c) as $delivery) 
{
    $options[$delivery->getId()] = $delivery->getName();
}

echo select_tag(
   'filters[filter_delivery]', 
   options_for_select($options, isset($filters['filter_delivery']) ? $filters['filter_delivery'] : null)
);