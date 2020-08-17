<?php
/** 
 * SOTESHOP/stCategory
 *
 * Ten plik należy do aplikacji stCategory opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stCategory
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: components.class.php 4925 2010-05-13 12:02:51Z krzysiek $
 */

/** 
 * Akcje dla komponentu kategorii
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stCategory
 * @subpackage  actions
 */
class stCategoryComponents extends sfComponents
{
    /**
     * Wyświetla drzewo kategorii
     */
    public function executeTree()
    {
        $this->smarty = new stSmarty('stCategory');

        $c = new Criteria();

        $c->add(CategoryPeer::PARENT_ID, null, Criteria::ISNULL);

        $c->addJoin(ProductHasCategoryPeer::CATEGORY_ID, CategoryPeer::ID);

        $c->addJoin(ProductHasCategoryPeer::PRODUCT_ID, ProductPeer::ID);

        $producer_id = $this->getUser()->getAttribute('id', null, 'soteshop/stProducer');

        if ($producer_id)
        {
            $c->add(ProductPeer::PRODUCER_ID, $producer_id);
        }

        $c->add(ProductPeer::ACTIVE, true);

        $c->addGroupByColumn(CategoryPeer::ID);

        $this->roots = CategoryPeer::doSelect($c);

        $category = CategoryPeer::retrieveByPk($this->getRequestParameter('id_category'));

        if (is_object($category) && $category->hasParent())
        {
            $path = $category->getPath();

            $category_path = array();

            $this->root_id = $path[0]->getId();

            foreach ($path as $cat)
            {
                $category_path[] = $cat->getId();
            }

            $category_path[] = $category->getId();

            $this->category_path = implode('/', $category_path);
        }
    }

    /**
     * Wyświetla szczegółowe informacje o kategorii
     */
    public function executeInfo()
    {
        if (!$this->category)
        {
            return sfView::NONE;
        }

        $this->smarty = new stSmarty('stCategory');

        $config = stConfig::getInstance(sfContext::getInstance(), 'stCategory');

        $this->show_subcategories = $config->get('show_subcategories');
    }

    /**
     * Wyświetla drzewo kategorii w poziomie
     */
    public function executeHorizontalTree()
    {
        $this->root_id = $this->getUser()->getAttribute('root_id', 0, 'soteshop/horizontal_tree');

        $this->category_id = $this->getRequestParameter('id_category');

        $c = new Criteria();

        $c->add(CategoryPeer::PARENT_ID, null, Criteria::ISNULL);

        $this->roots = CategoryPeer::doSelect($c);

        $c = new Criteria();

        $c->add(CategoryPeer::PARENT_ID, $this->root_id);

        $this->categories = CategoryPeer::doSelect($c);
    }

    public function executeSubcategories()
    {
        $this->producer_id = stProducer::getSelectedProducerId();

        $this->smarty = new stSmarty('stCategory');

        $this->config = stConfig::getInstance(sfContext::getInstance(), 'stCategory');

        $c = new Criteria();

        $c->add(CategoryPeer::PARENT_ID, $this->category->getId());

        if ($this->producer_id)
        {
            $c->add(ProductPeer::PRODUCER_ID, $this->producer_id);
        }
        
        $c = stEventDispatcher::getInstance()->filter(new sfEvent($this, 'stCategoryComponents.executeSubcategories.filterCriteria'), $c)->getReturnValue();

        $this->url = stEventDispatcher::getInstance()->filter(new sfEvent($this, 'stCategoryComponents.executeSubcategories.filterUrl'), array('module' => 'stProduct', 'action' => 'list'))->getReturnValue();

        if ($this->getRequest()->hasParameter('producer'))
        {
           $this->url['producer'] = $this->getRequest()->getParameter('producer');
        }

        $this->subcategories = ProductHasCategoryPeer::doSelectCategories($c);

        if (!$this->subcategories)
        {
            return sfView::NONE;
        }

    }
}