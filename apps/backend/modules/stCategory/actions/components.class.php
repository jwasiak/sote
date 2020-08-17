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
 * @version     $Id: components.class.php 318 2009-09-07 12:39:29Z michal $
 */

/**
 * Komponenty aplikacji stCategory
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stCategory
 * @subpackage  actions
 */
class stCategoryComponents extends autoStCategoryComponents
{
   /**
    * Wyświetla komponent umożliwiający dodanie dowolnego modelu do kategorii
    */
   public function executeAddToManager()
   {
      $this->iterators = stNestedIterator::retrieveTree();
   }

   public function executeTree()
   {
      $c = new Criteria();

      $c->add(CategoryPeer::RGT, 2, Criteria::GREATER_THAN);

      $c->addAscendingOrderByColumn(CategoryPeer::ROOT_POSITION);

      $this->roots = CategoryPeer::doSelectRootsWithI18n($c);

      if (!isset($this->selected))
      {
         $this->selected = $this->getUser()->getAttribute('category_filter', null, 'soteshop/stProduct');      
      }

      $this->expanded = CategoryPeer::doSelectExpanded($this->selected);

      if (!isset($this->url))
      {
         $this->url = $this->getController()->genUrl('@stProductDefault');
      }
   }

   public function executeTreeBreadcrumbs()
   {
      if (!isset($this->selected))
      {
         $this->selected = $this->getUser()->getAttribute('category_filter', null, 'soteshop/stProduct');
      }

      $this->breadcrumbs = CategoryPeer::doSelectExpanded($this->selected) ;

      if (!$this->breadcrumbs)
      {
         return sfView::NONE;
      }

      if (!isset($this->url))
      {
         $this->url = $this->getController()->genUrl('@stProductDefault');
      }
   }
}

?>