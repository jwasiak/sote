<?php
$smarty->assign('form_start', form_tag('stSearchFrontend/search',array('class'=>'st_form', 'method'=>'get')));
$smarty->assign('search_name_label', label_for('st_search_name',__('Nazwa produktu')));
$smarty->assign('search_name', input_tag('st_search[name]',htmlspecialchars(htmlspecialchars_decode($what))));
$smarty->assign('search_detail_label', __('Szukaj w opisach'));
$smarty->assign('search_detail',  checkbox_tag('st_search[detail]',1,$sf_params->get('st_search[detail]',$searchDone?0:$config->get('simple_full_search'))));
$smarty->assign('search_and_search_label', __('Dopasuj wszystkie wyrazy'));
$smarty->assign('search_and_search',  checkbox_tag('st_search[and_search]',1,$sf_params->get('st_search[and_search]',$searchDone?0:$config->get('simple_and_search'))));
$smarty->assign('submit_search', submit_tag(__('Szukaj'),array('id'=>'st_main_search_button')));

/** default2 **/
$smarty->assign('form_start2', form_tag('stSearchFrontend/search',array('class'=>'st_form', 'method'=>'get')));

$smarty->assign('search_and_search',  checkbox_tag('st_search[and_search]',1,$sf_params->get('st_search[and_search]',$searchDone?0:$config->get('advanced_and_search'))));
$smarty->assign('search_detail',  checkbox_tag('st_search[detail]',1,$sf_params->get('st_search[detail]',$searchDone?0:$config->get('advanced_full_search'))));
if ($producer_show) {
	$smarty->assign('search_producer_label', label_for('search_price_type',__('Producent')));
	$smarty->assign('search_producer', select_tag('st_search[producer]',options_for_select($selectProducerList,$sf_params->get('st_search[producer]'))));
}
if ($category_show) {
	$smarty->assign('search_category_label', label_for('search_price_type',__('Kategorie')));
	$smarty->assign('search_category', select_tag('st_search_category',$selectCategoryList,array('multiple' => true)));
}
$smarty->assign('category_show',$category_show);
$smarty->assign('producer_show',$producer_show);
$smarty->assign('search_price_from_label', label_for('search_price_from',__('Cena od')));
$smarty->assign('search_price_to_label', __('do'));
$smarty->assign('search_price_from', input_tag('st_search[price_from]',$sf_params->get('st_search[price_from]')));
$smarty->assign('search_price_to', input_tag('st_search[price_to]',$sf_params->get('st_search[price_to]')));
$smarty->assign('show_advance', input_hidden_tag('showAdvance',$sf_params->get('showAdvance',false))); 
$smarty->assign('advance_search_socket', stSocketView::openComponents('stAdvanceSearch'));
$smarty->assign('switch_simple_search', content_tag('span',__("Szukanie standardowe"),array('class'=>'st_search-mode', 'onclick'=>"$('showAdvance').value=0;$('st_search-advanced').style.display='none';$('st_search-simple').style.display='block';")));
$smarty->assign('switch_advance_search', content_tag('span',__("Szukanie zaawansowane"),array('class'=>'st_search-mode', 'onclick'=>"$('showAdvance').value=1;$('st_search-advanced').style.display='block';$('st_search-simple').style.display='none';")));
$smarty->assign('simple_search', link_to(__("Szukanie standardowe"),'stSearchFrontend/search'));
$smarty->assign('advance_search', link_to(__("Szukanie zaawansowane"),'stSearchFrontend/search?showAdvance=true'));

if (is_object($searchResults) && $searchResults->haveToPaginate())
{
	$smarty->assign('simple_search_producer_filter',select_tag('st_search[producer]',options_for_select($selectProducerList,$sf_params->get('st_search[producer]'))));
}

if($sf_params->get('showAdvance'))
{
	$smarty->display('search_advance_main_search_box.html');
}
else
{
	$smarty->display('search_main_search_box.html');
}
?>

