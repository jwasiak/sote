<?php
/**
 * SOTESHOP/stLanguagePlugin
 *
 * Ten plik należy do aplikacji stLanguagePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stLanguagePlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stLocale.class.php 260 2009-09-03 11:08:56Z michal $
 * @author      Piotr Halas <piotr.halas@sote.pl>
 */

/**
 * Klasa stLocale
 *
 * @package     stLanguagePlugin
 * @subpackage  libs
 */
class stLocale
{
    /**
     * Tablica z definicjami symboli
     *
     * @var array
     */
    protected static $locale = array();

    /**
     * Usuwanie symboli
     *
     * @param string $text
     * @param string $culture
     * @return string
     */
    public static function removeLocalSymbols($text, $culture = 'pl_PL')
    {
        if(!isset(self::$locale[$culture])) self::loadCulture($culture);
        return str_replace(self::$locale[$culture]['from'], self::$locale[$culture]['to'], $text);
    }

    /**
     * Ładowanie definicji symboli do zmiany
     * 
     * @param string $culture
     */
    protected static function loadCulture($culture)
    {
        $localeFile = sfConfig::get('sf_config_dir').DIRECTORY_SEPARATOR.'locale'.DIRECTORY_SEPARATOR.$culture.'.yml';
        if (is_readable($localeFile))
        {
            self::$locale[$culture] = sfYaml::load($localeFile);
        } else {
            self::$locale[$culture] = array('from'=>array(), 'to'=>array());
        }
    }
}