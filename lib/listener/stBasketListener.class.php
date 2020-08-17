<?php

/**
 * SOTESHOP/stBasket
 *
 * Ten plik należy do aplikacji stBasket opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stBasket
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stBasketListener.class.php 17068 2012-02-09 13:16:30Z marcin $
 */

/**
 * Klasa sluchacza dla stBasket
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stBasket
 * @subpackage  libs
 */
class stBasketListener
{
    public static function stPartialCacheGenerateId(sfEvent $event, $value)
    {
        $parameters = $event->getParameters();

        if ($parameters['module'] == 'stBasket' && $parameters['action'] == '_show')
        {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
            $value['cache_id'] = stBasket::cacheId();
        }

        return $value;
    }

   /**
    * Sluchacz rozszerzający generator.yml stProduct
    *
    * @param       sfEvent     $event
    */
   public static function generateStProduct(sfEvent $event)
   {
      $event->getSubject()->attachAdminGeneratorFile('stBasket', 'stProduct.yml');
   }
   
   public static function refreshBasketProducts(sfEvent $event)
   {
      self::refreshBasket();  
   }

   public static function refreshBasket()
   {
      $user = sfContext::getInstance()->getUser();

      $basket = stBasket::getInstance($user);

      $user->setVatEx(stTax::hasEx($user->isAuthenticated() && $user->getUserDataDefaultBilling() ? $user->getUserDataDefaultBilling()->getCountries()->getId() : null));

      if ($basket->hasItems())
      {
         $basket->refresh();

         $basket->save();
      }       
   }

   public static function preExecuteAction(sfEvent $event)
   {
      $action = $event->getSubject();

      $namespace = $action->getModuleName().'/'.$action->getActionName();

      switch($namespace) 
      {
         case 'stCurrencyFrontend/change':
         case 'stCurrencyFrontend/addCurrency':
         case 'stUser/logoutUser':
            stBasket::clearCache();
         break;
      }

      if ($action->getContext()->getStorage()->read(sfBasicSecurityUser::AUTH_NAMESPACE) === null || $namespace == 'stUserData/userPanel' || $namespace == 'stUserData/createFirstUserData')
      {
         stBasket::clearCache();
      }
   }

    public static function postExecuteAction(sfEvent $event)
    {
        $action = $event->getSubject();

        $namespace = $action->getModuleName().'/'.$action->getActionName();     

        if ($namespace == 'stCurrencyFrontend/addCurrency' || $namespace == 'stCurrencyFrontend/change')
        {
            self::refreshBasketProducts($event);
        } elseif ($namespace == 'stUser/loginGoogleUser' && $action->getUser()->isAuthenticated()) {
            self::refreshBasketProducts($event);
        } 
        
    }
}

?>
