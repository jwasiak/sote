<?php
/** 
 * SOTESHOP/stAllegroPlugin 
 * 
 * Ten plik należy do aplikacji stAllegroPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stAllegroPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: AllegroAuctionHasOrder.php 16339 2011-12-01 12:09:59Z piotr $
 * @author      Piotr Halas <piotr.halas@sote.pl>
 */
 
/** 
 * Klasa AllegroAuctionHasOrder
 *
 * @package     stAllegroPlugin
 * @subpackage  libs
 */
class AllegroAuctionHasOrder extends BaseAllegroAuctionHasOrder
{

	public function save($con = null)
	{
        parent::save($con);
        $this->getOrder()->setOptAllegroAuctionId($this->getAllegroAuctionId());
        $this->getOrder()->save();
    }
}
