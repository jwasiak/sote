<?php
/** 
 * SOTESHOP/stWpPlugin 
 * 
 * Ten plik należy do aplikacji stWpPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stWpPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa stWpBackendComponents
 *
 * @package     stWpPlugin
 * @subpackage  actions
 */
class stWpBackendComponents extends autostWpBackendComponents
{
    /** 
     * Generowanie pliku xml
     */
    public function executeGenerateXml()
    {
        $this->generate = false;
        if ($this->getRequest()->hasParameter('generate')) $this->generate = true;
        
        $stWp = new stWp();
        $this->steps = $stWp->getStepsCount();
    }
}