<?php 

class stBackendActions extends stActions
{
    public function executeAdditionalApplicationsList()
    {
		$applications = array();

		$routing = sfRouting::getInstance();

		foreach(stConfiguration::getInstance()->getDesktopModules() as $modules) {
			foreach ($modules as $module) 
			{
				if (preg_match('/^app|sm/', $module->getName()))
				{
					$applications[$module->getRoute()] = $module;
				}
			}
		}

	
		foreach (stApplication::getDefaultDesktopApps() as $app => $name) 
		{
			if (preg_match('/^app|sm/', $app)) 
			{
            $module = new stBackendDesktopModule($routing, $app);

				$applications[$module->getRoute()] = $module;
			}
		}

		$this->applications = $applications;
	}
	
	public function executeLicense()
	{
		$block = stCommunication::blockSite(10);

		if (!$block)
		{
			stCommunicationCache::disableCache();
			stCommunication::getIsSeven();
			stCommunication::getUpgradeExpirationDate();
			stCommunication::getSupportExpirationDate();
			stCommunicationCache::enableCache();
			
			stPartialCache::clear('stBackend', '_updateInfo', array('app' => 'backend'));
			
			return $this->redirect($this->getRequest()->getReferer());
		}
	}

    public function executeCheckService() {
        
        stCommunicationCache::disableCache();
        stCommunication::getIsSeven();
        stCommunication::getUpgradeExpirationDate();
        stCommunication::getSupportExpirationDate();
        stCommunicationCache::enableCache();

        sfLoader::loadHelpers(array('Helper', 'stBackend'));

        return $this->renderText(get_service_information());
	}
	
	public function executeUpdateInfoRefresh()
	{
        stCommunicationCache::disableCache();
        stCommunication::getIsSeven();
        stCommunication::getUpgradeExpirationDate();
        stCommunication::getSupportExpirationDate();
        stCommunicationCache::enableCache();

		stPartialCache::clear('stBackend', '_updateInfo', array('app' => 'backend'));
		
		return $this->renderText($this->getRenderComponent('stBackend', 'updateInfo'));
	}
}