<?php
/**
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package symfony
 * @subpackage i18n
 * @author Fabien Potencier <fabien.potencier@symfony-project.com>
 * @author Michal Prochowski <michal.prochowski@sote.pl>
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @version SVN: $Id: sfI18N.class.php 6501 2010-07-15 14:26:41Z michal $
 */

/**
 * Klasa sfI18N - obsługa wersji językowych
 */
class sfI18N
{
    /**
     * Instancja klasy sfContext
     * @var sfContext
     */
    protected $context = null;

    /**
     * Instacja klasy stI18N
     * @var stI18N
     */
    protected $stI18N = null;

    /**
     * Aktualny katalog językowy 
     * @var string
     */
    protected $currentCatalogue = null;

    /**
     * Poprzednie katalogi językowe 
     * @var array
     */
    protected $previousCatalogue = array();

    /**
     * Instacja klasy sfI18N
     * @var sfI18N
     */
    static protected $instance = null;

    /**
     * Pobieranie instancji klasy
     *
     * @author Michal Prochowski <michal.prochowski@sote.pl>
     *
     * @return sfI18N
     */
    static public function getInstance()
    {
        if (!isset(self::$instance))
        {
            $class = __CLASS__;
            self::$instance = new $class();
        }

        return self::$instance;
    }

    /**
     * Inicjalizacja
     *
     * @author Michal Prochowski <michal.prochowski@sote.pl>
     *
     * @param string $context
     */
    public function initialize($context)
    {
        $this->context = $context;
        $this->stI18N = stI18N::getInstance();

        if (sfConfig::get('sf_i18n_cache'))
        {
            $cacheDir = str_replace('/', DIRECTORY_SEPARATOR, sfConfig::get('sf_i18n_cache_dir'));

            $cache = new stMessageCache();
            $cache->initialize(array('cacheDir' => $cacheDir, 'lifeTime' => 315360000));

            $this->stI18N->setCache($cache);
        }
    }

    /**
     * Ustawianie culture
     *
     * @author Michal Prochowski <michal.prochowski@sote.pl>
     *
     * @param string $culture
     */
    public function setCulture($culture)
    {
        $this->stI18N->setCulture($culture);
    }

    public function hasTranslation($string, $catalogue = null)
    {
        return $this->stI18N->hasTranslation($string, null === $catalogue ? $this->getCurrentCatalogue() : $catalogue);
    }

    /**
     * Ustawianie culture w kontrolerze
     *
     * @author Michal Prochowski <michal.prochowski@sote.pl>
     *
     * @param string $dir
     * @param string $culture
     */
    public function setMessageSourceDir($dir, $culture)
    {
        $this->stI18N->setCulture($culture);
    }

    /**
     * Ustawianie aktualnego katalogu językowego
     *
     * @author Marcin Butlak <marcin.butlak@sote.pl>
     *
     * @param string $catalogue
     */
    public function setCurrentCatalogue($catalogue)
    {
        $this->previousCatalogue[] = $this->getCurrentCatalogue();
        $this->currentCatalogue = $catalogue;
    }

    /**
     * Pobieranie aktualnego katalogu językowego
     *
     * @author Marcin Butlak <marcin.butlak@sote.pl>
     *
     * @return string
     */
    public function getCurrentCatalogue()
    {
        if (null == $this->currentCatalogue) $this->currentCatalogue = $this->context->getModuleName();
        return $this->currentCatalogue;
    }

    /**
     * Przywracanie poprzedniego katlogu językowego
     *
     * @author Marcin Butlak <marcin.butlak@sote.pl>
     */
    public function revertToPreviousCatalogue()
    {
        $this->currentCatalogue = array_pop($this->previousCatalogue);
    }

    /**
     * Pobieranie tłumaczeń
     *
     * @author Michal Prochowski <michal.prochowski@sote.pl>
     *
     * @param string $string
     * @param array $args
     * @param string $catalogue
     * @return string
     */
    public function __($string, $args = array(), $catalogue = null)
    {
        return $this->stI18N->format($string, $args, null === $catalogue || $catalogue == 'messages' ? $this->getCurrentCatalogue() : $catalogue);
    }

