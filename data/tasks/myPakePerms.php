<?php
/** 
 * SOTESHOP/stBase 
 * 
 * Ten plik należy do aplikacji stBase opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stBase
 * @subpackage  tasks
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: myPakePerms.php 7 2009-08-24 08:59:30Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

pake_desc('(SOTE) sote fix directories permissions');
pake_task('st-fix-perms', 'project_exists');

/** 
 * Fixes permissions in soteshop
 * symfony fix-perms
 *
 * @param      pakeTask    $task
 * @param         array       $args
 */
function run_st_fix_perms($task, $args)
{
    $sf_root_dir = sfConfig::get('sf_root_dir');

    pake_chmod(sfConfig::get('sf_cache_dir_name'), $sf_root_dir, 0777);
    pake_chmod(sfConfig::get('sf_log_dir_name'), $sf_root_dir, 0777);
    pake_chmod(sfConfig::get('sf_web_dir_name').DIRECTORY_SEPARATOR.sfConfig::get('sf_upload_dir_name'), $sf_root_dir, 0777);
    pake_chmod(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'config', $sf_root_dir, 0777);
    pake_chmod('symfony', $sf_root_dir, 0777);

    $dirs = array(sfConfig::get('sf_cache_dir_name'), sfConfig::get('sf_web_dir_name').DIRECTORY_SEPARATOR.sfConfig::get('sf_upload_dir_name'), sfConfig::get('sf_log_dir_name'), sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'config');
    $dir_finder = pakeFinder::type('dir')->ignore_version_control();
    $file_finder = pakeFinder::type('file')->ignore_version_control();
    foreach ($dirs as $dir)
    {
        pake_chmod($dir_finder, $dir, 0777);
        pake_chmod($file_finder, $dir, 0666);
    }
}