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
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stProductImageHelper.php 617 2009-04-09 13:02:31Z michal $
 */

use_helper('stAsset', 'Tag');

function st_product_smarty_image_tag($params)
{
    $product = is_object($params['product']) ? $params['product'] : $params['product']['instance'];

    if (isset($params['include_link']) && $params['include_link'])
    {
        return st_link_to(st_product_image_tag($product, $params['image_type']), 'stProduct/show?url=' . $product->getFriendlyUrl());
    }

    return st_product_image_tag($product, $params['image_type']);
}

/**
 * Zwraca znacznik <img> ze zdjęciem produktu
 *
 * @param Product $product Produkt
 * @param string $thumbnail_type Typ zdjęcia (icon, small, large)
 * @param array $option Opcje HTML
 * @return string HTML znacznik <img>
 */
function st_product_image_tag($product, $thumbnail_type = 'large', $options = array())
{
    $options = _parse_attributes($options);

    if (!isset($options['show_blank']))
    {
        $show_blank = true;
    }
    else
    {
        $show_blank = $options['show_blank'];

        unset($options['show_blank']);
    }

    if ($product instanceof Product)
    {
        if (sfContext::getInstance()->getModuleName() == 'stProduct' && sfContext::getInstance()->getActionName() == 'show')
        {
            $description = $product->getOptImageDescription();
        }
        else
        {
            $description = null;
        }

        $options['alt'] = $description ? $description : $product->getName();
    }

    if (defined('ST_FAST_CACHE_SAVE_MODE') && (ST_FAST_CACHE_SAVE_MODE==1)) return stFastCacheCode::prepareCode('st_asset_image_tag',array('src'=> $product, 'for' => 'product', 'type' => $thumbnail_type, 'options' => $options));

    $src = st_product_image_path($product, $thumbnail_type, $show_blank);

    return image_tag($src, $options);
}

/**
 * Zwraca relatywny adres url lub ścieżke systemową do zdjęcia produktu
 *
 * @param mixed $product Produkt (lub obiekt typu sfAsset)
 * @param string $thumbnail_type Typ zdjęcia
 * @param bool $show_blank Zwróć ścieżkę do obrazka reprezentującego brak zdjęcia
 * @param bool $system_path Zwróć ścieżkę systemową dla zdjęcia (wyklucza parametr $absolute)
 * @param bool $absolute Zwróć pełny adres url
 * @return string
 */
function st_product_image_path($product, $thumbnail_type = 'large', $show_blank = true, $system_path = false, $absolute = false)
{
   $ret = st_asset_image_path($product, $thumbnail_type, 'product', $system_path, $absolute);

   if (!$ret && $show_blank)
   {
      $ret = st_asset_image_path('media/shares/no_image.png', $thumbnail_type, 'product', $system_path, $absolute);
   }

   return $ret;
}