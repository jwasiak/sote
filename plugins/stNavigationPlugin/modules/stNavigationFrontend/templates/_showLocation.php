<?php
use_helper('stUrl');

if (empty($smarty)) $smarty = new stSmarty('stNavigationFrontend');
st_theme_use_stylesheet('stNavigationPlugin.css');


$stNavigation = stNavigation::getInstance($sf_context);

/**
 * Ustawienie wyświetlania paska nawigacji 
 */
$smarty->assign('configOn', $stNavigation->getConfig('bar'));
if($stNavigation->getConfig('navigation') == 0 && $stNavigation->getConfig('history') == 0) $smarty->assign('configOn', 0);
$smarty->assign('configViewType', $stNavigation->getConfig('view_type'));

/**
 * Ustawianie zmiennych dla breadcrums
 */
$navigationPath = $stNavigation->getNavigationPath();

$hasNavigationPath = false;
if($navigationPath)
{
    $hasNavigationPath = true;
} else {
	$hasNavigationPath = false;
}

if($stNavigation->getConfig('navigation') == 0) $hasNavigationPath = false;

$smarty->assign('navigationPath', $navigationPath);
$smarty->assign('navigationPathCount', count($navigationPath));
$smarty->assign('hasNavigationPath', $hasNavigationPath);
$smarty->assign('configNavigationStartName', $stNavigation->getConfig('navigation_start_name', true));
$smarty->assign('configDecrease', $stNavigation->getConfig('decrease'));

/**
 * Ładowanie partiala stNavigationFrontend/navigationBreadcrumbs
 */
$params = array('hasPath' => $hasNavigationPath,
                'viewType' => $stNavigation->getConfig('view_type'),
                'homepageLink' => st_link_to($stNavigation->getConfig('navigation_start_name', true), '@homepage'),
                'navigationPath' => $navigationPath,
                'decrease' => $stNavigation->getConfig('decrease'),
                'navigationPathCount' => count($navigationPath),
                );
                
$smarty->assign('navigationBreadcrumbs', st_get_partial('stNavigationFrontend/navigationBreadcrumbs', $params));

/**
 * Ustawianie zmiennych dla histori
 */
if ($stNavigation->getConfig('historyOn')) $stNavigation->saveLastViewedProducts();

$lastViewedProduct = $stNavigation->getLastViewedProduct();
$hasHistoryLink = $stNavigation->getConfig('history_link') ? true : false;

$hasLastViewedProduct = false;
if ($lastViewedProduct && $hasNavigationPath) $hasLastViewedProduct = true;
if ($stNavigation->getConfig('history') == 0 || $stNavigation->getConfig('historyOn') == 0) $hasLastViewedProduct = false;

/**
 * Przekazywanie danych do pliku template
 */
	$smarty->assign('hasLastViewedProduct', $hasLastViewedProduct);
	$smarty->assign('hasLastViewedProductHistoryLink', $hasHistoryLink);
	$smarty->assign('lastViewedProduct', $lastViewedProduct);

/**
 * Ładowanie partiala stNavigationFrontend/navigationHistory
 */
$params = array('hasProduct' => $hasLastViewedProduct, 
                'viewType' => $stNavigation->getConfig('view_type'),
                'productLink' => @st_link_to(@$lastViewedProduct['name'], @$lastViewedProduct['link']),
                'historyLink' => $hasHistoryLink ? st_link_to(__('Historia'), 'stNavigationFrontend/showHistory') : __('Historia'),
                'fastcache' => false,
                );

/**
 * Wyłącz historie w przypadku zapisywania strony
 */
if (defined(ST_FAST_CACHE_SAVE_MODE) || defined(ST_FAST_CACHE_DEFAULT_MODE) || file_exists(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'fastcache'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'fast_cache_enabled'))
{
	$params['fastcache'] = true;
}

$smarty->assign('navigationHistory', st_get_partial('stNavigationFrontend/navigationHistory', $params));

$smarty->display('navigation_show_location.html');