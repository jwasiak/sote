<?php
use_helper('stUrl');
st_theme_use_stylesheet('stProduct.css');

if ($product_pager->haveToPaginate()){


    $links=array();

    $smarty->assign('current_page',$product_pager->getPage());
    
    $smarty->assign('last_page',$product_pager->getLastPage());

    if (stTheme::getInstance(sfContext::getInstance())->getVersion() < 7){

    $smarty->assign('first_page','stDiscountFrontend/' . $action . '?discountId=' . $for_link['discountId'] . '&page=1');
    $smarty->assign('previous_page_url','stDiscountFrontend/' . $action . '?discountId=' . $for_link['discountId'] . '&page=' . $product_pager->getPreviousPage());
    $smarty->assign('next_page_url','stDiscountFrontend/' . $action . '?discountId=' . $for_link['discountId'] . '&page=' . $product_pager->getNextPage());
    $smarty->assign('last_page_url','stDiscountFrontend/' . $action . '?discountId=' . $for_link['discountId'] . '&page=' . $product_pager->getLastPage());


            
        foreach ($product_pager->getLinks() as $page)
        {
            if ($page != $product_pager->getPage())
            {
                $row['page']=st_link_to($page, 'stDiscountFrontend/' . $action . '?discountId=' . $for_link['discountId'] . '&page=' .$page);
            }
            else
            {
                $row['page']='<span>'.$page.'</span>';
            }
            $links[] = $row;
        }            

    }else{

        $smarty->assign('next_page_url',st_url_for('stDiscountFrontend/' . $action . '?discountId=' . $for_link['discountId'] . '&page=' . $product_pager->getNextPage()));
        $smarty->assign('previous_page_url',st_url_for('stDiscountFrontend/' . $action . '?discountId=' . $for_link['discountId'] . '&page=' . $product_pager->getPreviousPage()));

        foreach ($product_pager->getLinks() as $page)
        {

        $links[] = array(
            'url' => st_url_for('stDiscountFrontend/' . $action . '?discountId=' . $for_link['discountId'] . '&page=' .$page),
            'page' => $page,
         );

        }

        $smarty->assign('current', $product_pager->getPage());

    }

$smarty->assign("links",$links);

$smarty->display('product_pager.html');

}

?>