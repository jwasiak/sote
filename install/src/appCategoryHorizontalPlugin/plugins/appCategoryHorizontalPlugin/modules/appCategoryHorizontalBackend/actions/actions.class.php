<?php
/** 
 * SOTESHOP/appCategoryHorizontalPlugin
 * 
 * 
 * @package     appCategoryHorizontalPlugin
 */
class appCategoryHorizontalBackendActions extends sfActions
{
   public function executeConfig()
   {
        $this->config = stConfig::getInstance($this->getContext(), 'appCategoryHorizontalBackend');

        $c = new Criteria();
        $c->add(CategoryPeer::PARENT_ID, NULL);
        $categories =  CategoryPeer::doSelect($c);

        if($categories)
        {
           foreach ($categories as $category)
           {
              $select[$category->getId()] = $category->getOptName();
           }
        }
        else
        {
           $select = 0;
        }

        $this->select = $select;
         
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->config->setFromRequest('categoryHorizontal');
            $this->config->save(true);
            appCategoryHorizontalListener::clearCache();
            $fc = new stFunctionCache('stCategoryTree');
            $fc->removeAll();
            stFastCacheManager::clearCache();
            $this->setFlash('notice', 'Twoje zmiany zostały zapisane');
        }
    }
}