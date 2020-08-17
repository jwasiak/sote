<?php

/**
 * SOTESHOP/stDepositoryPlugin 
 * 
 * Ten plik należy do aplikacji stDepositoryPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stDepositoryPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stDepositiory.class.php 617 2009-04-09 13:02:31Z michal $
 * @author      Marcin Olejniczak <marcin.olejniczak@sote.pl>
 */

/**
 * Klasa stDepository
 *
 * @author Marcin Olejniczak <marcin.olejniczak@sote.pl>
 *
 * @package     stDepositoryPlugin
 * @subpackage  libs
 */
class stDepository
{

   /**
    * Zwiększanie stanu magazynowego produktu
    *
    * @param        object      $product
    * @param       integer     $quantity
    */
   public static function increase($product, $quantity)
   {
      $id = is_object($product)? $product->getId() : $product;
       
      if ($id)
      {  
         $con = Propel::getConnection();

         $con->executeQuery(sprintf('UPDATE %1$s SET %2$s = %2$s + %3$s WHERE %4$s = %5$s',
            ProductPeer::TABLE_NAME,
            ProductPeer::STOCK,
            $quantity,
            ProductPeer::ID,
            $id
         ));

         AllegroAuctionPeer::updateRequiresSync($id);
      }

   }

   /**
    * Zmniejszanie stanu magazynowego produktu
    *
    * @param        object      $product
    * @param       integer     $quantity
    */
   public static function decrease($product, $quantity)
   {
      $id = is_object($product) ? $product->getId() : $product;
       
      if ($id)
      {  
         $con = Propel::getConnection();

         $con->executeQuery(sprintf('UPDATE %1$s SET %2$s = GREATEST(0, %2$s - %3$s) WHERE %4$s = %5$s',
            ProductPeer::TABLE_NAME,
            ProductPeer::STOCK,
            $quantity,
            ProductPeer::ID,
            $id
         ));

         AllegroAuctionPeer::updateRequiresSync($id);
      }
   }

   public static function set($product, $quantity)
   {
      $id = is_object($product) ? $product->getId() : $product;

      if ($id)
      {
         $con = Propel::getConnection();
         $ps = $con->prepareStatement(sprintf('UPDATE %s SET %s = ? WHERE %s = ?',
            ProductPeer::TABLE_NAME,
            ProductPeer::STOCK,
            ProductPeer::ID
         ));

                
         $ps->set(1, $quantity);
         $ps->setInteger(2, $id);   
         $ps->executeQuery();
      }
   }

   public static function increaseProductOptions($ids, $quantity)
   {
      $con = Propel::getConnection();
      $con->executeQuery(sprintf('UPDATE %1$s SET %2$s = %2$s + %3$s WHERE %4$s IN (%5$s)', 
         ProductOptionsValuePeer::TABLE_NAME,
         ProductOptionsValuePeer::STOCK,
         $quantity,
         ProductOptionsValuePeer::ID,
         implode(',', $ids)
      ));
   }

   public static function decreaseProductOptions($ids, $quantity)
   {
      $con = Propel::getConnection();
      $con->executeQuery(sprintf('UPDATE %1$s SET %2$s = GREATEST(0, %2$s - %3$s) WHERE %4$s IN (%5$s)', 
         ProductOptionsValuePeer::TABLE_NAME,
         ProductOptionsValuePeer::STOCK,
         $quantity,
         ProductOptionsValuePeer::ID,
         implode(',', $ids)
      ));
   }   

   /**
    * Pobranie stanu magazynowego produktu
    *
    * @param       integer     $product_id
    * @return   integer
    */
   public static function getStock($product_id)
   {
      $product = ProductPeer::retrieveByPK($product_id);
      return $product->getStock();
   }

}