<?php
/**
 * SOTESHOP/stThemePlugin
 *
 * Ten plik należy do aplikacji stThemePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stThemePlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: components.class.php 256 2009-03-30 11:49:45Z marek $
 */

/**
 * Klasa stThemeBackendComponents
 *
 * @package     stThemePlugin
 * @subpackage  actions
 */
class stThemeBackendComponents extends autoStThemeBackendComponents
{
   public function executeResponsive()
   {

      $c = new Criteria();
      $c->add(ThemePeer::VERSION, 7, Criteria::GREATER_EQUAL);
      $c->addAscendingOrderByColumn(ThemePeer::THEME);
      
      $themes = ThemePeer::doSelect($c);
      $options = array("" => $this->getContext()->getI18N()->__('Brak'));
      
      foreach ($themes as $theme)
      {
         $options[$theme->getId()] = $theme->getTheme();
      }

      $this->options = $options;
      $this->selected = stConfig::getInstance('stThemeBackend')->get('responsive');
   }

   public function executeStylingForm()
   {
      $name = $this->theme_config->getTheme()->getName();
            
      $this->config = Yaml::parse(sfConfig::get('sf_config_dir').'/theme/'.$name.'.yml');
   }
   
   public function executeBaseThemeList()
   {
      if ($this->theme->isNew() || $this->theme->getVersion() >= 2)
      {
         $c = new Criteria();
         
         $c->add(ThemePeer::ID, $this->theme->getId(), Criteria::NOT_EQUAL);
      
         $this->base_themes = ThemePeer::doSelectBaseTheme($c);
      }
      else
      {
         $this->base_themes = null;
      }
      
      if ($this->theme->isNew())
      {
         $theme = ThemePeer::doSelectByName('default2');
         
         $this->selected = $theme ? $theme->getId() : null;
      }
      else
      {
         $this->selected = $this->theme->getBaseThemeId();
      }
   }

   public function executeConfigContent()
   {
        $this->config = stConfig::getInstance($this->getContext(), 'stThemeBackend');
   }

   public function executeEditMenu() 
   {
        parent::executeEditMenu();
        $config = new stThemeConfig();
        $theme_config = $config->load($this->theme->getThemeConfig());

        if ($this->theme->getVersion() >= 7)
        {
            unset($this->items["@stThemePlugin?action=colorEdit&id={$this->theme->getId()}"]);
        }

        if (!isset($theme_config['layout_config']))
        {
            unset($this->items["@stThemePlugin?action=layoutEdit&id={$this->theme->getId()}"]);
        }

        if (SF_ENVIRONMENT != 'dev' && !$this->theme->countThemeContents())
        {
           unset($this->items["@stThemePlugin?action=contentList&theme_id={$this->theme->getId()}"]);
        }
   } 
}