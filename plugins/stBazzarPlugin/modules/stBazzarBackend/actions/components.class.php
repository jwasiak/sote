<?php
/**
 * SOTESHOP/stBazzarPlugin
 *
 * Ten plik należy do aplikacji stBazzarPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stBazzarPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stBazzarBackendComponents
 *
 * @package     stBazzarPlugin
 * @subpackage  actions
 */
class stBazzarBackendComponents extends autostBazzarBackendComponents
{
    /**
     * Generowanie pliku xml
     */
    public function executeGenerateXml()
    {
        $this->generate = false;
        if ($this->getRequest()->hasParameter('generate')) $this->generate = true;

        $stBazzar = new stBazzar();
        $this->checkedConfig = false;
        $shopId = $stBazzar->getConfig('shop_id');
        $shopName = $stBazzar->getConfig('shop_name');
        if (!empty($shopId) && !empty($shopName)) $this->checkedConfig = true;

        $this->steps = $stBazzar->getStepsCount();
    }
}