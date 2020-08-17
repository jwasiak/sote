<?php
/**
 * Wywołanie backend trybie produkcyjnym.
 * 
 * @package   stBackend
 * @author    Marek Jakubowicz <marek.jakubowicz@sote.pl>
 * @copyright SOTE
 * @license   SOTE
 * @version   SVN: $Id: backend.php 1038 2009-10-05 09:32:30Z michal $
 */

/**
 * Ładownienie pliku profile z ST_ROOT_DIR
 */
if (file_exists('.profile.php'))
{
    include_once('.profile.php');
}

/**
 * Scieżka do katalogu głównego instalacji.
 */
if (defined('ST_ROOT_DIR'))
{
    define('SF_ROOT_DIR',    realpath(dirname(__FILE__).ST_ROOT_DIR));
} else {
    define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
}

/**
 * Definicja aplikacji Symfony.
 */
define('SF_APP',         'backend');

/**
 * Tryb uruchomienia [dev|prod|test]
 */
define('SF_ENVIRONMENT', 'prod');    

/**
 * Tryb raportowania błędów.
 */
define('SF_DEBUG',       false);
    
/**
 * Fix do wywołań task'ów przez WWW
 */ 
$_SERVER['PWD']=SF_ROOT_DIR; 

/**
 * Sprawdzanie czy jest włączna blokada sklepu
 */
include(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'stLockPlugin'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'stLock.class.php');
if(!stLock::check())
{
    include SF_ROOT_DIR.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'errors'.DIRECTORY_SEPARATOR.'unavailable.php';
    exit();
}

/**
 * Odczytuje konfigurację Symfony.
 */
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

sfContext::getInstance()->getController()->dispatch();