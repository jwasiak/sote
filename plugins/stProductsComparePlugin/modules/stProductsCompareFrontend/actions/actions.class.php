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
 * @version     $Id: actions.class.php 16321 2011-12-01 10:54:02Z krzysiek $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa stProductsCompareFrontendActions
 *
 * @package     stProductsComparePlugin
 * @subpackage  actions
 */
class stProductsCompareFrontendActions extends stActions
{
    /** 
     * Porówanie produktów
     */
    public function executeIndex()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        $this->productsWithoutTemplate = array();

        $this->productsWithoutTemplateOn = false;
        $this->productsWithTemplateOn = false;

        if ($this->getUser()->hasAttribute('productsToCompare'))
        {
            $productsList = $this->getUser()->getAttribute('productsToCompare');
            
            $c = new Criteria();
            $c->add(ProductPeer::ID, $productsList, Criteria::IN);
            $this->productsWithoutTemplate = ProductPeer::doSelect($c);
            
            if (count($this->productsWithoutTemplate) > 0) $this->productsWithoutTemplateOn = true;
        }
        
        $config = stConfig::getInstance(sfContext::getInstance(), array('hide_price' => stConfig::BOOL),'stProduct');
        $config->load();
        
        stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stProductsCompareFrontendActions.myExecuteIndex'));
        
        $this->showPrice = true;
        if ($config->get('hide_price'))
        {
            $this->showPrice = false;
        }
        
        $stNavigation = stNavigation::getInstance($this->getContext());
        $this->lastViewedProduct = $stNavigation->getLastViewedProduct();
        
        $this->hasLastViewedProduct = false;
        if (is_array($this->lastViewedProduct)) $this->hasLastViewedProduct = true;
        
        // disable Fast Cache for this session if currency is different that default
        stFastCacheController::disable();
    }

    /** 
     * Dodawanie produktu do sesji
     *
     * @param   integer     $productId          Id produktu
     */
    private function addProduct($productId)
    {
        $productsToCompareArray = array();
        if($this->getUser()->hasAttribute('productsToCompare'))
        {
            $productsToCompareArray = $this->getUser()->getAttribute('productsToCompare');
        }
        $productsToCompareArray[$productId] = $productId;

        $this->getUser()->setAttribute('productsToCompare', $productsToCompareArray);
    }

    /** 
     * Usuwanie produktu z sesji
     *
     * @param   integer     $productId          Id produktu
     */
    private function removeProduct($productId)
    {
        $productsToCompareArray = array();
        if($this->getUser()->hasAttribute('productsToCompare'))
        {
            $productsToCompareArray = $this->getUser()->getAttribute('productsToCompare');
        }
        unset($productsToCompareArray[$productId]);

        $this->getUser()->setAttribute('productsToCompare', $productsToCompareArray);
    }

    /** 
     * Prezentacja przycisku `dodaj` produktu w karcie produktu
     */
    public function executeAddProductToCompare()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        if($this->getRequest()->hasParameter('id'))
        {
            $this->addProduct($this->getRequestParameter('id'));
        }
        stFastCacheController::disable();
    }

    /** 
     * Prezentacja przycisku `usuń` produktu w karcie produktu
     */
    public function executeRemoveProductFromCompare()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        if($this->getRequest()->hasParameter('id'))
        {
            $this->removeProduct($this->getRequestParameter('id'));
        }
    }

    /** 
     * Prezentacja przycisku `usuń` produktu na liście porównywanych produktów
     */
    public function executeRemoveProductInCompare()
    {
        if($this->getRequest()->hasParameter('id'))
        {
            $this->removeProduct($this->getRequestParameter('id'));
        }
        $this->redirect('@stProductsComparePlugin');
    }

    /** 
     * Dodanie produktu do listy porównywanych produktów bez JavaScriptu
     */
    public function executeAddFromInfo()
    {
        if($this->getRequest()->hasParameter('id'))
        {
            $this->addProduct($this->getRequestParameter('id'));
            $this->redirect('product/show?id='.$this->getRequestParameter('id'));
        }
        
        $this->redirect('/');
    }

    /** 
     * Usunięcie produktu z listy porównywanych produktów bez JavaScriptu
     */
    public function executeRemoveFromInfo()
    {
        if($this->getRequest()->hasParameter('id'))
        {
            $this->removeProduct($this->getRequestParameter('id'));
            $this->redirect('product/show?id='.$this->getRequestParameter('id'));
        }
        
        $this->redirect('/');
    }
}