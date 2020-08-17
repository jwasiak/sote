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
 * @version     $Id: components.class.php 17609 2012-04-02 07:40:06Z marcin $
 * @author      Daniel Mendalka <daniel.mendalka@sote.pl>
 */

/** 
 * Komponenty dla modułu stProductOptionsFrontend
 *
 * @author Daniel Mendalka <daniel.mendalka@sote.pl>
 *
 * @package     stProductOptionsPlugin
 * @subpackage  actions
 */
class stProductOptionsFrontendComponents extends sfComponents
{
   /**
    *
    */
   public function executeBasketProductImage()
   {
      sfLoader::loadHelpers(array('stProductOptions'));
      if(preg_match('/[0-9\-]+$/', $this->product->getOptions(), $option_ids)
              && $asset = get_asset_data_for_options($option_ids[0], null, true))
      {
         $this->asset = $asset;
      }
      elseif($this->product->getProduct())
      {
         $this->asset = $this->product->getProduct()->getOptImage();
      }
   }

   /**
    *
    */
   public function executeModifyBasketView()
   {  
      $this->basket_config = stConfig::getInstance($this->getContext(), 'stBasket');

      $this->product_config = $this->product->getConfiguration();

      if (null === $this->selected_options)
      {
         $this->selected_options = stNewProductOptions::getSelectedOptions($this->product);
      }

      if (null === $this->info)
      {
         $this->info = false;
      }

      if ($this->product->getIsStockValidated())
      {
         $this->enabled = null === $this->product->getStock() || $this->product->getStock() >= $this->product->getMinQty();
      }
      else
      {
         $this->enabled = true;
      }      

      $this->options_smarty = new stSmarty('stProductOptionsFrontend');
   }

   /**
    * Displays hidden inputs inside basket_form
    * for passing selected options ids
    */
   public function executeGetProductOptions()
   {
      $this->smarty = new stSmarty('stProductOptionsFrontend');
   }


    public function executeFilter()
    {
        $config = stConfig::getInstance('stProduct');
        if (!$config->get('product_options_filters_enabled') || !isset($this->getContext()->getActionStack()->getLastEntry()->getActionInstance()->product_pager) && !isset($this->criteria))
        {
            return sfView::NONE;
        }

        if ($this->getController()->getTheme()->getVersion() >= 7)
        {
            $filters = array();

            $context = $this->getContext();

            if (isset($this->criteria) && !$config->get('disable_filter_dependency'))
            {
                ProductPeer::addPriceFilterCriteria($context, $this->criteria);
                appProductAttributeHelper::addProductFilterCriteria($context, $this->criteria);
            }

            stNewProductOptions::addOptionsFilterCriteria($context, $this->criteria);

            foreach (stNewProductOptions::getOptionsFilters() as $filter)
            {
                $options = array();

                foreach (stNewProductOptions::getOptionsForFilter($filter) as $option)
                {
                    $options[$option->getId()] = array(
                        'has_color' => !$option->getUseImageAsColor(),
                        'name' => $option->getValue(),
                        'value' => $option->getOptValue(),
                        'color' => $option->getUseImageAsColor() ? $option->getColorImagePath() : $option->getColor(),
                        'color_value' => $option->getColor(),
                    );
                }

                $filters[$filter->getId()] = array(
                    'type' => $filter->getFilterType(),
                    'name' => $filter->getName(),
                    'options' => $options, 
                    'reset_url' => stProductFilter::getFilterResetUrl($context, $filter->getId(), 'options'),
                );
            }

            if (!$filters)
            {
                return sfView::NONE;
            }

            $smarty = new stSmarty('stProductOptionsFrontend');
            $smarty->assign('filters', $filters);
            $smarty->assign('filter_url', stProductFilter::getFilterUrl($context));
            $smarty->assign('reset_url', stProductFilter::getFilterResetUrl($context, 'all', 'options'));
            $smarty->assign('selected', stNewProductOptions::getFilters($context));

            return $smarty;
        }
        else
        {
            $this->productConfig = stConfig::getInstance('stProduct');
            if ($this->getContext()->getModuleName() != 'stProduct' || $this->getContext()->getActionName() != 'list') return sfView::NONE;
            $this->filters = stNewProductOptions::getOptionsFilters();
            $this->smarty = new stSmarty('stProductOptionsFrontend');

            $this->action = $this->getContext()->getActionName();
            $this->module = $this->getContext()->getModuleName();

            $this->params = stNewProductOptions::getFilters($this->getContext());

            $c = new Criteria();
            $c->add(ProductOptionsFilterPeer::FILTER_TYPE, ProductOptionsFilterPeer::PRICE_FILTER);
            $c->addAscendingOrderByColumn(ProductOptionsFilterPeer::PRICE_FROM);

            $this->price_filters = ProductOptionsFilterPeer::doSelect($c);

            if (count($this->filters)+count($this->price_filters)==0) return sfView::NONE;
        }

    }

    public function executeColors() 
    {
        $colors = $this->product->getOptionsColor();

        if (!$colors)
        {
            return sfView::NONE;
        }

        $config = stConfig::getInstance('stProduct');
        $hide_no_stock = $config->get('hide_options_with_empty_stock');
        $nb_colors_on_list = $config->get('nb_colors_on_list');
        
        if (!$config->get('show_colors_on_list',0)) 
        {
            return sfView::NONE;
        }

        $this->avail_colors = array();

        if ($this->product->getStockManagment() != ProductPeer::STOCK_PRODUCT_OPTIONS)
        {
            $hide_no_stock = false;
        }

        foreach ($colors as $value) 
        {
            if (!isset($this->avail_colors[$value['color']]) && (!$hide_no_stock || $value['stock'] > 0)) 
            {
                $this->avail_colors[$value['color']] = $value;
            }
        }

        if (count($this->avail_colors) == 0) return sfView::NONE;

        if($nb_colors_on_list>0 ) $this->avail_colors = array_slice($this->avail_colors, 0, $nb_colors_on_list);
        
        $this->smarty = new stSmarty('stProductOptionsFrontend');
    }
}
