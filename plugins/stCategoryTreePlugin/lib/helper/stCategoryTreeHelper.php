<?php
/** 
 * SOTESHOP/stCategoryTreePlugin 
 * 
 * Ten plik należy do aplikacji stCategoryTreePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stCategoryTreePlugin
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stCategoryTreeHelper.php 15550 2011-10-12 13:57:53Z marcin $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/** 
 * Includuje drzewo kategorii
 *
 * @param     $root
 * @param     $editable
 * @param     $module_name
 * @param     $ui_provider
 * @param     $params
 * @param     $container_scroll
 * @param     $animated
 * @param     integer
 * @param     $root_href
 */
function st_category_tree_include($root, $editable = false, $module_name = 'stCategoryTree', $ui_provider = 'Ext.tree.stTreeNodeUI', $params = array(), $container_scroll = true, $animated = true, $show_hints = true, $root_href = '')
{
    echo content_tag('div', '', array('id' => 'st_category-tree-' . $root->getId(), 'class' => 'st_category-tree'));

    if (is_null($module_name))
    {
        $module_name = sfContext::getInstance()->getModuleName();
    }

    $culture = sfContext::getInstance()->getUser()->getCulture();

    $root->setCulture($culture);


    use_javascript('/plugins/sfExtjs2Plugin/extjs/adapter/ext/ext-base.js?v1');
    use_javascript('/plugins/sfExtjs2Plugin/extjs/ext-all.js?v1');
    use_javascript(url_for('@stCategoryTreeJS', true).'?sf_culture='.$culture.'&v1');
    use_stylesheet('/plugins/sfExtjs2Plugin/extjs/resources/css/ext-all.css');
    use_stylesheet('/plugins/sfExtjs2Plugin/patches/fixes.css');
    use_stylesheet('/plugins/sfExtjs2Plugin/extjs/resources/css/xtheme-gray.css');

    $tree_panel = sprintf('stCategoryTree.create("%s", %d, \'%s\', %d, %s, %s, %d, %d, %d, \'%s\');', addcslashes($root->getName(), '"'), $root->getId(), $module_name, $editable, $ui_provider, json_encode($params), $container_scroll, $animated, $show_hints, $root_href);
    echo javascript_tag('Ext.onReady(function(){ Ext.SF_SCRIPT_NAME = "'.$_SERVER['SCRIPT_NAME'].'"; '.$tree_panel.'});');
}
