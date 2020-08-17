<?php
use_helper('stReview', 'Text');
st_theme_use_stylesheet('stReview.css');
st_theme_use_stylesheet('stUser.css');
st_theme_use_stylesheet('stOrder.css');

$smarty->assign('user_panel_icon', image_tag('/images/frontend/theme/default/user_panel_icon.png'));
$smarty->assign('my_account', link_to(__('Moje konto'), 'stUserData/userPanel'));
$smarty->assign('user_panel_menu', st_get_component('stUserData', 'userPanelMenu'));
$smarty->assign('order_reviews_link', link_to(__("Recenzje zamówień"),'review/listUserOrderReviews'));
$smarty->assign('product_reviews_link', link_to(__("Recenzje produktów"),'review/listUserProductReviews'));

if ($reviews_order)
{
    $smarty->assign('reviews_order', $reviews_order);
    $results=array();

    foreach ($reviews_order as $review_order)
    {
        if ($review_order->getOrder())
        {
            $row['review_has_order']=$review_order->getOrder();
            $row['order_link']=link_to($review_order->getOrder()->getNumber(), '@stOrderListShowForUser?id=' . $review_order->getOrder()->getId() . '&hash_code=' . $review_order->getOrder()->getHashCode());
        }
        else
        {
            $row['order_link']=$review_order->getOrderNumber();
        }

        $row['created_at']=$review_order->getCreatedAt();
        $row['description']=truncate_text($review_order->getDescription(), 40);
        $row['mark']=getMarkName($review_order->getMark());

        $results[]=$row;
    }
    $smarty->assign('results',$results);
}
$smarty->display('review_list_user_order_reviews.html');
?>