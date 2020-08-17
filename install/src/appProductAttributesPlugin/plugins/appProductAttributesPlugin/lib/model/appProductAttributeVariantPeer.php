<?php

/**
 * Subclass for performing query and update operations on the 'app_product_attribute_variant' table.
 *
 * 
 *
 * @package plugins.appProductAttributesPlugin.lib.model
 */ 
class appProductAttributeVariantPeer extends BaseappProductAttributeVariantPeer
{
   public static function doSelectTokens(Criteria $c, $type = 'T')
   {
      $c = clone $c;

      $c->addSelectColumn(self::ID);

      $c->addSelectColumn(self::POSITION);

      $c->addSelectColumn(self::OPT_VALUE);

      $c->addSelectColumn(self::OPT_NAME);

      $c->addSelectColumn(self::TYPE);

      $rs = self::doSelectRs($c);

      $tokens = array();

        $rs->setFetchmode(ResultSet::FETCHMODE_ASSOC);

      while ($rs->next())
      {
         $row = $rs->getRow();

         $tokens[] = self::hydrateArray($row);
      }

      appProductAttributeHelper::sortArrayResults($tokens, false);
      
      return $tokens;
   }

   public static function doSelectSingleScalar($c)
   {
      $rs = self::doSelectRs($c);

      return $rs->next() ? $rs->get(1) : null; 
   }

   public static function doCountByProduct($product)
   {
      $c = new Criteria();

      $c->add(appProductAttributeVariantHasProductPeer::PRODUCT_ID, $product instanceof Product ? $product->getId() : $product);

      return appProductAttributeVariantHasProductPeer::doCount($c);
   }

   public static function doSelectArrayWithAttribyteByProduct($product, $culture)
   {
      $c = new Criteria();

      $c->addJoin(self::ID, appProductAttributeVariantHasProductPeer::VARIANT_ID);

      $c->add(appProductAttributeVariantHasProductPeer::PRODUCT_ID, $product instanceof Product ? $product->getId() : $product);

      return self::doSelectArrayWithAttribute($c, $culture);
   }

   public static function doSelectArrayWithAttribute(Criteria $c, $culture, $attribute_ids = array())
   {
      $c = clone $c;

      $c->addSelectColumn(self::ID);

      $c->addSelectColumn(self::OPT_NAME);

      $c->addSelectColumn(self::OPT_VALUE);

      $c->addSelectColumn(self::TYPE);

      $c->addSelectColumn(self::POSITION);      

      $c->addSelectColumn(appProductAttributeVariantI18nPeer::VALUE);

      $c->addSelectColumn(appProductAttributeVariantI18nPeer::NAME);

      $c->addAsColumn('ATTR_ID', appProductAttributeHasVariantPeer::ATTRIBUTE_ID);

      $c->addJoin(self::ID, appProductAttributeHasVariantPeer::VARIANT_ID);

      $c->addJoin(self::ID, appProductAttributeVariantI18nPeer::ID.' AND '.appProductAttributeVariantI18nPeer::CULTURE.' = \''.$culture.'\'', Criteria::LEFT_JOIN);

      if ($attribute_ids)
      {
         $c->add(appProductAttributeHasVariantPeer::ATTRIBUTE_ID, $attribute_ids, Criteria::IN);
      }
      $c->addAscendingOrderByColumn(self::POSITION);
      $c->addAscendingOrderByColumn(appProductAttributeVariantI18nPeer::VALUE);


      $rs = self::doSelectRs($c);

      $rs->setFetchmode(ResultSet::FETCHMODE_ASSOC);

      $results = array();

      while($rs->next())
      {
         $row = $rs->getRow();

         $results[$row['ATTR_ID']][$row['ID']] = self::hydrateArray($row);
      }

     

      return $results;
   }

   protected static function hydrateArray($row)
   {
      return  array(
         'id' => $row['ID'],
         'name' => isset($row['NAME']) ? $row['NAME'] : $row['OPT_NAME'], 
         'value' => isset($row['VALUE']) && $row['VALUE'] ? $row['VALUE'] : $row['OPT_VALUE'],
         'type' => $row['TYPE'],
         'position' => $row['POSITION'],
      );
   }
}
