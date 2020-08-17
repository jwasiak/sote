<?php
/**
 * Tasks for stUpdate
 *
 * @package   stUpdate
 * @author    Marek Jakubowicz <marek.jakubowicz@sote.pl>
 * @version   $Id: myPakeUpdate.php 13637 2011-06-16 10:52:04Z michal $
 * @license   SOTE
 * @copyright SOTE
 */
 
pake_desc('(SOTE) sote fix cache strycture');
pake_task('st-fix-cache', 'project_exists');

pake_desc('(SOTE) Load default data');
pake_task('st-propel-load-default-data', 'project_exists');

/**
 * stFixCache class
 */
require_once (sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'update'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'stFixCache.class.php');

/**
 * Move sync file from cache/*.sync to install/sync/*.sync
 *
 * @param PakeTask $task
 * @param array    $args
 */
function run_st_fix_cache($task, $args)
{
	$fix_cache = new stFixCache();
	$fix_cache->fixAll();
	pake_echo ("Cache fixed and rebuilded.");
}

/**
 * Load default data from provided fixtures dir
 *
 * @param PakeTask $task
 * @param array    $args
 */
function run_st_propel_load_default_data($tasks, $args)
{
	if (empty($args[0])) throw new Exception('You must provide theme name');
	$fixtures_dir_name = $args[0];
	
	pake_echo('Importing data for theme: '.$fixtures_dir_name);

	define('SF_ROOT_DIR', sfConfig::get('sf_root_dir'));
	define('SF_APP', 'update');
	define('SF_ENVIRONMENT', 'prod');
	define('SF_DEBUG', false);

	require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

	$plugin_dirs = glob(sfConfig::get('sf_plugins_dir').'/*/data/fixtures');
	$fixtures_dir = array(sfConfig::get('sf_data_dir').'/fixtures');

	$plugin_theme_dirs = glob(sfConfig::get('sf_plugins_dir').'/*/data/'.$fixtures_dir_name);
	$fixtures_theme_dir = array(sfConfig::get('sf_data_dir').'/'.$fixtures_dir_name);

	$dirs = array_merge($plugin_dirs, $fixtures_dir, $plugin_theme_dirs, $fixtures_theme_dir);
	
	$databaseManager = new sfDatabaseManager();

	$databaseManager->initialize();
	
	sfLoader::loadPluginConfig();

	$data = new stPropelDataLoader();

	$data->indexFixturesFiles($dirs, 200);

	foreach ($dirs as $fixtures_dir)
	{
		pake_echo_action('propel', sprintf('load data from "%s"', $fixtures_dir));

		$files = $data->loadData($fixtures_dir);
		sleep(1);
	}
}