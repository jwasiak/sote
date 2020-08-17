<?php
use_helper('stReview', 'Text');
st_theme_use_stylesheet('stReview.css');

st_theme_use_stylesheet('stUser.css');
$smarty->assign('user_panel_icon', image_tag('/images/frontend/theme/default/user_panel_icon.png'));
$smarty->assign('my_account', link_to(__('Moje konto'), 'stUserData/userPanel'));
$smarty->assign('user_panel_menu', st_get_component('stUserData', 'userPanelMenu'));
$smarty->assign('order_reviews_link', link_to(__('Recenzje zamówień'),'review/listUserOrderReviews'));
$smarty->assign('product_reviews_link', link_to(__('Recenzje produktów'),'review/listUserProductReviews'));

if ($reviews)
{
    $smarty->assign('reviews', $reviews);
    $results=array();
    foreach ($reviews as $review)
    {
        $row['product']=link_to($review->getProduct(), "stReview/add?order_id=".$review->getOrderId().'&hash_code='.$review->getOrder()->getHashCode());
        $row['order_number']=$review->getOrderNumber();
        $row['created_at']=$review->getCreatedAt();
        $row['description']=truncate_text($review->getDescription(),40);
        $row['score']=$review->getScore();
        $row['agreement']=$review->getAgreement();
        $row['active']=$review->getActive();
        $results[]=$row;
    }
    $smarty->assign('results', $results);
}
$smarty->display('review_list_user_prododuct_review.html');
?>