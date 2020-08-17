<?php
/**
 * Wywołanie frontend w trybie produkcyjnym.
 * 
 * @package   stFrontend
 * @author    Marek Jakubowicz <marek.jakubowicz@sote.pl>
 * @copyright SOTE
 * @license   SOTE
 * @version   SVN: $Id: index.php 10025 2010-12-28 10:14:43Z marek $
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
define('SF_ENVIRONMENT', 'prod');  

/**
 * Tryb raportowania błędów.
 */
define('SF_DEBUG',       false);
      
/**
 * Sprawdzanie czy jest włączna blokada sklepu
 */
include(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'stLockPlugin'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'stLock.class.php');

if(!stLock::check())
{
    include SF_ROOT_DIR.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'errors'.DIRECTORY_SEPARATOR.'unavailable.php';
    exit();
}

include(SF_ROOT_DIR.'/lib/stFastCacheManager.class.php');

$fastCache = stFastCacheManager::getInstance();

if ($fastCache)
{
    $fastCache->dispatch();
}

/**
 * Odczytuje konfigurację Symfony.
 */
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

sfContext::getInstance()->getController()->dispatch();