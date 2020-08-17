<?php
/** 
 * SOTESHOP/stBlogPlugin 
 * 
 * Ten plik należy do aplikacji stBlogPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stBlogPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 12100 2013-02-01 07:18:36Z pawel $
 * @author      Paweł Byszewski <pawel.byszewski@sote.pl>
 */


class stBlogBackendActions extends autostBlogBackendActions
{

    protected function saveBlog($blog)
    {

        stFunctionCache::clearFrontendModule('stBlogFrontend');

        stFastCacheManager::clearCache();
        
        parent::saveBlog($blog);
        
        $plupload = stJQueryToolsHelper::parsePluploadFromRequest($this->getRequestParameter('blog_image_main_page'));
    
        if ($plupload['delete'])
        {
            foreach ($plupload['modified'] as $filename)
            {
                $dest = $blog->getGalleryPath($filename, true);
                
                if (is_file($dest))
                {
                    unlink($dest);
                }
            }            
        }

        if ($plupload['modified'])
        {            
            $gallery = array();

            foreach ($plupload['modified'] as $filename)
            {    
                if (is_file($blog->getGalleryPath($filename, true)))
                {
                    $gallery[$filename] = $filename;
                }
                else 
                {
                    $target = uniqid().'-'.$filename;
                    $dest = $blog->getGalleryPath($target, true);
                    $source = $plupload['dir'].'/'.$filename;
                    stJQueryToolsHelper::pluploadCopy($source, $dest);  
                    $gallery[$target] = $target;
                }
            } 

            $blog->setGallery($gallery); 
  
        }

        stJQueryToolsHelper::pluploadCleanup($plupload);                
        
        $blog->save();
        
        
        
        $c = new Criteria();        
        $c -> add(BlogHasBlogCategoryPeer::BLOG_ID, $blog->getId());                        
        BlogHasBlogCategoryPeer::doDelete($c);
        
        $categorysBlog = $this->getRequestParameter('blog[category]');
        
        foreach ($categorysBlog as $key => $value) {
            
            $blogHasCategory = new BlogHasBlogCategory();
            $blogHasCategory->setBlogId($blog->getId());
            $blogHasCategory->setBlogCategoryId($key);        
            $blogHasCategory->save();
                
        }
        
    }

    public function validateEdit()
    {
      if ($this->getRequest()->getMethod() == sfRequest::POST && !$this->getRequestParameter('id'))
      {
         $validator = new stAssetFileValidator();

         $validator->initialize($this->getContext(), array('mime_types' => '@web_images'));

         $value = $this->getRequest()->getFileValues('blog[image_main_page]');

        // if (!$value['name'])
         // {
            // $this->getRequest()->setError('blog{image_main_page}', 'Dodaj zdjęcie wpisu na stronę główną.');
// 
            // return false;
         // }

         // if (!$validator->execute($value, $error))
         // {
            // $this->getRequest()->setError('blog{image_main_page}', $error);
// 
            // return false;
         // }
      }

      return true;

    }

    protected function saveConfig()
    {
        $categorysBlog = $this->getRequestParameter('config[category_home]');
        
        foreach ($categorysBlog as $key => $value) {            
            $homeCategorysBlog[] = $key;        
        }
        
        $this->config->set('blog_category_home', serialize($homeCategorysBlog));
        
        stFunctionCache::clearFrontendModule('stBlogFrontend');

        stFastCacheManager::clearCache();                
        
        $this->config->save();
                
        // echo "<pre>";
        // print_r($this->getRequestParameter('config[category_home]'));
        // die();
    }

    public function executePositioning()
    {
        $i18n = $this->getContext()->getI18N();

        $this->config = stConfig::getInstance(sfContext::getInstance(), 'stBlogBackend');

        $this->config->setCulture($this->getRequestParameter('culture', stLanguage::getOptLanguage()));

        if ($this->getRequest()->getMethod() == sfRequest::POST){

            $this->config->set('title', $this->getRequestParameter('positioning[title]'), true);

            $this->config->set('description', $this->getRequestParameter('positioning[description]'), ture);

            $this->config->set('keywords', $this->getRequestParameter('positioning[keywords]'), true);

            $this->config->save();

            $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));
            
            $this->redirect('stBlogBackend/positioning?culture=' . $this->getRequestParameter('culture', stLanguage::getOptLanguage()));
        }
        
    }

}