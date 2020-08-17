<?php
/** 
 * SOTESHOP/stOrder 
 * 
 * Ten plik należy do aplikacji stOrder opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stOrder
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stOrderListener.class.php 310 2009-09-04 14:28:35Z marcin $
 */

/** 
 * SOTESHOP/stOrder
 * Ten plik należy do aplikacji stOrder opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stOrder
 * @subpackage  libs
 */
class stNewsletterListener
{
    /** 
     * Sluchacz dodajacy dodatkowa zakladke do menu w panelu uzytkownika
     *
     * @param       sfEvent     $event
     */
    public static function postExecuteUserPanelMenu(sfEvent $event)
    {
        
        $event->getSubject()->panel_navigator->addTab('Newsletter', 'stNewsletterFrontend', 'newsletterList', null, 'newsletterList');
    }
    
    public static function postExecuteOrderSave(sfEvent $event)
    {
        $order = $event->getSubject()->order;
        
        $newsletter_config = stConfig::getInstance(sfContext::getInstance(), 'stNewsletterBackend');        

        $user_data_billing = $event->getSubject()->getRequestParameter('user_data_billing');


        if(isset($user_data_billing['newsletter']))
        {

            if($user_data_billing['newsletter']==1)
            {
                $c = new Criteria();
                $c->add(NewsletterUserPeer::SF_GUARD_USER_ID, $order->getSfGuardUser()->getId());
                $newsletterUser = NewsletterUserPeer::doSelectOne($c);
                
                if(!$newsletterUser)
                {
                    $c = new Criteria();
                    $c->add(NewsletterUserPeer::EMAIL, $order->getSfGuardUser()->getUsername());
                    $newsletterUser = NewsletterUserPeer::doSelectOne($c);
                    
                    if($newsletterUser)
                    {
                        $newsletterUser->setUserId($order->getSfGuardUser()->getId());
                        $newsletterUser->save();
                    }
                    else
                    {
                        $newsletterUser = new NewsletterUser();
                        $newsletterUser->setEmail($order->getSfGuardUser()->getUsername());
                        $newsletterUser->setUserId($order->getSfGuardUser()->getId());
                        $newsletterUser->setLanguage(sfContext::getInstance()->getUser()->getCulture());
                        $newsletterUser->setActive(1);
                        $newsletterUser->setConfirm(1);
                        $newsletterUser->save();
                        
                        $hash = md5($newsletterUser->getId().$newsletterUser->getCreatedAt());
    
                        $newsletterUser->setHash($hash);
                        $newsletterUser->save();
                        
                            $c = new Criteria();
                            $c->add(NewsletterGroupPeer::IS_PUBLIC , 1);
                            $c->add(NewsletterGroupPeer::IS_DEFAULT , 1);
                            $defaultNewsletterGroup = NewsletterGroupPeer::doSelect($c);
                    
                            if($defaultNewsletterGroup)
                            {
                                foreach ($defaultNewsletterGroup as $group)
                                {
                                    $c = new Criteria();
                                    $c->add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, $newsletterUser->getId());
                                    $c->add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID, $group->getId());
                                    NewsletterUserHasNewsletterGroupPeer::doInsert($c);
                                }
                            }
                    }

                    if($newsletter_config->get('register_message_on')){                        
                        
                        $action = $event->getSubject()->getController()->getAction('stNewsletterFrontend', 'unsubscribe');                                                
                        $event->getSubject()->getController()->getActionStack()->addEntry('stNewsletterFrontend', 'unsubscribe', $action);                                               
                        
                        $action->initialize($event->getSubject()->getContext());                       
                        $action->sendAfterRegisterMail($newsletterUser);                        
                        $event->getSubject()->getController()->getActionStack()->popEntry();
                        
                    }

                }     
            }
        }
    }

}
?>