<?php

/**
 * SOTESHOP/stCategory
 *
 * Ten plik należy do aplikacji stCategory opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stCategory
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 10063 2010-12-30 12:57:19Z marcin $
 */

/**
 * Akcje kategorii
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stCategory
 * @subpackage  actions
 */
class stCategoryActions extends autostCategoryActions
{
   public function executeAjaxCategoryFilterChildren()
   {
      $url = $this->getRequestParameter('url');
      $id = $this->getRequestParameter('id');
      $parent = CategoryPeer::retrieveByPK($id);
      
      if (null === $parent) 
      {
         return sfView::HEADER_ONLY;
      }

      $result = $this->getRenderPartial('stCategory/categories', array('parent' => $parent, 'expanded' => array(), 'selected' => null, 'url' => $url));

      return $this->renderText($result);
   }
   
   public function executeAjaxCategoryTree()
   {
      $roots = CategoryPeer::doSelectRoots(new Criteria());

      $html_data = '';

      $this->default = $this->getRequestParameter('default');

      $this->show_default = $this->getRequestParameter('show_default', true);

      $this->allow_assign_leaf_only = $this->getRequestParameter('allow_assign_leaf_only', false);

      $allow_assign_root = $this->getRequestParameter('allow_assign_root', false);

      $path = array();

      $assigned = $this->getRequestParameter('assigned');

      $this->assigned = $assigned ? array_flip(explode(',', $assigned)) : array(); 


      if ($this->assigned)
      {
         foreach (CategoryPeer::retrieveByPKs(array_keys($this->assigned)) as $cat)
         {
            foreach ($cat->getPath('doSelectIds') as $p)
            {
               $path[] = $p;
            }
         }         

         $path = array_flip($path);
      }


      if (!$path && $roots) 
      {
         $path[$roots[0]->getId()] = $roots[0]->getId();
      }
     

      foreach ($roots as $root) 
      {
         $id = $root->getId();

         $assigned = isset($this->assigned[$id]);

         if (isset($path[$root->getId()]))
         {
            $params = array('status' => 'open', 'children' => $this->getAjaxTreeChildren($root, $path));
         }
         else
         {
            $params = array('status' => $root->hasChildren() ? 'closed' : 'leaf');
         }

         if ($allow_assign_root && !$this->allow_assign_leaf_only)
         {
            $content = stJQueryToolsHelper::getJsTreeHtmlAssignedControl('jstree_category', $id, $assigned);
            $params['content'] = $content;
         }

         $html_data .= stJQueryToolsHelper::getJsTreeHtmlRow($root->getId(), htmlspecialchars(strtr($root->getOptName(), array("\n" => "", "\r" => "")), ENT_QUOTES), $params);
      }

      $this->html_data = $html_data; 
   }

   public function executeAjaxCategoryChildren()
   {
      $id = $this->getRequestParameter('id');

      $assigned = $this->getRequestParameter('assigned');

      $this->default = $this->getRequestParameter('default');

      $this->show_default = $this->getRequestParameter('show_default');

      $this->allow_assign_leaf_only = $this->getRequestParameter('allow_assign_leaf_only', false);

      if ($assigned) 
      {
         $this->assigned = array_flip(explode(',', $assigned));
      }

      $parent = CategoryPeer::retrieveByPK($id);

      if (!$parent)
      {
         return sfView::NONE;
      }

      $html_data = $this->getAjaxTreeChildren($parent);      

      return $this->renderText($html_data);
   }

   public function executeSetRootPosition()
   {
      $id = $this->getRequestParameter("id");
      
      $move = $this->getRequestParameter('move');
      
      $node = CategoryPeer::retrieveByPK($id);
      
      if ($node->isRoot())
      {
         if ($move == 'up')
         {
            $this->treeMoveUp($node);
         }
         elseif ($move == 'down')
         {
            $this->treeMoveDown($node);
         }
      }
      
      return $this->redirect('stCategory/manager');
   }
   
   public function executeIndex()
   {
      $this->redirect('category/manager');
   }

   /**
    * Wyświetla zarządzanie kategoriami
    */
   public function executeManager()
   {
      $c = new Criteria();

      $c->add(CategoryPeer::PARENT_ID, null, Criteria::ISNULL);

      $c->addAscendingOrderByColumn(CategoryPeer::ROOT_POSITION);

      $this->roots = CategoryPeer::doSelect($c);
   }

