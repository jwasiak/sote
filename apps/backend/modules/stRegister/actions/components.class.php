<?php
/**
 * SOTESHOP/stRegister
 *
 * Ten plik należy do aplikacji stRegister opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stRegister
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 613 2009-04-09 12:34:35Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stRegisterComponents
 *
 * @package     stRegister
 * @subpackage  actions
 */
class stRegisterComponents extends sfComponents
{
	/**
	 * Wyświetlanie informacji o ważności licencji
	 */
	Public function executeLicenseInfo()
	{
		$config = stConfig::getInstance($this->getContext(), 'stRegister');
		$license = $config->get('license');
		
		$this->show = 0;
		
		if(!empty($license))
		{
			$this->show = 1;
			$stLicense = new stLicense($license);
			$this->dayLimit = $stLicense->getLicenseExpirationDays();
			$this->dataUse = $stLicense->checkLicenseDate();
		}
	}
}