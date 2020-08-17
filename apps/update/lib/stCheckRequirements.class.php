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
 * @version     $Id: stCheckRequirements.class.php 9266 2010-11-17 15:31:58Z piotr $
 * @author Piotr Halas piotr.halas@sote.pl
 */

/** 
 * PHP verification.
 * 
 * @author Piotr Halas piotr.halas@sote.pl
 * @package     stUpdate
 * @subpackage  libs
 */
class stCheckRequirements extends stSetupRequirements {

	public function __construct()
	{
		$this->tests['testSymfony'] = "Lokalna instalacja Symfony";
		$this->tests['testPear'] = "Lokalna instalacja Pear";
	}
	
	public function testAll($class = __CLASS__)
	{
		return parent::testAll($class);
	}
	
	public static function testSymfony()
	{
		$symfony_file = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'symfony'.DIRECTORY_SEPARATOR.'VERSION';
		if (!file_exists($symfony_file)) return false;
		$version = file_get_contents($symfony_file);
		if (trim($version)!='1.0.19') return false;
		return true;
	}
	
	public static function testPear()
	{
		$pear_file = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'pear'.DIRECTORY_SEPARATOR.'php'.DIRECTORY_SEPARATOR.'PEAR.php';
		if (!file_exists($pear_file)) return false;
		return true;
	}
}