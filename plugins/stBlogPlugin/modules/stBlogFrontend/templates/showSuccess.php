<?php
st_theme_use_stylesheet('stBlogPlugin.css');

$url_params = array(
    'module' => 'stBlogFrontend',
    'action' => 'list',
);

if(!empty($blog)) {

	$smarty->assign('config_date', $config->get('date'));

    if ($config->get('date')==2) {
                
        $date = explode(" ", $blog->getCreatedAt());
            
        $date =  explode("-", $date[0]);

        $date = $date[2]."-".$date[1]."-".$date[0];

    } elseif ($config->get('date')==1) {

        
        $date = explode(" ", $blog->getUpdatedAt());
            
        $date =  explode("-", $date[0]);

        $date = $date[2]."-".$date[1]."-".$date[0];

    } else {

        $date = NULL;

    }    
    
    sfContext::getInstance()->getResponse()->setTitle($blog->getName());
    

    $smarty->assign('name', $blog->getName());
        
    $smarty->assign('show_date', $config->get('post_show_date'));
    
    $smarty->assign('show_gallery', $config->get('post_show_gallery'));
    
    $smarty->assign('show_gallery_thumb', $config->get('post_show_gallery_thumb'));
    
    if ($blog_category)
    {
        $url_params['url'] = $blog_category->getUrl();
        $smarty->assign('blog_category_url', st_url_for($url_params));
        $smarty->assign('blog_category', $blog_category->getName());
    }

    $smarty->assign('image_main_page', image_tag('/'.sfConfig::get('sf_upload_dir_name').'/blog/main/'.$blog->getImageMainPage(), array('alt' => '')));

    if($blog->getImage()!=""){
        $smarty->assign('image', image_tag('/'.sfConfig::get('sf_upload_dir_name').'/blog/post/'.$blog->getImage(), array('alt' => '')));    
    }else{
        $smarty->assign('image', image_tag('/'.sfConfig::get('sf_upload_dir_name').'/blog/main/'.$blog->getImageMainPage(), array('alt' => '')));
    }

    if($blog->getGallery()){
        
        $gallery = array();        
        foreach ($blog->getGallery() as $image) {
            $gallery[] = '/'.sfConfig::get('sf_upload_dir_name').'/blog/main/'.$image;
        }        
        
        $smarty->assign('gallery', $gallery);
    }else{
        
        if($blog->getImageMainPage()){
            $gallery = array();        
            $gallery[] = '/'.sfConfig::get('sf_upload_dir_name').'/blog/main/'.$blog->getImageMainPage();                        
            $smarty->assign('gallery', $gallery);    
        }        
    }    	

	$smarty->assign('date', $date);
    
    $smarty->assign('post_show_sidebar', $config->get('post_show_sidebar'));        

    $smarty->assign('short_description', $blog->getShortDescription());

    if (!$blog->getLongDescription())
    {

        $smarty->assign('long_description', $blog->getShortDescription());

    } else {

        $smarty->assign('long_description', $blog->getLongDescription());

    }

}

if ($blogs)
{
    $results = array();

    foreach ($blogs as $blog)
    {

        $blog_url = st_url_for('stBlogFrontend/show?url=' . $blog->getFriendlyUrl());

        $row['id'] = $blog->getId();

        $row['active'] = $blog->getActive();

        $row['name'] = $blog->getName();
    
        if($blog->getAlternativeUrl()){
            $row['link'] = st_link_to($blog->getName(), $blog->getAlternativeUrl());

            $row['url'] = $blog->getAlternativeUrl();                                                    
        }else{
            $row['link'] = st_link_to($blog->getName(), 'stBlogFrontend/show?url=' . $blog->getFriendlyUrl());

            $row['url'] = st_url_for('stBlogFrontend/show?url=' . $blog->getFriendlyUrl());                                                        
        }

        
        $results[] = $row;
    }

$smarty->assign('results', $results);
}

if ($categorys)
{
    $results = array();

    foreach ($categorys as $category)
    {
        $url_params['url'] = $category->getUrl();

        $row['id'] = $category->getId();        

        $row['name'] = $blog->getName();

        $url = st_url_for($url_params);

        $row['link'] = '<a href="'.$url.'">'.$category->getName().'</a>';

        $row['url'] = $url;                                        

        $results[] = $row;
    }

$smarty->assign('categorys', $results);
}

$smarty->assign('blog_index_url', st_url_for('stBlogFrontend/list'));

$smarty->display('blog_show.html');

?>