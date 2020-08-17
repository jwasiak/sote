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

class stBlogFrontendActions extends stActions
{

    public function executeShow()
    {
        $this->smarty = new stSmarty('stBlogFrontend');

        $config = stConfig::getInstance(sfContext::getInstance(), 'stBlogBackend');
        
        if($config->get('active')==0)
        {            
            return $this->redirect('/');
        }        

        $this->config = $config;

        if (!$this->process301Redirects())
        {
            $this->getUser()->setParameter('status-404', true);

            return $this->forward404();
            //return $this->forward('stBlogFrontend', 'list');
        }

        if (!$this->processFriendlyUrl())
        {
            $this->getUser()->setParameter('status-404', true);
            
            return $this->forward404();
            //return $this->forward('stBlogFrontend', 'list');
        }

        $blog_category = null;
        
        if($this->getRequestParameter('category')){            
            $this->getUser()->setAttribute("blog_category_id", $this->getRequestParameter('category'));
            $blog_category_id = $this->getRequestParameter('category');
            $blog_category = BlogCategoryPeer::retrieveByPK($blog_category_id);
        }
        else
        {
            $blog_category_id = $this->getUser()->getAttribute("blog_category_id");
            $blog_category = BlogCategoryPeer::retrieveByPK($blog_category_id);
        }
        
        $this->blog_category = $blog_category;

        $c = new Criteria();
        $c->add(BlogPeer::ACTIVE, 1);
                
        if($config->get('post_number')!="")
        {
            $c->setLimit($config->get('post_number'));
        }
        
        // if($config->get('date')==1)
        // {
            // $c->addDescendingOrderByColumn(BlogPeer::UPDATED_AT);
        // }
        // else
        // {
            $c->addDescendingOrderByColumn(BlogPeer::CREATED_AT);
        //}
        
        $this->blogs = BlogPeer::doSelect($c);
        
        
        $c = new Criteria();        
        $c -> add(BlogCategoryPeer::ACTIVE, 1);
        $c->addJoin(BlogHasBlogCategoryPeer::BLOG_CATEGORY_ID, BlogCategoryPeer::ID);
        $c->addGroupByColumn('blog_category_id');
                                            
        if ($categorys = BlogCategoryPeer::doSelectWithI18n($c)) {
            $this->categorys = $categorys;               
        }
        
    }

    public function executeList()
    {   
        if ($this->getUser()->hasParameter('status-404'))
        {
            $this->getResponse()->setStatusCode(404);

            $this->getResponse()->setHttpHeader('Status', '404 Not Found');
        }

        $blog_category = null;
        
        if($this->getRequestParameter('category'))
        {            
            $this->getUser()->setAttribute("blog_category_id", $this->getRequestParameter('category'));
            $blog_category_id = $this->getRequestParameter('category');
            $blog_category = BlogCategoryPeer::retrieveByPK($blog_category_id);
        } 
        elseif ($this->hasRequestParameter('url'))
        {
            $blog_category = BlogCategoryPeer::retrieveByUrl($this->getRequestParameter('url')); 
        }

        $this->blog_category = $blog_category;
        
        $this->processCategory301Redirects();

        $this->smarty = new stSmarty('stBlogFrontend');

        $config = stConfig::getInstance(sfContext::getInstance(), 'stBlogBackend');
        
        $blogs_count = $config->get('list_number');
        
        if($config->get('active')==0)
        {            
            return $this->redirect('/');
        }

        $this->config = $config;        

        $c = new Criteria();
        $c->add(BlogPeer::ACTIVE, 1);
        
        if($blog_category)
        {
            $c->addJoin(BlogHasBlogCategoryPeer::BLOG_ID, BlogPeer::ID);
            $c->add(BlogHasBlogCategoryPeer::BLOG_CATEGORY_ID, $blog_category->getId());    
        }
                                
        $c->setLimit($blogs_count);

        // if($config->get('date'))
        // {
            // $c->addDescendingOrderByColumn(BlogPeer::UPDATED_AT);
        // }
        // else
        // {
            $c->addDescendingOrderByColumn(BlogPeer::CREATED_AT);
        //}
                
        $this->blogPagerInit($c);

        $page = $this->blog_pager->getPage();            
        
        if($page == 1){

        $this->getResponse()->setTitle($config->get('title', null, true));
        
        $this->getResponse()->addMeta('description', $config->get('description', null, true));        

        }else{

        $this->getResponse()->setTitle($config->get('title', null, true)." - ".$page);

        $this->getResponse()->addMeta('description', $config->get('description', null, true)." - ".$page);

        }

        $this->getResponse()->addMeta('keywords', $config->get('keywords', null, true));     

    }

    protected function blogPagerInit(Criteria $c)
    {
        $config = stConfig::getInstance(sfContext::getInstance(), 'stBlogBackend');                  
          
        $this->blog_pager = new stPropelPager('Blog', $config->get('list_number'));

        $c = clone $c;

        $this->blog_pager->setPage($this->getRequestParameter('page'));

        $this->blog_pager->setCriteria($c);

        $this->blog_pager->setPeerMethod('doSelect');

        $this->blog_pager->init();
    }
   
    protected function process301Redirects()
    {
        if ($this->hasRequestParameter('blog_id'))
        {
            sfLoader::loadHelpers(array('Helper','stUrl'));

            $blog_id = $this->getRequestParameter('blog_id');

            $blog = BlogPeer::retrieveByPK($blog_id);

            if (is_null($blog))
            {
                return false;
            }

            $blog->setCulture($this->getUser()->getCulture());

            return $this->redirect(st_url_for('stBlogFrontend/show?url='.$blog->getFriendlyUrl(), true), 301);
        }

        return true;
    }

    protected function processCategory301Redirects()
    {
        if ($this->hasRequestParameter('category') && $this->blog_category)
        {
            $url_params = array(
                'module' => 'stBlogFrontend',
                'action' => 'list',
                'url' => $this->blog_category->getUrl(),
            );                

            if ($this->hasRequestParameter('page'))
            {
                $url_params['page'] = $this->getRequestParameter('page');
            }

            return $this->redirect($url_params, 301);
        }
        elseif (strpos($this->getRequest()->getUri(), '/blog/list')) 
        {
            return $this->redirect(sfRouting::getInstance()->getCurrentInternalUri(), 301);
        }        
    }

    protected function processFriendlyUrl()
    {
        if ($this->getRequest()->hasParameter('url'))
        {
            $url = $this->getRequest()->getParameter('url');

            $this->blog = BlogPeer::retrieveByUrl($url);

            if ($this->blog && $this->blog->getActive())
            {
                $this->blog->setCulture($this->getUser()->getCulture());

                $this->getUser()->setParameter('selected', $this->blog, 'soteshop/stBlog');

                if ($url != $this->blog->getFriendlyUrl())
                {
                    sfLoader::loadHelpers(array('Helper','stUrl'));

                    $r = sfRouting::getInstance();

                    list(,$redirect) = $this->getController()->convertUrlStringToParameters($r->getCurrentInternalUri());

                    $redirect['url'] = $this->blog->getFriendlyUrl();

                    $this->redirect(st_url_for($redirect, true) , 301);
                }
            }
            else
            {
                return false;
            }
        }

        return true;
    }  
  
}
