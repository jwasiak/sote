<?php

use_helper('stProducer');

$defaults = array();

if ($sf_request->hasErrors() && $sf_request->hasParameter('producers')) 
{      
   $parameters = $sf_request->getParameter('producers');
   $defaults = stJQueryToolsHelper::parseTokensFromRequest($parameters);
}
elseif (!$discount_coupon_code->isNew())
{   
   $defaults = DiscountCouponCodeHasProducerPeer::doSelectProducerForTokenInput($discount_coupon_code);
}

echo producer_picker_input_tag('producers', $defaults);