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
 * @version     $Id: actions.class.php 1206 2009-10-07 12:28:56Z marcin $
 */

/** 
 * Akcje kategorii
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stCategory
 * @subpackage  actions
 */
class stCategoryActions extends stActions
{
    /** 
     * Pobiera kategorie dla danego rodzica
     *
     * @return   sfView
     */
    public function executeFetchCategories()
    {

        $node = $this->getRequestParameter('node');
                
        $output = '';
        
        $extjs_data = array();
        
        if ($node)
        {
            
            $producer_id = $this->getUser()->getAttribute('id', null, 'soteshop/stProducer');

            $c = new Criteria();

            $c->add(CategoryPeer::PARENT_ID, $node);

            $c->addJoin(ProductHasCategoryPeer::CATEGORY_ID, CategoryPeer::ID);

            $c->addJoin(ProductHasCategoryPeer::PRODUCT_ID, ProductPeer::ID);

            if ($producer_id)
            {
                $c->add(ProductPeer::PRODUCER_ID, $producer_id);
            }

            $c->add(ProductPeer::ACTIVE, true);

            $c->addGroupByColumn(CategoryPeer::ID);

            $categories = CategoryPeer::doSelect($c);            

            foreach ($categories as $category)
            {
                $category->setCulture($this->getUser()->getCulture());

                if ($producer_id)
                {
                    $href = $this->getController()->genUrl('product/list?id_category=' . $category->getId() . '&producer=' . $producer_id, false);
                }
                else
                {
                    $href = $this->getController()->genUrl('product/list?id_category=' . $category->getId(), false);
                }

                $extjs_data[] = array('id' => $category->getId(), 'text' => $category->getName(), 'href' => $href);
            }
            
            $output = json_encode($extjs_data);
        }
        
        $this->getResponse()->setHttpHeader('Content-Type', 'application/json');
        return $this->renderText($output);
    }

    /** 
     * Wyświetla drzewo kategorii w poziomie
     */
    public function executeHorizontalTree()
    {
        $category_id = $this->getRequestParameter('id_category', 0);

        $category = CategoryPeer::retrieveByPk($category_id);

        $root_id = 0;

        if ($category)
        {
            if ($category->hasParent())
            {
                $root_id = $category->getParentId();
            } else
            {
                $root_id = $category->getId();
            }
        }

        $this->getUser()->setAttribute('root_id', $root_id, 'soteshop/horizontal_tree');

        $this->redirect($this->getRequest()->getReferer());
    }
}
