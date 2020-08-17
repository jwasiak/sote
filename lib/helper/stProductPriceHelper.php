<?php
/** 
 * SOTESHOP/stProduct 
 * 
 * Ten plik należy do aplikacji stProduct opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stProduct
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stProductPriceHelper.php 617 2009-04-09 13:02:31Z michal $
 */
 
use_helper('stCurrency');

/** 
 * Cena produktu
 *
 * @param         float       $product_price
 * @return   float
 */
function ShowProductPrice($product_price)
{
    $config = stConfig::getInstance(sfContext::getInstance(), array('hide_price' => stConfig::STRING), 'stProduct');
    $config->load();
    if ($config->get('hide_price') == 1)
    {
        return false;
    }
    else 
    {
        return $product_price;
    }
}

function st_product_smarty_price_tag($params)
{
    $product = $params['product'];
    $view = $params['view'];

    if ($product->isPriceVisible())
    {
        $price_view = $product->getConfiguration()->get('price_view_'.$view);

        if ($price_view == 'net_gross')
        {
            return '<div class="double_price price">'.st_currency_format($product->getPriceNetto(true)).'<br />(<span class="minor_price">'.st_currency_format($product->getPriceBrutto(true)).'</span>)</div>';
        }
        elseif ($price_view == 'only_gross')
        {
            return '<div class="price"><span>'.st_currency_format($product->getPriceBrutto(true)).'</span></div>';
        }
        elseif ($price_view == 'only_net') 
        {
            return '<div class="price"><span>'.st_currency_format($product->getPriceNetto(true)).'</span></div>';
        }
        else
        {
            return '<div class="double_price price">'.st_currency_format($product->getPriceBrutto(true)).'<br />(<span class="minor_price">'.st_currency_format($product->getPriceNetto(true)).'</span>)</div>';
        }
    }
    else
    {
        return '<div class="price"></div>';
    }   
}

?>














