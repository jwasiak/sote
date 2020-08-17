<?php                                 
/** 
 * SOTESHOP/stFrontend 
 * 
 * Ten plik należy do aplikacji stFrontend opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stFrontend
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 16678 2012-01-09 14:39:56Z krzysiek $
 */

/** 
 * Akcje strony głównej sklepu.
 *
 * @author Marek Jakubowicz marek.jakubowicz@sote.pl
 *
 * @package     stFrontend
 * @subpackage  actions
 */
class stFrontendMainActions extends stActions
{
    /** 
     * Executes index action
     */
    public function executeIndex()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        $producer_config = stConfig::getInstance(sfContext::getInstance(), 'stProducer');
        
        $this->getUser()->getAttributeHolder()->remove('chosen_category');
        
        if ($producer_config->get('clear_filter'))
        {
            stProducer::clearSelectedProducerId();
        }
        
        if ($this->hasRequestParameter('uniqid'))
        {
            $this->uniqid = $this->getRequestParameter('uniqid');
            $this->getUser()->setAttribute('uniqid_shop_id', $this->getRequestParameter('uniqid'));
        }
        else
        {
            $this->uniqid = false;
        }  

        $this->getResponse()->setCanonicalLink(st_url_for(array('module' => 'stFrontendMain', 'action' => 'index'), true, null, stLanguage::getInstance($this->getContext())->getDomain()));  
    }
    
    public function executeThemeDemo()
    {
        
    }

}
