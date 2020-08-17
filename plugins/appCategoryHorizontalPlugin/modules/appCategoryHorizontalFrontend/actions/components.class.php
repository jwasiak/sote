<?php

if (!class_exists('stCategoryTreeComponents', false))
{
   include sfConfig::get('sf_plugins_dir').'/stCategoryTreePlugin/modules/stCategoryTree/actions/components.class.php';
}

class appCategoryHorizontalFrontendComponents extends stCategoryTreeComponents
{
   public function __toString()
   {
      return get_class($this);
   }

   public function executeTree()
   {
      $this->smarty = new stSmarty('appCategoryHorizontalFrontend');

      $config = stConfig::getInstance(sfContext::getInstance(), 'stCategory');

      $this->categoryHorizontal = $config->load();

      if (!isset($this->parent_id)) 
      {
         $this->parent_id = $config->get('cathor_tree');
      }

      $this->categories = $this->getCategoriesCached(array('parent_id' => $this->parent_id));  

      if ($config->get('menu_on') && !$this->categories)   
      {
         return sfView::NONE;
      } 

      $this->smarty->register_function('capture_category_description', array($this, 'smartyCategoryDescription'));
   }

   protected function checkForHidden()
   {
      return false;
   }

   public function smartyCategoryDescription($params, $smarty)
   {
      $c = new Criteria();
      $c->addSelectColumn(CategoryPeer::OPT_DESCRIPTION);
      $c->addSelectColumn(CategoryI18nPeer::DESCRIPTION);
      $c->add(CategoryPeer::ID, $params['category']['id']);
      $c->setLimit(1);
      CategoryPeer::setHydrateMethod(array('appCategoryHorizontalFrontendComponents', 'hydrateCategoryDescription'));
      $smarty->_smarty_vars['capture']['category_description'] = CategoryPeer::doSelectWithI18n($c);
      CategoryPeer::setHydrateMethod(null);
   }

   public static function hydrateCategoryDescription(ResultSet $rs)
   {
      if ($rs->next())
      {
         $row = $rs->getRow();

         return $row[1] ? $row[1] : $row[0];
      }

      return '';
   }
}
