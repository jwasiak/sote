<?php
use_helper('stUrl', 'stProduct');

$smarty = new stSmarty('stBlogFrontend');

st_theme_use_stylesheet('stProduct.css');

$url_params = array(
    'module' => 'stBlogFrontend',
    'action' => $action,
);

if ($blog_category)
{
    $url_params['url'] = $blog_category->getUrl();
}

if ($blog_pager->haveToPaginate())
{
    $smarty->assign('current_page', $blog_pager->getPage());

    $smarty->assign('last_page', $blog_pager->getLastPage());

    $links = array();

    foreach ($blog_pager->getLinks() as $page)
    {
        $url_params['page'] = $page;
        $links[] = array(
            'page' => $page,
            'url' => st_url_for($url_params),
        );
    }  

    $smarty->assign('first_page', 1);

    $url_params['page'] = $blog_pager->getPreviousPage();

    $smarty->assign('previous_page_url', st_url_for($url_params));

    $url_params['page'] = $blog_pager->getNextPage();

    $smarty->assign('next_page_url', st_url_for($url_params));

    $url_params['page'] = $blog_pager->getLastPage();

    $smarty->assign('last_page_url', st_url_for($url_params));               

    $smarty->assign('current', $blog_pager->getPage());

    $smarty->assign("links", $links);

    $smarty->display('blog_pager.html');
}