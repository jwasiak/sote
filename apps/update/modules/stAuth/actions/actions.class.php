<?php
/** 
 * SOTESHOP/stUpdate 
 * 
 * This file is the part of stUpdate application. License: (Open License SOTE) Open License SOTE. 
 * Do not modify this file, system will overwrite it during upgrade.
 * 
 * @package     stUpdate
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Open License SOTE
 * @version     $Id: actions.class.php 11168 2011-02-21 12:44:38Z michal $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */


/** 
 * stInstallerWeb actions.
 *
 * @author Marek Jakubowicz <marek.jakubowicz@sote.pl>
 *
 * @package     stUpdate
 * @subpackage  actions
 */
class stAuthActions extends sfActions
{

	public function executeIndex()
	{
		$config = stConfig::getInstance(null, 'stLanguagePlugin');
        $culture = $config->get('admin_language', null);
        if (!is_null($culture)) $this->getUser()->setCulture($culture);
		
		$config = stUpdateConfig::getInstance($this->getContext());

		if($config->isEmpty())
		{
			try {
				$db = new sfDatabaseManager();

				$db->initialize();

				$con = $db->getDatabase('propel')->getConnection();

				$st = $con->prepareStatement("SELECT username, salt, password FROM sf_guard_user u, sf_guard_user_permission up, sf_guard_permission p WHERE u.id = up.user_id AND up.permission_id = p.id AND p.name = 'update'");

				if ($st)
				{
					$rs = $st->executeQuery();

					$users = array();

					while($rs->next())
					{
						$row = $rs->getRow();

						$users[] = $row;
					}

					$config->set('users', $users);

					$config->save();
				}
			} catch (Exception $e) {
				
			}
		}
	}

	public function executeRegister()
	{
		$this->config = stUpdateConfig::getInstance($this->getContext());

		$register = $this->config->load();

		$this->register = $register;

	}

	public function executeRegisterSave()
	{
		if ($this->getRequest()->getMethod() == sfRequest::POST)
		{
			$register = $this->getRequestParameter('register', array());

			$this->config = stUpdateConfig::getInstance($this->getContext());

			$this->config->set('email',$register['email']);
			$this->config->set('password1',$register['password1']);

			$this->config->save();
			$this->redirect('stAuth/summary');
		}
	}

	public function executeSummary()
	{
		$this->config = stUpdateConfig::getInstance($this->getContext());

		$register = $this->config->load();

		$this->register = $register;
	}

	public function handleErrorRegisterSave()
	{
		$this->forward('stAuth','register');
	}

	public function executeLogin()
	{
		if ($this->getRequest()->getMethod() == sfRequest::POST)
		{
			$this->redirect('stInstallerWeb');
		}
	}

	public function executeLogout()
	{
		$this->getUser()->setAuthenticated(false);
		$this->forward('stAuth','index');
	}

	public function handleErrorLogin()
	{
		$this->forward('stAuth','index');
	}

	public function validateLogin()
	{
		$error_exists = true;

		$i18n = $this->getContext()->getI18N();

		$register = $this->getRequestParameter('register', array());

		$config = stUpdateConfig::getInstance($this->getContext());

		foreach ($config->get('users') as $user)
		{
			if($user['password'] == $this->passwordHash(@$register['password1'], $user['salt']) && $user['username']==@$register['email'])
			{
				$error_exists = false;
				break;
			}



		}

		if ($error_exists)
		{
			$this->getRequest()->setError('register{email}', $i18n->__('Zły login lub hasło.'));
		}

		$this->getUser()->setAuthenticated(!$error_exists);

		return !$error_exists;
	}

	protected function passwordHash($password, $salt)
	{
		return sha1($salt.$password);
	}


}