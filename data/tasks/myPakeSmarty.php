<?php

pake_desc('(SOTE) exports smarty template slot definions into database');
pake_task('smarty-slot-export', 'project_exists');

pake_desc('(SOTE) clear smarty template cache');
pake_task('smarty-clear-cache', 'project_exists');

function run_smarty_clear_cache($task, $args)
{
   $files = glob(sfConfig::get('sf_root_cache_dir').DIRECTORY_SEPARATOR.'smarty_c'.DIRECTORY_SEPARATOR.'*');
   
   foreach ($files as $file)
   {
      if (unlink($file))
      {
         pake_echo_action('file-', $file);
      }
   }
}

function run_smarty_slot_export($task, $args)
{
   define('SF_ROOT_DIR', sfConfig::get('sf_root_dir'));

   define('SF_APP', 'frontend');

   define('SF_ENVIRONMENT', 'dev');

   define('SF_DEBUG', true);
   
   require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

   $databaseManager = new sfDatabaseManager();

   $databaseManager->initialize();
      
   if (!isset($args[0]))
   {
      throw new sfException('You must provide a theme name: ./symfony smarty-slot-export theme_name');
   }
   
   $theme_name = $args[0];   
   
   $c = new Criteria();
   
   $c->add(ThemePeer::THEME, $theme_name);
   
   $theme = ThemePeer::doSelectOne($c);
   
   if (!$theme)
   {
      throw new sfException(sprintf('The given theme "%s" does not exist', $theme_name));
   }   
   
   $c = new Criteria();
   
   $c->add(ThemeSlotPeer::THEME_ID, $theme->getId());
   
   foreach (ThemeSlotPeer::doSelect($c) as $slot)
   {
      $slot->delete();
   }

   $paths = array();

   foreach (sfLoader::getPluginModulePaths() as $dir)
   {
      $files = glob($dir.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.$theme_name.DIRECTORY_SEPARATOR.'*.html');

      foreach ($files as $file)
      {
         pake_echo_action('processing template', $file);
         
         stSmartySlotExport::export($theme, $file);
      }
      
      
   }

   $files = glob(sfConfig::get('sf_app_module_dir').DIRECTORY_SEPARATOR.'*'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.$theme_name.DIRECTORY_SEPARATOR.'*.html');
   
   foreach ($files as $file)
   {      
      pake_echo_action('processing template', $file);
      
      stSmartySlotExport::export($theme, $file);
   }
   
   $files = glob(sfConfig::get('sf_app_template_dir').DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.$theme_name.DIRECTORY_SEPARATOR.'*.html');
   
   foreach ($files as $file)
   {      
      pake_echo_action('processing template', $file);
      
      stSmartySlotExport::export($theme, $file);
   }   
}