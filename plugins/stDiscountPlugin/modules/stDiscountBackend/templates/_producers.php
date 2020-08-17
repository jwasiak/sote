<?php

use_helper('stProducer');

$defaults = array();

if ($sf_request->hasErrors() && $sf_request->hasParameter('producers')) 
{      
   $parameters = $sf_request->getParameter('producers');
   $defaults = stJQueryToolsHelper::parseTokensFromRequest($parameters);
}
elseif (!$discount->isNew())
{   
   $defaults = DiscountHasProducerPeer::doSelectProducerForTokenInput($discount);
}

echo producer_picker_input_tag('producers', $defaults);