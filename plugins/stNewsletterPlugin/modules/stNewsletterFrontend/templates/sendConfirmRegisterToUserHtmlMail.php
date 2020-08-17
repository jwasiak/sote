<?php
use_helper('Date', 'stUrl');

$smarty->assign("host", $sf_request->getHost());
$smarty->assign("email", $user->getEmail());
    

$smarty->assign("confirm_link", st_url_for('@stNewsletterConfirm?id=' . $user->getId() . '&hash_code=' . $hash, 'absolute=true'));


$smarty->assign("group", $group);

if($group)
{
    $results=array();
    foreach ($group as $record)
    {
        $row['name']=$record->getName();
        $row['description']=$record->getDescription();
        $results[]=$row;
    }
    $smarty->assign('results',$results);
}

$smarty->assign('date', date("d-m-Y H:i"));

$smarty->assign('user_head', $head);

$smarty->assign('user_foot', $foot);

$smarty->assign('bg_header_color', $mail_config->get('bg_header_color'));

$smarty->assign('bg_footer_color', $mail_config->get('bg_footer_color'));

$smarty->assign('bg_action_color', $mail_config->get('bg_action_color'));

$smarty->assign('bg_action_link_color', $mail_config->get('bg_action_link_color'));

$smarty->assign('link_color', $mail_config->get('link_color'));

$smarty->assign('logo', $mail_config->get('logo'));

$smarty->assign("unregister_link", link_to(__('Usuń mnie z listy'), '@stNewsletterRemove?id=' . $user->getId() . '&hash_code=' . $hash, 'absolute=true'));
$smarty->display("newsletter_mail_confirm_html.html");
?>