<?php
/**
 * Wywołanie update w trybie produkcyjnym.
 * 
 * @package   stUpdate
 * @author    Marek Jakubowicz <marek.jakubowicz@sote.pl>
 * @copyright SOTE
 * @license   SOTE
 * @version   SVN: $Id: update.php 10080 2011-01-04 11:18:35Z michal $
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
define('SF_APP',         'update');

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
 * local PEAR
 */
$pearlib=SF_ROOT_DIR.DIRECTORY_SEPARATOR.'pear'.DIRECTORY_SEPARATOR.'php'; 
if (is_dir($pearlib)) 
{
    $include_path=ini_get('include_path');
    ini_set('include_path',".:$pearlib:$include_path");
}

/**
 * Odczytuje konfigurację Symfony.
 */
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

sfContext::getInstance()->getController()->dispatch();
