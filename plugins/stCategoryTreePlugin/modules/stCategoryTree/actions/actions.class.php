<?php

/**
 * SOTESHOP/stCategoryTreePlugin
 *
 * Ten plik należy do aplikacji stCategoryTreePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stCategoryTreePlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 13308 2011-05-31 13:56:27Z marcin $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * Akcje modułu stCategoryTree
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stCategoryTreePlugin
 * @subpackage  actions
 */
class stCategoryTreeActions extends stActions
{
   public function executeJavascript()
   {
      $this->setLayout(false);

      $response = $this->getResponse();

      $response->setContentType('text/javascript');

      $max_age = 60*60*24*384;

      $response->addCacheControlHttpHeader('private');
      
      $response->addCacheControlHttpHeader('must-revalidate');      
      
      $response->addCacheControlHttpHeader('max-age', $max_age);
      
      $response->addCacheControlHttpHeader('s-maxage', $max_age);      

      $response->setHttpHeader('Expires', false);

      $response->setHttpHeader('Pragma', false);
   }

   public function executeAjaxCategories()
   {
      $id = $this->getRequestParameter('id');

      $parent = CategoryPeer::retrieveByPK($id);

      if (!$parent)
      {
         return sfView::NONE;
      }

      sfLoader::loadHelpers(array('Helper', 'stPartial', 'stJQueryTree'), 'stCategoryTree');

      $content = st_get_component('stCategoryTree', 'ajaxCategories', array('parent' => array('id' => $parent->getId(), 'is_root' => $parent->isRoot(), 'scope' => $parent->getScope()), 'expanded' => array()));

      $js = st_jquery_tree_init($id, array('url' => array('module' => 'stCategoryTree', 'action' => 'ajaxCategories')));

      return $this->renderText($content.$js);
   }
   /**
    * Zmienia nazwę kategorii
    *
    * @return   sfView
    */
   public function executeChangeCategoryName()
   {
      stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), 'stCategory', false);
      $value = $this->getRequestParameter("value");
      $id = $this->getRequestParameter("id");

      $value = strip_tags($value);

      $value = trim($value);

      if (!empty($value))
      {
         $category = CategoryPeer::retrieveByPK($id);

         $category->setCulture(stLanguage::getOptLanguage());

         $category->setName($value);

         $category->save();
      }

      return sfView::HEADER_ONLY;
   }

   /**
    * Usuwa kategorię
    *
    * @return   sfView
    */
   public function executeRemoveCategory()
   {
      stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), 'stCategory', false);
      $category = CategoryPeer::retrieveByPk($this->getRequestParameter('id'));

      if (stConfig::getInstance('stCategory')->get('check_for_product_before_delete') && $category->hasProducts())
      {
         $i18n = $this->getContext()->getI18N();
         return $this->renderJSON(array('error' => $i18n->__('Kategoria nie może być usunięta dopóki ma przypisane produkty', null, 'stCategory')));
      }

      if ($category)
      {
         $category->delete();

         $output = json_encode(array('id' => $category->getId()));
      }

      $this->getResponse()->setHttpHeader('Content-Type', 'application/json');
      return $this->renderText($output);
   }

   /**
    * Dodaje nową kategorię
    *
    * @return   sfView
    */
   public function executeAppendCategory()
   {
      stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), 'stCategory', false);
      $output = '';

      $parent = CategoryPeer::retrieveByPk($this->getRequestParameter('parent_id'));
      $name = $this->getRequestParameter('name');

      if ($parent)
      {
         $category = new Category();
         $category->setCulture(stLanguage::getOptLanguage());
         $category->setName($name);
         $category->insertAsLastChildOf($parent);

         $category->save();

         $output = json_encode(array('id' => $category->getId(), 'name' => $category->getName(), 'parent_id' => $parent->getId()));
      }

      $this->getResponse()->setHttpHeader('Content-Type', 'application/json');
      return $this->renderText($output);
   }

   /**
    * Przenosi kategorię w dowolne miejsce w drzewie
    *
    * @return   sfView
    */
   public function executeMoveCategory()
   {
      stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), 'stCategory', false);
      $category_id = $this->getRequestParameter('id');

      $sibling_id = $this->getRequestParameter('next_sibling_id');

      $parent_id = $this->getRequestParameter('parent_id');

      self::moveCategory($category_id, $sibling_id, $parent_id);

      return sfView::HEADER_ONLY;
   }

   /**
    * Pobiera kategorie dla danego rodzica
    *
    * @return   sfView
    */
   public function executeFetchCategories()
   {

      $node = $this->getRequestParameter('node');

      $selected_node_id = $this->getRequestParameter('selected_node_id');

      $output = '';

      $extjs_data = array();

      if ($node)
      {
         $category = CategoryPeer::retrieveByPk($node);
         $user = $this->getUser();
         $culture = $user->getCulture();
         $user->setCulture(stLanguage::getOptLanguage());
         $categories = $category->getChildren('doSelectWithI18n');
         $user->setCulture($culture);
         $i18n = $this->getContext()->getI18N();

         $qtip = $i18n->__('Kliknij dwukrotnie aby zmienić nazwę kategorii. Kliknij i przytrzymaj aby przeciągnać i zmienić jej położenie');

         foreach ($categories as $category)
         {
            $extjs_data[] = array('id' => $category->getId(), 'text' => $category->getName(), 'qtip' => $qtip);
         }

         $output = json_encode($extjs_data);
      }

      $this->getResponse()->setHttpHeader('Content-Type', 'application/json');

      return $this->renderText($output);
   }

   /**
    * Przsuwanie kategorii
    *
    * @param   integer     $category_id        numer Id kategorii
    * @param   integer     $sibling_id         numer Id sąsiada kategorii
    * @param   integer     $parent_id          numer Id rodzica kategorii
    */
   public static function moveCategory($category_id, $sibling_id, $parent_id)
   {
      $category = CategoryPeer::retrieveByPK($category_id);

      if ($category)
      {
         if ($sibling_id)
         {
            $category->moveToPrevSiblingOf(CategoryPeer::retrieveByPK($sibling_id));
         }
         else
         {
            $category->moveToLastChildOf(CategoryPeer::retrieveByPK($parent_id));
         }

         $category->save();

         ProductHasCategoryPeer::cleanCache();
      }
   }

}
