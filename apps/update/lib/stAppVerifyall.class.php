<?php
/**
 * SOTESHOP/stUpdate
 *
 * This file is the part of stUpdate application. License: (Open License SOTE) Open License SOTE.
 * Do not modify this file, system will overwrite it during upgrade.
 *
 * @package     stUpdate
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Open License SOTE
 * @version     $Id: stAppVerifyall.class.php 13528 2011-06-08 09:57:46Z michal $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */


/**
 * stAppVerify class
 *
 * @package     stUpdate
 * @subpackage  libs
 */
require_once (sfConfig::get('sf_app_dir').DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'stAppVerify.class.php');

/**
 * Code verification for all packages.
 *
 * @package     stUpdate
 * @subpackage  libs
 */
class stAppVerifyall extends stAppVerify
{
	protected function getApps()
	{
		$peari = stPearInfo::getInstance();
		$packages = $peari->getPackages();
		$i=0;
		foreach ($packages as $package=>$data)
		{
			$apps[]=$package;
			$i++;
		}

		return $apps;
	}
	 
	/**
	 * Reboot action
	 *
	 * @return   string
	 */
	protected function reboot()
	{
		return __('Aplikacje zostały poprawnie zweryfikowane. Nie ma modyfikacji plików systemowych.', null, 'stInstallerWeb');
	}
	 
	/**
	 * Get number of installed applications.
	 */
	static public function getCount()
	{
		$peari = stPearInfo::getInstance();
		$packages = $peari->getPackages();
		return sizeof($packages);
	}

	/**
	 * Skip PEAR install/src verification
	 */
	public function verifyPearInstall($app)
	{
		return NULL;
	}

	/**
	 * File verification.
	 *
	 * @param string $app application (PEAR package name)
	 * @param string $name relative file name
	 * @param string $md5sum md5 in PEAR database
	 * @param string $md5sum_current md5 in filesystem
	 * @param string $owner_current owner of the verified file
	 * @return bool true - file is modified, false - file is not modified, is OK
	 */
	protected function isFileModified($app, $name,$md5sum,$md5sum_current,$owner_current)
	{
		// if ((($md5sum!=$md5sum_current) && (! empty($md5sum_current))) || ($owner_current != $this->owner)) // allow for deleted files
		if ((($md5sum!=$md5sum_current) && (! empty($md5sum))) || ($owner_current != $this->owner))            // don't allow for deleted files
		{
			// if file exists verify it
			if ((file_exists($this->getPath($name))) && (! empty($name)))   // allow for deleted files
			//if (! empty($name))                                                // don't allow for deleted files
			{
				if (! $this->ignore($this->getPath($name,true),$app))
				{
					return true;
				}
			}
		}
		return false;
	}
}