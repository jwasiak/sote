<?php
/** 
 * SOTESHOP/stCategory
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
 * @version     $Id: stCategoryImageHelper.php 9465 2010-11-25 10:55:01Z marcin $
 */

use_helper('stAsset', 'Tag', 'stUrl');

/**
 * Zwraca znacznik <img> ze zdjęciem kategorii
 *
 * @param Category $category Kategoria
 * @param string $thumbnail_type Typ zdjęcia (icon, small, large)
 * @param array $option Opcje HTML
 * @return string HTML znacznik <img>
 */
function st_category_image_tag($category, $thumbnail_type = 'large', $options = array())
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

    if ($category instanceof Category)
    {
        $options['alt'] = $category->getName();
    }

    if (defined('ST_FAST_CACHE_SAVE_MODE') && (ST_FAST_CACHE_SAVE_MODE==1)) return stFastCacheCode::prepareCode('st_asset_image_tag',array('src'=> $category, 'for' => 'category', 'type' => $thumbnail_type, 'options' => $options));

    return image_tag(st_category_image_path($category, $thumbnail_type, $show_blank), $options);
}

/**
 * Zwraca znacznik <img> ze zdjęciem kategorii
 *
 * @param Category $category Kategoria
 * @param string $thumbnail_type Typ zdjęcia (icon, small, large)
 * @param array $option Opcje HTML
 * @return string HTML znacznik <img>
 */
function st_category_image_link_to($category, $thumbnail_type = 'large', $options = array())
{
    return st_link_to(st_category_image_tag($category, $thumbnail_type, $options), 'stProduct/list?url='. $category->getFriendlyUrl());
}

/**
 * Zwraca relatywny adres url lub ścieżke systemową do zdjęcia kategorii
 *
 * @param mixed $category Kategoria (lub obiekt typu sfAsset)
 * @param string $thumbnail_type Typ zdjęcia
 * @param bool $show_blank Zwróć ścieżkę do obrazka reprezentującego brak zdjęcia
 * @param bool $system_path Zwróć ścieżkę systemową dla zdjęcia (wyklucza parametr $absolute)
 * @param bool $absolute Zwróć pełny adres url
 * @return string
 */
function st_category_image_path($category, $thumbnail_type = 'large', $show_blank = true, $system_path = false, $absolute = false)
{
   $ret = st_asset_image_path($category, $thumbnail_type, 'category', $system_path, $absolute);

   if (!$ret && $show_blank)
   {
      $ret = st_asset_image_path('media/shares/no_image.png', $thumbnail_type, 'category', $system_path, $absolute);
   }

   return $ret;
}