   /**
    * Dodaje nowe drzewo kategorii
    */
   public function executeAddTree()
   {
      stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), 'stCategory', false);

      $name = $this->getRequestParameter("category_tree_name");

      $tree = new Category();

      $tree->setCulture(stLanguage::getOptLanguage());

      $tree->setName($name);

      $tree->makeRoot();

      $tree->save();

      $tree->setScope($tree->getId());

      $tree->save();

      $this->redirect('category/manager');
   }

   /**
    * Dodaje nową kategorię do drzewa
    */
   public function executeAddCategory()
   {
      stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), 'stCategory', false);

      $categoryName = $this->getRequestParameter("category_tree[category_name]");

      $treeId = $this->getRequestParameter("category_tree[tree_id]");

      $c = new Criteria();

      $rootTree = CategoryPeer::retrieveByPK($treeId);

      $this->childCategory = new Category();

      $this->childCategory->setCulture('pl_PL');

      $this->childCategory->setName($categoryName);

      $this->childCategory->insertAsLastChildOf($rootTree);

      $this->childCategory->save();

      $this->redirect('category/manager');
   }

   /**
    * Aktualizuje nazwę kategorii i zwraca jej nazwę jako odpowiedź na wywołanie Ajax
    *
    * @return   string
    */
   public function executeCategorySave()
   {
      stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), 'stCategory', false);

      $value = $this->getRequestParameter("value");
      $id = $this->getRequestParameter("id");

      $category = CategoryPeer::retrieveByPK($id);

      $category->setCulture('pl_PL');

      if (empty($value))
      {
         return $this->renderText($category->getName());
      }

      $category->setName($value);

      $category->save();

      return $this->renderText($value);
   }

   /**
    * Usuwa całe drzewo lub gałąź kategorii
    */
   public function executeDelete()
   {
      stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), 'stCategory', false);

      $categoryTree = CategoryPeer::retrieveByPK($this->getRequestParameter("id"));

      $categoryTree->delete();

      $this->redirect('category/manager');
   }

   /**
    * Wiąże produkt z wybranymi kategoriami
    */
   public function executeAddToManager()
   {
      $this->product_id = $this->getRequestParameter('product_id');

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {

         $categories = $this->getRequestParameter('category');

         CategoryPeer::addProduct($this->product_id, $categories);
      }
   }

   public function validateAddTree()
   {
      $ok = true;

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $name = $this->getRequestParameter('category_tree_name');

         if (empty($name))
         {
            $this->getRequest()->setError('category_tree_name', 'Musisz podać nazwę drzewa');

            $ok = false;
         }
         elseif (CategoryPeer::checkByName($name))
         {
            $this->getRequest()->setError('category_tree_name', 'Nazwa już istnieje');

            $ok = false;
         }
      }
      else
      {
         $ok = false;
      }

      return $ok; 
   }

   /**
    * Informuje o błędzie dodania drzewa kategorii
    */
   public function handleErrorAddTree()
   {
      return $this->forward('stCategory', 'manager');
   }

   /**
    * Dodaje zdjęcie do produktu
    *
    * @param Product $product Produkt
    */
   protected function saveCategoryImage($category)
   {
      $category_images = $this->getRequestParameter('category_images');
      $plupload = stJQueryToolsHelper::parsePluploadFromRequest($category_images);

      if ($plupload['delete'])
      {
         $category->destroyAsset();
      }
      
      if ($plupload['modified'])
      {
         foreach ($plupload['modified'] as $filename)
         {
            $ext = sfAssetsLibraryTools::getFileExtension($filename);
            $category->createAsset($category->getId() . '.' . $ext, $plupload['dir'].'/'.$filename);
            $category->save();      
         }      
      }

      stJQueryToolsHelper::pluploadCleanup($plupload);
   }

   protected function processDelete($id)
   {
      $category = CategoryPeer::retrieveByPK($id);

      if (stConfig::getInstance('stCategory')->get('check_for_product_before_delete') && $category->hasProducts())
      {
         $i18n = $this->getContext()->getI18N();
         $this->setFlash('warning', $i18n->__('Kategoria nie może być usunięta dopóki ma przypisane produkty', null, 'stCategory'));
         return $this->redirect($this->getRequest()->getReferer());
      }

      parent::processDelete();
   }

   protected function saveCategory($category)
   {
      $v = strip_tags($category->getName());

      $category->setName($v);

      parent::saveCategory($category);

      $this->saveCategoryImage($category);
   }

   protected function saveConfig()
   {

      parent::saveConfig();
      
      appCategoryHorizontalListener::clearCache();

      $fc = new stFunctionCache('stCategoryTree');
            
      $fc->removeAll();

      stTheme::clearSmartyCache(true);

      stFastCacheManager::clearCache();

   }
   
   protected function treeMoveUp(Category $node, $by = 1)
   {
      stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), 'stCategory', false);

      $position = $node->getRootPosition();
      
      $c = new Criteria();
      
      $c->add(CategoryPeer::ROOT_POSITION, $position - $by);
      
      $prev = CategoryPeer::doSelectOne($c);
      
      if ($prev)
      {
         $node->setRootPosition($prev->getRootPosition());
         
         $prev->setRootPosition($position);
         
         $node->save();
         
         $prev->save();
      }
   }
   
   protected function treeMoveDown(Category $node, $by = 1)
   {
      stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), 'stCategory', false);
      
      $position = $node->getRootPosition();
      
      $c = new Criteria();
      
      $c->add(CategoryPeer::ROOT_POSITION, $position + $by);
      
      $next = CategoryPeer::doSelectOne($c);
      
      if ($next)
      {
         $node->setRootPosition($next->getRootPosition());
         
         $next->setRootPosition($position);
         
         $node->save();
         
         $next->save();
      }
   }   

   protected function getAjaxTreeChildren(Category $parent, $path = array())
   {
      $html_data = '';

      foreach ($parent->getChildren() as $child)
      {
         $id = $child->getId();

         $assigned = isset($this->assigned[$id]);

         $content = '';

         if (!$this->allow_assign_leaf_only || $child->isLeaf())
         {
            $content = stJQueryToolsHelper::getJsTreeHtmlAssignedControl('jstree_category', $id, $assigned);
         }

         if ($this->show_default)
         {
            $content .= stJQueryToolsHelper::getJsTreeHtmlDefaultControl('jstree_category', $id, $this->default == $id, !$assigned);
         }

         if (isset($path[$id]))
         {
            $params = array(
               'status' => 'open', 
               'content' => $content,
               'children' => $this->getAjaxTreeChildren($child, $path, $this->assigned),
            );
         }
         else
         {
            $params = array(
               'status' => $child->hasChildren() ? 'closed' : 'leaf',
               'content' => $content,
            );
         }

         $html_data .= stJQueryToolsHelper::getJsTreeHtmlRow($child->getId(), htmlspecialchars(strtr($child->getOptName(), array("\n" => "", "\r" => "")), ENT_QUOTES), $params);
      }

      return $html_data;
   }

   public function executeProductAddGroup()
   {  
      stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());

      $ids = $this->getRequestParameter('product[selected]', array($this->getRequestParameter('id')));
      $related_id = $this->getRequestParameter('forward_parameters[category_id]');
      $forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStCategory/product_forward_parameters');

      $langages = LanguagePeer::doSelectActive(new Criteria());

      foreach ($ids as $id)
      {
         $c = new Criteria();
         $c->add(ProductHasCategoryPeer::CATEGORY_ID, $related_id);
         $c->add(ProductHasCategoryPeer::PRODUCT_ID, $id);

         if (!ProductHasCategoryPeer::doCount($c))
         {
            $product_has_category = new ProductHasCategory();
            $product_has_category->setCategoryId($related_id);
            $product_has_category->setProductId($id);
            $product_has_category->save();
            $product = $product_has_category->getProduct();
            foreach ($langages as $lang) 
            {
               $product->setCulture($lang->getOriginalLanguage());
               stNewSearch::buildIndex($product, true);
            }
         }
      }

      return $this->redirect('stCategory/productList?page='.$this->getRequestParameter('page', 1).'&category_id='.$forward_parameters['category_id']);
   }


   public function executeProductRemoveGroup()
   {  
      stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());

      $ids = $this->getRequestParameter('product[selected]', array($this->getRequestParameter('id')));
      $related_id = $this->getRequestParameter('forward_parameters[category_id]');
      $forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStCategory/product_forward_parameters');

      $c = new Criteria();
      $c->add(ProductHasCategoryPeer::CATEGORY_ID, $related_id);
      $c->add(ProductHasCategoryPeer::PRODUCT_ID, array_values($ids), Criteria::IN);

      $langages = LanguagePeer::doSelectActive(new Criteria());

      foreach (ProductHasCategoryPeer::doSelectJoinProduct($c) as $product_has_category)
      {
         $product = $product_has_category->getProduct();
         $product_has_category->delete();
         foreach ($langages as $lang) 
         {
            $product->setCulture($lang->getOriginalLanguage());
            stNewSearch::buildIndex($product, true);
         }         
      }        

      return $this->redirect('stCategory/productList?page='.$this->getRequestParameter('page', 1).'&category_id='.$forward_parameters['category_id']);
   }

   public function addProductFiltersCriteria($c){

        parent::addProductFiltersCriteria($c);

        if (isset($this->filters['list_image']) && $this->filters['list_image'] !== ''){
            $c->add(ProductPeer::OPT_IMAGE, null, $this->filters['list_image'] ? Criteria::ISNOTNULL : Criteria::ISNULL);
        }
    }     

}
