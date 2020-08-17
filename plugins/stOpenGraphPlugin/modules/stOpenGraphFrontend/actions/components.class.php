<?php

class stOpenGraphFrontendComponents extends sfComponents
{
    
    public function executeShowOGTags()
    {        
        $scope = sfContext::getInstance()->getModuleName() . '/' . sfContext::getInstance()->getActionName();       

        //echo $scope;

        if($scope == 'stProduct/show')
        {
            sfLoader::loadHelpers('Helper');
            sfLoader::loadHelpers('stUrl');
            sfLoader::loadHelpers('stProductImage');

            $this->url = $this->getController()->genUrl(sfRouting::getInstance()->getCurrentInternalUri(true), true);

            $product = sfContext::getInstance()->getActionStack()->getLastEntry()->getActionInstance()->product; 

            $this->title = $product->getName();

            $this->description = $product->getShortDescription() ? $product->getShortDescription() : $product->getDescription();
            
            $image = $product->getDefaultAssetImage();

            if ($image)
            {
                $this->image = st_product_image_path($image, 'big', true, false, true);
            }
        }
        elseif ($scope == 'stProduct/list')
        {
            sfLoader::loadHelpers('Helper');
            sfLoader::loadHelpers('stUrl');
            sfLoader::loadHelpers('stCategoryImage');

            $this->url = $this->getController()->genUrl(sfRouting::getInstance()->getCurrentInternalUri(true), true);

            $category = $this->getUser()->getParameter('selected', null, 'soteshop/stCategory');

            if (!$category)
            {
                return sfView::NONE;
            }

            $this->title = $category->getName();

            $this->description = $category->getDescription();

            $image = $category->getOptImage();

            if ($image)
            {
                $this->image = st_category_image_path($image, 'big', true, false, true);
            }
        }            
        elseif ($scope == 'stFrontendMain/index')
        {
            $config = stConfig::getInstance($this->getContext(), 'stOpenGraphBackend');        
            $config->setCulture($this->getRequestParameter('culture', stLanguage::getOptLanguage()));
                
            if ($_SERVER['HTTPS'] == "on") {
                $url_base =  "https://".$_SERVER['HTTP_HOST'];   
            }else{
                $url_base =  "http://".$_SERVER['HTTP_HOST'];
            }    
                        
            if($config->get('image', null, true)){
                $this->image = $url_base."/uploads".$config->get('image', null, true);    
            }else{
                $this->image = $url_base.stTheme::getImagePath("logo.png");    
            }
            
            if($config->get('text', null, true)){
               $this->description = $config->get('text', null, true);     
            }else{
                                                                                                                                                   
                $this->description = sfContext::getInstance()->getResponse()->getMetas()['description'];
            }
            
            if($config->get('title', null, true)){
               $this->title = $config->get('title', null, true);     
            }else{                                
                                                
                $this->title = sfContext::getInstance()->getResponse()->getTitle();
            }
            
            $this->url = $this->getController()->genUrl(sfRouting::getInstance()->getCurrentInternalUri(true), true);                   
            
         
        }
        else
        {
            return sfView::NONE;
        }

    }

    
    
}