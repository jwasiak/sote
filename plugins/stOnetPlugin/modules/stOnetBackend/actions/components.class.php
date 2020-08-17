<?php
/** 
 * SOTESHOP/stOnetPlugin 
 * 
 * Ten plik należy do aplikacji stOnetPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stOnetPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Piotr Halas <piotr.halas@sote.pl>
 */

/** 
 * Klasa stOnetBackendComponents
 *
 * @package     stOnetPlugin
 * @subpackage  actions
 */
class stOnetBackendComponents extends autostOnetBackendComponents
{
    /** 
     * Generowanie pliku xml
     */
    public function executeGenerateXml()
    {
        $this->generate = false;
        if ($this->getRequest()->hasParameter('generate')) $this->generate = true;

        $stOnet = new stOnet();
        $this->steps = $stOnet->getStepsCount();
    }
}