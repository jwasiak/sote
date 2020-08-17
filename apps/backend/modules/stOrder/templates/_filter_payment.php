<?php
$options = array("" => "---", "gift_card" => __('Bon zakupowy'));

foreach (PaymentTypePeer::doSelectCached() as $payment) 
{
    $options[$payment->getId()] = $payment->getName();
}

asort($options, SORT_NATURAL | SORT_FLAG_CASE);

echo select_tag(
   'filters[filter_payment]', 
   options_for_select($options, isset($filters['filter_payment']) ? $filters['filter_payment'] : null)
);