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
 * @version     $Id: Category.php 10240 2011-01-13 14:11:55Z michal $
 */

/**
 * Subclass for representing a row from the 'st_category_tree' table.
 *
 * @package     stCategory
 * @subpackage  libs
 */
class Category extends BaseCategory
{
   public function getShowChildrenProducts()
   {
      return parent::getShowChildrenProducts() || stConfig::getInstance('stCategory')->get('show_children_products');
   }

   public function __toString()
   {
      $nodes = $this->getPath('doSelect');
      $path = '';
      foreach ($nodes as $node)
      {
         if ($node->hasParent())
         {
            $path .= $node->getName() . ' &raquo; ';
         }
      }

      return $path . $this->getName();
   }

   public function hasProducts()
   {
      $c = new Criteria();
      
      if (!$this->isRoot())
      {
         $c->add(CategoryPeer::LFT, sprintf('%s BETWEEN %d and %d', CategoryPeer::LFT, $this->getLft(), $this->getRgt()) , Criteria::CUSTOM);
      }
      
      $c->add(CategoryPeer::SCOPE, $this->getScope());
      $c->addJoin(ProductHasCategoryPeer::CATEGORY_ID, CategoryPeer::ID);

      return ProductHasCategoryPeer::doCount($c) > 0;
   }

   public function setIsActive($v)
   {
      if ($this->is_active != $v)
      {
         $this->is_active = $v;
         $this->modifiedColumns[] = CategoryPeer::IS_ACTIVE;
      }
   }
   
   public function setIsHidden($v)
   {
      if ($this->is_hidden != $v)
      {
         $this->is_hidden = $v;
         $this->modifiedColumns[] = CategoryPeer::IS_HIDDEN;
      }
   }   
   
   public function getOptImage()
   {
      $this->opt_image = parent::getOptImage();
      
      if (!$this->opt_image || !is_file(sfConfig::get('sf_web_dir').'/'.$this->opt_image))
      {                    
         $this->opt_image = CategoryPeer::generateImage($this->id, $this->scope, $this->lft, $this->rgt);
      }
      
      return $this->opt_image;
   }
  
   public function isRoot()
   {
      return $this->parent_id === null;
   }

   public function getLevel()
   {
      return $this->depth;
   }

   public function hasChildren()
   {
      return $this->rgt - $this->lft > 1;
   }

   public function getFriendlyUrl()
   {
      return $this->getUrl();
   }

   public function getUrlPathHelper()
   {
      $config = stConfig::getInstance(null, 'stCategory');

      $path = array();

      $node_count = 0;

      $culture = $this->getCulture();

      $nodes = $this->getPath();

      foreach ($nodes as $node)
      {
         if ($node->isRoot())
            continue;

         $node_count++;

         $node->setCulture($culture);

         $path[] = $node->getName();
      }

      $path[] = $this->getName();

      $path_string = implode('-', $path);

      if (strlen($path_string) > 255)
      {
         return sprintf('%s-%s-%s', $path[0], $path[intval($node_count / 2)], end($path));
      }

      return $path_string;
   }

   public function getProducers(Criteria $c = null, $active = true)
   {
      if (is_null($c))
      {
         $c = new Criteria();
      }
      else
      {
         $c = clone Criteria();
      }

      $c->add(ProductPeer::ACTIVE, $active);

      $c->addJoin(ProductHasCategoryPeer::PRODUCT_ID, ProductPeer::ID);

      $c->addJoin(ProductPeer::PRODUCER_ID, ProducerPeer::ID);

      $c->add(ProductHasCategoryPeer::CATEGORY_ID, $this->getId());

      $c->addGroupByColumn(ProducerPeer::ID);

      $c->addAscendingOrderByColumn(ProducerI18nPeer::NAME);
      
      stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stCategoryModel.postGetProducers', array('criteria' => $c)));
      
      return ProducerPeer::doSelectWithI18n($c);
   }

   /**
    *
    * Dodane na potrzeby admin generator
    *
    * @param string $v
    */
   public function setEditUrl($v)
   {
      $this->setUrl($v);
   }

   public function hasDatabaseRecord($object)
   {
      if (!is_object($object))
      {
         return false;
      }

      $base_class = get_class($object);
      $class_name = $base_class . 'HasCategory';

      if (!class_exists($class_name))
      {
         throw new sfException('Category::hasDatabaseRecord requires ' . $class_name . ' model');
      }

      $c = new Criteria();

      $c->add(constant($class_name . 'Peer::' . strtoupper($base_class) . '_ID'), $object->getPrimaryKey());
      $c->add(constant($class_name . 'Peer::CATEGORY_ID'), $this->getId());

      return call_user_func($class_name . 'Peer::doSelectOne', $c);
   }

