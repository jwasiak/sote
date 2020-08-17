<?php
/**
 * SOTESHOP/stAvailabilityPlugin 
 * 
 * Ten plik należy do aplikacji stAvailabilityPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stAvailabilityPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: Availability.php 617 2009-04-09 13:02:31Z michal $
 */

/**
 * Model stAvailabilityPlugin
 *
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl> 
 *
 * @package     stAvailabilityPlugin
 * @subpackage  libs
 */
class Availability extends BaseAvailability
{
    /**
     * Wyświetlenie nazwy zamiast id
     */
    public function __toString()
    {
        return $this->getAvailabilityName();
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
     * Przeciążenie getAvailabilityName
     *
     * @return string
     */
    public function getAvailabilityName()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            return stLanguage::getDefaultValue($this, __METHOD__);   
        }   
        $v = parent::getAvailabilityName();
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $v;
    }
    
    /**
     * Przeciążenie setAvailabilityName
     * 
     * @param string $v
     */
    public function setAvailabilityName($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            stLanguage::setDefaultValue($this, __METHOD__, $v);
        }
        
        parent::setAvailabilityName($v);
    }

   public function setOptImage($v)
   {
      $this->setImage($v);
   }

   public function getOptImage()
   {
      return $this->getImage();
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

      $folder = sfAssetFolderPeer::retrieveByPath('media/availability');

      if (!$folder)
      {
         $folder = sfAssetFolderPeer::createFromPath('media/availability');
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
         $asset->delete(null, 'availability');

         $this->setImage(null);

         $this->setsfAsset(null);
      }
   }

   public function delete($con = null)
   {
      parent::delete($con);
      AvailabilityPeer::cleanCache();
   }

   public function save($con = null)
   {
      if ($this->asfAsset || $this->getSfAssetId() && $this->isColumnModified(ProducerPeer::SF_ASSET_ID))
      {
         $this->setOptImage($this->getsfAsset()->getRelativePath());
      }     
      
      parent::save($con);

      AvailabilityPeer::cleanCache();
   }
}
