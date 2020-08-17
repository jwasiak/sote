<?php

/**
 * Subclass for performing query and update operations on the 'app_product_attribute_variant_has_product' table.
 *
 * 
 *
 * @package plugins.appProductAttributesPlugin.lib.model
 */ 
class appProductAttributeVariantHasProductPeer extends BaseappProductAttributeVariantHasProductPeer
{
   public static function doCountProduct(Criteria $c)
   {
      $c = clone $c;

      $con = Propel::getConnection($c->getDbName());

      $c->clearOrderByColumns();

      $c->addSelectColumn(self::PRODUCT_ID);

      $sql = BasePeer::createSqlQuery($c);

      $rs = $con->executeQuery('SELECT count(*) as cnt FROM ('.$sql.') as temp');

      return $rs->next() ? $rs->getInt('cnt') : 0;
   }
}
