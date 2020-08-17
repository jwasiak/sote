<?php

/**
 * SOTESHOP/stProduct
 *
 * Ten plik należy do aplikacji stProduct opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stProduct
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: ProductHasCategoryPeer.php 1350 2009-05-26 06:29:13Z krzysiek $
 */

/**
 * Klasa powiązań produktu z kategoriami
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stProduct
 * @subpackage  libs
 */
class ProductHasCategoryPeer extends BaseProductHasCategoryPeer
{

   /**
    * Sprawdza czy produkt jest włączony w kategorii jako specjalny
    *
    * @param   integer     $product_id         id produktu powiązanego z kategorią
    * @param   integer     $category_id        id kategorii powiązanej z produktem
    */
   public static function getSpecial($product_id, $category_id)
   {
      $c = new Criteria();
      $c->add(ProductHasCategoryPeer::PRODUCT_ID, $product_id);
      $c->add(ProductHasCategoryPeer::CATEGORY_ID, $category_id);
      $c->add(ProductHasCategoryPeer::SPECIAL, true);
      return ProductHasCategoryPeer::doCount($c);
   }

   /**
    * Dodaje product do kategorii
    *
    * @param   Product     $product            Obiekt Product
    * @param   array       $category_ids       Tablica id kategorii
    */
   public static function addProductToCategory($product, $category_ids = array())
   {
      $c = new Criteria();

      $c->add(self::PRODUCT_ID, $product->getId());

      self::doDelete($c);

      if (is_array($category_ids))
      {
         foreach ($category_ids as $id)
         {
            $pc = new ProductHasCategory();

            $pc->setProduct($product);

            $pc->setCategoryId($id);

            $pc->save();
         }
      }
   }

   public static function retrieveByProductIdAndCategoryId($product_id, $category_id)
   {
      $c = new Criteria();

      $c->add(self::PRODUCT_ID, $product_id);

      $c->add(self::CATEGORY_ID, $category_id);

      return self::doSelectOne($c);
   }

   public static function retrieveCategoriesByProducer($producer, $active = true)
   {
      if ($producer instanceof Producer)
      {
         $producer_id = $producer->getId();
      }
      else
      {
         $producer_id = $producer;
      }

      $c = new Criteria();

      $c->add(ProductPeer::PRODUCER_ID, $producer_id);

      $c->addJoin(CategoryPeer::DEPTH, 1);

      return self::doSelectCategories($c);
   }

   public static function retrieveProducersByCategory($category, $active = true)
   {
      if ($category instanceof Category)
      {
         $category_id = $category->getId();
      }
      else
      {
         $category_id = $category;
      }

      $c = new Criteria();

      $c->add(ProductPeer::ACTIVE, $active);

      $c->addJoin(ProductHasCategoryPeer::PRODUCT_ID, ProductPeer::ID);

      $c->addJoin(ProductPeer::PRODUCER_ID, ProducerPeer::ID);

      $c->add(ProductHasCategoryPeer::CATEGORY_ID, $category);

      $c->addGroupByColumn(ProducerPeer::ID);

      $c->addAscendingOrderByColumn(ProducerI18nPeer::NAME);

      return ProducerPeer::doSelectWithI18n($c);
   }

