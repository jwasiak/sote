<?php

class stImportExportBackendActions extends autoStImportExportBackendActions
{

   public function executeList()
   {
      if ($this->hasRequestParameter('for_module'))
      {
         $for_module = $this->getRequestParameter('for_module');
         sfConfigCache::getInstance()->import(sfConfig::get('sf_app_module_dir_name').'/'.$for_module.'/'.sfConfig::get('sf_app_module_config_dir_name').'/generator.yml', true);
         require_once(sfConfig::get('sf_module_cache_dir').'/auto'.ucfirst($for_module).'/lib/stModuleImportExport.class.php');

         $paths = sfLoader::getPluginModulePaths();

         if (isset($paths[$for_module]) && is_file($paths[$for_module] . '/lib/' . $for_module . 'ImportExport.class.php'))
         {
            require_once($paths[$for_module] . '/lib/' . $for_module . 'ImportExport.class.php');
         }
         else
         {
            require_once(sfConfig::get('sf_app_module_dir') . '/' . $for_module . '/lib/' . $for_module . 'ImportExport.class.php');
         }

         $export = call_user_func(array($for_module.'ImportExport', 'getExport'));
         stImportExportPropel::updateExportProfiles($this->getRequestParameter('model'), $export['fields'], $export['primary_key']);
      }
      parent::executeList();

      $c = $this->pager->getCriteria();

      if (!$this->hasRequestParameter('model') && !isset($this->forward_parameters['model']))
         $this->forward();
      $model = $this->getRequestParameter('model', $this->forward_parameters['model']);

      $c->add(ExportProfilePeer::MODEL, $model);

      $this->pager->init();
   }

   protected function getExportProfileOrCreate($id = 'id')
   {
      $export_profile = parent::getExportProfileOrCreate($id);
      if ($export_profile->isNew())
      {
         $export_profile->setModel($this->getRequestParameter('model'));
      }
      return $export_profile;
   }

   public function validateEdit()
   {

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $fields = stJQueryToolsHelper::parseTokensFromRequest($this->getRequestParameter("export_profile_fields"));

         //No fields selected
         if (!count($fields))
         {
            $this->getRequest()->setError('export_profile{field}', sfContext::getInstance()->getI18n()->__('Proszę wybrać co najmniej jedno pole.'));
            return false;
         }
      }
      return true;
   }

   protected function saveExportProfile($export_profile)
   {
      $is_new = $export_profile->isNew();
      $ret = parent::saveExportProfile($export_profile);
      
      if (!$is_new)
      {
         $c = new Criteria();
         $c->add(ExportProfileHasExportFieldPeer::EXPORT_PROFILE_ID, $export_profile->getId());
         ExportProfileHasExportFieldPeer::doDelete($c);
      }

      $fields = stJQueryToolsHelper::parseTokensFromRequest($this->getRequestParameter("export_profile_fields"));
      
      if ($fields) 
      {
         foreach ($fields as $field) 
         {
            $epf = new ExportProfileHasExportField();
            $epf->setExportProfileId($export_profile->getId());
            $epf->setExportFieldId($field['id']);
            $epf->save();
         }
      }
      
      return $ret;
   }

}