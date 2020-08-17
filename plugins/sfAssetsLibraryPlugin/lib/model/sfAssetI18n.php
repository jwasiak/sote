<?php

/**
 * Subclass for representing a row from the 'sf_asset_i18n' table.
 *
 * 
 *
 * @package plugins.sfAssetsLibraryPlugin.lib.model
 */ 
class sfAssetI18n extends BasesfAssetI18n
{
   public function save($con = null)
   {
      if (null === $this->culture)
      {
         return 0;
      }

      return parent::save($con);
   }
}
