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
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: CategoryPeer.php 9417 2010-11-24 08:39:06Z piotr $
 */

/**
 * Subclass for performing query and update operations on the 'st_category_tree' table.
 *
 * @package     stCategory
 * @subpackage  libs
 */
class CategoryPeer extends BaseCategoryPeer
{
   protected static $expanded = array();

   protected static $urlPool = array();

   public static function retrieveByUrl($url)
   {
      if (!isset(self::$urlPool[$url]) && !array_key_exists($url, self::$urlPool))
      {
         $c = new Criteria();
         $c->addSelectColumn(CategoryI18nPeer::ID);
         $c->add(CategoryI18nPeer::URL, $url);
         $c->setLimit(1);
         $rs = CategoryI18nPeer::doSelectRS($c);

         if ($rs->next())
         {  
            $row = $rs->getRow();
            $c = new Criteria();
            $c->add(self::ID, $row[0]);
            $c->setLimit(1);
            $tmp = self::doSelectWithI18n($c);     
            self::$urlPool[$url] = $tmp ? $tmp[0] : null;   
         }
      }

      return self::$urlPool[$url];
   }

   public static function checkByName($name) 
   {
      $c = new Criteria();

      $c->add(self::PARENT_ID, null, Criteria::ISNULL);

      $c->add(self::OPT_NAME, $name);

      return self::doCount($c) > 0;
   }

   public function doSelectIds(Criteria $c)
   {
      $c = clone $c;

      $c->addSelectColumn(self::ID);

      $rs = self::doSelectRs($c);

      $ids = array();

      while($rs->next())
      {
         $ids[] = $rs->getInt(1);
      }

      return $ids;
   }

   public static function doSelectOneWithI18n(Criteria $criteria, $con = null)
   {
      $objects = self::doSelectWithI18n($criteria, $con);
      
      return $objects ? $objects[0] : null;
   }
   public static function doSelectRootsWithI18n(Criteria $criteria, $con = null)
   {
      $c = clone $criteria;

      $c->add(self::PARENT_ID, null, Criteria::ISNULL);

      return self::doSelectWithI18n($c);
   }

   public static function doSelectRoots(Criteria $criteria, $con = null)
   {
      $c = clone $criteria;

      $c->add(self::PARENT_ID, null, Criteria::ISNULL);

      return self::doSelect($c);
   }

   public static function doSelectNestedSet(Criteria $criteria, $con = null)
   {
      $c = clone $criteria;

      $c->addAscendingOrderByColumn(CategoryPeer::LFT);

      return self::doSelect($c);
   }

   /**
    * Dodaje dowolny obiekt model danych do przekazanych id kategorii
    *
    * @param   BaseObject  $object             dowolny obiekt modelu ktory posiada relacje z modelem Category
    * @param   array       $categories         tablica id kategorii do jakich danych produkt ma zostac dodany
    */
   public static function addAs(BaseObject $object, $to_categories = array())
   {
      $c = new Criteria();

      $base_class = get_class($object);
      $class_name = $base_class.'HasCategory';

      if (!class_exists($class_name))
      {
         throw new sfException('CategoryPeer::addAs requires '.$class_name.' model');
      }

      $c->add(constant($class_name.'Peer::'.strtoupper($base_class).'_ID'), $object->getPrimaryKey());
      call_user_func($class_name.'Peer::doDelete', $c);

      if (is_array($to_categories))
      {
         foreach ($to_categories as $id)
         {
            $pc = new $class_name();

            //                $pc->setProductId($product_id);
            call_user_func(array($pc, 'set'.$base_class.'Id'), $object->getPrimaryKey());
            $pc->setCategoryId($id);
            $pc->save();
         }
      }
   }

   /**
    * Dodaje dowolny obiekt model danych do przekazanych id kategorii
    *
    * @param   BaseObject  $object             dowolny obiekt modelu ktory posiada relacje z modelem Category
    * @param   array       $categories         tablica id kategorii do jakich danych produkt ma zostac dodany
    */
   public static function addAsProduct(BaseObject $object, $to_categories = array())
   {
      $c = new Criteria();

      $c->add(ProductHasCategoryPeer::PRODUCT_ID, $object->getPrimaryKey());
      ProductHasCategoryPeer::doDelete($c);

      if (is_array($to_categories))
      {
         foreach ($to_categories as $cat)
         {
            $pc = new ProductHasCategory();

            $pc->setProductId($object->getPrimaryKey());

            $pc->setSpecial(isset($cat['in_additional']) ? true : false);
            $pc->setCategoryId($cat['in_category']);
            $pc->save();
         }
      }
   }

