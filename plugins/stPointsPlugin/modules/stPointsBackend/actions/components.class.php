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
 * @version     $Id: components.class.php 2285 2009-07-23 12:50:05Z bartek $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/**
 * Komponent stPointsBackendComponents
 *
 * @package     stPointsPlugin
 * @subpackage  actions
 */
class stPointsBackendComponents extends autoStPointsBackendComponents {

    public function executeConfigContent() {
        $this -> config = stConfig::getInstance('stPointsBackend');
        $this -> config -> setCulture($this -> getRequestParameter('culture', stLanguage::getOptLanguage()));

    }

    public function executeOrderStatusType() {
        $this -> select_options = array();

        $i18n = $this -> getContext() -> getI18N();
        
        $c = new Criteria();
        $orderStatus = OrderStatusPeer::doSelect($c);

        foreach ($orderStatus as $status) {
            $this -> select_options[$status->getId()] = $status->getOptName();
        }
        
        $this->config = stConfig::getInstance('stPointsBackend');
    }

}
