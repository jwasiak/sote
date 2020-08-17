<?php
st_theme_use_stylesheet('stCompatibilityPlugin.css');

if(stCompatibilityLaw::isSection("mode_de_countrys") && $compatibility_config->get('mode_de')==1){    
    $smarty->assign('change_price',1);
    
}

if (stCompatibilityLaw::isSection("mode_de_countrys") && $compatibility_config->get('mode_de')==1) {
    
    if(is_object($webpage) && $webpage->getActive()==1){
        $star_description = preg_replace('/{LINK_TO_DELIVERY}/', '<a style="display: inline;" href="'.st_url_for('stWebpageFrontend/index?url='.$webpage->getFriendlyUrl()).'">', $star_description);
        $star_description = preg_replace('/{\/LINK_TO_DELIVERY}/', "</a>", $star_description);
    }else{
        $star_description = preg_replace('/{LINK_TO_DELIVERY}/', '', $star_description);
        $star_description = preg_replace('/{\/LINK_TO_DELIVERY}/', '', $star_description);        
    }
    
    $smarty->assign('star_description', $star_description);
}

$product_config = stConfig::getInstance('stProduct');

if ($sf_context->getModuleName() == 'stFrontendMain' && $sf_context->getActionName() == 'index')
{
    $list_type = 'group';

    $smarty->assign('list_view', $list_type);
    $smarty->assign('price_view', $product_config->get('price_view_'.$list_type));
}
elseif ($sf_context->getModuleName() == 'stProduct' && in_array($sf_context->getActionName(), array("list", "producerList", "groupList")))
{
    $list_type = $sf_user->getAttribute('view_type', $product_config->get('list_type'), 'soteshop/stProduct');

    if ($list_type == "description") 
    {
        $list_type = "long";
    }

    $smarty->assign('list_view', $list_type);
    $smarty->assign('price_view', $product_config->get('price_view_'.$list_type));
}
else
{
    $smarty->assign('list_view', "");
    $smarty->assign('price_view', $product_config->get('price_view'));    
}


$smarty->display('compatibility_show_price_desc_in_footer.html');