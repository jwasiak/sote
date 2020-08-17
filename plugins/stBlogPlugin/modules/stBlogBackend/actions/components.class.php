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

class stBlogBackendComponents extends autoStBlogBackendComponents
{
    public function executeBlogCategory() {
        //echo $this->getRequestParameter('id');
        
        $c = new Criteria();        
        $c -> add(BlogCategoryPeer::ACTIVE, 1);                        
        if ($blogCategorys = BlogCategoryPeer::doSelectWithI18n($c)) {
                 
            $row = array();    
                        
            foreach ($blogCategorys as $index => $category) {
                
                $row[$index]['id'] = $category->getId();
                $row[$index]['assighn'] = 0;
                $row[$index]['name'] = $category->getOptName();
                
                $c = new Criteria();        
                $c -> add(BlogHasBlogCategoryPeer::BLOG_ID, $this->getRequestParameter('id'));
                $c -> add(BlogHasBlogCategoryPeer::BLOG_CATEGORY_ID, $category->getId());                        
                if($categoryAssighn = BlogHasBlogCategoryPeer::doSelectOne($c)){
                    $row[$index]['assighn'] = 1;
                }    
            }            
        } 
        
        $this->row = $row;
        
    }  

    public function executeBlogCategoryList() {
        
        
        $c = new Criteria();        
        $c -> add(BlogCategoryPeer::ACTIVE, 1);                        
        if ($blogCategorys = BlogCategoryPeer::doSelectWithI18n($c)) {
                 
            $row = array();    
                        
            foreach ($blogCategorys as $index => $category) {
                
                $row[$index]['id'] = $category->getId();
                $row[$index]['assighn'] = 0;
                $row[$index]['name'] = $category->getOptName();
                
                $c = new Criteria();        
                $c -> add(BlogHasBlogCategoryPeer::BLOG_ID, $this->blog->getId());
                $c -> add(BlogHasBlogCategoryPeer::BLOG_CATEGORY_ID, $category->getId());                        
                if($categoryAssighn = BlogHasBlogCategoryPeer::doSelectOne($c)){
                    $row[$index]['assighn'] = 1;
                }    
            }            
        } 
        
        $this->row = $row;
        
    }  

    public function executeBlogCategoryHome() {
        
        $config = stConfig::getInstance($this->getContext(), 'stBlogBackend');
        $ids = unserialize($config->get('blog_category_home'));    
        
        $c = new Criteria();        
        $c -> add(BlogCategoryPeer::ACTIVE, 1);                        
        if ($blogCategorys = BlogCategoryPeer::doSelectWithI18n($c)) {
                 
            $row = array();    
                        
            foreach ($blogCategorys as $index => $category) {
                
                $row[$index]['id'] = $category->getId();
                $row[$index]['assighn'] = 0;
                $row[$index]['name'] = $category->getOptName();
                
                if($ids){
                    foreach ($ids as $key => $value) {                
                        if($category->getId() == $value){
                         $row[$index]['assighn'] = 1;
                        }                                 
                     }    
                }
                
            }            
        } 
        
        $this->row = $row;
        
    }  
}