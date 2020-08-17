<?php

if (version_compare($version_old, '1.1.0.18', '<'))
{
   $admin_templates_dir = sfConfig::get('sf_plugins_dir').DIRECTORY_SEPARATOR.'stAdminGeneratorPlugin'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'generator'.DIRECTORY_SEPARATOR.'sfPropelAdmin'.DIRECTORY_SEPARATOR.'simple'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.'templates';

   if (is_file($admin_templates_dir.DIRECTORY_SEPARATOR.'_list_td_stacked.php'))
   {
      unlink($admin_templates_dir.DIRECTORY_SEPARATOR.'_list_td_stacked.php');
   }

   if (is_file($admin_templates_dir.DIRECTORY_SEPARATOR.'_list_th_filter_actions.php'))
   {
      unlink($admin_templates_dir.DIRECTORY_SEPARATOR.'_list_th_filter_actions.php');
   }

   if (is_file($admin_templates_dir.DIRECTORY_SEPARATOR.'_list_th_stacked.php'))
   {
      unlink($admin_templates_dir.DIRECTORY_SEPARATOR.'_list_th_stacked.php');
   }
}
