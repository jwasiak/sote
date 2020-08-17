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
 * @version     $Id: stDepositoryPluginListener.class.php 617 2009-04-09 13:02:31Z michal $
 * @author      Daniel Mendalka <daniel.mendalka@sote.pl>
 */

/**
 * Podpięcie pod generator stProduct modułu stDepositoryPlugin
 * 
 * @author Daniel Mendalka <daniel.mendalka@sote.pl>
 *
 * @package     stDepositoryPlugin
 * @subpackage  libs
 */
class stDepositoryPluginListener
{
   const LIST_STOCK = 'list_stock';

   public static function productSetListStock(sfEvent $event)
   {
      $event->getSubject()->setStock($event['arguments'][0]);

      return true;
   }

   public static function translateFieldName()
   {
      return 'list_stock';
   }

   /**
    * Podpięcie zdarzenia dla generatora produktu
    *
    * @param       sfEvent     $event
    */
   public static function generate(sfEvent $event)
   {
      // możemy wywoływać podaną metodę wielokrotnie co powoduje dołączenie kolejnych plików
      $event->getSubject()->attachAdminGeneratorFile('stDepositoryPlugin', 'stProduct.yml');
   }

   public static function modAddItem(sfEvent $event)
   {
      $event['item']->setMaxQuantity($event['product']->getStock());
   }

   public static function addDepositoryFiltersCriteria(sfEvent $event)
   {
      
      
      $action = $event->getSubject();

      $has_filter = isset($action->filters['list_stock']) && (isset($action->filters['list_stock']['from']) && $action->filters['list_stock']['from'] !== '' || isset($action->filters['list_stock']['to']) && $action->filters['list_stock']['to'] !== '');


      if ($has_filter || $action->getUser()->getAttribute('sort', null, 'sf_admin/autoStProduct/depository_sort') == 'list_stock')
      {
         $c = $event['criteria'];
         $sql = sprintf('SELECT SUM(%s) FROM %s WHERE %s = %s AND %s - %s = 1', 
            ProductOptionsValuePeer::STOCK,
            ProductOptionsValuePeer::TABLE_NAME, 
            ProductOptionsValuePeer::PRODUCT_ID, 
            ProductPeer::ID,
            ProductOptionsValuePeer::RGT, 
            ProductOptionsValuePeer::LFT
         );

         $c->addAsColumn('list_stock', sprintf('IF(%s > 1 AND %s = %s, (%s), %s)', ProductPeer::OPT_HAS_OPTIONS, ProductPeer::STOCK_MANAGMENT, ProductPeer::STOCK_PRODUCT_OPTIONS, $sql, ProductPeer::STOCK));
      }

      if ($has_filter) 
      {
         $having = array();

         if ($action->filters['list_stock']['from'] !== '' && $action->filters['list_stock']['to'] !== '' && $action->filters['list_stock']['to'] == $action->filters['list_stock']['from'])
         {
            $having[] = 'list_stock = '.$action->filters['list_stock']['from'];
         }
         else
         {
            if ($action->filters['list_stock']['from'] !== '')
            {
               $having[] = 'list_stock >= '.floatval(str_replace(',', '.', $action->filters['list_stock']['from']));
            }
            
            if ($action->filters['list_stock']['to'] !== '')
            {
               $having[] = 'list_stock <= '.floatval(str_replace(',', '.', $action->filters['list_stock']['to']));  
            }
         }

         $c->addHaving(implode(' AND ', $having));

         $action->pager->setPeerCountMethod(array('stDepositoryPluginListener', 'depositoryPeerCoundMethod'));
      }
   }

