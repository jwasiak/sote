<?php 
/**
 * Wywołanie frontend w trybie produkcyjnym.
 * 
 * @package   stBase
 * @author    Marek Jakubowicz <marek.jakubowicz@sote.pl>
 * @copyright SOTE
 * @license   SOTE
 * @version   SVN: $Id: frontend_edit.php 256 2009-03-30 11:49:45Z marek $
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
define('SF_APP',         'frontend');   

/**
 * Tryb uruchomienia [dev|prod|test]
 */
define('SF_ENVIRONMENT', 'theme');  

/**
 * Tryb raportowania błędów.
 */
define('SF_DEBUG',       false);
  
/**
 * Sprawdzanie czy jest włączna blokada sklepu
 */
include(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'stLockPlugin'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'stLock.class.php');
if(!stLock::check('backend'))
{
    include SF_ROOT_DIR.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'errors'.DIRECTORY_SEPARATOR.'unavailable.php';
    exit();
}

/**
 * Odczytuje konfigurację Symfony.
 */
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance()->getResponse()->addMeta('robots', "noindex");
sfContext::getInstance()->getController()->dispatch();