   public function getProducts(Criteria $criteria = null)
   {
      if (is_null($criteria))
      {
         $c = new Criteria();
      }
      else
      {
         $c = clone $criteria;
      }

      $c->addJoin(ProductHasCategoryPeer::PRODUCT_ID, ProductPeer::ID);
      $c->addJoin(ProductHasCategoryPeer::CATEGORY_ID, CategoryPeer::ID);

      $c->add(CategoryPeer::LFT, CategoryPeer::LFT . ' BETWEEN ' . $this->getLft() . ' AND ' . $this->getRgt(), Criteria::CUSTOM);
      $c->add(CategoryPeer::SCOPE, $this->getScope());
      $c->add(ProductPeer::ACTIVE, true);

      return ProductPeer::doSelect($c);
   }

   public function getChildrenByCriteria(Criteria $c = null)
   {
      if (is_null($c))
      {
         $c = new Criteria();
      }
      else
      {
         $c = clone $c;
      }

      $c->addAnd(CategoryPeer::PARENT_ID, $this->getPrimaryKey(), Criteria::EQUAL);
      $c->addAnd(CategoryPeer::SCOPE, $this->getScope(), Criteria::EQUAL);
      $c->addAscendingOrderByColumn(CategoryPeer::LFT);

      return CategoryPeer::doSelect($c);
   }

   public function save($con = null)
   {
      if ($this->isModified())
      {
         ProductHasCategoryPeer::cleanCache();
      }

      if (!$this->isNew() && $this->isColumnModified(CategoryPeer::IS_ACTIVE))
      {
         $con = Propel::getConnection();

         $st = $con->prepareStatement(sprintf('UPDATE %s SET %s = ? WHERE %s BETWEEN ? AND ? AND %s = ?', CategoryPeer::TABLE_NAME, CategoryPeer::IS_ACTIVE, CategoryPeer::LFT, CategoryPeer::SCOPE));

         $st->setBoolean(1, $this->getIsActive());

         $st->setInt(2, $this->getLft());

         $st->setInt(3, $this->getRgt());

         $st->setInt(4, $this->getScope());

         $st->executeQuery();
      }
      
      if (!$this->isNew() && $this->isColumnModified(CategoryPeer::IS_HIDDEN))
      {
         $con = Propel::getConnection();

         $st = $con->prepareStatement(sprintf('UPDATE %s SET %s = ? WHERE %s BETWEEN ? AND ? AND %s = ?', CategoryPeer::TABLE_NAME, CategoryPeer::IS_HIDDEN, CategoryPeer::LFT, CategoryPeer::SCOPE));

         $st->setBoolean(1, $this->getIsHidden());

         $st->setInt(2, $this->getLft());

         $st->setInt(3, $this->getRgt());

         $st->setInt(4, $this->getScope());

         $st->executeQuery();
      }      

      if ($this->asfAsset || $this->getSfAssetId() && $this->isColumnModified(CategoryPeer::SF_ASSET_ID))
      {
         $this->setOptImage($this->getsfAsset()->getRelativePath());
      }

      if ($this->isNew() && $this->isRoot())
      {
         $c = new Criteria();

         $c->addSelectColumn('max(' . CategoryPeer::ROOT_POSITION . ')');

         $c->add(CategoryPeer::PARENT_ID, null, Criteria::ISNULL);

         $rs = CategoryPeer::doSelectRS($c);

         if ($rs->next())
         {
            $this->setRootPosition($rs->getInt(1) + 1);
         }
      }

      parent::save($con);
   }

   /**
    * Przeciążenie hydrate
    *
    * @param ResultSet $rs
    * @param int $startcol
    * @return object
    */
   public function hydrate(ResultSet $rs, $startcol = 1)
   {
      if (SF_APP == 'frontend')
      {
         $this->setCulture(stLanguage::getHydrateCulture());
      }

      return parent::hydrate($rs, $startcol);
   }

