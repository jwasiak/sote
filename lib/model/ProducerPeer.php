<?php

/**
 * SOTESHOP/stProducer
 *
 * Ten plik należy do aplikacji stProducer opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stProducer
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: ProducerPeer.php 850 2009-04-27 11:43:19Z marcin $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa ProducerPeer
 *
 * @package     stProducer
 * @subpackage  libs
 */
class ProducerPeer extends BaseProducerPeer
{
   protected static $exportProducerPool = array();   
   protected static $urlPool = array();
   protected static $activePool = array();
   
   public static function retrieveByUrl($url)
   {
      if (!isset(self::$urlPool[$url]) && !array_key_exists($url, self::$urlPool))
      {
         $c = new Criteria();
         $c->addSelectColumn(ProducerI18nPeer::ID);
         $c->add(ProducerI18nPeer::URL, $url);
         $c->setLimit(1);
         $rs = ProducerI18nPeer::doSelectRS($c);

         if ($rs->next())
         {  
            $row = $rs->getRow();
            $c = new Criteria();
            $c->add(self::ID, $row[0]);
            $c->setLimit(1);
            $tmp = self::doSelectWithI18n($c);     
            self::$urlPool[$url] = $tmp ? $tmp[0] : null;   
         }
         else
         {
            self::$urlPool[$url] = null;
         }
      }

      return self::$urlPool[$url];
   }  

   /**
    * Pobiera nazwe producenta przypisana do produktu, jako parametr podawany
    * obiekt produktu
    *
    * @param        object      $object
    * @return   object
    */
   public static function getProductProducer(Product $product)
   {
      $id = $product->getProducerId();

      if (null !== $id && !isset(self::$exportProducerPool[$id]))
      {
         $c = new Criteria();
         $c->addSelectColumn(ProducerPeer::OPT_NAME);
         $c->add(ProducerPeer::ID, $id);
         $c->setLimit(1);
         $rs = ProducerPeer::doSelectRS($c);

         if ($rs->next())
         {  
            list(self::$exportProducerPool[$id]) = $rs->getRow();
         }
      }

      return isset(self::$exportProducerPool[$id]) ? self::$exportProducerPool[$id] : '';
   }

   /**
    * Ustawia dla danego produktu producenta, jezeli producent nie istnieje
    * towrzy go. Jako parametr object
    *
    * @param        object      $object
    * @param        string      $value
    */
   public static function setProductProducer(Product $product, $value)
   {
      if ($value && !isset(self::$exportProducerPool[$value]))
      {
         $c = new Criteria();
         $c->addSelectColumn(ProducerPeer::ID);
         $c->add(ProducerPeer::OPT_NAME, $value);
         $c->setLimit(1);
         $rs = ProducerPeer::doSelectRS($c);

         if ($rs->next())
         {
            list($id) = $rs->getRow();
         }
         else
         {
            $id = null;
         }

         if (null === $id)
         {
            $producer = new Producer();
            $producer->setCulture($product->getCulture());
            $producer->setName($value);
            $producer->save();
            $id = $producer->getId();
         } 

         self::$exportProducerPool[$value] = $id;
      }
      elseif (!$value)
      {
         self::$exportProducerPool[$value] = null;
      }
      
      $product->setProducerId(self::$exportProducerPool[$value]);
   }

   public static function doSelectArray(Criteria $c = null)
   {
      if (is_null($c))
      {
         $c = new Criteria();
      }
      else
      {
         $c = clone $c;
      }

      $c->clearSelectColumns();
      $c->addSelectColumn(ProducerPeer::ID);

      $rs = self::doSelectRS($c);

      $ids = array();

      while($rs->next())
      {
         $row = $rs->getRow();
         $ids[$row[0]] = true;
      }

      $results = array();

      if ($ids)
      {
         $producers = self::doSelectActiveArrayCached(sfContext::getInstance()->getUser()->getCulture());

         foreach ($producers as $id => $producer) 
         {
            if (isset($ids[$id]))
            {
               $results[$id] = $producer;
            }
         }
      }

      return $results;
   }

   public static function doCountWithI18n(Criteria $c, $con = null)
   {
      $c->addJoin(ProducerI18nPeer::ID, ProducerPeer::ID);

      $c->add(ProducerI18nPeer::CULTURE, stLanguage::getHydrateCulture());

      return self::doCount($c, $con);
   }

