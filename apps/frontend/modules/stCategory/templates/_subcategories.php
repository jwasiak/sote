<?php
use_helper('stText', 'stUrl');
st_theme_use_stylesheet('stCategory.css');
$smarty->assign("subcategories", $subcategories);
$results=array();

foreach ($subcategories as $key => $descendat)
{
    $smarty->assign('height', st_asset_thumbnail_setting('height', 'thumb', 'category'));

    $row['instance'] = $descendat;
    $url['url'] = $descendat->getFriendlyUrl();

    $link = st_url_for($url);

    $row['photo'] = '<a href="'.$link.'">'.st_category_image_tag($descendat, 'thumb').'</a>';

    if ($config->get('cut_subcategories_name')!=1 || (st_check_strlen($descendat->getName())<$config->get('cut_subcategories_name_num')))
    {
        $row['name'] = '<a href="'.$link.'">'.$descendat->getName().'</a>';
    }else
    {
        $row['name'] = '<span title="'.$descendat->getName().'"><a href="'.$link.'">'.st_truncate_text($descendat->getName(),$config->get('cut_subcategories_name_num'),'...').'</a></span>';


    }
    $row['description']=$descendat->getDescription();
    $results[]=$row;
}
$smarty->assign('results',$results);
$smarty->display('category_subcategories.html');
?>
