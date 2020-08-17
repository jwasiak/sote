<?php

/**
 * SOTESHOP/stProducer
 *
 * Ten plik należy do aplikacji stProducer opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stProducer
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: Producer.php 617 2009-04-09 13:02:31Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa Producer
 *
 * @package     stProducer
 * @subpackage  libs
 */
class Producer extends BaseProducer
{

   /**
    * Pobieranie nazwy producenta
    *
    * @return  string      Nazwa producenta
    */
   public function __toString()
   {
      return $this->getName() ? $this->getName() : '';
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
    * @param string $v Nazwa producenta
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

   public function urlFilter($friendly_url)
   {
      $c = new Criteria();

      $c->add(ProducerI18nPeer::ID, $this->getPrimaryKey(), Criteria::NOT_EQUAL);

      $c->add(ProducerI18nPeer::URL, $friendly_url);

      if (ProducerI18nPeer::doCount($c) > 0)
      {
         return $friendly_url.'-'.$this->getPrimaryKey();
      }

      return false;
   }

   public function save($con = null)
   {
      if ($this->asfAsset || $this->getSfAssetId() && $this->isColumnModified(ProducerPeer::SF_ASSET_ID))
      {
         $this->setOptImage($this->getsfAsset()->getRelativePath());
      }  

      if ($this->isModified())
      {
         ProducerPeer::clearCache();
      }   
      
      parent::save($con);
   }

   public function delete($con = null)
   {
      parent::delete($con);

      ProducerPeer::clearCache();
   }

   public function setOptImage($v)
   {
      $this->setImage($v);
   }

   public function getOptImage()
   {
      return $this->getImage();
   }

   public function destroyAsset()
   {
      $asset = $this->getsfAsset();

      if ($asset)
      {
         $asset->delete(null, 'producer');

         $this->setImage(null);

         $this->setsfAsset(null);
      }
   }

   public function createAsset($filename, $source_file)
   {
      if (!$this->getPrimaryKey())
      {
         throw new sfException('Producent musi być wpierw zapisany do bazy danych...');
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

      $folder = sfAssetFolderPeer::retrieveByPath('media/producers');

      if (!$folder)
      {
         $folder = sfAssetFolderPeer::createFromPath('media/producers');
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

}

sfPropelBehavior::add('Producer', array('stPropelSeoUrlBehavior' => array('source_column' => 'Name', 'target_column' => 'Url', 'target_column_filter' => 'urlFilter')));