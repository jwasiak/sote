<?php

use_helper('stProducer');

$defaults = array();

if ($sf_request->hasErrors()) 
{      
   $parameters = $sf_request->getParameter('producers');
   $defaults = stJQueryToolsHelper::parseTokensFromRequest($parameters);
}
elseif (!$gift_card->isNew())
{   
   $defaults = GiftCardHasProducerPeer::doSelectProducerForTokenInput($gift_card);
}

echo producer_picker_input_tag('producers', $defaults);