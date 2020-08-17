<?php

class appImageTagFrontendComponents extends sfComponents 
{
    public function executeShowCategoryImageTags()
    {
        $category = $this->getUser()->getParameter('selected', null, 'soteshop/stCategory');

        if (null === $category || !$category->getIsAppImageTagActive())
        {
            return sfView::NONE;
        }

        $gallery = appCategoryImageTagGalleryPeer::doSelectByCategory($category);

        if (!$gallery)
        {
            $app_image_tag = appCategoryImageTagPeer::retrieveByCategory($category);

            if ($app_image_tag && $app_image_tag->hasImage() && $app_image_tag->getTags())
            {
                $tags = appImageTagHelper::renderTags($app_image_tag->getTags(), isset($this->thumb_type) ? $this->thumb_type : 'small');

                $gallery[$app_image_tag->getId()] = array(
                    'image' => $app_image_tag->getImagePath(),
                    'tags' => $tags,
                );
            }
        }
        else
        {     
            foreach ($gallery as $index => $value)
            {
                $tags = appImageTagHelper::renderTags($value['tags'], isset($this->thumb_type) ? $this->thumb_type : 'small');

                $value['tags'] = $tags;
                $gallery[$index] = $value;
            } 
        }

        if (!$gallery && stTheme::is_responsive())
        {
            return sfView::NONE;
        }

        $smarty = new stSmarty('appImageTagFrontend');

        $smarty->assign('gallery', $gallery);
        $smarty->assign('json_gallery', json_encode($gallery));
        $smarty->assign('count', count($gallery));
        $smarty->assign('view_mode', stConfig::getInstance('stCategory')->get('image_tag_view_mode'));

        sfLoader::loadHelpers(array('Helper', 'stPartial'));


        if (!stTheme::is_responsive())
        {
            if($gallery)
            {
                $smarty->assign('children', st_get_component('stCategory', 'subcategories', array('category' => $category)));
            }
            else
            {
                $smarty->assign('category_info', st_get_component('stCategory', 'info', array("category" => $category)));
            }
        }

        $smarty->assign('category', $category);
        $smarty->assign('show_image', $this->getRequest()->getParameter('page', 1) == 1);

        return $smarty;
    }
}