<?php
/**
 * SOTESHOP/stShopInfoPlugin
 *
 * Ten plik należy do aplikacji stShopInfoPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stShopInfoPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 4651 2009-02-04 12:51:04Z pawel $
 * @author      Paweł Byszewski <pawel.byszewski@sote.pl>
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stShopInfoBackendActions
 *
 * @package     stShopInfoPlugin
 * @subpackage  actions
 */
class stShopInfoBackendActions extends sfActions
{
	/**
	 * Wyświetlanie formularza danych sklepu
	 */
	public function executeIndex()
	{
		$i18n = $this->getContext()->getI18N();

		$this->config = stConfig::getInstance($this->getContext());

		$this->menu_items = $this->getMenuItems();

		if ($this->getRequest()->getMethod() == sfRequest::POST)
		{
			stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
			
			$this->config->setFromRequest('st_shop_info');
			
            if (!$this->getRequest()->hasErrors())
			{
                $this->config->save();
                $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));
                stFastCacheManager::clearCache();
            }
		}
	}

    public function validateIndex()
    {
        $request = $this->getRequest();
        if ($request->getMethod() == sfRequest::POST)
        {
            $data = $request->getParameter('st_shop_info');

            if (isset($data['show_phone']) && strpos($data['phone'], '+') !== 0)
            {
                $request->setError('st_shop_info{phone}', 'Musisz podać telefon w formacie miedzynarodowym');
            }
        }

        return !$request->hasErrors();
    }

    public function handleErrorIndex()
    {
        $this->executeIndex();
        return sfView::SUCCESS;
    }

	/**
	 * Wyświetlanie informacji o licencji
	 */
	public function executeRegister()
	{
		$this->config = stConfig::getInstance($this->getContext(), 'stRegister');

		$this->menu_items = $this->getMenuItems();

		$this->showChangeLicenseButton = false;
		
		if (stLicense::isOpen()) $this->showChangeLicenseButton = true;
	}

	/**
	 * Wyświetlanie zmiany numeru licencji
	 */
	public function executeChangeLicense()
	{
		$this->config = stConfig::getInstance($this->getContext(), 'stRegister');

		$this->menu_items = $this->getMenuItems();
			
		if ($this->getRequest()->getMethod() == sfRequest::POST)
		{
			$license = $this->getRequest()->getParameter('license_number');
			
			$this->config->set('license', trim($license));
			
			$this->config->save();
			
			$stLicense = new stLicense($license);
			
			$stLicense->activateInSote();
			
			$this->setFlash('notice', 'Twoje zmiany zostały zapisane');
		}
	}

	/**
	 * Walidacja numeru licencji
	 */
	public function validateChangeLicense()
	{
		if ($this->getRequest()->getMethod() == sfRequest::POST)
		{
			$i18n = $this->getContext()->getI18N();

			$license = $this->getRequest()->getParameter('license_number');

			if(!$license)
			{
				$this->getRequest()->setError('license_number', $i18n->__('Proszę uzupełnić pole.'));
				return false;
			}

			$params = array(
    	       'min' => 29,
    	       'min_error' => $i18n->__('Proszę sprawdzić czy numer licencji oraz jego format są poprawne.<br/>Numer licencji powinien zawierać 29 znaków w formacie xxxx-xxxx-xxxx-xxxx-xxxx-xxxx.'),
               'max' => 29,
               'max_error' => $i18n->__('Proszę sprawdzić czy numer licencji oraz jego format są poprawne.<br/>Numer licencji powinien zawierać 29 znaków w formacie xxxx-xxxx-xxxx-xxxx-xxxx-xxxx.'),
			);

			$sfStringValidator = new sfStringValidator();
			$sfStringValidator->initialize($this->getContext(), $params);
			if (!$sfStringValidator->execute($license, $error))
			{
				$this->getRequest()->setError('license_number', $error);
				return false;
			}

			if (stLicense::isCommercial())
			{
				$this->getRequest()->setError('license_number', $i18n->__('Nie można zmienić numeru licencji wersji komercyjnej.'));
				return false;
			}

			$stLicense = new stLicense($license);

			if ($stLicense->getType() !== stLicense::LICENSE_TYPE_COMMERCIAL)
			{
				$this->getRequest()->setError('license_number', $i18n->__('Numer licencji wersji Open może zostać zmieniony tylko na numer licencji wersji komercyjnej.'));
				return false;
			}
				
			if (!$stLicense->checkInSote())
			{
				$this->getRequest()->setError('license_number', $i18n->__('Numer licencji jest nieprawidłowy.'));
				return false;
			}
		}

		return true;
	}

	/**
	 * Akcja w przypadku błędu w uzupełnianiu pól
	 */
	public function handleErrorChangeLicense()
	{
		$this->config = stConfig::getInstance($this->getContext(), 'stRegister');
		
		$this->menu_items = $this->getMenuItems();
		
		$this->labels = array('license_number' => $this->getContext()->getI18n()->__('Numer licencji'));
		
		return sfView::SUCCESS;
	}

	protected function getMenuItems()
   {
      $i18n = $this->getContext()->getI18N();

      return array(
          'stShopInfoBackend/index' => $i18n->__('Informacje o sklepie'),
          'stShopInfoBackend/register' => $i18n->__('Informacje o licencji'));
   }
}