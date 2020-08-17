<?php
use_helper('stUrl');
st_theme_use_stylesheet('stWebpagePlugin.css');
st_theme_use_stylesheet('stErrorPlugin.css');
if ($webpages)
{
    $results = array();
    foreach ($webpages as $webpage)
    {
        $row['link'] = st_link_to($webpage->getName(), 'stWebpageFrontend/index?url='.$webpage->getFriendlyUrl());
        $results[] = $row;
    }
    $smarty->assign('results', $results);
    $smarty->display('webpage_list.html');
}
?>