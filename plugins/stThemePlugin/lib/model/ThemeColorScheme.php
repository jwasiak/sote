<?php

/**
 * Subclass for representing a row from the 'st_theme_color' table.
 *
 * 
 *
 * @package plugins.stThemePlugin.lib.model
 */
class ThemeColorScheme extends BaseThemeColorScheme
{

   public function save($con = null)
   {
      if ($this->getIsDefault() && $this->isColumnModified(ThemeColorSchemePeer::IS_DEFAULT))
      {
         $c = new Criteria();
         $c->add(ThemeColorSchemePeer::THEME_ID, $this->getThemeId());
         $c->add(ThemeColorSchemePeer::IS_DEFAULT, true);
         $themeColor = ThemeColorSchemePeer::doSelectOne($c);

         if ($themeColor)
         {
            $themeColor->setIsDefault(false);

            $themeColor->save($con);
         }

         $this->getTheme()->setOptColorScheme($this->getName());
      }
      elseif ($this->getIsDefault() && $this->isColumnModified(ThemeColorSchemePeer::NAME))
      {
         $this->getTheme()->setOptColorScheme($this->getName());
      }
      elseif (!$this->isNew() && $this->getIsDefault() == false && $this->isColumnModified(ThemeColorSchemePeer::IS_DEFAULT))
      {
         $this->getTheme()->setOptColorScheme(null);
      }

      $ret = parent::save($con);

      stTheme::clearCache();

      return $ret;
   }

}
