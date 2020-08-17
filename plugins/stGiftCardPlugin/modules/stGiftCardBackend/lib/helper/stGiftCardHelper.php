<?php
function st_gift_card_status_select_tag($name, $selected = null, $params = array())
{
   $status = sfConfig::get('app_stGiftCard_status');
   
   $options = array();
   
   if (isset($params['include_custom']))
   {
      $options[''] = __($params['include_custom']);
      
      unset($params['include_custom']);
   }
   
   foreach ($status as $v => $n)
   {
      $options[$v] = __($n);
   }
   
   return select_tag($name, options_for_select($options, $selected), $params);
}

function st_gift_card_status_name($selected)
{
   $status = sfConfig::get('app_stGiftCard_status');
   
   return isset($status[$selected]) ? __($status[$selected]) : null;
}