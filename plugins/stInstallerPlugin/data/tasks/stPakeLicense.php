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
 * @version     $Id: stPakeLicense.php 3782 2010-03-05 13:39:42Z marek $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */  
                   
pake_desc('(SOTE) License info');
pake_task('license-info', 'project_exists');


/**
 * Zwraca informacje o licencji.
 *
 * @param PakeTask $task
 * @param array    $args 
 */
function run_license_info($task, $args)
{   
    // odczytaj numer licensji z pliku data/config/__stRegister.yml
    // ---
    // all:
    //   .auto_generated:
    //     config:
    //      last_modified: 2009/05/11 11:05:48
    //      fields:
    //         license: 2009-0123-0001-0000-0000-0000              
    $data=sfYaml::load(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'__stRegister.yml');
    if (! empty($data['all']['.auto_generated']['config']['fields']['license'])) 
    {
        $license_number=$data['all']['.auto_generated']['config']['fields']['license'];
        pake_echo_action("License:","$license_number");
    } else 
    {                               
        print_r($data);
        throw new PakeException ("License information not found.");
    }
    
    /**
     * stLicenseDemo class
     */                
    require_once (sfConfig::get('sf_plugins_dir').DIRECTORY_SEPARATOR.'stInstallerPlugin'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'stLicenseInfo.class.php');
    
    $license = new stLicenseInfo();
    $status=$license->getLicenseStatus($license_number);                                              
}    

