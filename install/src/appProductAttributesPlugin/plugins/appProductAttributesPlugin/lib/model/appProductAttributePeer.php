<?php

/**
 * Subclass for performing query and update operations on the 'app_product_attribute' table.
 *
 * 
 *
 * @package plugins.appProductAttributesPlugin.lib.model
 */ 
class appProductAttributePeer extends BaseappProductAttributePeer
{
   public static function doSelectCategoriesForTokenInput(appProductAttribute $app_product_attribute)
   {
      $c = new Criteria();

      $c->add(appProductAttributeHasCategoryPeer::ATTRIBUTE_ID, $app_product_attribute->getId());

      $c->addJoin(appProductAttributeHasCategoryPeer::CATEGORY_ID, CategoryPeer::ID);

      return ProductPeer::doSelectCategoriesTokens($c);
   } 

   public static function doSelectArray(Criteria $c, $culture)
   {
   	$c = clone $c;

      $c->addSelectColumn(self::ID);

      $c->addSelectColumn(self::OPT_NAME);

      $c->addSelectColumn(self::TYPE); 

      $c->addSelectColumn(self::POSITION);  

      $c->addSelectColumn(appProductAttributeI18nPeer::NAME);   

      $c->addJoin(self::ID, appProductAttributeI18nPeer::ID.' AND '.appProductAttributeI18nPeer::CULTURE.' = \''.$culture.'\'', Criteria::LEFT_JOIN);

      $rs = self::doSelectRs($c);      

      $rs->setFetchmode(ResultSet::FETCHMODE_ASSOC);  

      $results = array();

      while($rs->next())
      {
         $row = $rs->getRow();

         $results[$row['ID']] = self::hydrateArray($row);
      }  
      
      if ($results)
      {
         appProductAttributeHelper::sortArrayResults($results);
      }

      return $results;                	
   }

   public static function doSelectArrayByCategory(Category $category, $culture)
   {
      $ids = $category->getPath('doSelectIds');

      $ids[] = $category->getId();

      $c = new Criteria();

      $c->addJoin(self::ID, appProductAttributeHasCategoryPeer::ATTRIBUTE_ID);

      $c->add(self::IS_SEARCHABLE, true);

      $c->add(self::IS_ACTIVE, true);

      $c->add(appProductAttributeHasCategoryPeer::CATEGORY_ID, $ids, Criteria::IN);

      return self::doSelectArray($c, $culture);
   } 

   public static function doSelectArrayByProduct($product, $culture)
   {
      $ranges = self::doSelectCategoriesRangesByProduct($product);

      $c = new Criteria();

      foreach ($ranges as $range)
      {
         $sql = sprintf('%s <= %s AND %s >= %s AND %s = %s', CategoryPeer::LFT, $range[0], CategoryPeer::RGT, $range[1], CategoryPeer::SCOPE, $range[2]);
         $c->addOr(CategoryPeer::LFT, $sql, Criteria::CUSTOM);
      }   

      $c->addJoin(self::ID, appProductAttributeHasCategoryPeer::ATTRIBUTE_ID);

      $c->addJoin(appProductAttributeHasCategoryPeer::CATEGORY_ID, CategoryPeer::ID); 

      $c->add(self::IS_VISIBLE_ON_PP, true);

      $c->add(self::IS_ACTIVE, true);       
      
      $c->addGroupByColumn(self::ID);

      return self::doSelectArray($c, $culture);     
   }

   public static function doSelectByProduct(Product $product)
   {
      $ranges = self::doSelectCategoriesRangesByProduct($product);

      if (!$ranges) {
         return array();
      }

      $c = new Criteria();

      foreach ($ranges as $range)
      {
         $sql = sprintf('%s <= %s AND %s >= %s AND %s = %s', CategoryPeer::LFT, $range[0], CategoryPeer::RGT, $range[1], CategoryPeer::SCOPE, $range[2]);
         $c->addOr(CategoryPeer::LFT, $sql, Criteria::CUSTOM);
      }

      $c->addJoin(self::ID, appProductAttributeHasCategoryPeer::ATTRIBUTE_ID);

      $c->addJoin(appProductAttributeHasCategoryPeer::CATEGORY_ID, CategoryPeer::ID);

      $c->addGroupByColumn(self::ID);

      $c->addAscendingOrderByColumn(self::POSITION);

      $c->addAscendingOrderByColumn(self::ID);

      return self::doSelectWithI18n($c);
   }

   public static function doSelectCategoriesRangesByProduct(Product $product)
   {
      $c = new Criteria();

      $c->addSelectColumn(CategoryPeer::LFT);

      $c->addSelectColumn(CategoryPeer::RGT);

      $c->addSelectColumn(CategoryPeer::SCOPE);

      $c->addJoin(CategoryPeer::ID, ProductHasCategoryPeer::CATEGORY_ID);

      $c->add(ProductHasCategoryPeer::PRODUCT_ID, $product->getId());

      $rs = CategoryPeer::doSelectRs($c);

      $results = array();

      while ($rs->next())
      {
         $results[] = $rs->getRow();
      }

      return $results;
   }

   protected static function hydrateArray($row)
   {
      return array(
      	'id' => $row['ID'],
         'name' => isset($row['NAME']) ? $row['NAME'] : $row['OPT_NAME'],
         'type' => $row['TYPE'],
         'position' => $row['POSITION'],    	
      );
   }
}
