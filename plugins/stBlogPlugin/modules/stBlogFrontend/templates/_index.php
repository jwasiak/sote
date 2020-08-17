<?php

use_helper('stText', 'stUrl');

st_theme_use_stylesheet('stBlogPlugin.css');

if ($blogs) {

    $results = array();

    foreach($blogs as $index => $blog)

    {

        $blog_url = st_url_for('stBlogFrontend/show?url=' . $blog->getFriendlyUrl());

        $results[$index]['instance'] = $blog;

        $results[$index]['id'] = $blog->getId();

        $results[$index]['active'] = $blog->getActive();

        $results[$index]['name'] = $blog->getName();

        if($blog->getAlternativeUrl()){
            $results[$index]['link'] = st_link_to($blog->getName(), $blog->getAlternativeUrl());
        }else{
            $results[$index]['link'] = st_link_to($blog->getName(), 'stBlogFrontend/show?url='.$blog->getFriendlyUrl());    
        }

        if($blog->getAlternativeUrl()){
            $results[$index]['url'] = $blog->getAlternativeUrl();
        }else{
            $results[$index]['url'] = st_url_for('stBlogFrontend/show?url=' . $blog->getFriendlyUrl());
        }        
        
        $results[$index]['short_description'] = st_link_to(st_truncate_text($blog->getShortDescription(), '100', '...'), 'stBlogFrontend/show?url='.$blog->getFriendlyUrl());

        $results[$index]['untruncated_short_description'] = st_link_to($blog->getShortDescription(), 'stBlogFrontend/show?url='.$blog->getFriendlyUrl());

        $results[$index]['unlinked_short_description'] = st_truncate_text($blog->getShortDescription(), '100', '...');

        $results[$index]['unlinked_short_description_300'] = st_truncate_text($blog->getShortDescription(), '300', '...');

        $results[$index]['clear_short_description'] = $blog->getShortDescription();

        $results[$index]['long_description'] = st_link_to(st_truncate_text($blog->getLongDescription(), '100', '...'), 'stBlogFrontend/show?url='.$blog->getFriendlyUrl());

        $results[$index]['untruncated_long_description'] = st_link_to($blog->getLongDescription(), 'stBlogFrontend/show?url='.$blog->getFriendlyUrl());

        $results[$index]['unlinked_long_description'] = st_truncate_text($blog->getLongDescription(), '100', '...');

        $results[$index]['clear_long_description'] = $blog->getLongDescription();
        
        if(!$blog->getShortDescription() || $blog->getShortDescription()==""){
            $results[$index]['short_description_char_count'] = Blog::trim_post($blog->getLongDescription(), $config->get('char_numbers'));
        }else{
            $results[$index]['short_description_char_count'] = Blog::trim_post($blog->getShortDescription(), $config->get('char_numbers'));    
        }        
        
        $results[$index]['long_description_char_count'] = Blog::trim_post($blog->getLongDescription(), $config->get('char_numbers'));

        if ($config->get('date')==2) {
                        
            $date = explode(" ", $blog->getCreatedAt());
            
            $date =  explode("-", $date[0]);

            $results[$index]['date'] = $date[2]."-".$date[1]."-".$date[0];   

        } elseif ($config->get('date')==1) {            
            
            $date = explode(" ", $blog->getUpdatedAt());
            
            $date =  explode("-", $date[0]);

            $results[$index]['date'] = $date[2]."-".$date[1]."-".$date[0];

        } else {

            $results[$index]['date'] = NULL;
        }                
        
        if($blog->getAlternativeUrl()){
            $results[$index]['image_main_page_rwd'] = st_link_to(image_tag(st_asset_image_path($blog->getImagePath(), 'thumb', 'blog'), array('alt' => $blog->getName())), $blog->getAlternativeUrl(), array());
        }else{
            $results[$index]['image_main_page_rwd'] = st_link_to(image_tag(st_asset_image_path($blog->getImagePath(), 'thumb', 'blog'), array('alt' => $blog->getName())), 'stBlogFrontend/show?url='.$blog->getFriendlyUrl(), array());    
        }
        
        
        $results[$index]['image_name'] = $blog->getImageMainPage();

        $results[$index]['image_main_page'] = st_link_to(image_tag('/'.sfConfig::get('sf_upload_dir_name').'/blog/main/'.$blog->getImageMainPage(), array('alt' => $blog->getName())), 'stBlogFrontend/show?url='.$blog->getFriendlyUrl(), array());

        $results[$index]['image'] = st_link_to(image_tag('/'.sfConfig::get('sf_upload_dir_name').'/blog/post/'.$blog->getImage(), array('alt' => $blog->getName())), 'stBlogFrontend/show?url='.$blog->getFriendlyUrl(), array());

    }

    $smarty->assign('date', $config->get('date'));
    
    $smarty->assign('show_image', $config->get('show_image'));
    
    $smarty->assign('show_title', $config->get('show_title'));
    
    $smarty->assign('post_grid', $config->get('post_grid'));
    
    $smarty->assign('show_more', $config->get('show_more'));    
    
    $smarty->assign('show_image_position', $config->get('show_image_position'));
    
    $smarty->assign('show_date', $config->get('show_date'));   
    
    $smarty->assign('display_type', $config->get('display_type')); 

    $smarty->assign('results', $results);

    $smarty->display('blog_box.html');

}

?>