   /**
    * Dodaje produkt do kategorii
    *
    * @param   integer     $product_id         id dodawanego produktu
    * @param   array       $categories         tablica id kategorii do jakich danych produkt ma zostac dodany
    */
   public static function addWebpage($webpage_id, $categories = array())
   {
      $c = new Criteria();
      $c->add(WebpageHasCategoryPeer::WEBPAGE_ID, $webpage_id);
      ProductHasCategoryPeer::doDelete($c);

      if (is_array($categories))
      {
         foreach ($categories as $id)
         {
            $pc = new ProductHasCategory();
            $pc->setProductId($product_id);
            $pc->setCategoryId($id);
            $pc->save();
         }
      }
   }

   /**
    * Zwraca liste kategorii dla danego produktu, funkcja wykorzystywana w imporcie eksporcie
    * Lista kategorii odzielana jest znakiem nowej linii '\n'
    * poszczegolne kategorie sa oddzielane znakiem '|'
    *
    * @author Piotr Halas
    * @param        object      $object
    * @return   string
    */
   public static function getProductCategories($object = null)
   {
      $categories = array();

      $c = new Criteria();
      $c->add(ProductHasCategoryPeer::PRODUCT_ID, $object->getId());
      $c->addDescendingOrderByColumn(ProductHasCategoryPeer::IS_DEFAULT);
      $category_list = ProductHasCategoryPeer::doSelectJoinCategory($c);

      foreach ($category_list as $category)
      {
         $categories[] = CategoryPeer::_getCategoryFullPath($category->getCategory());
      }

      return implode("\n", $categories);
   }

   /**
    * Ustawia liste kategorii dla danego produktu, funkcja wykorzystywana w imporcie eksporcie
    * Lista kategorii odzielana jest znakiem nowej linii '\n'
    * poszczegolne kategorie sa oddzielane znakiem '|'
    *
    * @author Piotr Halas
    * @param        Object      $object
    * @param        string      $cat_info
    */
   public static function setProductCategories($object = null, $cat_info = '')
   {
      $categories = explode("\n", $cat_info);

      $c = new Criteria();
      $c->add(ProductHasCategoryPeer::PRODUCT_ID, $object->getId());
      ProductHasCategoryPeer::doDelete($c);

      $default = true;
      $new_has = array();

      foreach ($categories as $path)
      {
         if (strlen(trim($path)))
         {
            $path = explode("|", $path);
            $parent = null;
            foreach ($path as $category)
            {
               if (strlen(trim($category)))
                  $parent = CategoryPeer::_createCategory($parent, $category);
            }
            
            if (!isset($new_has[$parent->getId()]))
            {
            	$new_has[$parent->getId()] = 1;
            	$new_product_category = new ProductHasCategory();
            	$new_product_category->setProductId($object->getId());
            	$new_product_category->setCategoryId($parent->getId());
            	$new_product_category->setIsDefault($default);
            	$new_product_category->save();
            	$default = false;
            }
         }
      }
   }

   /**
    * Twowrzy drzewo kategorii
    *
    * @author Piotr Halas
    * @param        object      $parent
    * @param        string      $category
    * @return   object
    */
   public static function _createCategory($parent = null, $category = '', $culture = 'pl_PL')
   {
      $c = new Criteria();
      $c2 = $c->getNewCriterion(CategoryPeer::OPT_NAME, $category);
      $c3 = $c->getNewCriterion(CategoryI18nPeer::NAME, $category);
      $c4 = $c->getNewCriterion(CategoryI18nPeer::CULTURE, $culture);
      $c3->addAnd($c4);
      $c2->addOr($c3);
      $c->add($c2);
      $c->addJoin(CategoryI18nPeer::ID, CategoryPeer::ID, Criteria::RIGHT_JOIN);

      if (!$parent)
      {
         $c->add(CategoryPeer::PARENT_ID, null);
         $root = CategoryPeer::doSelectOne($c);
         if (!$root)
         {
            $root = new Category();
            $root->makeRoot();
            $root->setCulture($culture);
            $root->setName($category);
            $root->save();
            $root->setScope($root->getId());
            $root->save();
         }
         return $root;
      }
      else
      {
         $parent->setCulture($culture);

         $c->add(CategoryPeer::PARENT_ID, $parent->getId());
         $c->add(CategoryPeer::SCOPE, $parent->getScope());
         $child = CategoryPeer::doSelectOne($c);
         if (!$child)
         {
            $child = new Category();
            $child->setCulture($culture);
            $child->setName($category);
            $child->insertAsLastChildOf($parent);
            $child->setScope($parent->getScope());
            $child->save();
         }
         else
         {
            $child->setCulture($culture);
         }

         return $child;
      }
   }

   /**
    * Zwraca pelna sciezke do okreslonej kategorii
    *
    * @author Piotr Halas
    * @param        object      $category
    * @return   string
    */
   public static function _getCategoryFullPath($category = null)
   {
      $nodes = $category->getPath('doSelect');
      $path = '';
      foreach ($nodes as $node)
      {
         $path .= $node->getName().'|';
      }
      return $path.$category->getName();
   }

