<?php

/**
 * Subclass for performing query and update operations on the 'st_slide_banner' table.
 *
 * 
 *
 * @package plugins.stSlideBannerPlugin.lib.model
 */ 
class SlideBannerPeer extends BaseSlideBannerPeer
{
   public static function doSelectSorted(Criteria $criteria, $con = null)
   {
      $c = clone $criteria;
      $c->addAscendingOrderByColumn(self::RANK);
      return self::doSelect($c);
   }

   public static function moveAllUp($id, $from_rank)
   {
      $con = Propel::getConnection();

      $query = sprintf('UPDATE %1$s SET %2$s = %2$s - 1 WHERE %3$s = ? AND %2$s > ?',
         self::TABLE_NAME,
         self::RANK,
         self::ID
      );

      $stmt = $con->prepareStatement($query);
      $stmt->setInt(1, $id);
      $stmt->setInt(2, $from_rank);
      $stmt->executeQuery();      
   }  

   public static function doSelectMaxRank($id)
   {
      $c = new Criteria();

      $c->addSelectColumn('MAX('.self::RANK.')');

      $rs = BasePeer::doSelect($c, Propel::getConnection());

      if ($rs->next())
      {
         return $rs->getInt(1);
      }

      return 0;
   }

   public static function clearCache()
   {
      stPartialCache::clear('stSlideBannerFrontend', '_show', array('app' => 'frontend'));     
      stFastCacheManager::clearCache(); 
   }
}
