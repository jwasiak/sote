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
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stProductOptionsTreeHelper.php 10577 2011-01-27 13:33:04Z piotr $
 * @author      Daniel Mendalka <daniel.mendalka@sote.pl>
 */



function st_product_options_tree_include($root, $model, $editable = false, $module_name = 'stProductOptionsTreeBackend', $ui_provider = 'Ext.tree.stTreeNodeUI', $params = array('root_name' => ''), $container_scroll = true, $animated = true, $show_hints = true, $root_href = '', $culture)
{    
    $params['add_button_label'] = __('Dodaj','','stProductOptionsBackend');
    $params['del_button_label'] = __('Usuń','','stProductOptionsBackend');
    $params['exp_button_label'] = __('Rozwiń','','stProductOptionsBackend');
    $params['fold_button_label'] = __('Zwiń','','stProductOptionsBackend');
    $params['tpl_button_label'] = __('Szablony','','stProductOptionsBackend');
    $params['tpl_window_label'] = __('Wybierz szablon','','stProductOptionsBackend');   
    $params['tpl_cancel_label'] = __('Anuluj','','stProductOptionsBackend');
    $params['add_button_tooltip'] = __('Dodaj nowe pole i opcje dla niego.','','stProductOptionsBackend');
    $params['del_button_tooltip'] = __('Wybierz pole lub opcje, którą chcesz usunąć','','stProductOptionsBackend');
    $params['exp_button_tooltip'] = __('Rozwiń lub zwiń wszystkie gałęzie drzewa','','stProductOptionsBackend');
    $params['tpl_button_tooltip'] = __('Wstaw szablony','','stProductOptionsBackend');
    $params['new_option_value'] = __('opcja','','stProductOptionsTreeBackend');
    $params['new_field_value'] = __('wartość','','stProductOptionsTreeBackend');
    $params['move_message'] = __('Przenoszenie opcji produktu, prosze czekać...','','stProductOptionsTreeBackend');
    $params['progress_text'] = __('Operacja w toku...','','stProductOptionsTreeBackend');
    $params['product_id'] = $root instanceof ProductOptionsValue ? $root->getProductId() : null;

    echo content_tag('div', '', array('id' => 'st_product_options-tree-' . $root->getId(), 'class' => 'st_product_options-tree', 'onKeyDown' => "if(event.which==27) stProductOptionsTree.get().getRootNode().select()"));
    
    // rozszerzenie mozliwosci standardowego loadera
    $loadFile = new stdClass();
    $loadFile->file = '/stProductOptionsPlugin/js/stProductOptionsTree.js?v17';
    stEventDispatcher::getInstance()->notify(new sfEvent($loadFile, 'stProductOptionsTreeHelper.loadJs', array()));
    
    
    use_javascript('/plugins/sfExtjs2Plugin/extjs/adapter/ext/ext-base.js?v1');
    use_javascript('/plugins/sfExtjs2Plugin/extjs/ext-all.js?v1');
    use_javascript($loadFile->file, 'last');
    use_stylesheet('/plugins/sfExtjs2Plugin/extjs/resources/css/ext-all.css');
    use_stylesheet('/plugins/sfExtjs2Plugin/patches/fixes.css');
    use_stylesheet('/plugins/sfExtjs2Plugin/extjs/resources/css/xtheme-gray.css');
    $tree_panel = sprintf('stProductOptionsTree.create(\'%s\', %d, \'%s\', \'%s\', %d, %s, %s, %d, %d, %d, \'%s\', \'%s\');', (($model == 'ProductOptionsDefaultValue') ? __('Szablon', null, 'stProductOptionsBackend') : '').' '.$params['root_name'], $root->getId(), $model, $module_name, $editable, $ui_provider, json_encode($params), $container_scroll, $animated, $show_hints, $root_href, $culture);
    echo javascript_tag('Ext.onReady(function(){ Ext.SF_SCRIPT_NAME = "'.$_SERVER['SCRIPT_NAME'].'"; '.$tree_panel . '});');
}