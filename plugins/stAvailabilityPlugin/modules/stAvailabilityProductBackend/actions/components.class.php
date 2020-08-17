<?php
/** 
 * SOTESHOP/stAvailabilityPlugin 
 * 
 * Ten plik należy do aplikacji stAvailabilityPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stAvailabilityPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 617 2009-04-09 13:02:31Z michal $
 */

/** 
 * Komponenty dla modułu stAvailabilityBackend
 *
 * @author Marcin Olejniczak <marcin.olejniczak@sote.pl>
 *
 * @package     stAvailabilityPlugin
 * @subpackage  actions
 */
class stAvailabilityProductBackendComponents extends sfComponents 
{
    /** 
     * Wyświetlanie dostępności na karcie produktu
     */
    public function executeProductAvailability()
    {
        $product = ProductPeer::retrieveByPK($this->getRequestParameter('id'));
        if($product)
        {
            if($product->getAvailabilityId())
            {
                $this->selected = $product->getAvailabilityId();
                $this->is_depository = false;
                $this->disable = false;
            }
            else 
            {
                if ($product)
                {
                    if($product->getStock() !== null)
                    {
                        $c = new Criteria();
                        $c->add(AvailabilityPeer::STOCK_FROM,$product->getStock(),Criteria::LESS_EQUAL);
                        $c->addDescendingOrderByColumn(AvailabilityPeer::STOCK_FROM);
                        $availability=AvailabilityPeer::doSelectOne($c);
                        if ($availability)
                        {
                            $this->selected=$availability->getId();
                        }
                        else 
                        {
                            $this->selected="";
                        }
                        
                    }
                    else 
                    {
                        $this->selected="";
                    }
                }
                else
                {
                    $this->availability="";
                    $this->selected="";
                }
                $this->disable = "disable";
                $this->is_depository = true;
            }
        }
        else 
        {
            $this->disable = "disable";
            $this->is_depository = true;
            $this->availability="";
            $this->selected="";
        }
        $c = new Criteria();
        $this->availability = AvailabilityPeer::doSelect($c);
    }
}