<?php
/**
 * SOTESHOP/stThemePlugin
 *
 * Ten plik należy do aplikacji stThemePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stThemePlugin
 * @subpackage  tasks
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id:  $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Inicjalizacja tasków
 */
pake_desc('(SOTE) Change default theme');
pake_task('theme-set-active', 'project_exists');

/**
 * Zmiana aktywnego tematu graficznego w sklepie.
 *
 * @param PakeTask $task
 * @param array $args
 */
function run_theme_set_active($task, $args)
{
	if (empty($args)) throw new Exception('You must provide theme name. Eg. theme-set-active simple');
	$theme = $args[0];

	define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
	define('SF_APP',         'backend');
	define('SF_ENVIRONMENT', 'dev');
	define('SF_DEBUG',       true);

	require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

	$databaseManager = new sfDatabaseManager();
	$databaseManager->initialize();

	$stTheme = ThemePeer::doSelectByName($theme);

	if(is_object($stTheme))
	{
		$stTheme->setActive(true);
		$stTheme->save();
		ThemePeer::updateThemeImageConfiguration($stTheme);
		pake_echo('Active theme: '.$theme);
	} else {
		throw new Exception('Theme '.$theme.' don\'t exists.');
	}
}