   /**
    * Przeciążenie getName
    *
    * @return string
    */
   public function getName()
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         return stLanguage::getDefaultValue($this, __METHOD__);
      }

      $v = parent::getName();

      if (is_null($v))
      {
         $v = stLanguage::getDefaultValue($this, __METHOD__);
      }

      return $v;
   }

   /**
    * Przeciążenie setName
    *
    * @param string
    */
   public function setName($v)
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         stLanguage::setDefaultValue($this, __METHOD__, $v);
      }

      parent::setName($v);
   }

   /**
    * Przeciążenie setName
    *
    * @param string
    */
   public function setUrl($v)
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         stLanguage::setDefaultValue($this, __METHOD__, $v);
      }

      parent::setUrl($v);
   }

   public function getUrl()
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         return stLanguage::getDefaultValue($this, __METHOD__);
      }

      $v = parent::getUrl();

      if (is_null($v))
      {
         $v = stLanguage::getDefaultValue($this, __METHOD__);
      }

      return $v;
   }

   /**
    * Przeciążenie getDescription
    *
    * @return string
    */
   public function getDescription()
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         return stLanguage::getDefaultValue($this, __METHOD__);
      }

      $v = parent::getDescription();

      if (is_null($v))
      {
         $v = stLanguage::getDefaultValue($this, __METHOD__);
      }

      return $v;
   }

   /**
    * Przeciążenie setDescription
    *
    * @param string $v
    */
   public function setDescription($v)
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         stLanguage::setDefaultValue($this, __METHOD__, $v);
      }

      parent::setDescription($v);
   }

   /**
    * Dodaje lub zastępuje plik produktu
    *
    * @param string $filename Nazwa pliku jaka zostanie nadana po dodaniu
    * @param string $source_file Pełna ścieżka do dodawanego pliku
    *
    * @return sfAsset Utworzony plik
    */
   public function createAsset($filename, $source_file)
   {
      $check_duplicate = true;

      if (!$this->getPrimaryKey())
      {
         throw new sfException('Kategoria musi być wpierw zapisana do bazy danych...');
      }

      $asset = $this->getsfAsset();

      if (!$asset)
      {
         $asset = new sfAsset();
      }
      else
      {
         $asset->destroy();
      }

      $folder = sfAssetFolderPeer::retrieveByPath('media/categories');

      if (!$folder)
      {
         $folder = sfAssetFolderPeer::createFromPath('media/categories');
      }

      $asset->setsfAssetFolder($folder);

      $asset->setFilename($filename);

      $tmp = $prev = sfConfig::get('app_sfAssetsLibrary_thumbnails');

      foreach ($tmp as $type => $config)
      {
         $tmp[$type]['watermark'] = false;
      }

      sfConfig::set('app_sfAssetsLibrary_thumbnails', $tmp);

      $asset->create($source_file, true, false);

      $this->setsfAsset($asset);

      sfConfig::set('app_sfAssetsLibrary_thumbnails', $prev);

      return $asset;
   }

   public function destroyAsset()
   {
      $asset = $this->getsfAsset();

      if ($asset)
      {
         $asset->delete(null, 'category');

         $this->setOptImage(null);

         $this->setsfAsset(null);
      }
   }

   public function delete($con = null)
   {
      $this->destroyAsset();

      parent::delete($con);

      if ($this->isRoot())
      {
         $con = Propel::getConnection();

         $st = $con->prepareStatement(sprintf('UPDATE %1$s SET %2$s = %2$s - 1 WHERE %2$s > ? AND %3$s IS NULL', CategoryPeer::TABLE_NAME, CategoryPeer::ROOT_POSITION, CategoryPeer::PARENT_ID));

         $st->setInt(1, $this->getRootPosition());

         $st->executeQuery();
      }

      ProductHasCategoryPeer::cleanCache();
   }

   public function urlPathFilter($friendly_url)
   {
      $c = new Criteria();

      $c->add(CategoryI18nPeer::ID, $this->getPrimaryKey(), Criteria::NOT_EQUAL);

      $c->add(CategoryI18nPeer::URL, $friendly_url);

      if (CategoryI18nPeer::doCount($c) > 0)
      {

         return $friendly_url . '-' . $this->getPrimaryKey();
      }

      return false;
   }

}

$columns_map = array('left' => CategoryPeer::LFT, 'right' => CategoryPeer::RGT, 'parent' => CategoryPeer::PARENT_ID, 'scope' => CategoryPeer::SCOPE, 'depth' => CategoryPeer::DEPTH);

sfPropelBehavior::add('Category', array('actasnestedset' => array('columns' => $columns_map)));

sfPropelBehavior::add('Category', array('stPropelSeoUrlBehavior' => array('source_column' => 'UrlPathHelper', 'target_column' => 'Url', 'target_column_filter' => 'urlPathFilter')));
