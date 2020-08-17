<?php
/** 
 * SOTESHOP/stWebpagePlugin 
 * 
 * Ten plik należy do aplikacji stWebpagePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stWebpagePlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: WebpageGroupHasWebpagePeer.php 392 2009-09-08 14:55:35Z michal $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/** 
 * Klasa WebpageGroupHasWebpagePeer
 *
 * @package     stWebpagePlugin
 * @subpackage  libs
 */
class WebpageGroupHasWebpagePeer extends BaseWebpageGroupHasWebpagePeer
{
    /** 
     * Pobieranie posortowanych wyników 
     *
     * @param      Criteria    $criteria
     * @param        object      $con
     * @return   object
     */
   public static function doSelectSorted(Criteria $criteria, $con = null)
   {
      $c = clone $criteria;
      $c->addAscendingOrderByColumn(self::RANK);
      return self::doSelect($c);
   }

   public static function moveAllUp($group_id, $from_rank)
   {
      $con = Propel::getConnection();

      $query = sprintf('UPDATE %1$s SET %2$s = %2$s - 1 WHERE %3$s = ? AND %2$s > ?',
         self::TABLE_NAME,
         self::RANK,
         self::WEBPAGE_GROUP_ID
      );

      $stmt = $con->prepareStatement($query);
      $stmt->setInt(1, $group_id);
      $stmt->setInt(2, $from_rank);
      $stmt->executeQuery();      
   }  

   public static function doSelectMaxRank($group_id)
   {
      $c = new Criteria();

      $c->addSelectColumn('MAX('.self::RANK.')');

      $c->add(self::WEBPAGE_GROUP_ID, $group_id);

      $rs = BasePeer::doSelect($c, Propel::getConnection());

      if ($rs->next())
      {
         return $rs->getInt(1);
      }

      return 0;
   }
}