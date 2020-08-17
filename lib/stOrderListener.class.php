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
 * @version     $Id: stOrderListener.class.php 16071 2011-11-10 14:23:16Z marcin $
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
class stOrderListener
{

   /**
    * Sluchacz dodajacy dodatkowa zakladke do menu w panelu uzytkownika
    *
    * @param       sfEvent     $event
    */
   public static function postExecuteUserPanelMenu(sfEvent $event)
   {
      /**
       * 
       * @var sfBasicSecurityUser
       */
      $sf_user = sfContext::getInstance()->getUser();

      if ($sf_user->isAuthenticated() && null !== $sf_user->getGuardUser())
      {
         $user_id = $sf_user->getGuardUser()->getId();

         $c = new Criteria();
         $c->add(OrderPeer::SF_GUARD_USER_ID, $user_id);

         $order = OrderPeer::doSelectOne($c);

         if($order)
         {
            $event->getSubject()->panel_navigator->addTab(__('Zamówienia', '', 'stOrder'), 'stOrder', 'list', null, 'list');
         }
      }
	  
   }

   public static function postExecuteAjaxDeliveryUpdate(sfEvent $event)
   {
      $action = $event->getSubject();

      $action->responseUpdateElement('st_user-order-submit-button', array('module' => 'stOrder', 'component' => 'submitButton'));
   }

   public static function postInstall(sfEvent $event)
   {
      sfLoader::loadHelpers('stProgressBar');
      sfLoader::loadHelpers('Partial');

      $count = stOrderProgressBar::countRepairTotalAmount();

      $event->getSubject()->msg .= progress_bar('stOrderRepair', 'stOrderProgressBar', 'repairTotalAmount', $count);
   }

   public static function numberRepair(sfEvent $event)
   {
      sfLoader::loadHelpers('stProgressBar');
      sfLoader::loadHelpers('Partial');

      $count = stOrderProgressBar::countRepairOrderNumber();

      $event->getSubject()->msg .= progress_bar('stOrderRepairNumber', 'stOrderProgressBar', 'repairOrderNumber', $count);
   }   

}

?>