<?php

/**
 * stFastCache actions.
 *
 * @package    soteshop
 * @subpackage stFastCache
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9661 2010-12-01 09:45:27Z piotr $
 */
class stFastCacheActions extends autostFastCacheActions
{
	/**
	 * Executes index action
	 *
	 */
	public function executeIndex()
	{
		return $this->forward('stFastCache','config');
	}

	public function validateConfig()
	{
		if ($this->getRequest()->getMethod() == sfRequest::POST)
		{
			$i18n = $this->getContext()->getI18N();
			if (!$this->testRequirements())
			{
				$this->getRequest()->setError('config{fast_cache_enabled}', $i18n->__('Brak obsługi PDO lub brak sterownika sqlite dla PDO. W celu rozwiązania problemu proszę skontaktować się z administratorem serwera.'));
			}
		}

		return !$this->getRequest()->hasErrors();
	}

	protected function saveConfig() 
	{      
		$ret = parent::saveConfig();

		stFastCacheManager::clearCache();

		return $ret;
	}

	public function executeClear()
	{
		stFastCacheManager::clearCache();

		$this->setFlash('notice', $this->getContext()->getI18N()->__('Fast Cache został wyczyszczony'));

		return $this->redirect($this->getRequest()->getReferer());
	}

	protected function testRequirements()
	{
		if (class_exists('PDO'))
		{
			if (array_search('sqlite',PDO::getAvailableDrivers()) === false) return false;
			return true;
		}
		return false;
	}
}