   public static function depositoryPeerCoundMethod($c)
   {
      $culture = sfContext::getInstance()->getUser()->getCulture();

      $c->clearSelectColumns()->clearOrderByColumns();

      $c->addSelectColumn(ProductPeer::ID);

      $sql = sprintf('SELECT SUM(%s) FROM %s WHERE %s = %s AND %s - %s = 1', 
            ProductOptionsValuePeer::STOCK,
            ProductOptionsValuePeer::TABLE_NAME, 
            ProductOptionsValuePeer::PRODUCT_ID, 
            ProductPeer::ID,
            ProductOptionsValuePeer::RGT, 
            ProductOptionsValuePeer::LFT
         );

      $c->addAsColumn('list_stock', sprintf('IF(%s > 1 AND %s = %s, (%s), %s)', ProductPeer::OPT_HAS_OPTIONS, ProductPeer::STOCK_MANAGMENT, ProductPeer::STOCK_PRODUCT_OPTIONS, $sql, ProductPeer::STOCK));

      // $c->addSelectColumn(ProductPeer::ID);

      // $c->addAsColumn('list_stock', sprintf('IFNULL(SUM(%s), %s)', ProductOptionsValuePeer::STOCK, ProductPeer::STOCK));

      $c->addJoin(ProductPeer::ID, sprintf('%s AND %s = \'%s\'', ProductI18nPeer::ID, ProductI18nPeer::CULTURE, $culture), Criteria::LEFT_JOIN);

      $sql = BasePeer::createSqlQuery($c);

      $con = Propel::getConnection($c->getDbName());

      $rs = $con->executeQuery('SELECT count(*) as cnt FROM ('.$sql.') as temp');

      return $rs->next() ? $rs->getInt('cnt') : 0;
      // return ProductPeer::doCountWithI18n($c);
   }

   /**
    * Zmienia wyświetlanie koszyka na disabled gdy jest włączone
    * sprawdzanie stany magazynowego, a wartość stock jest ustawiona na 0.
    *
    * @param sfEvent $event
    */
   public static function blockAddBasketButton(sfEvent $event)
   {
      $config = stConfig::getInstance(sfContext::getInstance(), array('depository_basket' => stConfig::BOOL), 'stProduct');
      $config->load();
      if ($config->get('depository_basket') == 1)
      {
         $subject = $event->getSubject();
         $depository = stDepository::getStock($subject->product->getId());
         if ($depository === 0)
         {
            $subject->enabled = 0;
         }
      }
   }

   /**
    * Sprawdza zmiany dokonane w zamówieniu i modyfikuje stany magazynowe
    * zgodnie z konfiguracją sklepu.          
    *                                         
    * Tabela do else:
    *
    * old_status      new_status      on_change       action
    * =========================================================
    * ST_CANCELED     ST_PENDING      ST_PENDING      decrease
    * ST_CANCELED     ST_COMPLETE     ST_PENDING      decrease
    * 
    * ST_PENDING      ST_CANCELED     ST_PENDING      increase
    * ST_COMPLETE     ST_CANCELED     ST_PENDING      increase    
    * 
    * ST_PENDING      ST_COMPLETE     ST_PENDING      nothing 
    * ST_COMPLETE     ST_PENDING      ST_PENDING      nothing 
    * 
    * ---------------------------------------------------------
    * 
    * ST_CANCELED     ST_COMPLETE      ST_COMPLETE      decrease
    * ST_PENDING      ST_COMPLETE      ST_COMPLETE      decrease
    * 
    * ST_COMPLETE      ST_PENDING      ST_COMPLETE      increase
    * ST_COMPLETE      ST_CANCELED     ST_COMPLETE      increase
    * 
    * ST_CANCELED     ST_PENDING      ST_COMPLETE      nothing 
    * ST_PENDING      ST_CANCELED     ST_COMPLETE      nothing
    *
    * @author Daniel Mendalka
    */
   public static function preSaveOrder(sfEvent $event)
   {
      $config = stConfig::getInstance('stProduct');

      if (!$config->get('depository_enabled', true))
      {
         return;
      }

      $order = $event->getSubject();

      if (null === $order->getChangeStockOn())
      {
         if ($config->get('get_depository') == 'order')
         {
            $order->setChangeStockOn('ST_PENDING');
         }
         elseif ($config->get('get_depository') == 'order_status')
         {
            $order->setChangeStockOn('ST_COMPLETE');
         }
      }

      if (null !== $order->getChangeStockOn() && $order->isColumnModified(OrderPeer::ORDER_STATUS_ID))
      {
         $previous_status = $order->getPreviousColumnValue(OrderPeer::ORDER_STATUS_ID) ? OrderStatusPeer::retrieveByPK($order->getPreviousColumnValue(OrderPeer::ORDER_STATUS_ID)) : null;

         switch ($order->getChangeStockOn())
         {
            case 'ST_PENDING':
               if ($previous_status && $previous_status->getType() == 'ST_CANCELED')
               {
                  self::decreaseAll($order->getOrderProducts());
               }
               elseif ($order->getOrderStatus()->getType() == 'ST_CANCELED')
               {
                  self::increaseAll($order->getOrderProducts());
               }
               ProductHasCategoryPeer::cleanCache();
               stFastCacheManager::clearCache(true);
               break;
            case 'ST_COMPLETE':
               if ($previous_status && $previous_status->getType() == 'ST_COMPLETE' && in_array($order->getOrderStatus()->getType(), array('ST_CANCELED', 'ST_PENDING', 'ST_IN_PROGRESS')))
               {
                     self::increaseAll($order->getOrderProducts());
               }
               elseif ($order->getOrderStatus()->getType() == 'ST_COMPLETE')
               {
                  self::decreaseAll($order->getOrderProducts());
               }
               ProductHasCategoryPeer::cleanCache();
               stFastCacheManager::clearCache(true);
               break;
         }
      }
   }

