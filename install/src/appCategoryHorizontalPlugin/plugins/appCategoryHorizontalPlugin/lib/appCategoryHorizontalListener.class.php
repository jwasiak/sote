<?php
class appCategoryHorizontalListener
{
   public static function append(sfEvent $event, $components)
   {
      if ($event['slot'] == 'container_head_bottom')
      {
         $components[] = $event->getSubject()->createComponent('appCategoryHorizontalFrontend', 'tree', array('initialize' => true));
      }

      return $components;
   }

   public static function preExecute(sfEvent $event)
   {
      if ($event->getSubject()->hasRequestParameter('horizontal'))
      {
         stProducer::clearSelectedProducerId();
      }
   }

   public static function clearCache(sfEvent $event=null)
   {      
      stPartialCache::clear('appCategoryHorizontalFrontend', '_tree', array('app' => 'frontend'));
   }
}
?>
