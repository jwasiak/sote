<?php
use_helper('Date');
$smarty->assign("host", $sf_request->getHost());
$smarty->assign("email", $user->getEmail());
$smarty->assign("confirm_link", "http://". $sf_request->getHost()."/newsletter/confirm/".$user->getId()."/".$hash);
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
$smarty->assign("unregister_link", "http://". $sf_request->getHost()."/newsletter/remove/".$user->getId()."/".$hash);
$smarty->display("newsletter_mail_confirm_plain.html");
?>