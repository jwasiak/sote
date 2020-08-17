<?php
/** 
 * SOTESHOP/stInstallerPlugin 
 * 
 * Ten plik należy do aplikacji stInstallerPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stInstallerPlugin
 * @subpackage  tasks
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stPakeInstallerClean.php 3782 2010-03-05 13:39:42Z marek $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */ 
                   
pake_desc('(SOTE) Delete temporary installation files.');
pake_task('installer-clean-all', 'project_exists');
                                                            
/**
 * Usuwa pliki install/download/*
 *
 * @param PakeTask $task
 * @param array    $args 
 */
function run_installer_clean_all($task, $args)
{
    $pear_download = new stPearDownload();
    $packages=$pear_download->getPackages();    
    foreach ($packages as $package)
    {                                           
        pake_echo ("Deleting: $package"); 
        $pear_download->deletePackage($package);
    }                                            

    $pear_download = new stPearDownload('src');
    $packages=$pear_download->getPackages();    
    foreach ($packages as $package)
    {                                           
        pake_echo ("Deleting: $package"); 
        $pear_download->deletePackage($package);
    }                                        
    
    pake_echo ("PEAR dwonloads cleaned");
}
