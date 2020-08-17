<?php
/** 
 * SOTESHOP/stBase 
 * 
 * Ten plik należy do aplikacji stBase opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stBase
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stMenuModifier.class.php 7 2009-08-24 08:59:30Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa stMenuModifier
 *
 * @package     stBase
 * @subpackage  libs
 */
class stMenuModifier
{
    /** 
     * Dodawanie nowego elementu do head.application
     *
     * @param   string      $moduleName         nazwa modułu 
     * @param   array       $applications       tablica z nowymi elementami
     */
    static public function addHeadApplications($moduleName, $applications = array())
    {
        $headApplications = sfConfig::get('st_menu_modifier_head_applications_'.$moduleName);
        if (!is_array($headApplications))
        {
            $headApplications = array();
        }
        $headApplications = array_merge($headApplications, $applications);
        sfConfig::add(array('st_menu_modifier_head_applications_'.$moduleName => $headApplications));
    }

    /** 
     * Sprawdzanie czy istenieje już jakiś wpis przeciążający daną aplikacje, plugin 
     *
     * @param   string      $moduleName         nazwa modułu 
     * @return  bool        inforamacja o istenieniu danego wpisu przeciążającego 
     */
    static public function hasHeadApplications($moduleName)
    {
        $menuApplications = sfConfig::get('st_menu_modifier_head_applications_'.$moduleName);

        if (isset($menuApplications))
        {
            if (is_array(sfConfig::get('st_menu_modifier_head_applications_'.$moduleName)))
            {
                return true;
            }
            return false;
        }
        return false;
    }

    /** 
     * Pobieranie przeciążonego wpisu i dodawanie nowych wartości do head.application
     *
     * @param   string      $moduleName         nazwa modułu 
     * @param   array       $applications       tablica z wpisami z pliku generator.yml
     * @return  array       tablica z elementami head.application
     */
    static public function getHeadApplications($moduleName, $applications)
    {
        $headApplications = sfConfig::get('st_menu_modifier_head_applications_'.$moduleName);
        if(is_array($applications))
        {
            if (!is_array($headApplications))
            {
                $headApplications = array();
            }
            $headApplications = array_merge($applications, $headApplications);
            sfConfig::add(array('st_menu_modifier_head_applications_'.$moduleName => $headApplications));
        }
        return $headApplications;
    }
}