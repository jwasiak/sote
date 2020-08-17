<?php
/**
 * SOTESHOP/stBackend
 *
 * Ten plik należy do aplikacji stBackend opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stBackend
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: components.class.php 15035 2011-09-08 13:42:20Z michal $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */

/**
 * Akcje modułu stBackendMain.
 *
 * @package     stBackend
 * @subpackage  actions
 */
class stBackendMainComponents extends sfComponents
{
	public function executeShowBrowsers()
	{
		$this->ie = false;
		$this->version = "";

		$stWebRequest = new stWebRequest();
		$httpUserAgent = $stWebRequest->getHttpUserAgent();

		if(ereg("MSIE 8.0", $httpUserAgent))
		{
			$this->ie = true;
			$this->version = "8.0";
		}
	}

	public function executeShowNaviBar()
	{
		$backendMainConfig = stConfig::getInstance($this->getContext(), 'stBackendMain');
		$this->isNaviBar = $backendMainConfig->get('is_navi_bar');
	}

	/**
	 * Desktop icons
	 */
	public function executeDesktopIcons()
	{
		$this->apps = stApplication::getDefaultDesktopApps();
		// tmporaray salution for backend emulation m@sote.pl 2011-01-19 not for release!!!
		// changed also listSuccess.php check diff
		$i=1;$this->apps1=array();$this->apps2=array();

		foreach ($this->apps as $key=>$val)
		{
			$this->apps1[$key]=$val;
		}
		// end
	}

	public function executeTimeRequest() {
		$this->time = (time()+5400)*1000;
	}
}