    /**
     * getCountry method
     *
     * @author Fabien Potencier <fabien.potencier@symfony-project.com>
     */
    public static function getCountry($iso, $culture)
    {
        $c = new sfCultureInfo($culture);
        $countries = $c->getCountries();

        return (array_key_exists($iso, $countries)) ? $countries[$iso] : '';
    }

    /**
     * getNativeName method
     *
     * @author Fabien Potencier <fabien.potencier@symfony-project.com>
     */
    public static function getNativeName($culture)
    {
        $cult = new sfCultureInfo($culture);
        return $cult->getNativeName();
    }

    /**
     * Return timestamp from a date formatted with a given culture
     *
     * @author Fabien Potencier <fabien.potencier@symfony-project.com>
     */
    public static function getTimestampForCulture($date, $culture)
    {
        list($d, $m, $y)     = self::getDateForCulture($date, $culture);
        list($hour, $minute) = self::getTimeForCulture($date, $culture);

        return mktime($hour, $minute, 0, $m, $d, $y);
    }

    /**
     * Return a d, m and y from a date formatted with a given culture
     *
     * @author Fabien Potencier <fabien.potencier@symfony-project.com>
     */
    public static function getDateForCulture($date, $culture)
    {
        if (!$date) return 0;

        $dateFormatInfo = @sfDateTimeFormatInfo::getInstance($culture);
        $dateFormat = $dateFormatInfo->getShortDatePattern();

        // We construct the regexp based on date format
        $dateRegexp = preg_replace('/[dmy]+/i', '(\d+)', $dateFormat);

        // We parse date format to see where things are (m, d, y)
        $a = array(
            'd' => strpos($dateFormat, 'd'),
            'm' => strpos($dateFormat, 'M'),
            'y' => strpos($dateFormat, 'y'),
        );
        $tmp = array_flip($a);
        ksort($tmp);
        $i = 0;
        $c = array();
        foreach ($tmp as $value) $c[++$i] = $value;
        $datePositions = array_flip($c);

        // We find all elements
        if (preg_match("~$dateRegexp~", $date, $matches))
        {
            // We get matching timestamp
            return array($matches[$datePositions['d']], $matches[$datePositions['m']], $matches[$datePositions['y']]);
        }
        else
        {
            return null;
        }
    }

    /**
     * Returns the hour, minute from a date formatted with a given culture.
     *
     * @author Fabien Potencier <fabien.potencier@symfony-project.com>
     *
     * @param string $date The formatted date as string
     * @param string $culture The culture
     *
     * @return array An array with the hour and minute
     */
    protected static function getTimeForCulture($time, $culture)
    {
        if (!$time) return 0;

        $culture = is_null($culture) ? $this->culture : $culture;

        $timeFormatInfo = @sfDateTimeFormatInfo::getInstance($culture);
        $timeFormat = $timeFormatInfo->getShortTimePattern();

        // We construct the regexp based on time format
        $timeRegexp = preg_replace(array('/[^hm:]+/i', '/[hm]+/i'), array('', '(\d+)'), $timeFormat);

        // We parse time format to see where things are (h, m)
        $a = array(
            'h' => strpos($timeFormat, 'H') !== false ? strpos($timeFormat, 'H') : strpos($timeFormat, 'h'),
            'm' => strpos($timeFormat, 'm')
        );
        $tmp = array_flip($a);
        ksort($tmp);
        $i = 0;
        $c = array();

        foreach ($tmp as $value)
        {
            $c[++$i] = $value;
        }

        $timePositions = array_flip($c);

        // We find all elements
        if (preg_match("~$timeRegexp~", $time, $matches))
        {
            // We get matching timestamp
            return array($matches[$timePositions['h']], $matches[$timePositions['m']]);
        }
        else
        {
            return null;
        }
    }

}