   /**
    * Przeciążenie metody pobierającej produkty w odpowiedniej wersji jezykowej
    *
    * @param Criteria $c Kryteria
    * @param mixed $culture Wersja językowa
    * @param CreoleConnection $con Połączenie z bazą danych
    * @return array Produkty
    */
   public static function doSelectWithI18n(Criteria $c, $culture = null, $con = null)
   {
      if ($culture === null)
      {
         $culture = stLanguage::getHydrateCulture();
      }

      return parent::doSelectWithI18n($c, $culture, $con);
   }

   public static function doSelectProducersForProduct(Criteria $c = null, $con = null)
   {
      if (is_null($c))
      {
         $c = new Criteria();
      }
      else
      {
         $c = clone $c;
      }

      $c->addAscendingOrderByColumn(ProducerI18nPeer::NAME);

      return self::doSelectWithI18n($c, $con);
   }

   public static function doSelectActiveArrayCached($culture)
   {
      if (!isset(self::$activePool[$culture]))
      {
         $cache = stFunctionCache::getInstance('stProducer');
         self::$activePool[$culture] = $cache->cacheCall(array('ProducerPeer', 'doSelectActiveArray'), array('culture' => $culture));
      } 

      return self::$activePool[$culture];     
   }

   /**
    * @deprecated use doSelectArray instead
    */
   public static function doSelectActive(Criteria $c = null, $con = null)
   {
      if (is_null($c))
      {
         $c = new Criteria();
      }
      else
      {
         $c = clone $c;
      }

      $product_config = stConfig::getInstance(null, 'stProduct');

      $c->addJoin(ProducerPeer::ID, ProductPeer::PRODUCER_ID, Criteria::LEFT_JOIN);

      $c->addJoin(ProductPeer::ID, ProductHasCategoryPeer::PRODUCT_ID, Criteria::LEFT_JOIN);

      $c->addJoin(ProductHasCategoryPeer::CATEGORY_ID, CategoryPeer::ID, Criteria::LEFT_JOIN);

      $c->add(CategoryPeer::IS_ACTIVE, true);

      $c->add(ProductPeer::ACTIVE, true);

      if ($product_config->get('show_without_price'))
      {
         $c->add(ProductPeer::PRICE, 0, Criteria::GREATER_THAN);
      }

      $c->addAscendingOrderByColumn(ProducerI18nPeer::NAME);
      
      $c->addGroupByColumn(self::ID);

      stEventDispatcher::getInstance()->notify(new sfEvent($this, 'ProducerPeer.doSelectActive', array('criteria'=>$c))); 

      return self::doSelectWithI18n($c, $con);
   }

   public static function doSelectActiveArray()
   {
      $pc = new Criteria();
      $pc->addSelectColumn("COUNT(".ProductPeer::PRODUCER_ID.")");
      $pc->add(ProductPeer::PRODUCER_ID, sprintf("%s = %s", ProductPeer::PRODUCER_ID, ProducerPeer::ID), Criteria::CUSTOM);
      ProductPeer::addFilterCriteria(sfContext::getInstance(), $pc, false);

      $sql = BasePeer::createSqlQuery($pc);      

      $c = new Criteria();
      $c->add(self::ID, sprintf('(%s) > 0', $sql), Criteria::CUSTOM);

      $producers = self::doSelectWithI18n($c);

      $results = array();

      if ($producers)
      {
         foreach ($producers as $producer)
         {
            $results[$producer->getId()] = array(
               'label' => $producer->getName(),
               'name' => $producer->getName(),
               'url' => $producer->getUrl(),
               'image' => $producer->getOptImage()
            );
         }

         uasort($results, array('ProducerPeer', 'sortHelper'));
      }

      return $results;      
   }

   public static function clearCache()
   {
      $cache = stFunctionCache::getInstance('stProducer');
      
      $cache->removeAll();
   }

   public static function sortHelper($p1, $p2)
   {
      return strnatcasecmp($p1['name'], $p2['name']);
   }

   public static function doSelectTokens(Criteria $c)
   {
      $tokens = array();

      $c = clone $c;

      $c->addSelectColumn(self::ID);

      $c->addSelectColumn(self::OPT_NAME);

      $rs = self::doSelectRS($c);

      while($rs->next())
      {
         list($id, $name) = $rs->getRow();

         $tokens[] = array('id' => $id, 'name' => $name);
      }      

      return $tokens;        
   }

}

