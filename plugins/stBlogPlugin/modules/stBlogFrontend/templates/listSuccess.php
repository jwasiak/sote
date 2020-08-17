<?php
use_helper('stText', 'stUrl');
sfLoader::loadHelpers('stProduct', 'stProduct');
st_theme_use_stylesheet('stBlogPlugin.css');

if ($blog_pager)
{
    $results = array();

    foreach ($blog_pager->getResults() as $blog)
    {

        $blog_url = st_url_for('stBlogFrontend/show?url=' . $blog->getFriendlyUrl());

        $row['id'] = $blog->getId();

        $row['active'] = $blog->getActive();

        $row['name'] = $blog->getName();

        if($blog->getAlternativeUrl()){
            $row['link'] = st_link_to($blog->getName(), $blog->getAlternativeUrl());
        }else{
            $row['link'] = st_link_to($blog->getName(), 'stBlogFrontend/show?url=' . $blog->getFriendlyUrl());    
        }
        
        if($blog->getAlternativeUrl()){            
            $row['url'] = $blog->getAlternativeUrl();
        }else{
            $row['url'] = st_url_for('stBlogFrontend/show?url=' . $blog->getFriendlyUrl());    
        }

        $row['short_description'] = st_link_to(st_truncate_text($blog->getShortDescription(), '100', '...'), 'stBlogFrontend/show?url=' . $blog->getFriendlyUrl());        

        $row['untruncated_short_description'] = st_link_to($blog->getShortDescription(), 'stBlogFrontend/show?url=' . $blog->getFriendlyUrl());

        $row['unlinked_short_description'] = st_truncate_text($blog->getShortDescription(), '100', '...');

        $row['clear_short_description'] = $blog->getShortDescription();

        $row['long_description'] = st_link_to(st_truncate_text($blog->getLongDescription(), '100', '...'), 'stBlogFrontend/show?url=' . $blog->getFriendlyUrl());

        $row['untruncated_long_description'] = st_link_to($blog->getLongDescription(), 'stBlogFrontend/show?url=' . $blog->getFriendlyUrl());

        $row['unlinked_long_description'] = st_truncate_text($blog->getLongDescription(), '100', '...');

        $row['clear_long_description'] = $blog->getLongDescription();
        
        if(!$blog->getShortDescription() || $blog->getShortDescription()==""){
            $row['short_description_char_count'] = Blog::trim_post($blog->getLongDescription(), $config->get('list_char_numbers'));
        }else{
            $row['short_description_char_count'] = Blog::trim_post($blog->getShortDescription(), $config->get('list_char_numbers'));    
        }                
        $row['long_description_char_count'] = Blog::trim_post($blog->getLongDescription(), $config->get('list_char_numbers'));

        if ($config->get('date')==2) {

            if($blog->getCreatedAt()){
                $date = explode(" ", $blog->getCreatedAt());
            
                $date =  explode("-", $date[0]);
    
                $row['date'] = $date[2]."-".$date[1]."-".$date[0];    
            }else{
                $row['date'] = "";
            }
               

        } elseif ($config->get('date')==1) {
            
            $date = explode(" ", $blog->getUpdatedAt());
            
            $date =  explode("-", $date[0]);

            $row['date'] = $date[2]."-".$date[1]."-".$date[0];

        } else {

            $row['date'] = NULL;
        }
        if($blog->getAlternativeUrl()){        
            $row['image_main_page_rwd'] = st_link_to(image_tag(st_asset_image_path($blog->getImagePath(), 'thumb', 'blog'), array('alt' => $blog->getName())), $blog->getAlternativeUrl(), array());
        }else{
           $row['image_main_page_rwd'] = st_link_to(image_tag(st_asset_image_path($blog->getImagePath(), 'thumb', 'blog'), array('alt' => $blog->getName())), 'stBlogFrontend/show?url=' . $blog->getFriendlyUrl(), array());
        }
        $row['image_name'] = $blog->getImageMainPage();

        $row['image_main_page'] = st_link_to(image_tag('/'.sfConfig::get('sf_upload_dir_name').'/blog/main/'.$blog->getImageMainPage(), array('alt' => $blog->getName())), 'stBlogFrontend/show?url=' . $blog->getFriendlyUrl());

        $row['image'] = st_link_to(image_tag('/'.sfConfig::get('sf_upload_dir_name').'/blog/post/'.$blog->getImage(), array('alt' => $blog->getName())), 'stBlogFrontend/show?url=' . $blog->getFriendlyUrl(), array());

        $results[] = $row;
    }

    $smarty->assign('date', $config->get('list_date'));
    
    $smarty->assign('show_image', $config->get('list_show_image'));
    
    $smarty->assign('show_title', $config->get('list_show_title'));
    
    $smarty->assign('post_grid', $config->get('list_post_grid'));
    
    $smarty->assign('show_more', $config->get('list_show_more'));    
    
    $smarty->assign('show_image_position', $config->get('list_show_image_position'));
    
    $smarty->assign('display_type', $config->get('list_display_type'));    

    $smarty->assign('results', $results);
        
    $smarty->assign('show_date', $config->get('list_show_date'));

    $smarty->assign('blog_index_url', st_url_for('stBlogFrontend/list'));
    
    if($blog_category){
        $smarty->assign('blog_category_banner', $blog_category->getBannerGroup());   
        $smarty->assign('blog_category', $blog_category->getName());
    }    

    $smarty->assignPartial('pager', 'stBlogFrontend', 'pager', array('blog_pager' => $blog_pager, 'blog_category' => $blog_category, 'action' => 'list'));

    $smarty->display('blog_list.html');
}
?>