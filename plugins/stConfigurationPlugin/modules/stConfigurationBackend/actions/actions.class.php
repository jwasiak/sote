<?php
/**
 * SOTESHOP/stConfigurationPlugin
 *
 * Ten plik należy do aplikacji stConfigurationPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stConfigurationPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 7321 2010-08-06 09:04:30Z marcin $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Akcje modułu stConfigurationBackend
 *
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 *
 * @package     stConfigurationPlugin
 * @subpackage  actions
 */
class stConfigurationBackendActions extends stActions
{
    /**
     * Wyświetla listę konfiguracji z danymi modułami
     */
    public function executeList()
    {
        $this->configuration = stConfiguration::getInstance();

    }
}