<?php

/**
 * SOTESHOP/stProductGroup 
 * 
 * Ten plik należy do aplikacji stProductGroup opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stProductGroup
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: ProductGroup.php 10258 2011-01-13 15:35:04Z michal $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>,
 */
class ProductGroup extends BaseProductGroup
{

   /**
    * 
    */
   public function __toString()
   {
      return $this->getName();
   }

   /**
    * Zapisuje wartości domyślne dla zapisanej strony
    *
    * @param   string      domyślna           wartość stron $page
    */
   public function setDefaultProductGroup($product_group)
   {
      if ($product_group == "NONE")
         $product_group = NULL;
      $this->setProductGroup($product_group);
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
      $this->setCulture(stLanguage::getHydrateCulture());
      return parent::hydrate($rs, $startcol);
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

      $c->addJoin(ProductPeer::PRODUCER_ID, ProducerPeer::ID);

      if ($this->getProductGroup() != 'NEW' || $this->countProductGroupHasProducts() > 0)
      {
         $c->addJoin(ProductGroupHasProductPeer::PRODUCT_ID, ProductPeer::ID);

         $c->add(ProductGroupHasProductPeer::PRODUCT_GROUP_ID, $this->getId());
      }
      else
      {        
         $config = stConfig::getInstance(sfContext::getInstance(), 'stProduct');

         $c->add(ProductPeer::CREATED_AT,$config->get('new_product_date'),Criteria::GREATER_THAN);
      }

      $c->addGroupByColumn(ProducerPeer::ID);  

      $c->addAscendingOrderByColumn(ProducerI18nPeer::NAME);

      return ProducerPeer::doSelectWithI18n($c);
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
         $v = stLanguage::getDefaultValue($this, __METHOD__);
      return $v;
   }

   /**
    * Przeciążenie setName
    *
    * @param string $v
    */
   public function setName($v)
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         stLanguage::setDefaultValue($this, __METHOD__, $v);
      }

      parent::setName($v);
   }

   public function save($con = null)
   {
      parent::save($con);
      
      ProductGroupPeer::cleanCache();
   }

   public function delete($con = null)
   {
      if (null !== $this->getFromBasketValue())
      {
         ProductGroupPeer::updateProductsWithGift($this, false);
      }
      
      parent::delete($con);

      ProductGroupPeer::cleanCache();      
   }

   /**
    * Przeciążenie getUrl
    *
    * @return string
    */
   public function getUrl()
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
         return stLanguage::getDefaultValue($this, __METHOD__);

      $v = parent::getUrl();
      if (is_null($v))
         $v = stLanguage::getDefaultValue($this, __METHOD__);
      return $v;
   }

   /**
    * Przeciążenie setUrl
    *
    * @param string $v
    */
   public function setUrl($v)
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
         stLanguage::setDefaultValue($this, __METHOD__, $v);
      parent::setUrl($v);
   }

   public function urlFilter($friendly_url)
   {
      $c = new Criteria();

      $c->add(ProductGroupI18nPeer::ID, $this->getPrimaryKey(), Criteria::NOT_EQUAL);

      $c->add(ProductGroupI18nPeer::URL, $friendly_url);

      if (ProductGroupI18nPeer::doCount($c) > 0)
      {
         return $friendly_url.'-'.$this->getPrimaryKey();
      }

      return false;
   }

      /**
    * Przeciążenie getName
    *
    * @return string
    */
   public function getImage()
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         return stLanguage::getDefaultValue($this, __METHOD__);
      }
      $v = parent::getImage();
      if (is_null($v))
         $v = stLanguage::getDefaultValue($this, __METHOD__);
      return $v;
   }

   /**
    * Przeciążenie setName
    *
    * @param string $v
    */
   public function setImage($v)
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         stLanguage::setDefaultValue($this, __METHOD__, $v);
      }

      parent::setImage($v);
   }
   
}

sfPropelBehavior::add('ProductGroup', array('stPropelSeoUrlBehavior' => array('source_column' => 'Name', 'target_column' => 'Url', 'target_column_filter' => 'urlFilter')));