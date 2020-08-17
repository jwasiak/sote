<?php
/**
 * SOTESHOP/stNavigationPlugin
 *
 * Ten plik należy do aplikacji stNavigationPlugin opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package stNavigationPlugin
 * @subpackage actions
 * @copyright SOTE (www.sote.pl)
 * @license http://www.sote.pl/license/sote (Professional License SOTE)
 * @version $Id: components.class.php 16525 2011-12-19 12:19:16Z krzysiek $
 * @author Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stNavigationFrontendComponents
 *
 * @package stNavigationPlugin
 * @subpackage actions
 */
class stNavigationFrontendComponents extends sfComponents
{
    /**
     * Wyświetlanie boksa z ostatnio oglądanymi produkatami
     *
     */
    public function executeProductsBox()
    {
        if (defined(ST_FAST_CACHE_SAVE_MODE) || defined(ST_FAST_CACHE_DEFAULT_MODE) || file_exists(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'fastcache'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'fast_cache_enabled'))
        return sfView::NONE;    
    	
        $this->smarty = new stSmarty('stNavigationFrontend');

        $this->smarty->register_function('st_product_image_tag', 'st_product_smarty_image_tag');

        $this->productConfig = stConfig::getInstance(sfContext::getInstance(), 'stProduct');
        $this->productConfig->load();

        stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stNavigationFrontendComponents.myExecuteProductsBox'));
        
        $this->stNavigation = stNavigation::getInstance($this->getContext());

        $productsId = array();
        foreach ($this->stNavigation->getLastViewedProducts() as $product) $productsId[] = $product['id'];

        $this->products = array();
        if (count($productsId))
        {
            $c = new Criteria();
            $c->add(ProductPeer::ID, $productsId, Criteria::IN);
            stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stNavigationFrontendComponents.postProductsBoxCriteria', array('criteria' => $c)));
            $c->addDescendingOrderByColumn('Field('.ProductPeer::ID.','.implode(',', $productsId).')', Criteria::CUSTOM);
            $c->setLimit($this->stNavigation->getConfig('history_box_limit'));
            $this->products = ProductPeer::doSelect($c);
        }

        $this->hasProducts = false;
        if (count($this->products)) $this->hasProducts = true;
        if ($this->stNavigation->getConfig('history_box') == 0) $this->hasProducts = false;
    }

    public function executeBreadcrumbs()
    {
        $navigation = stNavigation::getInstance($this->getContext());
        $path = $navigation->getNavigationPath();
        
        if (!$path || $navigation->getConfig('bar') == 0)
        {
            return sfView::NONE;
        }

        $smarty = new stSmarty('stNavigationFrontend');
        $smarty->assign('breadcrumbs', $path);
        
        return $smarty;
    }
}