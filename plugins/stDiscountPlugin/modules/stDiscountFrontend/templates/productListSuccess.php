<?php
st_theme_use_stylesheet('stProduct.css');
use_helper('stCurrency', 'stImageSize', 'stText', 'stProductPrice', 'stProductPhoto','stUrl');

$smarty->assign('discount_name', $selectDiscount->getName());



if ($pager->getNbResults()>0) {

	if (stTheme::getInstance(sfContext::getInstance())->getVersion() < 7)
	{
		$version_type = $list_type['short'];	
	}else{
		$version_type = $list_type['long'];	
	}


	$smarty->assign('pager', st_get_partial('pager',array('product_pager'=>$pager, 'smarty'=>$productSmarty, 'action' => 'productList', 'for_link'=>$for_link)));
	$smarty->assign('product', st_get_partial('stProduct/'.$version_type,array('product_pager'=>$pager, 'smarty'=>$productSmarty, 'config'=>$configProduct, 'config_points' => $config_points)));
} else {
	$smarty->assign('no_results', __('Do grupy rabatowej %group% nie przypisano jeszcze żadnego produktu',array('%group%'=>$selectDiscount->getName())));
}
$smarty->display('discount_product_list.html');
