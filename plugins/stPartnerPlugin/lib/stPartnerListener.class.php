<?php
/**
 * SOTESHOP/stPartner
 *
 * Ten plik należy do aplikacji stPartner opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPartner
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stPartnerListener.class.php 1858 2009-06-25 13:59:29Z bartek $
 */

/**
 * Podpięcie pod stProduct modułu stPartner
 *
 * @author Bartosz Alejski <bartosz.@sote.pl>
 *
 * @package     stPartner
 * @subpackage  libs
 */
class stPartnerListener
{
    /**
     * Podpięcie linku do recenzji zamówień w panelu klienta
     *
     * @param       sfEvent     $event
     */
    public static function postExecuteUserPanelMenu(sfEvent $event)
    {
        $action = $event->getSubject();

        
            $config = stConfig::getInstance(null, 'stPartnerBackend');

            $config->load();
            
            if($config->get('is_active'))
            {
                $action->panel_navigator->addTab(__('Partner', '', 'partner'), 'partner', 'index', null, 'index');    
            }
        
    }

    public static function generateStUser(sfEvent $event)
    {
        $generator = $event->getSubject();

        $generator->attachAdminGeneratorFile('stPartnerPlugin', 'stPartnerPluginInUser.yml');
    }


    public static function postExecutePartnerList(sfEvent $event)
    {
        $action = $event->getSubject();

        $action->pager->getCriteria()->addJoin(PartnerPeer::SF_GUARD_USER_ID , sfGuardUserPeer::ID );

        $action->pager->init();

    }

    /**
     * Przeciazanie zapisywania zamówienia
     *
     * @param       sfEvent     $event
     */
    public static function filterOrderSave(sfEvent $event)
    {
        $order = $event['order'];

        if ($event->getSubject()->getUser()->hasAttribute('partnerHash'))
        {
            $hash = $event->getSubject()->getUser()->getAttribute('partnerHash');

            $c = new Criteria();
            $c->add(PartnerHashPeer::HASH, $hash);
            $partnerHash = PartnerHashPeer::doSelectOne($c);

            if (is_object($partnerHash))
            {   
                
                $provision = $order->getTotalAmount(true)*($partnerHash->getPartner()->getProvision()/100)+$partnerHash->getPartner()->getAmount();
                
                $order->setPartner($partnerHash->getPartner());
                
                $order->setProvisionValue($provision);
            }
        }
        
       
    }
}