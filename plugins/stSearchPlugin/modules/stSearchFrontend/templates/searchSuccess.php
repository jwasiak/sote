<?php
st_theme_use_stylesheet('stProduct.css','stSearch.css');
use_helper('stCurrency', 'stImageSize', 'stText', 'stProductPrice', 'stProductPhoto','stUrl');

$smarty->assign('what', strlen($what)?": ".htmlspecialchars(htmlspecialchars_decode($what)):'');
$smarty->assign('main_search_box', st_get_component('stSearchFrontend','mainSearchBox',array('showAdvance'=>$sf_params->get('showAdvance'), 'what'=>$what, 'smarty'=>$smarty, 'config'=>$config, 'searchEngine'=>$searchEngine, 'searchResults'=>$searchResults, 'searchDone'=>$searchDone)));

if ($searchResults)
{
    if ($searchResults->getNbResults()>0)
    {
        $smarty->assign('producers',st_get_component('stSearchFrontend','producers',array('searchEngine'=>$searchEngine,'searchCriteria'=>$searchCriteria, 'smarty'=>$smarty)));
        $smarty->assign('sort',st_get_partial('sort',array('for_link'=>$searchEngine->getPagerParams(true), 'smarty'=>$smarty, 'sort_labels' => $sort_data,'action' => 'search')));
        $smarty->assign('pager', st_get_partial('pager',array('searchResults'=>$searchResults, 'searchEngine'=>$searchEngine, 'smarty'=>$smarty)));
        $smarty->assign('product', st_get_partial('stProduct/'.$config->get('list_type'),array('product_pager'=>$searchResults, 'smarty'=>$productSmarty, 'what'=>$what, 'config'=>$configProduct, 'config_points'=>$config_points)));
        $smarty->assign('product_all',$searchResults->getnbResults());

    }
    elseif (!$searchDone)
    {
        $smarty->assign('no_query', st_get_partial('no_query',array('searchResults'=>null, 'smarty'=>$smarty, 'min_len'=>3)));
    }
    else
    {
        $smarty->assign('no_results', st_get_partial('no_results',array('searchResults'=>null, 'smarty'=>$smarty)));
    }
}
else
{
    $smarty->assign('no_query', st_get_partial('no_query',array('searchResults'=>null, 'smarty'=>$smarty, 'min_len'=>3)));
}

$smarty->display('search_search.html');
?>
