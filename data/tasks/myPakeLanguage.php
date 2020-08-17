<?php
/**
 * SOTESHOP/stLanguagePlugin
 *
 * Ten plik należy do aplikacji stLanguagePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stLanguagePlugin
 * @subpackage  tasks
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

pake_desc('(SOTE) change language');
pake_task('change-language', 'project_exists');

function run_change_language($task, $args)
{
	if (count($args) != 1) throw new Exception('example: ./symfony change-language en_US');

	$argLanguage = $args[0];

	define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
	define('SF_APP',         'backend');
	define('SF_ENVIRONMENT', 'prod');
	define('SF_DEBUG',       true);

	require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

	$databaseManager = new sfDatabaseManager();
	$databaseManager->initialize();

	$c = new Criteria();
	$c->add(LanguagePeer::LANGUAGE, $argLanguage);
	$language = LanguagePeer::doSelectOne($c);
	if(is_object($language)) {

		$c1 = new Criteria();
		$c1->add(LanguagePeer::ID, 0, Criteria::GREATER_THAN);
		$c2 = new Criteria();
		$c2->add(LanguagePeer::ACTIVE, 0);
		BasePeer::doUpdate($c1, $c2, Propel::getConnection());

		$language->setIsDefault(true);
		$language->setActive(true);
		if ($language->getIsTranslatePanel()) $language->setIsDefaultPanel(true);
		$language->save();
	} else {
		throw new Exception('Language '.$argLanguage.' don\'t exists');
	}
}