<?php
st_theme_use_stylesheet('stNewSearch.css');
use_helper('XssSafe', 'stJQueryTools', 'stUrl', 'stAsset');
use_javascript('/jQueryTools/jquery/effects.core.js');
use_javascript('/js/stSearch.js');
$smarty->assign('search_input', input_auto_complete_tag('query', $search->getQuery(), 'stNewSearchFrontend/newSearchAjax',array('autocomplete'=>'off'),array('use_style'=> true)));
$smarty->assign('form_start', form_tag('stSearchFrontend/search', array('method' => 'get')));
if ($search->getQuery() != '' && count($results)==0 && !$isAjax) $smarty->assign('no_results',1);
if (count($results)==$search->getPageLimit()) $smarty->assign('more',content_tag('button',__('Więcej wyników',null,'stSearchFrontend'),array('id'=>'st_search_more_button')));
$smarty->assign('list',st_get_component('stNewSearchFrontend','list',array('results'=>$results, 'search'=>$search)));
if ($isAjax) $smarty->display('search_ajax.html'); else $smarty->display('search.html');

