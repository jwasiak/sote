<?php
/** 
 * SOTESHOP/stCronPlugin 
 * 
 * Ten plik należy do aplikacji stCronPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stCronPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stCron.class.php 3018 2008-12-09 17:15:25Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa do obsługi pseudo crona
 *
 * @package     stCronPlugin
 * @subpackage  libs
 */
class stCron
{
    /** 
     * Dodawanie metod jakie mają zostać wywołane w cron'ie
     *
     * @param   string      $class              nazwa klasy
     * @param   string      $method             nazwa metody
     * @param   array       $parameters         tablica z parametrami
     * @param   array       $dayAndTime         data i czas wykonania operacji
     * Tablica $dayAndTime wygląda następująco:
     * array('d' => numer_dnia_tygodnia, 'h' => godzina, 'm'=> minuta);
     * Dozwolone parametry w  $dayAndTime to:
     * - d - dzień tygodnia (poniedziałek - 1, wtorek - 2, ..., niedziela - 7) - nie wymagane
     * - h - godzina (0, 1, 2, ..., 21, 22, 23) - wymagane
     * - m - minuta (00, 01, 02, ..., 57, 58, 59) - wymagane
     * np. array('d' => "4", 'h' => "13", 'm' => "15"); - czwartek, godzina 13:15
     *
     * @package     stCronPlugin
     * @subpackage  libs
     */
    public static function addMethod($class, $method, $parameters = array(), $dayAndTime = array())
    {
        $cronJobs = sfConfig::get('st_cron_plugin_methods');

        if (!is_array($cronJobs))
        {
            $cronJobs = array();
        }

        $job = array('class' => $class, 'method' => $method, 'parameters' => $parameters, 'dayAndTime' => $dayAndTime);
        $cronJobs = array_merge($cronJobs, array($job));

        sfConfig::add(array('st_cron_plugin_methods' => $cronJobs));
    }

    /** 
     * Dodawanie uri jakie mają zostać wywołane w cron'ie
     *
     * @param   string      $uri                adres strony
     * @param   array       $dayAndTime         data i czas wykonania operacji
     * Tablica $dayAndTime wygląda następująco:
     * array('d' => numer_dnia_tygodnia, 'h' => godzina, 'm'=> minuta);
     * Dozwolone parametry w  $dayAndTime to:
     * - d - dzień tygodnia (poniedziałek - 1, wtorek - 2, ..., niedziela - 7) - nie wymagane
     * - h - godzina (0, 1, 2, ..., 21, 22, 23) - wymagane
     * - m - minuta (00, 01, 02, ..., 57, 58, 59) - wymagane
     * np. array('d' => "4", 'h' => "13", 'm' => "15"); - czwartek, godzina 13:15
     */
    public static function addUri($uri, $dayAndTime = array())
    {
        $cronJobs = sfConfig::get('st_cron_plugin_uri');

        if (!is_array($cronJobs))
        {
            $cronJobs = array();
        }

        $job = array('uri' => $uri, 'dayAndTime' => $dayAndTime);
        $cronJobs = array_merge($cronJobs, array($job));

        sfConfig::add(array('st_cron_plugin_uri' => $cronJobs));
    }

    /** 
     * Wykonywanie zadań z cron'a
     *
     * @return  bool        wynik wykonania zadań  
     * Zwracana jest wartość TRUE w przypadku przeprowadzenia zadań z cron'a, 
     * w przypadku braku zadań lub błędu zwracana jest wartość FALSE
     */
    public static function execute()
    {
        $methodJobs = false;
        $uriJobs = false;
        
        $cronJobs = sfConfig::get('st_cron_plugin_methods');

        if (is_array($cronJobs))
        {
            foreach ($cronJobs as $cronJob)
            {
                if (@$cronJob['dayAndTime']['d'] == date('N') || !isset($cronJob['dayAndTime']['d']))
                {
                    if ($cronJob['dayAndTime']['h'] == date('G') && $cronJob['dayAndTime']['m'] == date('i'))
                    {
                        if (class_exists($cronJob['class']))
                        {
                            $class = new $cronJob['class'];
                            if (method_exists($class, $cronJob['method']))
                            {
                                $class->$cronJob['method']($cronJob['parameters']);
                            }
                        }
                    }
                }
            }
            $methodJobs = true;
        }

        $cronJobs = sfConfig::get('st_cron_plugin_uri');

        if (is_array($cronJobs))
        {
            foreach ($cronJobs as $cronJob)
            {
                if ($cronJob['dayAndTime']['d'] == date('N') || !isset($cronJob['dayAndTime']['d']))
                {
                    if ($cronJob['dayAndTime']['h'] == date('G') && $cronJob['dayAndTime']['m'] == date('i'))
                    {
                        $web = new sfWebBrowser();
                        $web->get($cronJob['uri']);
                    }
                }
            }
            $uriJobs = true;
        }
        
        if ($methodJobs || $uriJobs) return true;
        return false;
    }
}