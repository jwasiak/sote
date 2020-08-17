<?php

/**
 * Subclass for representing a row from the 'st_theme_layout' table.
 *
 * @package     stThemePlugin
 * @subpackage  libs
 */
class ThemeLayout extends BaseThemeLayout
{

   public function save($con = null)
   {
      $this->getTheme()->setUpdatedAt(time());

      $ret = parent::save($con);

      stTheme::clearCache();

      return $ret;
   }

}
