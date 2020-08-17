<?php
/** 
 * SOTESHOP/stUnavailablePlugin 
 * 
 * Ten plik należy do aplikacji stUnavailablePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stUnavailablePlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 9 2009-08-24 09:31:16Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa stUnavailableFrontendActions
 *
 * @package     stUnavailablePlugin
 * @subpackage  actions
 */
class stUnavailableFrontendActions extends stActions
{
    /** 
     * Unavailable
     */
    public function executeUnavailable()
    {
        $this->setLayout(false);
        
        $file = include SF_ROOT_DIR.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'errors'.DIRECTORY_SEPARATOR.'unavailable.php';
        $this->content = file_get_contents($file);
    }
}