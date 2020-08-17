<?php
st_theme_use_stylesheet('stReview.css');

if ($review_order)
{
    $smarty->assign('review_order', $review_order);
    $results=array();
    foreach ($review_order as $rev)
    {
        if ($rev->getAgreement()==1 && $are_reviewed)
        {
            $row['done']=$rev->getAgreement()==1 && $are_reviewed;
            $row['show']=link_to(__("Pokaż recenzje"),'/stReview/add?order_id='.$order->getId().'&hash_code='.$order->getHashCode());
        }
        else
        {
            $row['complete']=link_to(__("Dodaj recenzję"),'/stReview/add?order_id='.$order->getId().'&hash_code='.$order->getHashCode());
        }
        $results[]=$row;
    }
    $smarty->assign('results',$results);
}
else
{
    $smarty->assign('add_review', link_to(__("Dodaj recenzję"),'/stReview/add?order_id='.$order->getId().'&hash_code='.$order->getHashCode()));
}
$smarty->display('review_add_review_list.html')
?>