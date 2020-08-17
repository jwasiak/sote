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
 * @version     $Id: stPakeSetup.php 3782 2010-03-05 13:39:42Z marek $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */
                   
pake_desc('(SOTE) Konfiguracja dostęp do bazy danych.');
pake_task('setup', 'project_exists');
                                            
pake_desc('(SOTE) Uaktulania konfigurację bazy danych.');
pake_task('setup-update', 'project_exists');

pake_desc('(SOTE) Check connection to database');
pake_task('installer-check-database-connection', 'project_exists');
pake_alias('icdc', 'installer-check-database-connection'); 

pake_desc('(SOTE) Update PEAR config');
pake_task('server-config-update','project_exists');   
pake_alias('pear-update-config','server-config-update');

/** 
 * Konfiguracja konkretnej instalacji.
 */
define("ST_SETUP_FILE",sfConfig::get('sf_config_dir').DIRECTORY_SEPARATOR.'st_setup.yml');      

/** 
 * Konfiguruje bazę danych i propel.ini.
 *
 * @param      PakeTask    $task
 * @param         array       $args
 */
function run_setup($task, $args)
{
    if (empty($args[0]))
        throw new Exception('Run ./symfony setup database=user:pass@localhost/dbname');
    
    $params = stYamlConfig::load(ST_SETUP_FILE);
    
    foreach ($args as $arg)
    {                
        if (strpos($arg, '@') !== false)
        {                   
            list($name, $dsn) = explode('=', $arg, 2);
  
            if (strpos($dsn, 'mysql://') === false && strpos($dsn, 'mysqli://') === false) 
            {
                $dsn = 'mysql://'.$dsn;
            }
            
            $database = Creole::parseDSN($dsn);
            $database['host'] = $database['hostspec'];
            
            $params[$name] = $database;
        }
    }   
    
    stYamlConfig::write(ST_SETUP_FILE, $params);                
    run_setup_update($task,array());       
}    

/** 
 * Zwaraca dane bazy danych na podstawie podanego parametru.
 *
 * @param                  string      $arg                database=user:pass@host/dbname
 * @return        array       array("database"=>array("user"=>...,"password"=>...,"database=>"))
 */
function _arg_database($arg)
{
    $database = array();
    preg_match("/^[a-z0-9_-]+=([a-z0-9_-]+):([a-z0-9_-]+)@([a-z0-9_\.-]+)\/([a-z0-9_-]+)/i", $arg, $matches);
    if (empty($matches))
    {
        preg_match("/^[a-z0-9_-]+=([a-z0-9_-]+)@([a-z0-9_\.-]+)\/([a-z0-9_-]+)/i", $arg, $matches);
    }
    if ( ! empty($matches))
    {
        $database['username'] = $matches[1];
        if (sizeof($matches) == 5)
        {
            $database['password'] = $matches[2];
            $database['host'] = $matches[3];
            $database['database'] = $matches[4];
        } else
        {
            $database['password'] = '';
            $database['host'] = $matches[2];
            $database['database'] = $matches[3];
        }
    } else {
        throw new Exception('Wrong parametrs for database configuration. Allowed chars [a-z A-Z 0-9 - _ ].');
    }
    
    return $database;
}        

/**
 * Sprawdza połączenie z bazą danych
 *
 * @param PakeTask $task Zadanie
 * @param array $argv Argumenty
 */
function run_installer_check_database_connection($task, $argv)
{
    pake_echo('  Establishing database connection');
    
    define('SF_ROOT_DIR', sfConfig::get('sf_root_dir'));
    define('SF_APP', 'frontend');
    define('SF_ENVIRONMENT', 'dev');
    define('SF_DEBUG', true);
    
    // get configuration
    $config=SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'apps' . DIRECTORY_SEPARATOR . SF_APP . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';
    require_once ($config);
    
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();
    
    $con = Propel::getConnection('propel');
    
    if ($con)
    {
        pake_echo("  Database connection established",'');
        $databaseManager->shutdown();
    } else {
        throw new PakeException('Unable connect to the database.');
    }
} 

/** 
 * Uaktualnie konfigurację bazy danych.
 *
 * @param      PakeTask    $task
 * @param         array       $args
 */
function run_setup_update($task,$args)
{                    
    $installer = new stInstaller();     
    $params = stYamlConfig::load(ST_SETUP_FILE);    
    if (! $installer->setConfig($params)) {
        throw new Exception('Configuration wasn\'t saved. Run symfony setup database=username:password@localhost/dbname');
    }   else {                           
        pake_echo_action("Database configuration updated",'');
    }
}       

/**
 * Aktualizuje konfiguracje sciezek w PEAR
 * 
 * @param      PakeTask    $task
 * @param         array    $args 
 */
function run_server_config_update()
{
    $new_server = new stNewServer();
    if ($new_server->update())
    {
        pake_echo_action('Software config for current server','updated');
    }        
}