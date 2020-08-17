<?php
/**
 * SOTESHOP/stFrontend
 *
 * Ten plik należy do aplikacji stFrontend opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stFrontend
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: config.php 9 2009-08-24 09:31:16Z michal $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * include project configuration
 */
include(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

/**
 * symfony bootstraping
 *
 * @package     stFrontend
 * @subpackage  configs
 */
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'symfony'.DIRECTORY_SEPARATOR.'util'. DIRECTORY_SEPARATOR.'stCore.class.php');
stCore::bootstrap($sf_symfony_lib_dir, $sf_symfony_data_dir);

/**
 * Uzupelnienie funkcji lcfirst (wystepuje tylko w CVS dla php 5.2.x. Dostepna dla php 5.3.x)
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 */
if(function_exists('lcfirst') == false)
{
    /**
     * Make a string's first character lowercase
     *
     * @param   string      $str                The input string.
     * @return  string      The resulting string.
     */
    function lcfirst($str)
    {
        $str[0] = strtolower($str[0]);
        return $str;
    }
}

/**
 * Ładowanie plików z konfiguracyjnych wszystkich zainstalowanych modułów
 *
 * @author Michal Prochowski <michal.prochowski@sote.pl>
 */
if (!defined('ST_SYMFONY_OPTIMIZATION'))
{
    foreach (stApplication::getApps() as $app => $data)
    {
        $dir = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.$app;
        if (!ereg('Plugin',$app) && file_exists($dir))
        {
            $file_config = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.$app.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';
            if (file_exists($file_config))
            {
                include_once($file_config);
            }
        }
    }
}
/**
 * Dodawanie limitów
 *
 * @author Piotr Halas <piotr.halas@sote.pl>
 */
$limit = new stLimits();

/**
 * Włączanie/wyłączanie cache
 *
 * @author Michal Prochowski <michal.prochowski@sote.pl>
 */
if (SF_ENVIRONMENT == 'prod')
{
    if (stConfig::getInstance(null, array(), 'stOptimizationBackend')->get('off') == 1)
    {
        sfConfig::set('sf_cache', '');
    } else {
        sfConfig::set('sf_cache', '1');
    }
}

/**
 * Ustawianie domyślnego języka
 *
 * @author Michal Prochowski <michal.prochowski@sote.pl>
 */
$stConfigOptimizer = stConfigOptimizer::getInstance();

if ($stConfigOptimizer->has('default_language'))
{
    $defaultLanguage = $stConfigOptimizer->get('default_language');
} else {
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();

    $language = LanguagePeer::doSelectDefault();
    $defaultLanguage = $language->getOriginalLanguage();
    $defaultLanguage = $stConfigOptimizer->set('default_language',$defaultLanguage);
}

if (!empty($defaultLanguage)) stPluginHelper::addSetting('sf_i18n_default_culture', $defaultLanguage, 'frontend');  