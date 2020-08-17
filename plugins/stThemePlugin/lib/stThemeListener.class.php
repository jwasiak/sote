<?php  

class stThemeListener
{
   public static function validate(sfEvent $event)
   {
      $action = $event->getSubject();

      if (SF_ENVIRONMENT == 'edit' && $action->getController()->getTheme()->getVersion() >= 2)
      {
         $action->redirect('http://'.$action->getRequest()->getHost().'/backend.php');
      }
   }

   public static function postExecute(sfEvent $event)
   {
      $action = $event->getSubject();

      if ($action->getModuleName() == 'appTaggableBackend' && $action->getActionName() == 'saveConfig')
      {
         stTheme::clearSmartyCache(true);
      }
   }
}
