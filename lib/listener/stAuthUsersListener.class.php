<?php

class stAuthUsersListener 
{ 
   protected static $modules = null;

   public static function checkCredentials(sfEvent $event)
   {
      $action = $event->getSubject();

      if (!$action->getUser()->isSuperAdmin() && $action->isSecure())
      {
         $request = $action->getRequest();

         if (!$request->isXmlHttpRequest())
         { 
            $module = $action->getModuleName();   

            if (!($module == 'stLanguageBackend' && $action == 'changeLanguage'))
            {
               self::checkAccessCredentials($action, $request, $module);

               if ($request->getMethod() == sfRequest::POST && preg_match('/(save|config)$/i', $action->getActionName()))
               {
                  self::checkModificationCredentials($action, $request, $module);
               }
            }
         }
      }
   }

   public static function checkModificationCredentials(sfAction $action, sfRequest $request, $module, $use_referer = true)
   {
      $modules = self::getModuleNames($module, 'modification');

      if ($modules)
      {
         $has_credential = false;

         foreach ($modules as $module) {    
            if ($action->getUser()->hasCredential($module.'.modification'))
            {
               $has_credential = true;
               break;
            }
         }

         if (!$has_credential)
         {
            if ($use_referer)
            {
               $i18n = $action->getContext()->getI18N();

               $action->setFlash('warning', $i18n->__('Nie posiadasz odpowiednich uprawnień do wykonania tej operacji', null, 'sfGuardUser'));

               $action->redirect($request->getReferer());
            }
            else
            {
               $action->redirect('sfGuardAuth/secure');
            }
         }
      }
   }

   public static function checkAccessCredentials(sfAction $action, sfRequest $request, $module)
   {
      $modules = self::getModuleNames($module, 'access');

      if ($modules)
      {           
         $has_credential = false;

         foreach ($modules as $module)
         {
            if ($action->getUser()->hasCredential(array($module.'.access', $module.'.modification'), false))
            {
               $has_credential = true;
               break;
            }
         }

         if (!$has_credential)
         {
            if ($action instanceof stGadgetActions)
            {
               $action->redirect('sfGuardAuth/secure?layout=layout_gadget');
            }
            else
            {
               $action->redirect('sfGuardAuth/secure');
            }
         }
      }
   }   

   public static function getModuleNames($module, $type)
   {
      $dependencies = sfConfig::get('app_security_credential_dependencies');

      $modules = array();

      if (isset($dependencies[$type][$module]))
      {
         $modules = $dependencies[$type][$module];
      }
      
      $modules[] = $module;

      $secured_modules = array_flip(self::getSecuredModules());

      return array_intersect($modules, $secured_modules);
   }

   public static function getSecuredModules()
   {
      if (null === self::$modules)
      {
         $fc = new stFunctionCache();

         $lastmodified = Dashboard::getLastModified();

         $culture = sfContext::getInstance()->getUser()->getCulture();

         self::$modules = $fc->cacheCall('stAuthUsersListener::getSecuredModulesCached', array($lastmodified, $culture));
      }

      return self::$modules;
   }

   public static function getSecuredModulesCached()
   {
      $modules = array();

      $routing = sfRouting::getInstance();

      $i18n = sfContext::getInstance()->getI18N();

      $ignore = array(
         'stAttributeTemplateBackend',
         'stImportExportBackend',
         'stRemindBackend',
         'stProductOptionsTemplateBackend',
         'stBackendFastMenuPlugin',
         'stRegister',
         'stConfigurationBackend',
         'sfGuardUser',
         'stRegister'
      );

      foreach (stApplication::getApps() as $app => $name) 
      {
         $module = new stBackendDesktopModule($routing, $app);

         $module_name = $module->getName();

         if (!$module->isValid() || in_array($module_name, $ignore)) continue;
    
         $modules[$module_name] = $i18n->__($module->getLabel(), null, $module_name);
      }

      foreach(stConfiguration::getInstance()->getDesktopModules() as $desktop_modules) 
      {
         foreach ($desktop_modules as $module) 
         {
            $module_name = $module->getName();

            if (!$module->isValid() || in_array($module_name, $ignore)) continue;

            if (!isset($modules[$module_name]))
            {
               $modules[$module_name] = $i18n->__($module->getLabel(), null, $module_name);
            }
         }
      }   

      asort($modules, SORT_STRING);   

      return $modules;    
   }
}