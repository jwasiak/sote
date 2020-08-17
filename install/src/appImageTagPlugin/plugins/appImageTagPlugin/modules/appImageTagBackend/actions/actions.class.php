<?php

class appImageTagBackendActions extends stActions
{
    public function executeShowCategoryImageTags()
    {
        $this->category = CategoryPeer::retrieveByPK($this->getRequestParameter('category_id'));

        if (null === $this->category)
        {
            return sfView::NONE;
        }

        $culture = $this->getRequestParameter('culture');
        $id = $this->getRequestParameter('image_id');

        $this->category->setCulture($culture);

        if ($id)
        {
            $tag = appCategoryImageTagGalleryPeer::retrieveByPK($id);
        }
        else
        {
            $tag = appCategoryImageTagPeer::retrieveByPK($this->category->getId());
        }

        if (null === $tag)
        {
            $c = new Criteria();
            $c->add(appCategoryImageTagGalleryPeer::CATEGORY_ID, $this->category->getId());
            $tag = appCategoryImageTagGalleryPeer::doSelectOne($c);
        }

        $this->tags = array();

        if ($tag)
        {
            $tag->setCulture($culture);

            $tags = $tag->getTags();

            if ($tags)
            {
                $c = new Criteria();
                $c->addSelectColumn(ProductPeer::ID);
                $c->addSelectColumn(ProductPeer::CODE);
                $c->addSelectColumn(ProductPeer::OPT_IMAGE);
                $c->addSelectColumn(ProductPeer::OPT_NAME);
                $c->addSelectColumn(ProductI18nPeer::NAME);
                // $c->add(ProductPeer::CODE, $query);   
                $c->addOr(ProductPeer::ID, array_keys($tags), Criteria::IN);
                
                ProductPeer::setHydrateMethod(array('appImageTagHelper', 'hydrateResponse'));
                $response = ProductPeer::doSelectWithI18n($c, $this->getUser()->getCulture());

                $this->tags = array();

                foreach ($response['data'] as $data)
                {
                    $id = $data['id'];
                    $this->tags[] = array(
                        'id' => $id,
                        'x' => $tags[$id]['x'],
                        'y' => $tags[$id]['y'],
                        'text' => '<p class="remove"><img data-id="'.$id.'" src="/jQueryTools/plupload/images/remove.png" alt="" /></p><img src="'.$data['thumb'].'"  alt="" /><p class="name">'.$data['name'].'</p><p class="code">'.$data['code'].'</p>'
                    );
                }
            }
        } 

        $this->tag = $tag;         
    }

    public function executeProductAutoComplete()
    {
        $query = $this->getRequestParameter('query');

        $c = new Criteria();
        $c->addSelectColumn(ProductPeer::ID);
        $c->addSelectColumn(ProductPeer::CODE);
        $c->addSelectColumn(ProductPeer::OPT_IMAGE);
        $c->addSelectColumn(ProductPeer::OPT_NAME);
        $c->addSelectColumn(ProductI18nPeer::NAME);
        $criterion = $c->getNewCriterion(ProductPeer::CODE, $query.'%', Criteria::LIKE);
          
        $criterion->addOr($c->getNewCriterion(ProductPeer::OPT_NAME, '%'.$query.'%', Criteria::LIKE));
        $c->add($criterion);
        
        ProductPeer::setHydrateMethod(array('appImageTagHelper', 'hydrateResponse'));
        $response = ProductPeer::doSelectWithI18n($c, $this->getUser()->getCulture());
        $response['query'] = $query;
        
        return $this->renderJSON($response);
    }

    public function executeSave() 
    {
        $tags = $this->getRequestParameter('tags');
        $params = $this->getRequestParameter('params');
        $category_id = $this->getRequestParameter('category_id');
        $culture = $this->getRequestParameter('culture');
        $id = $this->getRequestParameter('id');
        
        if (!$id)
        {
            $cit = new appCategoryImageTagGallery();
            $cit->setCategoryId($category_id);

            $tag = appCategoryImageTagPeer::retrieveByPK($category_id);

            if ($tag && $tag->getImage())
            {
                $cit->setImage($tag->getImage());
                $dir = dirname($cit->getImagePath(true));

                if (!is_dir($dir))
                {
                    mkdir($dir, 0755, true);
                }

                rename($tag->getImagePath(true), $cit->getImagePath(true));
            }
        }
        else
        {
            $cit = appCategoryImageTagGalleryPeer::retrieveByPK($id);
        }

        if (null === $cit) 
        {
            $cit = new appCategoryImageTagGallery();
            $cit->setCategoryId($category_id);
        }

        $cit->setTags($tags);

        $cit->setCulture($culture);

        if (isset($params['url']))
        {
            $cit->setUrl($params['url']);
        }

        if (isset($params['description']))
        {
            $cit->setDescription($params['description']);
        }

        if (isset($params['description_color']))
        {
            $cit->setDescriptionColor($params['description_color']);
        }

        $cit->save();

        return sfView::HEADER_ONLY;
    }
}