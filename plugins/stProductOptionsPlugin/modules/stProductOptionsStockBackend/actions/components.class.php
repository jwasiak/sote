<?php
/** 
 * SOTESHOP/stProductOptionsPlugin 
 * 
 * Ten plik należy do aplikacji stProductOptionsPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stProductOptionsPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: components.class.php 210 2009-09-01 13:21:28Z michal $
 * @author      Daniel Mendalka <daniel.mendalka@sote.pl>
 */
 
/** 
 * Komponenty dla modułu stProductOptionsStockBackendComponents
 *
 * @author Daniel Mendalka <daniel.mendalka@sote.pl>
 *
 * @package     stProductOptionsPlugin
 * @subpackage  actions
 */
class stProductOptionsStockBackendComponents extends sfComponents
{
    public function executeDepositoryStockOptions()
    {
        if ($this->product->getStockManagment() != ProductPeer::STOCK_PRODUCT_OPTIONS || $this->product->getOptHasOptions() <= 1)
        {
            return sfView::NONE;
        }
    }
}