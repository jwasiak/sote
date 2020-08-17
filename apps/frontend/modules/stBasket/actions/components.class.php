<?php

/**
 * SOTESHOP/stBasket
 *
 * Ten plik należy do aplikacji stBasket opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stBasket
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 15818 2011-10-27 11:10:12Z marcin $
 */

/**
 * Akcje komponentu basket
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>, Krzysztof Bebło <krzysztof.beblo@sote.pl>
 *
 * @package     stBasket
 * @subpackage  actions
 */
class stBasketComponents extends sfComponents
{

    protected static
    $productConfig = null,
    $basketConfig = null;

    public static $ajaxIncludeOnce = false;

    public function initialize($context)
    {
        $ret = parent::initialize($context);

        if (null === self::$productConfig)
        {
            self::$basketConfig = stConfig::getInstance($context, 'stBasket');
        }

        if (null === self::$productConfig)
        {
            self::$productConfig = stConfig::getInstance($context, 'stProduct');
        }

        return $ret;
    }

    /**
     * Lista produktów w koszyku
     */
    public function executeShow()
    {
        if (self::$productConfig->get('hide_basket') != true)
        {
            $this->smarty = new stSmarty('stBasket');

            $this->basket = stBasket::getInstance($this->getUser());
            $this->config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');
        }
        else
        {
            return sfView::NONE;
        }
    }

    /**
     * Dodawanie do koszyka
     */
    public function executeAdd()
    {
        if (self::$productConfig->get('hide_basket') != true)
        {
            $this->basket_config = self::$basketConfig;

            $this->product_config = self::$productConfig;

            $this->smarty = new stSmarty('stBasket'); // basket - moduleName

            if (!isset($this->simple))
            {
                $this->simple = false;
            }

            if (!isset($this->info))
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
                        
            $this->show_basket = $this->product->getOptHasOptions() <= 1;
        }
        else
        {
            return sfView::NONE;
        }
    }

    public function executeAjaxAddedProductPreview()
    {
      $basket = $this->getUser()->getBasket();

      $items = $basket->getLastAddedItems();

      $products = array();

      sfLoader::loadHelpers(array('Helper', 'stProduct', 'stProductImage', 'stUrl', 'stProductOptions'), 'stProduct');

      $errors = array(
         stBasket::ERR_OUT_OF_STOCK => 'Ilość została zmniejszona z powodu niskiego stanu magazynowego',
         stBasket::ERR_MAX_QTY => 'Ilość została zmniejszona. Maksymalna ilość jaką możesz zamówić w ramach jednego zamówienia to %max_quantity% %uom%',
         stBasket::ERR_MIN_QTY => 'Ilość została zwiększona. Minimalna ilość jaką możesz zamówic to %quantity% %uom%',
         stBasket::ERR_POINTS => 'Brak wymaganej ilości punktów'
      );

      $i18n = $this->getContext()->getI18N();
      $config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');

      $config_product = stConfig::getInstance(sfContext::getInstance(), 'stProduct');

      foreach ($items as $data)
      {
         $item = $data['item'];

         $error_code = $data['error_code'];

         $product = $item->getProduct();

         $uom = st_product_uom($product);

         $products[] = array(
            'instance' => $item,
            'name' => $item->getName(),
            'image' => st_product_image_path($product, 'thumb'),
            'url' => $this->getController()->genUrl('stProduct/show?url='.$product->getUrl()),
            'price' => $item->getPriceBrutto(true),
            'points_value' =>$item->getProduct()->getPointsValue(),
            'points_product' =>$item->getProductForPoints(),
            'points_shortcut' => $config_points->get('points_shortcut', null, true),
            'quantity' => $data['quantity'],
            'uom' => $uom,
            'options' => st_product_options_get_view($item),
            'error' => $error_code < 0 ? $i18n->__($errors[$error_code], array('%quantity%' => $product->getMinQty(), '%max_quantity%' => $product->getMaxQty(), '%uom%' => $uom)) : false
         );
      }

      $this->smarty = new stSmarty('stBasket');

      $this->smarty->assign('basket_url', st_secure_url_for('@stBasket'));

      if ($config_product->get('price_view') == "net_gross" || $config_product->get('price_view') == "only_net" )
      {
        $this->smarty->assign('show_netto', 1);
      } 

      $this->smarty->assign('products', $products);
    }

}