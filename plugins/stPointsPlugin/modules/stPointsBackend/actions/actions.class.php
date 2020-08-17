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
 * Klasa stPointsBackendActions.
 *
 * @package     stPointsPlugin
 * @subpackage  actions
 */
class stPointsBackendActions extends autoStPointsBackendActions {

    public function executeAddPointsForOrder() {

        $i18n = $this -> getContext() -> getI18N();

        $this -> config = stConfig::getInstance('stPointsBackend');
        $this -> config -> setCulture($this -> getRequestParameter('culture', stLanguage::getOptLanguage()));

        $c = new Criteria();
        $c -> add(OrderPeer::ID, $this -> getRequestParameter('id'));
        $order = OrderPeer::doSelectOne($c);

        if (stPoints::isPointsAssigned($order) == false) {
            stPoints::addPointForOrder($order,true);
        }

        $flash_text = $i18n -> __('Punkty zostały przydzielone');
        $this -> setFlash('notice', $flash_text);

        return $this -> redirect('stOrder/edit?id=' . $this -> getRequestParameter('id'));

    }
    
    public function executeConfirmMessage() {

        $config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');
        $config_points->set('points_system_install_update', 0);   
        $config_points->save();

        return $this -> redirect('stPointsBackend/config');

    }
    
    

}
