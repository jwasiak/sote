<?php
/** 
 * SOTESHOP/stPrzelewy24Plugin 
 * 
 * Ten plik należy do aplikacji stPrzelewy24Plugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stPrzelewy24Plugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa stPrzelewy24Components
 *
 * @package     stPrzelewy24Plugin
 * @subpackage  actions
 */
class stPrzelewy24FrontendComponents extends sfComponents
{
    /** 
     * Pokazywanie formularza płatności
     */
    public function executeShowPayment()
    {
        $request = $this->getRequest();

        if ($this->order)
        {
            $this->api = new stPrzelewy24();

            try
            {
                $url = $this->api->getPaymentUrl($this->order);

                stPayment::log("przelewy24", "Generate payment url for order with id {$this->order->getId()}: $url");   
            }
            catch (Exception $e)
            {
                stPayment::log("przelewy24", "Generate payment url exception for order with id {$this->order->getId()}: {$e->getMessage()}");   
            }

            if ($url) 
            {
                return $this->getController()->redirect($url);
            }
        }

        $this->smarty = new stSmarty('stPrzelewy24Frontend');

        $webpage = WebpagePeer::retrieveByState('CONTACT');
        
        if ($webpage)
        {
            sfLoader::loadHelpers(array('Helper', 'stUrl'));
            $this->smarty->assign('contact_url', st_url_for('stWebpageFrontend/index?url='.$webpage->getFriendlyUrl()));
        }        
    }
}