<?php 
use_helper('stUrl', 'stBackend');

if ($related_object instanceof ProductGroup && !$related_object->isNew()) 
{
   $icon = get_app_icon('/images/backend/main/icons/stProductGroup.png');
   echo st_get_admin_head(array('@stProductGroupEdit?id='.$related_object->getId(), $related_object->getName(), $icon), $title, array(
      'shortcuts' => array(
         0 => 'stProduct',
      ), 
      'culture' => isset($culture) ? $culture : null, 'route' => $route));
}
else
{
   $icon = get_app_icon('/images/backend/main/icons/stProductGroup.png');
   echo st_get_admin_head(array('@stProductGroup', __('Grupy produktów'), $icon), $title, array(
      'shortcuts' => array(
         0 => 'stProduct',
      ), 
      'culture' => isset($culture) ? $culture : null, 'route' => isset($route) ? $route : null));
}
?>