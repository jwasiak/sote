<?php
/** 
 * SOTESHOP/stBackendFastMenuPlugin 
 * 
 * Ten plik należy do aplikacji stBackendFastMenuPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stBackendFastMenuPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id$
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/** 
 * Obsługa menu historii aplikacji.
 *
 * @package     stBackendFastMenuPlugin
 * @subpackage  libs
 */
class stBackendFastMenu
{
    /** 
     * Dodanie nazwy modułu do bazy danych.
     */
    public static function addToTask()
    {
        $ModuleName = sfContext::getInstance();
        
        if (!array_search($ModuleName->getModuleName(), self::getDisabledModules()))
        {
            $c = new Criteria();
            $c->add(FastMenuPeer::MODULE, $ModuleName->getModuleName());
            $checkModule = FastMenuPeer::doSelectOne($c);

            if(!$checkModule)
            {
                $fastMenu = new FastMenu();
                $fastMenu->setModule($ModuleName->getModuleName());
                $fastMenu->setPosition(1);
                $fastMenu->save();
            }
            else
            {
                $positionValue = $checkModule->getPosition();
                $positionValue++;

                $checkModule->setPosition($positionValue);
                $checkModule->save();
            }
        }
    }
    
    /**
     * Pobieranie modułów, które mają nie być pokazywane w menu.
     *
     * @return array
     * 
     * @author Michal Prochowski <michal.prochowski@sote.pl>
     */
    public static function getDisabledModules()
    {
        return array('sfGuardAuth', 'stErrorBackend', 'stBackendMain');
    }
    
    /**
     * Poprawianie nazwy modułu, m.in. zmaina Backend na Plugin itp.
     *
     * @return string
     * 
     * @author Michal Prochowski <michal.prochowski@sote.pl> 
     */
    public static function getModuleName($module)
    {
        $replaceArray = array('Backend' => 'Plugin', 'sfStats' => 'stStatsPlugin', 'sfGuardUser' => 'stAuthUsers', 'stMailAccountBackend' => 'stMailPlugin');
        return strtr($module, $replaceArray);
    }
}