   public static function doSelectMain(Criteria $c = null, $con = null)
   {
      if (is_null($c))
      {
         $c = new Criteria();
      }
      else
      {
         $c = clone $c;
      }

      $c->addJoin(CategoryPeer::PARENT_ID, CategoryPeer::SCOPE);

      return self::doSelect($c, $con);
   }

   public static function fixDepths()
   {
      $c = new Criteria();

      $c->addAscendingOrderByColumn(CategoryPeer::SCOPE);

      $c->addAscendingOrderByColumn(CategoryPeer::LFT);

      $categories = CategoryPeer::doSelect($c);

      $parents[] = array();

      foreach ($categories as $category)
      {
         if ($category->hasChildren())
         {
            $parents[$category->getId()] = $category;
         }

         if ($category->isRoot())
         {

            $category->setScope($category->getId());

            $category->save();

            continue;
         }

         $depth = 0 + $parents[$category->getParentId()]->getDepth();

         $scope = $parents[$category->getParentId()]->getScope();

         $category->setDepth($depth + 1);

         $category->setScope($scope);

         $category->save();
      }
   }

   public static function doSelectExpanded($selected)
   {
      if (!$selected)
      {
         return array();
      }

      if (!isset(self::$expanded[$selected]))
      {
         $c = new Criteria();

         $c->add(CategoryPeer::ID, $selected);

         $current = CategoryPeer::doSelectOneWithI18n($c);
         
         if ($current)
         {
            $categories = $current->getPath('doSelectWithI18n');

            $expanded = array();

            foreach ($categories as $category)
            {
               $expanded[$category->getId()] = $category;
            }

            $expanded[$current->getId()] = $current;

            self::$expanded[$selected] = $expanded;
         }
      }

      return self::$expanded[$selected];
   }

   public static function generateImage($id, $scope, $lft, $rgt)
   {
      $image = null;
      
      $c = new Criteria();
      
      $c->addSelectColumn(ProductPeer::OPT_IMAGE);
      
      $c->addJoin(CategoryPeer::ID, ProductHasCategoryPeer::CATEGORY_ID, 'STRAIGHT_JOIN');

      $c->addJoin(ProductHasCategoryPeer::PRODUCT_ID, ProductPeer::ID, 'STRAIGHT_JOIN');      
      
      $c->add(CategoryPeer::LFT, sprintf('%s BETWEEN %s AND %s', CategoryPeer::LFT, $lft, $rgt), Criteria::CUSTOM);
      
      $c->add(CategoryPeer::SCOPE, $scope);
      
      $c->add(ProductPeer::OPT_IMAGE, null, Criteria::ISNOTNULL);
      
      $c->setLimit(20);
      
      $rs = ProductPeer::doSelectRS($c);
      
      if ($rs && $rs->getRecordCount())
      {                  
         $offset = mt_rand(1, $rs->getRecordCount());
                  
         $rs->absolute($offset);
         
         $image = $rs->getString(1);
         
         if ($image)
         {
            $sf_web_dir = sfConfig::get('sf_web_dir');
            $ext = pathinfo($image, PATHINFO_EXTENSION);
            $dest = 'media/categories/'.$id.'.'.$ext;
            
            copy($sf_web_dir.'/'.$image, $sf_web_dir.'/'.$dest);

            $con = Propel::getConnection();
            
            $ps = $con->prepareStatement(sprintf('UPDATE %s SET %s = ? WHERE %s = ?', CategoryPeer::TABLE_NAME, CategoryPeer::OPT_IMAGE, CategoryPeer::ID));
            
            $ps->setString(1, $dest);
            
            $ps->setInt(2, $id);
            
            $ps->executeQuery();
         }
      }
      
      return $image;
   }     
   
   public static function doSelectCategoriesTokens(Criteria $c)
   {
       $tokens = array();

       $c = clone $c;

       $c->addSelectColumn(self::ID);

       $c->addSelectColumn(self::OPT_NAME);

       $c->addSelectColumn(self::LFT);

       $c->addSelectColumn(self::RGT);

       $c->addSelectColumn(self::SCOPE);

       $rs1 = self::doSelectRs($c);

       while($rs1->next())
       {
           $current = $rs1->getRow();

           $path = array();

           if ($current[0] != $current[4])
           {
              $cc = new Criteria();

              $cc->add(self::LFT, $current[2], Criteria::LESS_THAN);

              $cc->add(self::RGT, $current[3], Criteria::GREATER_THAN);

              $cc->add(self::SCOPE, $current[4]);
              
              $cc->addAscendingOrderByColumn(self::LFT); 
              
              $cc->addSelectColumn(self::OPT_NAME);

              $rs2 = self::doSelectRs($cc); 

              while($rs2->next())
              {                
                  $path[] = $rs2->getString(1);
              }
           }

           $path[] = $current[1];

           $tokens[] = array('id' => $current[0], 'name' => implode(' / ', $path));
       }      

       return $tokens;        
   }

}
