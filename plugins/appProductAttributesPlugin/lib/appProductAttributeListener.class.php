<?php

class appProductAttributeListener
{
   public static function generateStProduct(sfEvent $event)
   {
      $generator = $event->getSubject();

      $generator->insertParameterAfter('edit.menu.display[attachment]', 'app_product_attributes');

      $generator->insertParameterAfter('presentation_config.display.Karta produktu[discount_type]', 'show_product_attributes');

      $generator->setValueForParameter('presentation_config.fields.show_product_attributes', array(
         'name' => 'Pokaż atrybuty produktu',
         'type' => 'select',
         'display' => array('before_desc', 'after_desc'),
         'options' => array(
            'before_desc' => array('name' => 'Wyświetlaj przed opisem'),
            'after_desc' => array('name' => 'Wyświetlaj po opisie'),
         ),
         'selected' => 'after_desc'
      ));

      $generator->setValueForParameter('edit.menu.fields.app_product_attributes', array(
         'name' => 'Atrybuty',
         'action' => '@appProductAttributesPlugin?action=productAttribute&product_id=%%id%%',
         'i18n_catalogue' => 'appProductAttributeBackend'
      ));      
   }

   public static function postExecuteDuplicate(sfEvent $event)
   {
      $product = $event['product'];
      $duplicate = $event['duplicate'];

      $c = new Criteria();
      $c->add(appProductAttributeVariantHasProductPeer::PRODUCT_ID, $product->getId());
      $attributes = appProductAttributeVariantHasProductPeer::doSelect($c);

      foreach($attributes as $attribute)
      {
         $new = $attribute->copy();
         $new->setProduct($duplicate);
         $new->save();
      }
   }

   public static function postExecuteFilter(sfEvent $event)
   {
      $action = $event->getSubject();

      if ($action->getRequest()->getMethod() == sfRequest::POST && $action->getRequest()->getParameter('type') == 'attr')
      {
         $app_product_filter = $action->getRequestParameter('app_product_filter');

         appProductAttributeHelper::setFilters($action->getContext(), $app_product_filter);
      }      
   }   

   public static function postExecuteClearFilter(sfEvent $event)
   {
      $action = $event->getSubject();

      $filter = $action->getRequestParameter('filter');

      $filters = appProductAttributeHelper::getFilters($action->getContext(), true);

      if ($filter && isset($filters[$filter]))
      {
         unset($filters[$filter]);

         appProductAttributeHelper::setFilters($action->getContext(), $filters);
      }
      elseif (null === $filter || $filter == 'attr')
      {
         appProductAttributeHelper::clearFilters($action->getContext());
      }
   }
}