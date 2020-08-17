<?php
sfLoader::loadHelpers('stProduct', 'stProduct');

function st_discount_type_select_tag($name, $selected, $options = array())
{
    if (isset($options['currency']))
    {
        $currency = $options['currency'];
        unset($options['currency']);
    }
    else
    {
        $currency = stCurrency::getDefault();
    }

    return select_tag($name, options_for_select(array(
        '%' => '%', 
        'P' => $currency->getShortcut()
    ), $selected), $options);  
}

function object_product_set_discount(Discount $discount, $method, $options = array())
{
   $request = sfContext::getInstance()->getRequest();
   
   if (!stLicense::hasSupport() && $discount->getProduct())
   {
      return '<input value="'.$discount->getProduct()->getOptName().'" disabled="disabled" class="support" />';
   }

   if ($request->getMethod() == sfRequest::POST && $request->hasErrors()) 
   {      
      $parameters = $request->getParameter($options['control_name']);
      $defaults = stJQueryToolsHelper::parseTokensFromRequest($parameters);
   }
   else
   {   
      if ($discount->getProduct())
      {
         $product = $discount->getProduct();
         $defaults = array(array('id' => $product->getId(), 'name' => $product->getOptName(), 'image' => st_product_image_path($product, 'icon'), 'code' => $product->getCode())); 
      }
      else
      {
         $defaults = array();
      }
   }

   $results_formatter = _token_input_product_results_formatter();

   $token_formatter = _token_input_product_token_formatter();

   return st_tokenizer_input_tag($options['control_name'], st_url_for('@stDiscountPlugin?action=ajaxProductsToken'), $defaults, array('tokenizer' => array(
      'preventDuplicates' => true, 
      'resultsFormatter' => $results_formatter, 
      'tokenFormatter' => $token_formatter,
      'hintText' => __('Wpisz kod/nazwę szukanego produktu', null, 'stProduct'), 
      'additionalDataFields' => array('code'),
      'tokenLimit' => 1,
      'sortable' => true
   )));
}