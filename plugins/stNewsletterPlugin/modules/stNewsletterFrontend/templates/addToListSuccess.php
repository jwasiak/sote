<?php
use_helper('Validation');
st_theme_use_stylesheet('stNewsletterPlugin.css');
$smarty->assign("email",$email);
$smarty->assign("choseGroup",$choseGroup);

if ($choseGroup)
{
    $results=array();
    foreach ($choseGroup as $group)
    {
        $row['name']=$group->getName();
        $row['description']=$group->getDescription();
        $results[]=$row;
    }
    $smarty->assign('results',$results);
}

$smarty->display("newsletter_add_to_list.html");
?>