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
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id$
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/** 
 * Komponenty menu historii.
 *
 * @package     stBackendFastMenuPlugin
 * @subpackage  actions
 */
class stBackendFastMenuComponents extends sfComponents
{
    /** 
     * Wyświetla listę aplikacji w menu.
     */
    public function executeShowTaskLine()
    {
        $userId = $this->getUser()->getAttribute('user_id', 0, 'sfGuardSecurityUser');
        $this->userId = $userId;

        $c = new Criteria();
        $c->addDescendingOrderByColumn('position');
        $c->setLimit(10);

        $ModuleName = FastMenuPeer::doSelect($c);
        $this->ModuleName = $ModuleName;
    }
}