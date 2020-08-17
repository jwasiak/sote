<?php 
use_helper('stProductImage','stUrl', 'stBackend');

if ($related_object instanceof Product && !$related_object->isNew()) 
{

   echo st_get_admin_head(array('@stProductEdit?id='.$related_object->getId(), $related_object->getName(), st_product_image_path($related_object, 'thumb')), $title, array(
      'shortcuts' => array(
         0 => 'stCategory',
         1 => 'stProducer',
         2 => 'stProductGroup',
         3 => 'stQuestionPlugin',
         4 => 'stReview',
         5 => 'appProductAttributesPlugin',
         6 => 'stGroupPricePlugin'
      ), 
      'culture' => isset($culture) ? $culture : null, 'route' => $route));
}
else
{
   $icon = get_app_icon('/images/backend/main/icons/stProduct.png');
   echo st_get_admin_head(array('@stProduct', __('Produkty'), $icon), $title, array(
      'shortcuts' => array(
         0 => 'stCategory',
         1 => 'stProducer',
         2 => 'stProductGroup',
         3 => 'stQuestionPlugin',
         4 => 'stReview',
         5 => 'appProductAttributesPlugin',
         6 => 'stGroupPricePlugin'
      ), 
      'culture' => isset($culture) ? $culture : null, 'route' => isset($route) ? $route : null));
}
?>