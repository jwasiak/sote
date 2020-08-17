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
 * @version $Id: actions.class.php 16649 2011-12-29 12:05:27Z krzysiek $
 * @author Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stNavigationFrontendActions
 *
 * @package stNavigationPlugin
 * @subpackage actions
 */
class stNavigationFrontendActions extends stActions
{
    /**
     * Wyświetla historie ostatnio oglądanych produktów
     */
    public function executeShowHistory()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        
        $this->smarty_product = new stSmarty('stProduct');
        $this->smarty_product->register_function('st_product_image_tag', 'st_product_smarty_image_tag');
        
        $this->config = stConfig::getInstance(sfContext::getInstance(), 'stProduct');
        $this->config->load();
        
        $this->config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');
        $this->config_points->setCulture(sfContext::getInstance()->getUser()->getCulture());

        $stNavigation = stNavigation::getInstance($this->getContext());
        $products = $stNavigation->getLastViewedProducts();

        $productsId = array();
        foreach ($products as $product)
        {
            $productsId[] = $product['id'];
        }
        
        if (count($productsId) == 0) $this->redirect('@homepage');


        $c = new Criteria();
        $this->addSort($c);
        $this->addProducer($c);
        $c->add(ProductPeer::ID, $productsId, Criteria::IN);
        $c->addDescendingOrderByColumn('Field('.ProductPeer::ID.','.implode(',', $productsId).')', Criteria::CUSTOM);
        stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stNavigationFrontendActions.postShowHistoryCriteria', array('criteria' => $c)));

        $pager = new sfPropelPager('Product');
        $pager->setCriteria($c);
        $pager->setPeerMethod('doSelectWithI18n');
        $pager->setPage($this->getRequestParameter('page',1));

        switch ($this->config->get('list_type')) {
            case 'long':
                $listType = 'long_list';
                $this->listType = "listLongProduct";
                break;
            case 'short':
                $listType = 'short_list';
                $this->listType = "listShortProduct";
                break;
            case 'other':
                $listType = 'other_list';
                $this->listType = "listOther";
                break;
            default:
                $listType = 'long_list';
                $this->listType = "listLongProduct";
                break;
        }

        $pager->setMaxPerPage($this->config->get($listType));
        $pager->init();
        
        $this->for_link = array(
          'module' => 'stNavigationFrontend',
          'type' => $this->type_list_url,
          'sort_by' => $this->sort_by,
          'sort_order' => $this->sort_order,
          'page' => $pager->getPage(),
          'producer_filter' => $this->producer_filter
        );

        $this->sort_labels = $this->getSortColumns('label_names');

        $this->view_labels = $this->getViewTypes('label_names');

        $this->products = $pager;

        $this->addType();

        $this->for_link["type"] = $this->type_list_url;

        $this->listType = $this->list_type;

        $this->related = $this;
        
        $this->page = $this->getRequestParameter('page', '1');
        
        $stNavigation->addNavigationPathElement($this->getContext()->getI18n()->__('Historia oglądanych produktów'), false, true);
    }

   protected function getViewTypes($type = null, $types = array())
   {
      $defaults = array(
         'label_names' => array(
              'long' => 'Pełna lista',
              'short' => 'Skrócona lista',
              'other' => 'Lista alternatywna',
          ),
          'view_names' => array(
              'long' => 'listLongProduct',
              'short' => 'listShortProduct',
              'other' => 'listOther',
          ),
      );

      $types = $types ? array_merge_recursive($defaults, $types) : $defaults;

      return $type ? $types[$type] : $types;
   }

   protected function getSortColumns($type = null, $columns = array())
   {
      $defaults = array(
          'label_names' => array(
              'name' => 'Nazwie',
              'price' => 'Cenie',
              'created_at' => 'Najnowszym'
          ),
          'table_names' => array(
              'name' => ProductI18nPeer::NAME,
              'price' => ProductPeer::OPT_PRICE_BRUTTO,
              'created_at' => ProductPeer::CREATED_AT,
          ),
      );

      $columns = $columns ? array_merge_recursive($defaults, $columns) : $defaults;

      return $type ? $columns[$type] : $columns;
   }

   protected function addSort(Criteria $c)
   {
      $sort_columns = $this->getSortColumns('table_names');

      if ($this->hasRequestParameter('sort_order'))
      {
         $this->getUser()->setAttribute('sort_order', $this->getRequestParameter('sort_order'), 'soteshop/stProduct');
      }

      if ($this->hasRequestParameter('sort_by'))
      {
         $this->getUser()->setAttribute('sort_by', $this->getRequestParameter('sort_by'), 'soteshop/stProduct');
      }

      $this->sort_order = $this->getUser()->getAttribute('sort_order', $this->config->get('sort_asc_desc'), 'soteshop/stProduct');

      $this->sort_by = $this->getUser()->getAttribute('sort_by', $this->config->get('sort_type'), 'soteshop/stProduct');

      if (isset($sort_columns[$this->sort_by]))
      {
         if ($this->sort_order == "asc")
         {
            $c->addAscendingOrderByColumn($sort_columns[$this->sort_by]);
         }
         else
         {
            $c->addDescendingOrderByColumn($sort_columns[$this->sort_by]);
         }
      }
   }

   protected function addType()
   {
      $view_types = $this->getViewTypes('view_names');

      if ($this->hasRequestParameter('type'))
      {
         $this->getUser()->setAttribute('view_type', $this->getRequestParameter('type'), 'soteshop/stProduct');
      }

      $this->type_list_url = $this->getUser()->getAttribute('view_type', $this->config->get('list_type'), 'soteshop/stProduct');

      if (isset($view_types[$this->type_list_url]))
      {
         $this->list_type = $view_types[$this->type_list_url];

         $this->products->setMaxPerPage($this->config->get($this->type_list_url . '_list'));
      }
   }

    public function getProducers() {
        $stNavigation = stNavigation::getInstance($this->getContext());
        $products = $stNavigation->getLastViewedProducts();

        $productsId = array();
        foreach ($products as $product) $productsId[] = $product['id'];
        
        if (count($productsId) == 0) return array();

        $c = new Criteria();
        $c->add(ProductPeer::ID, $productsId, Criteria::IN);
        $c->addJoin(ProductPeer::PRODUCER_ID, ProducerPeer::ID);
        stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stNavigationFrontendActions.postShowHistoryCriteria', array('criteria' => $c)));


        return ProducerPeer::doSelect($c);
    }

   protected function addProducer(Criteria $c)
   {
      $default = stProducer::getSelectedProducerId() ? stProducer::getSelectedProducerId() : 0;
      
      if ($this->hasRequestParameter('producer_filter'))
      {
         $producer_filter = $this->getRequestParameter('producer_filter');

         $this->getUser()->setAttribute('producer_filter', $producer_filter, 'soteshop/stProduct');
      }
      elseif (!$this->hasRequestParameter('page'))
      {
         $this->getUser()->setAttribute('producer_filter', $default, 'soteshop/stProduct');
      }

      $this->producer_filter = $this->getUser()->getAttribute('producer_filter', $default, 'soteshop/stProduct');

      if ($this->producer_filter)
      {
         $c->add(ProductPeer::PRODUCER_ID, $this->producer_filter);
      }
   }

}
