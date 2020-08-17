<?php
/** 
 * SOTESHOP/stIe 
 * 
 * Ten plik należy do aplikacji stIe opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stIe
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 1885 2009-06-26 13:15:49Z bartek $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/** 
 * Modul prezentujacy mozliwosci klasy stIe
 *
 * @package     stIe
 * @subpackage  actions
 */
class stIeActions extends stActions
{
    /** 
     * Executes index action
     */
    public function executeIndex()
    {   
        
       $stWebRequest = new stWebRequest();
       $httpUserAgent = $stWebRequest->getHttpUserAgent(); 
       
       if(ereg("MSIE 7.0", $httpUserAgent)){$ie = "7";}

       if(ereg("MSIE 6.0", $httpUserAgent)){$ie = "6";}
        
       $this->ie = $ie;
        
    }
    
}