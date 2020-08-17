<?php 
use_helper('stJQueryTools');

$options = array();
$payments = PaymentTypePeer::doSelectCached();
$defaults = array();

foreach ($payments as $payment) 
{
    if (!$payment->getActive()) continue;

    $options[] = array('id' => $payment->getId(), 'name' => $payment->getName());
}

if ($sf_request->hasErrors()) 
{      
  $parameters = $sf_request->getParameter('config[payment]');
  $defaults = stJQueryToolsHelper::parseTokensFromRequest($parameters);
}
elseif ($config->get('payment'))
{
    foreach ($config->get('payment') as $id)
    {
        if (isset($payments[$id]))
        {
            $defaults[] = array('id' => $payments[$id]->getId(), 'name' => $payments[$id]->getName());  
        }
    }
}

echo st_tokenizer_input_tag('config[payment]', $options, $defaults, array('tokenizer' => array(
    'preventDuplicates' => true, 
    'hintText' => __('Wpisz nazwę płatności'), 
    'sortable' => false, 
)));
?>