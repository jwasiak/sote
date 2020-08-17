<?php
if ($searchResults->haveToPaginate())
{
    stSearch::useFriendlyLink(false);
    $smarty->assign('first_page', st_link_to(st_theme_image_tag('arrow_pager_main_left.png',array('alt'=>__("Pierwsza strona"))),'stSearchFrontend/search?'.urldecode($searchEngine->getPagerParams()).'&page=1'));
    $smarty->assign('previous_page', st_link_to(st_theme_image_tag('arrow_pager_left.png',array('alt'=>__("Poprzednia strona"))),'stSearchFrontend/search?'.urldecode($searchEngine->getPagerParams()).'&page='.$searchResults->getPreviousPage()));
    $links=array();

    foreach ($searchResults->getLinks() as $page)
    {
        $row['page']=link_to_unless($page == $searchResults->getPage(), $page, 'stSearchFrontend/search?'.urldecode($searchEngine->getPagerParams()).'&page='.$page);
        $row['max']=($page != $searchResults->getCurrentMaxLink()) ? ' - ' : ' ';
        $links[]=$row;
    }

    $smarty->assign('next_page', st_link_to(st_theme_image_tag('arrow_pager_right.png',array('alt'=>__("Następna strona"))),'stSearchFrontend/search?'.urldecode($searchEngine->getPagerParams()).'&page='.$searchResults->getNextPage()));
    $smarty->assign('last_page', st_link_to(st_theme_image_tag('arrow_pager_main_right.png',array('alt'=>__("Ostatnia strona"))),'stSearchFrontend/search?'.urldecode($searchEngine->getPagerParams()).'&page='.$searchResults->getLastPage()));
    $smarty->assign('links',$links);

    /** default 2 **/
    $smarty->assign('current_page',$searchResults->getPage());
    $smarty->assign('last_page2',$searchResults->getLastPage());

    $smarty->display('search_pager.html');
    stSearch::useFriendlyLink(true);
}
?>