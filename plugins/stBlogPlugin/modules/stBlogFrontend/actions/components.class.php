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

class stBlogFrontendComponents extends sfComponents
{

    public function executeIndex()
    {
        $config = stConfig::getInstance(sfContext::getInstance(), 'stBlogBackend');
                
        $ids = unserialize($config->get('blog_category_home'));

        $config->load();

        if($config->get('active')==0 || $config->get('active_home')==0)
        {
            return sfView::NONE;
        }

        $blogs_count = $config->get('number');

        $this->config = $config;

        $this->smarty = new stSmarty('stBlogFrontend');

         

        $c = new Criteria();
        $c->add(BlogPeer::ACTIVE, 1);
        
        if($ids){
            $c->addJoin(BlogHasBlogCategoryPeer::BLOG_ID, BlogPeer::ID);
            $c->add(BlogHasBlogCategoryPeer::BLOG_CATEGORY_ID, $ids, Criteria::IN);
            $c->addGroupByColumn(BlogPeer::ID);                
        }
        
        $c->setLimit($blogs_count);
        // if($config->get('date')==1)
        // {
            // $c->addDescendingOrderByColumn(BlogPeer::UPDATED_AT);
        // }
        // else
        // {
            $c->addDescendingOrderByColumn(BlogPeer::CREATED_AT);
        //}
        $blogs = BlogPeer::doSelect($c);

        $this->blogs = $blogs;
    }
}
