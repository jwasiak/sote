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
 * @version     $Id: actions.class.php 1885 2009-06-26 13:15:49Z bartek $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/**
 * Modul prezentujacy mozliwosci klasy stRegister
 *
 * @package     stRegister
 * @subpackage  actions
 */
class stRegisterActions extends stActions
{
	/**
	 * Executes index action
	 */
	public function executeIndex()
	{
		$c = new Criteria();
		$c->add(sfGuardUserPeer::IS_ACTIVE, 1);
		$c->add(sfGuardUserPeer::IS_SUPER_ADMIN , 1);
		$user = sfGuardUserPeer::doSelectOne($c);

		if($user)
		{
			$this->redirect('@homepage');
		}

		$this->config = stConfig::getInstance($this->getContext(), array());

		$register = $this->config->load();

		if(empty($register['www']))
		{
			$register['www'] =  "http://".$_SERVER["HTTP_HOST"]."/";
		}

		$this->readOnly = false;
		$file = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR."install".DIRECTORY_SEPARATOR."db".DIRECTORY_SEPARATOR.".license.reg";
		if (file_exists($file))
		{
			$this->readOnly = true;
			$register['license'] = file_get_contents($file);
		}

		$this->register = $register;
	}


	public function executeUpdateLicense()
	{
		if ($this->getRequest()->getMethod() == sfRequest::POST)
		{
			$license = $this->getRequestParameter('license');

			$this->config = stConfig::getInstance($this->getContext(), array());

			$this->config->load();

			$this->config->set('license',$license);

			$this->config->save();

			$this->redirect('@homepage');
		}
	}

	public function handleErrorUpdateLicense()
	{

		$this->forward('stBackend','index');
	}

	public function validateUpdateLicense()
	{
		$error_exists = true;

		$i18n = $this->getContext()->getI18N();

		$stLicense = new stLicense($this->getRequestParameter('license'));
		if(!$stLicense->check())
		{
			$this->getRequest()->setError('license', $i18n->__('Błędny numer licencji.'));
			$error_exists = false;
		}

		if ($error_exists == true)
		{
			// if(!$stLicense->checkInSote())
			// {
			// 	$this->getRequest()->setError('license', $i18n->__('Błędna weryfikacja licencji.'));
			// 	$error_exists = false;
			// }
		}

		return $error_exists;
	}


	public function executeRegister()
	{

		$c = new Criteria();
		$c->add(sfGuardUserPeer::IS_ACTIVE, 1);
		$c->add(sfGuardUserPeer::IS_SUPER_ADMIN , 1);
		$user = sfGuardUserPeer::doSelectOne($c);

		if($user)
		{
			$this->redirect('@homepage');
		}

		if ($this->getRequest()->getMethod() == sfRequest::POST)
		{
			$register = $this->getRequestParameter('register', array());
			$shop_hash = Crypt::getShopHash($register['license']);


			$this->config = stConfig::getInstance('stRegister');
			$this->config->set('company',$register['company']);
			$this->config->set('vatNumber',$register['vatNumber']);
			$this->config->set('email',$register['email']);
			$this->config->set('name',$register['name']);
			$this->config->set('surname',$register['surname']);
			$this->config->set('street',$register['street']);
			$this->config->set('house',$register['house']);
			$this->config->set('flat',$register['flat']);
			$this->config->set('code',$register['code']);
			$this->config->set('town',$register['town']);
			$this->config->set('phone',$register['phone']);
			$this->config->set('www', $register['www'] ? $register['www'] : 'http://'.$_SERVER['HTTP_HOST'].'/');
			$this->config->set('license',$register['license']);
			$this->config->set('shop_hash', $shop_hash);

			$this->config->save(true);

			$user = new sfGuardUser();
			$user->setUsername($register['email']);
			$user->setPassword($register['password1']);
			$user->setHashCode(md5(microtime()));
			$user->setIsConfirm(1);
			$user->setIsSuperAdmin(1);
			$user->save();

			$user->addGroupByName('admin');
			$user->addPermissionByName('backend');
			$user->addPermissionByName('update');

			$laguageHasDomain = LanguageHasDomainPeer::doCount(new Criteria());
			if ($laguageHasDomain == 0)
			{
				$stWebRequest = new stWebRequest();

				$language = LanguagePeer::doSelectDefault();

				if (is_object($language))
				{
					$obj = new LanguageHasDomain();
					$obj->setLanguageId($language->getId());
					$obj->setDomain($stWebRequest->getHost());
					$obj->setIsDefault(1);
					$obj->save();

					$stCache = new stFunctionCache('stLanguagePlugin');
					$stCache->clearFunction('allLanguageHasDomain');
				}
			}

			$stLicense = new stLicense($register['license']);
			$stLicense->activateInSote();

			$this->register = $register;

			stAppStats::activate('Install');
		}
	}

	public function handleErrorRegister()
	{
		$this->config = stConfig::getInstance($this->getContext());

		$this->config->setFromRequest('register');

		$this->forward('stRegister','index');
	}

	public function validateRegister()
	{
		$error_exists = true;

		$i18n = $this->getContext()->getI18N();

		$register = $this->getRequestParameter('register', array());

		$stLicense = new stLicense($register['license']);
		if(!$stLicense->check())
		{
			$this->getRequest()->setError('register{license}', $i18n->__('Błędny numer licencji.'));
			$error_exists = false;
		}

		// if(!$stLicense->checkInSote())
		// {
		// 	$this->getRequest()->setError('register{license}', $i18n->__('Błędna weryfikacja licencji.'));
		// 	$error_exists = false;
		// }

		return $error_exists;
	}

	/**
	 * Sprawdzanie połączenia z bazą danych
	 *
	 * @author Michal Prochowski <michal.prochowski@sote.pl>
	 * @param   string      $hostname           nazwa hosta
	 * @param   string      $username           nazwa użytkownika
	 * @param   string      $password           hasło użytkownika
	 * @param   string      $database           nazwa bazy danych
	 * @return   bool
	 */
	private function checkDB($hostname, $username, $password, $database)
	{
		if(@mysql_connect($hostname, $username, $password))
		{
			if (@mysql_select_db($database)) return true;
		}
		return false;
	}
}