   /**
    * Remeber that `$eventOrItems` is hack or appShopgatePlugin.
    **/
   public static function validateOrderSave($eventOrItems, $ok)
   {
      if ($ok)
      {
         $config = stConfig::getInstance('stProduct');

         if (!$config->get('depository_enabled', true) || $config->get('get_depository') != 'order')
         {
            return $ok;
         }

         if(is_array($eventOrItems))
            $items = $eventOrItems;
         else 
            $items = sfContext::getInstance()->getUser()->getBasket()->getItems();

         foreach ($items as $item)
         {
            if (!$item->productValidate()) continue;

            if ($item->hasPriceModifiers() && $item->getProduct()->hasStockManagmentWithOptions())
            {
               self::decreaseProductOptions($item);
            }
            else
            {
               stDepository::decrease($item->getProduct(), $item->getQuantity());
            }

            if ($item instanceof BasketProduct && $item->getProductSetDiscountId())
            {
               $c = new Criteria();
               $c->addSelectColumn(DiscountHasProductPeer::PRODUCT_ID);
               $c->add(DiscountHasProductPeer::DISCOUNT_ID, $item->getProductSetDiscountId());
               $rs = DiscountHasProductPeer::doSelectRs($c);

               while($rs->next())
               {
                  $row = $rs->getRow();
                  stDepository::decrease($row[0], $item->getQuantity());
               }
            }
         }

         ProductHasCategoryPeer::cleanCache();
         stFastCacheManager::clearCache(true);
      }

      return $ok;
   }

   public static function increaseAll($items)
   {
      foreach ($items as $item)
      {
         if (!$item->productValidate()) continue;
         
         if ($item->hasPriceModifiers() && $item->getProduct()->hasStockManagmentWithOptions())
         {
            self::increaseProductOptions($item);
         }
         else
         {
            stDepository::increase($item->getProductId(), $item->getQuantity());
         }

         foreach ($item->getOrderProductHasSets() as $set)
         {
            if ($set->getProductId() != $item->getProductId())
            {
               stDepository::increase($set->getProductId(), $item->getQuantity());
            }
         }             
      }
   }

   public static function decreaseAll($items)
   {
      foreach ($items as $item)
      {
         if (!$item->productValidate()) continue;

         if ($item->hasPriceModifiers() && $item->getProduct()->hasStockManagmentWithOptions())
         {
            self::decreaseProductOptions($item);
         }
         else
         {         
            stDepository::decrease($item->getProductId(), $item->getQuantity());
         }

         foreach ($item->getOrderProductHasSets() as $set)
         {
            if ($set->getProductId() != $item->getProductId())
            {
               stDepository::decrease($set->getProductId(), $item->getQuantity());
            }
         }
      }
   }

   private static function increaseProductOptions($item)
   {
      $ids = self::getProductOptionsIds($item);
      if ($ids)
      {
         stDepository::increaseProductOptions($ids, $item->getQuantity());
         ProductOptionsValuePeer::updateStock($item->getProductId());
         AllegroAuctionPeer::updateRequiresSync($item->getProductId(), end($ids)); 
      }
   }

   private static function decreaseProductOptions($item)
   {
      $ids = self::getProductOptionsIds($item);
      if ($ids)
      {
         stDepository::decreaseProductOptions($ids, $item->getQuantity());
         ProductOptionsValuePeer::updateStock($item->getProductId());
         AllegroAuctionPeer::updateRequiresSync($item->getProductId(), end($ids)); 
      }
   }   

   private static function getProductOptionsIds($item)
   {
      $ids = array();

      foreach ($item->getPriceModifiers() as $option)
      {
         if (isset($option['custom']['id']))
         {
            $ids[] = $option['custom']['id'];
         }
      }  
      
      return $ids;    
   } 
}