<?php
/**
 * SOTESHOP/stCrossellingPlugin
 *
 * Ten plik należy do aplikacji stCrossellingPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stCrossellingPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Komponent stCrossellingFrontendComponents
 *
 * @package     stCrossellingPlugin
 * @subpackage  actions
 */
class stCrossellingFrontendActions extends stActions {
    
    public function executeShowInProductTab() {
        $this->setLayout(false);
        $this->smarty = new stSmarty($this->getModuleName());
        
        if ($this->hasRequestParameter('id'))
            $this->products = stCrosselling::getProducts(array($this->getRequestParameter('id')));
        else
            return sfView::NONE;

        $this->config = stConfig::getInstance('stProduct');
      
        $this->config_points = stConfig::getInstance('stPointsBackend');
        $this->config_points->setCulture($this->getUser()->getCulture());
    }
}
