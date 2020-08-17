<?php

/**
 * Subclass for performing query and update operations on the 'st_discount_coupon_code' table.
 *
 * 
 *
 * @package plugins.stDiscountPlugin.lib.model
 */ 
class DiscountCouponCodePeer extends BaseDiscountCouponCodePeer
{
   public static function retrieveNewCode()
   {
      $c = new Criteria();

      $c->addSelectColumn('MAX('.DiscountCouponCodePeer::ID.')');

      $rs = DiscountCouponCodePeer::doSelectRS($c);

      if ($rs->next())
      {
         $id = $rs->getInt(1);
      }
      else
      {
         $id = 0;
      }

      $c->clear();

      for ($n = 0; $n <= 10; $n++)
      {
         $code = base_convert(60000 + $id * 1000 + rand(1, 1000), 10, 35);

         $c->add(self::CODE, $code);

         if (!self::doCount($c))
         {
            return $code;
         }
      }
   }

   public static function retrieveByCode($code)
   {
      $c = new Criteria();
      $c->add(self::CODE, $code);

      return self::doSelectOne($c);
   }
}
