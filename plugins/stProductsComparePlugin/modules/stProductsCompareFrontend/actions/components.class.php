<?php
/** 
 * SOTESHOP/stProductComparePlugin 
 * 
 * Ten plik należy do aplikacji stProductComparePlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stProductsComparePlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 15469 2011-10-06 13:51:06Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Komponent stProductsCompareFrontendComponents
 *
 * @package     stProductsComparePlugin
 * @subpackage  actions
 */
class stProductsCompareFrontendComponents extends sfComponents
{
    /** 
     * Prezentacja przycisku 'dodaj'/'usuń' w karcie produktu
     */
    public function executeProductCompareButton()
    {
        $this->smarty = new stSmarty('stProductsCompareFrontend');
        $this->productId = $this->getRequestParameter('id');

        if (is_object($this->product)) 
        {
            if (!$this->product->isPriceVisible())
            {
                return sfView::NONE;
            }
            
            $this->productId = $this->product->getId(); 
        }
        $this->productsToCompareArray = array();
        $this->compareProduct = true;
        if($this->getUser()->hasAttribute('productsToCompare'))
        {
            $this->productsToCompareArray = $this->getUser()->getAttribute('productsToCompare');
            if (isset($this->productsToCompareArray[$this->productId]))
            {
                $this->compareProduct = false;
            }
        }
        // disable Fast Cache for this session if currency is different that default
    }
}