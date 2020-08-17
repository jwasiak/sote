<?php

/**
 * SOTESHOP/stProduct 
 * 
 * Ten plik należy do aplikacji stProduct opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stProduct
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: components.class.php 1031 2009-05-07 13:03:25Z krzysiek $
 */

/**
 * Komponenty stProduct
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stProduct
 * @subpackage  actions
 */
class stProductComponents extends autoStProductComponents
{

   public function executeEditMenu()
   {
      parent::executeEditMenu();

      $i18n = $this->getContext()->getI18n();

      $this->items["stProduct/moreList?product_id={$this->product->getId()}"] = $i18n->__('Dodatkowe opcje');

      $this->processMenuItems(); 
      $this->selected_item_path = $this->getUser()->getAttribute('selected', false, 'soteshop/component/menu');
   }

   public function executeEditCurrency()
   {
      $cache = new stFunctionCache('stCurrency');

      $this->currency = $cache->cacheCall('stProductEdit::getCurrency');      
   }
   /**
    * Komponent wyświetlający drzewa kategorii
    */
   public function executeCategory()
   {
      $c = new Criteria();

      $user = $this->getUser();

      $c->add(CategoryPeer::PARENT_ID, null, Criteria::ISNULL);

      $this->roots = CategoryPeer::doSelect($c);

      if ($this->product->isNew() && $this->getUser()->getAttribute('category_filter', null, 'soteshop/stProduct'))
      {
         $id = $this->getUser()->getAttribute('category_filter', null, 'soteshop/stProduct');
         
         $this->categories = array($id => array('id' => $id, 'default' => true));
      }
      else
      {
         $this->categories = $this->getAssignedCategories($this->product->getId());
      }
   }

   /**
    * Komponent zdjecia
    */
   public function executeImages()
   {
      $this->product = ProductPeer::retrieveByPK($this->product_id);
      $this->dir = $this->product->getImage();
      $this->photos = sfFinder::type('file')->name('*.jpg')->maxdepth(0)->relative()->in('uploads/products/'.$this->dir);
   }

   /**
    * Główne zdjęcie produktu
    */
   public function executeMainImage()
   {
      $this->product = ProductPeer::retrieveByPK($this->getRequestParameter('id'));
      if ($this->product)
      {
         $this->dir = $this->product->getImage();
         $this->photos = sfFinder::type('file')->name('*.jpg')->maxdepth(0)->relative()->in('uploads/products/'.$this->dir);
      }
   }

   /**
    * Pobieranie template dla wyświetlania opisu szczegółowego produktu
    */
   public function executeProductViews()
   {
      $theme_name = strtolower(stTheme::getActiveTheme()->getTheme());

      $filehtmlRoot = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'stProduct'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.$theme_name.DIRECTORY_SEPARATOR;
      $files = sfFinder::type('file')->name('product_show_*.html')->in($filehtmlRoot);
      $this->template_files = array();
      foreach ($files as $file)
      {
         $file = str_replace($filehtmlRoot.'product_show_', '', $file);
         $file = str_replace('.html', '', $file);
         $this->template_files[$file] = $file;
      }
      $this->template_files = $this->getProductViewsNames($this->template_files);
   }

   public function executeDefaultImage()
   {
      $this->default_image = ProductHasSfAssetPeer::retrieveDefaultImage($this->product->getId());
   }

   /**
    * Pobiera nazwy templatow z pliku yaml
    *
    * @param array $template_files
    * @return array list templatow
    */
   public function getProductViewsNames($template_files)
   {
      $fileymlRoot = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'backend'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'stProduct'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'views.yml';
      $yml = sfYaml::load($fileymlRoot);
      return array_merge($template_files, $yml['show']);
   }

   /**
    * Sprawdzanie czy występuje błąd z filtowaniem (5.0.0 -> 5.0.1)
    *
    */
   public function executeFixProducts()
   {
      $c = new Criteria();
      $this->num_products = ProductPeer::doCount($c);

      $c = new Criteria();
      $c->addJoin(ProductI18nPeer::ID, ProductPeer::ID);
      $c->add(ProductI18nPeer::CULTURE, "pl_PL");
      $this->num_products_good = ProductPeer::doCount($c);

      $this->culture = $this->getUser()->getCulture();
   }

   public function executeVat()
   {
      $c = new Criteria();
      $this->taxes = TaxPeer::doSelect($c);
   }

   protected function getAssignedCategories($product_id)
   {
      $categories = array();

      $assigned = $this->getRequestParameter('product_has_category');

      $default = $this->getRequestParameter('product_default_category');

      $c = new Criteria();

      $c->add(ProductHasCategoryPeer::PRODUCT_ID, $product_id);

      $c->addSelectColumn(ProductHasCategoryPeer::CATEGORY_ID);

      $c->addSelectColumn(ProductHasCategoryPeer::IS_DEFAULT);

      $rs = ProductHasCategoryPeer::doSelectRS($c);

      while ($rs->next())
      {
         $row = $rs->getRow();

         $id = $row[0];

         if (null === $assigned || isset($assigned[$id]))
         {
            $categories[$id] = array('id' => $id, 'default' => $default ? $default == $id : $row[1]);
         }
      }

      if ($assigned)
      {
         foreach ($assigned as $id)
         {
            if (!isset($categories[$id]))
            {
               $categories[$id] = array('id' => $id, 'default' => $default ? $default == $id : false);
            }
         }
      }

      return $categories;
   }

   public function executeBpumDefault()
   {
      $c = new Criteria();
      $this->bpum = BaseBasicPriceUnitMeasurePeer::doSelect($c);
   }

   public function executeBpum()
   {
        $c = new Criteria();
        $this->bpum = BaseBasicPriceUnitMeasurePeer::doSelect($c);    
   }
     
}

?>