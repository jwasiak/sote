<?php
use_helper('Validation', 'Object');
st_theme_use_stylesheet('stReview.css');

$smarty->assign('form_start', form_tag('stReview/send?order_id='.$order->getId().'&hash_code='.$order->getHashCode()));

if ($reviewed_order)
{
    $smarty->assign('reviewed_order', $reviewed_order);
    $smarty->assign('radiobutton_positive_done', radiobutton_tag("mark", '1', $transaction->getMark()==1, array('disabled' => true)));
    $smarty->assign('radiobutton_neutral_done',  radiobutton_tag("mark", '2', $transaction->getMark()==2, array('disabled' => true)));
    $smarty->assign('radiobutton_nagative_done', radiobutton_tag("mark", '3', $transaction->getMark()==3, array('disabled' => true)));
    $smarty->assign('description_done',  $transaction->getDescription());

    if ($agreement)
    {
        $smarty->assign('agreement', $agreement);
        $smarty->assign('agreement_checkbox_done', checkbox_tag("agreement", 1, true, array('disabled' => true)));
    }
    else
    {
        $smarty->assign('input_hidden_transation_id', input_hidden_tag('transaction_id', $transaction->getId()));
        $smarty->assign('agreement_checkbox', checkbox_tag("agreement", 1, false));
        $smarty->assign('save_submit', submit_tag(__('Zapisz')));
    }
}
else
{
    $smarty->assign('radiobutton_positive', radiobutton_tag("mark", '1', true));
    $smarty->assign('radiobutton_neutral', radiobutton_tag("mark", '2', false));
    $smarty->assign('radiobutton_negative', radiobutton_tag("mark", '3', false));
    $smarty->assign('description',  textarea_tag("description", '', array ('id' => 'description', 'rich' => false, 'tinymce_options' => "height:150,width:480,theme:'simple'")));
    $smarty->assign('agreement_checkbox_checked',  checkbox_tag("agreement", 1, true));
    $smarty->assign('save_submit', submit_tag(__('Zapisz')));
}
$smarty->display('review_transaction_review.html');
?>