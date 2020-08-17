<?php
if ($pager->haveToPaginate())
{
    $smarty->assign('currentPage', $page);
    $smarty->assign('lastPageNumber', $pager->getLastPage());
    $smarty->assign('firstPage', link_to(image_tag('/images/frontend/theme/default/arrow_pager_main_left.png', array('alt'=>__("Pierwsza strona"))), 'stNavigationFrontend/showHistory?page=1'));
    $smarty->assign('previousPage', link_to(image_tag('/images/frontend/theme/default/arrow_pager_left.png', array('alt'=>__("Poprzednia strona"))), 'stNavigationFrontend/showHistory?page='.$pager->getPreviousPage()));
    $pages = array();
    foreach ($pager->getLinks() as $page)
    {
        $row['page'] = link_to_unless($page == $pager->getPage(), $page, 'stNavigationFrontend/showHistory?page='.$page);
        $row['max'] = ($page != $pager->getCurrentMaxLink()) ? ' - ' : ' ';
        $pages[] = $row;
    }
    $smarty->assign('nextPage', link_to(image_tag('/images/frontend/theme/default/arrow_pager_right.png',array('alt'=>__("Następna strona"))), 'stNavigationFrontend/showHistory?page='.$pager->getNextPage()));
    $smarty->assign('lastPage', link_to(image_tag('/images/frontend/theme/default/arrow_pager_main_right.png',array('alt'=>__("Ostatnia strona"))), 'stNavigationFrontend/showHistory?page='.$pager->getLastPage()));
    $smarty->assign('pages', $pages);
    $smarty->display('navigation_pager.html');
}
?>