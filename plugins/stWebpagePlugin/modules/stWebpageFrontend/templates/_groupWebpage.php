<?php
use_helper('stUrl');
st_theme_use_stylesheet('stWebpagePlugin.css');
if ($webpages)
{
    $results = array();
    foreach ($webpages as $index => $webpage)
    {
        $row = array();
        $row['instance'] = $webpage;
        $row['count'] = count($webpages)-1;
        if ($webpage->getOtherLink())
        {   
            if ($webpage->getTarget()==1)
            {
                $options = 'target="_blank"';
            }
            else
            {
                $options = "";
            }

            $row['link'] = '<a href="'.$webpage->getOtherLink().'"'.$options.'>'.$webpage->getName().'</a>';

        }
        else
        {
            $row['link'] = st_link_to($webpage->getName(), 'stWebpageFrontend/index?url='.$webpage->getFriendlyUrl());
        }

        $row['url'] = $webpage->getFriendlyUrl();
        $row['index'] = $index;
        $results[] = $row;
    }
    $smarty->assign('group_page',$group_page);
    $smarty->assign('webpage_group_name', $webpage_group);
    $smarty->assign('webpage_group_id', $id);
    $smarty->assign('results', $results);


    if ($sf_context->getController()->getTheme()->getVersion() >= 2)
    {
        if (($group_page) || ($in_line))
        {
            $smarty->display('webpage_group_line.html');
        }
        else
        {
            $smarty->display('webpage_group.html');
        }
    }
    else
    {
        $smarty->display('webpage_group.html');
    }
}
?>
