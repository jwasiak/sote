<?php
class stOpenGraphListener
{
   public static function append(sfEvent $event, $components)
   {      

      switch($event['slot'])
      {
         case 'before_head_ends':
         case 'before-head-ends':
         $components[] = $event->getSubject()->createComponent('stOpenGraphFrontend', 'showOGTags');                          
         break;
      }
      return $components;
   }

   
   
}
?>
