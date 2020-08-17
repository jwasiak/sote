<?php
/**
 * SOTESHOP/stThemePlugin
 *
 * Ten plik należy do aplikacji stThemePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stThemePlugin
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stThemeHelper.php 256 2009-03-30 11:49:45Z marek $
 * @author      Marek Jakubowicz <marek.akubowicz@sote.pl>
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

use_helper('Asset');

function st_theme_stylesheet_tag($stylesheet)
{
    $context = sfContext::getInstance();

    $theme = stTheme::getInstance($context);

    $stylesheet_path = $theme->getStylesheetPaths($stylesheet);

    return $stylesheet_path ? stylesheet_tag($stylesheet_path['default']) : null;
}

/**
 * Dodaje plik css ktory ma zostac zalaczony podczas wyswietlania strony
 *
 * @param   string      $stylesheet         Nazwa pliku css umieszczonego w katalogu 'frontend/theme/nazwa_tematu'
 */
function st_theme_use_stylesheet($stylesheet, $position = '', $options = array())
{
    stTheme::useStylesheet($stylesheet, $position, $options);
}

function st_theme_get_content($content_id, $default = null)
{
    $theme = stTheme::getInstance(sfContext::getInstance());

    return $theme->getThemeContent($content_id, $default);
}

/**
 * Zwraca relatywna scieżke url do podanego obrazka
 *
 * @param        string      $source
 * @return   string
 */
function _st_get_image_path($source, $absolute = false)
{
    $image_path = stTheme::getImagePath($source);

    return image_path($image_path, $absolute);
}

/**
 * Zwraca znacznik <img> dla podanego obrazka.
 *
 * @param   string      image               asset name
 * @param   array       additional          HTML compliant <img> tag parameters
 * @return  string      XHTML compliant <img> tag
 * @see image_path
 */
function st_theme_image_tag($source, $options = array())
{
    $source = _st_get_image_path($source);
    return image_tag($source, $options);
}

/**
 * Zwraca znacznik input o typie image dla podanego obrazka
 *
 * @param   string      path                to image file
 * @param   array       additional          HTML compliant <input> tag parameters
 * @return  string      XHTML compliant <input> tag with type="image"
 */
function st_theme_submit_image_tag($source, $options = array())
{
    $source = _st_get_image_path($source);
    return submit_image_tag($source, $options);
}

function st_theme_layout_edit_head()
{
	if (SF_ENVIRONMENT == 'edit') echo st_get_component('stThemeFrontend','editThemeHead');
	else echo content_tag('a', '', array('id' => 'portal-block-list-link', 'name' => 'portal-block-list-link'));
}

function st_theme_layout_edit_foot()
{
    if (SF_ENVIRONMENT == 'edit') echo st_get_component('stThemeFrontend','editThemeFoot');
    else echo content_tag('div', content_tag('div', content_tag('div', '', array('id' => 'magazine1', 'class' => 'portal-column'))), array('id' => 'portal-column-block-list', 'style' => 'display:none'));
}

function st_theme_init_jquery_tools()
{
//   use_javascript('/stCategoryTreePlugin/js/jquery-1.3.2.min.js', 'first');
//   use_javascript('/stCategoryTreePlugin/js/jquery-no-conflict.js', 'first');
   use_javascript('/js/jquery.tools.min.js', 'first');
}