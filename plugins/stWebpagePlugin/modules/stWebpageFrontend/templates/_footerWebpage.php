<?php
st_theme_use_stylesheet('stWebpagePlugin.css');
$results = array();
foreach($webpages_groups as $index => $webpages_group)
{
    $row['instance'] = $webpages_group;
    $row['id'] = $webpages_group->getId();
    $results[] = $row;
}

if(WebpagePeer::getContactWebpage()){
    $smarty->assign('contact_link', st_link_to(__('Kontakt'), 'stWebpageFrontend/index?url='.WebpagePeer::getContactWebpage()->getFriendlyUrl()));
};


$smarty->assign('results', $results);

$smarty->display('webpage_footer.html');
?>