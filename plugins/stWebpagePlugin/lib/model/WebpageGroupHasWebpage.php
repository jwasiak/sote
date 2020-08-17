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
 * @version     $Id: WebpageGroupHasWebpage.php 392 2009-09-08 14:55:35Z michal $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/** 
 * Klasa WebpageGroupHasWebpage
 *
 * @package     stWebpagePlugin
 * @subpackage  libs
 */
class WebpageGroupHasWebpage extends BaseWebpageGroupHasWebpage
{
   public function moveUp()
   {
      $c = new Criteria();

      $c->add(WebpageGroupHasWebpagePeer::WEBPAGE_GROUP_ID, $this->getWebpageGroupId());

      $c->add(WebpageGroupHasWebpagePeer::RANK, $this->getRank(), Criteria::LESS_THAN);

      $c->addDescendingOrderByColumn(WebpageGroupHasWebpagePeer::RANK);

      $previous = WebpageGroupHasWebpagePeer::doSelectOne($c);

      if ($previous)
      {
         $rank = $this->getRank();

         $this->setRank($previous->getRank());

         $previous->setRank($rank);

         $previous->save();

         $this->save();
      }
   }

   public function moveDown()
   {
      $c = new Criteria();

      $c->add(WebpageGroupHasWebpagePeer::WEBPAGE_GROUP_ID, $this->getWebpageGroupId());

      $c->add(WebpageGroupHasWebpagePeer::RANK, $this->getRank(), Criteria::GREATER_THAN);

      $c->addAscendingOrderByColumn(WebpageGroupHasWebpagePeer::RANK);

      $next = WebpageGroupHasWebpagePeer::doSelectOne($c);

      if ($next)
      {
         $rank = $this->getRank();

         $this->setRank($next->getRank());

         $next->setRank($rank);

         $next->save();

         $this->save();
      }
   }  

   public function save($con = null)
   {
      if ($this->isNew())
      {
         $max_rank = WebpageGroupHasWebpagePeer::doSelectMaxRank($this->getWebpageGroupId());

         $this->setRank($max_rank + 1);
      }

      $ret = parent::save($con);

      WebpagePeer::clearCache();
   } 

   public function delete($con = null)
   {
      $rank = $this->getRank();

      $group_id = $this->getWebpageGroupId();

      $ret = parent::delete($con);

      WebpageGroupHasWebpagePeer::moveAllUp($group_id, $rank);

      WebpagePeer::clearCache();
   }
}

/** 
 * Dodanie sortowania
 */