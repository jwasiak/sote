<?php
/** 
 * SOTESHOP/stPlatnosciPlPlugin 
 * 
 * Ten plik należy do aplikacji stPlatnosciPlPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stPlatnosciPlPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa stPlatnosciPlFrontendComponents
 *
 * @package     stPlatnosciPlPlugin
 * @subpackage  actions
 */
class stPlatnosciPlFrontendComponents extends sfComponents {

    /** 
     * Pokazywanie formularza płatności
     */
    public function executeShowPayment() {
        $this->smarty = new stSmarty('stPlatnosciPlFrontend');

        $api = new stPlatnosciPl();
        $order = stPaymentType::getOrderInSummary();   

        try
        {
            $url = $api->getOrderFormUrl($order); 
            
            if ($url) 
            {                
                return $this->getController()->redirect($url);
            }
        }   
        catch (OpenPayU_Exception $e) 
        {
            stPlatnosciPl::log("stPlatnosciPl::getOrderFormUrl() - Exception:\n".$e->getFile().':'.$e->getLine().':'.$e->getMessage());
        } 

        $webpage = WebpagePeer::retrieveByState('CONTACT');

        if ($webpage)
        {
            sfLoader::loadHelpers(array('Helper', 'stUrl'));
            $this->smarty->assign('contact_url', st_url_for('stWebpageFrontend/index?url='.$webpage->getFriendlyUrl()));
        }
    }
}
