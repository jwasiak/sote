<?php

use_helper('Javascript');

/**
 * Ładowanie przemieszczania elementów
 */
function st_drop_menu_load_view()
{

   $path = sfConfig::get('sf_root_dir') . DIRECTORY_SEPARATOR . 'apps' . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'soteshop.yml';
   $config = sfYaml::load($path);

   if (!$config['all']['.view']['theme'])
   {
      $userView = ThemeLayoutPeer::doSelectByThemeId(stTheme::getInstance(sfContext::getInstance())->getTheme()->getId());
      $settings = '';

      foreach ($userView as $view)
      {
         $settings .= '"' . $view->getContainer() . '": [';

         $blocks = explode(",", $view->getBlocks());
         foreach ($blocks as $block)
            $settings .= '"' . $block . '",';

         $settings = substr($settings, 0, -1);
         $settings .= '], ';
      }

      $settings = substr($settings, 0, -2);

      return javascript_tag('var settings = {' . $settings . '};');
   }
   else
   {

      return javascript_tag('var settings = {}; var oJsFrame = document.getElementById("js_frame"); oJsFrame.style.display = "block";');
   }
}

/**
 * Ładowanie konfiguracji modułu drop menu
 */
function st_drop_menu_load_config()
{

   if (SF_ENVIRONMENT == 'edit')
   {
      $options = "
                portal: 'portal',
                column: 'portal-column',
                block: 'block',
                content: 'content',
                handle: 'handle',
                hoverclass: 'block-hover',
                toggle: 'block-toggle',
                blocklist: 'portal-column-block-list',
                blocklistlink: 'portal-block-list-link',
                blocklisthandle: 'block-list-handle',
                saveurl: '/frontend_edit.php/stThemeFrontend/SaveView'
               ";
   }
   else
   {
      $options = "
                portal: 'portal',
                column: 'portal-columnX',
                block: 'block',
                content: 'content',
                handle: 'handle',
                hoverclass: 'block-hover',
                toggle: 'block-toggle',
                blocklist: 'portal-column-block-list',
                blocklistlink: 'portal-block-list-link',
                blocklisthandle: 'block-list-handle',
                saveurl: ''
               ";
   }

   return javascript_tag('var options = {' . $options . '};');
}

/**
 * Funkcja przeciążająca css'y
 */
function st_drop_menu_extend_css()
{

   $css_content = '';
   $styles = ThemeCssPeer::doSelectByThemeId(stTheme::getInstance(sfContext::getInstance())->getTheme()->getId());

   foreach ($styles as $style)
   {
      if ($style->getCssHeadId() != 'baner_swf')
         $css_content .= $style->getCssHeadId() . ' { ' . $style->getCssContent() . "; }\n";
   }

   echo content_tag('style', $css_content, array('type' => 'text/css'));
}