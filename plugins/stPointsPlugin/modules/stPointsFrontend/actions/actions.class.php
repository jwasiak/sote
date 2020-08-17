<?php

/**
 * SOTESHOP/stPointsPlugin
 *
 * Ten plik należy do aplikacji stInvoicePlugin opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPointsPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 2285 2009-07-23 12:50:05Z bartek $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/**
 * Klasa stPointsFrontendActions.
 *
 * @package     stPointsPlugin
 * @subpackage  actions
 */
class stPointsFrontendActions extends stActions {

    /**
     * Wyświetla listę zamówien klienta
     */
     
    public function executeList() {
        $this -> smarty = new stSmarty($this -> getModuleName());

        $this -> forwardif($this -> getUser() -> isAnonymous(), 'stUser', 'loginUser');

        $c = new Criteria();

        $c -> addDescendingOrderByColumn(UserPointsPeer::CREATED_AT);

        $c -> add(UserPointsPeer::SF_GUARD_USER_ID, $this -> getUser() -> getGuardUser() -> getId());

        $this -> pager = new sfPropelPager('UserPoints', 20);

        $this -> pager -> setPeerMethod('doSelectJoinSfGuardUserRelatedBySfGuardUserId');

        $this -> pager -> setCriteria($c);

        $this -> pager -> setPage($this -> getRequestParameter('page'));

        $this -> pager -> init();
        
    }

}
