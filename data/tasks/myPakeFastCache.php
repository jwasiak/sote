<?php
/**
 * Tasks Fast Cache
 * 
 * @package   stFastCacheSymfony
 * @author    Marek Jakubowicz <marek.jakubowicz@sote.pl>
 * @version   $Id: myPakeFastCache.php 9390 2010-11-23 12:17:25Z marek $
 * @license   SOTE
 * @copyright SOTE 
 */   
                   
pake_desc('(SOTE) Clear Cache Symfiony & Fast Cache');
pake_task('fcc', 'project_exists');


/**
 * Clar Cache Symfony & Fast Cache
 *
 * @param PakeTask $task
 * @param array    $args 
 */
function run_fcc($task, $args)
{
    run_clear_cache($task,$args);
    if (! defined('SF_ROOT_DIR')) define ('SF_ROOT_DIR',sfConfig::get('sf_root_dir'));
    require_once(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'stFastCacheManager.class.php');
    stFastCacheManager::clearCache();    
}