   public static function doSelectCategories(Criteria $c, $con = null, $cached = true)
   {
      $product_config = stConfig::getInstance(null, 'stProduct');

      $c = clone $c;

      $c->addAlias('c1', CategoryPeer::TABLE_NAME);

      $c->addJoin(CategoryPeer::alias('c1', CategoryPeer::ID), ProductHasCategoryPeer::CATEGORY_ID, 'STRAIGHT_JOIN');

      $c->addJoin(ProductHasCategoryPeer::PRODUCT_ID, ProductPeer::ID, 'STRAIGHT_JOIN');

      $c->add(CategoryPeer::alias('c1', CategoryPeer::LFT), sprintf('%s BETWEEN %s AND %s AND %s = %s', CategoryPeer::alias('c1', CategoryPeer::LFT), CategoryPeer::LFT, CategoryPeer::RGT, CategoryPeer::alias('c1', CategoryPeer::SCOPE), CategoryPeer::SCOPE), Criteria::CUSTOM);

      $c->add(ProductPeer::ACTIVE, true);
      
      $c->add(CategoryPeer::IS_ACTIVE, true);

      if ($product_config->get('show_without_price'))
      {
         $c->add(ProductPeer::PRICE, 0, Criteria::GREATER_THAN);
      }

      $c->addGroupByColumn(CategoryPeer::ID);

      $fc = new stFunctionCache();

      if ($cached)
      {
         return $fc->callBy('ProductHasCategoryPeer', 'CategoryPeer::doSelectNestedSet', $c, $con, sfContext::getInstance()->getUser()->getCulture());
      }

      return CategoryPeer::doSelectNestedSet($c, $con);
   }

   public static function doSelectRoots(Criteria $c, $con = null)
   {
      $c = clone $c;

      $c->add(CategoryPeer::PARENT_ID, null, Criteria::ISNULL);

      return self::doSelectCategories($c, $con);
   }

   public static function cleanCache()
   {
      if (sfContext::hasInstance())
      {
         $fc = new stFunctionCache();

         $fc->cleanBy('frontend', 'ProductHasCategoryPeer');

         $fc->cleanBy('backend', 'ProductHasCategoryPeer');

         $fc->cleanBy('cache', 'ProductHasCategoryPeer');

         $fc = new stFunctionCache('stCategoryTree');

         $fc->removeAll();

         stPartialCache::clear('stProduct', '_productGroup', array('app' => 'frontend'));
         stPartialCache::clear('stProduct', '_new', array('app' => 'frontend'));
      }
   }

   public static function doSelectMainPageCategories(Category $parent = null)
   {
      $config = stConfig::getInstance('stCategory');

      $c = new Criteria();

      $c->add(CategoryPeer::IS_ACTIVE, true);
      $c->add(CategoryPeer::MAIN_PAGE, true);

      if (null === $parent)
      {
         if (!$config->get('category_main_menu_all_depths'))
         {
            $c->add(CategoryPeer::DEPTH, 1);
         }
      }
      elseif (!$config->get('subcategory_main_menu_num'))
      {
         return array();
      }
      else
      {
         $c->setLimit($config->get('subcategory_main_menu_num'));
         $c->add(CategoryPeer::PARENT_ID, $parent->getId());
      }

      if ($config->get('hide_categories_without_products'))
      {
         $pc = new Criteria();
         $pc->addSelectColumn('COUNT('.ProductPeer::ID.')');
         $pc->addJoin(ProductHasCategoryPeer::PRODUCT_ID, ProductPeer::ID);
         $pc->addJoin(ProductHasCategoryPeer::CATEGORY_ID, CategoryPeer::ID);
         ProductPeer::addFilterCriteria(sfContext::getInstance(), $pc, false);
      }

      $c->addAlias('c', CategoryPeer::TABLE_NAME);
      $c->addJoin(CategoryPeer::SCOPE, CategoryPeer::alias('c', CategoryPeer::ID));
      $c->addAscendingOrderByColumn(CategoryPeer::alias('c', CategoryPeer::ROOT_POSITION));

      $results = array();

      foreach (CategoryPeer::doSelectNestedSet($c) as $category) 
      {
         if (!$config->get('hide_categories_without_products') || self::doCountProduct($category, $pc))
         {
            $results[] = $category;
         }
      }

      return $results;
   }

   public static function doCountProduct(Category $category, Criteria $pc)
   {
      $pc->add(CategoryPeer::LFT, sprintf('%s BETWEEN %s AND %s', CategoryPeer::LFT, $category->getLft(), $category->getRgt()), Criteria::CUSTOM);
      $pc->add(CategoryPeer::SCOPE, $category->getScope());    

      $rs = ProductPeer::doSelectRs($pc);
      return $rs->next() ? $rs->getInt(1) : 0;  
   }

}