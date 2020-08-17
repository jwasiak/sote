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
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stThemeView.php 653 2009-04-16 06:18:48Z michal $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * Klasa rozszerzająca warstwę view dla stTheme
 *
 * @package     stThemePlugin
 * @subpackage  libs
 */
class stThemeView extends sfPHPView 
{

   protected $theme = null;

   protected $themeMode;

   protected $themeCulture;

   protected $themeReturnUrl;

   public function initialize($context, $moduleName, $actionName, $viewName)
   {
      $this->themeMode = SF_ENVIRONMENT == 'theme' && $context->getUser()->isAuthenticated() && $context->getUser()->hasCredential('stThemeBackend.modification');
      
      if (SF_ENVIRONMENT == 'theme')
      {
         $referer = $context->getRequest()->getReferer();
         
         if (strpos($referer, 'backend.php') !== false || strpos($referer, 'backend_dev.php') !== false)
         {
            $context->getUser()->setAttribute('return_url', $referer, 'stThemePlugin');   
         }  

         if ($context->getRequest()->hasParameter('theme_culture'))
         {
            $context->getUser()->setAttribute('culture', $context->getRequest()->getParameter('theme_culture'), 'stThemePlugin');
         }

         $this->themeReturnUrl = $context->getUser()->getAttribute('return_url', '/backend.php', 'stThemePlugin');

         $this->themeCulture = $context->getUser()->getAttribute('culture', stLanguage::getOptLanguage(), 'stThemePlugin');
      }

      parent::initialize($context, $moduleName, $actionName, $viewName);

      if (stConfig::getInstance('stThemeBackend')->get('responsive_vary'))
      {
         $this->context->getResponse()->addVaryHttpHeader('User-Agent');
      }      
   }

	/**
	 * Zwraca instancję obiektu stTheme
	 *
	 * @return   stTheme
	 */
	public function getTheme() 
	{
		if (null === $this->theme) 
		{
			$this->theme = $this->context->getController()->getTheme();
		}

		return $this->theme;
	}

   public function hasThemeMode()
   { 	    
      return $this->themeMode;
   }

	public function smartyIncludeStylesheets($params, &$smarty) 
	{
		if ($this->themeMode) 
		{
			echo minify_get_stylesheets($this->context->getResponse(), isset($params['minify']) && $params['minify'] == 'true', 'cache/css/_editor');
		} 
		else 
		{
			echo minify_get_stylesheets($this->context->getResponse(), isset($params['minify']) && $params['minify'] == 'true');
		}

		if (SF_ENVIRONMENT == 'theme') 
		{
			echo '<link rel="stylesheet" type="text/css" media="screen" href="/css/frontend/stSmartyPlugin.css?v1" />';
         echo '<link rel="stylesheet" type="text/css" media="screen" href="/css/frontend/stThemeEditor.css?v1" />';
         echo '<link rel="stylesheet" type="text/css" media="screen" href="/css/backend/stTinyMCEPlugin.css?v1" />';
		}

	} 

	public function smartyIncludeJavascripts($params, &$smarty) 
	{

		echo minify_get_javascripts($this->context->getResponse(), isset($params['minify']) && $params['minify'] == 'true');

      if ($this->themeMode) 
      {
         echo '<script type="text/javascript" src="/js/tinymce/tinymce.min.js?v427"></script>';         
         echo '<script type="text/javascript" src="/js/jquery-ui-1.8.20.custom.min.js"></script>';
         echo '<script type="text/javascript" src="/js/showEditContent.js"></script>';
         echo '<script type="text/javascript" src="/js/jquery.cookie.js"></script>'; 
      } 
      elseif (SF_ENVIRONMENT == 'theme') 
      {
         $i18n = $this->context->getI18N();

         $i18n->setCulture($this->themeCulture);

         $request = $this->context->getRequest();

         $login_label = $i18n->__('Użytkownik', null, 'stThemeFrontend');

         $password_label = $i18n->__('Hasło', null, 'stThemeFrontend');

         $login_title = $i18n->__('Logowanie do zarządzania tematami', null, 'stThemeFrontend');

         $button_label = $i18n->__('Zaloguj się', null, 'stThemeFrontend');

         $error_message = $i18n->__($request->getError('theme_login'), null, 'stThemeFrontend');

         $login = $request->getParameter('theme_login[login]');

         $login_url = $this->context->getController()->genUrl('stSmartyFrontend/login');

         $return_label = $i18n->__('Powrót', null, 'stThemeFrontend');    

         $i18n->setCulture($this->context->getUser()->getCulture());


         if ($this->getTheme()->getVersion() < 7)
         {
            $js =<<<JS
jQuery(function($) {
   var login = $('<div class="smarty_popup_window" id="smarty_login_form">\
      <div class="smarty_popup_container">\
         <h2>$login_title</h2>\
         <div class="content">\
            <form action="$login_url" method="post">\
               <div class="form-row">\
                  <label for="theme_login_login">$login_label:</label><br />\
                  <input type="text" name="theme_login[login]" value="$login" id="theme_login_login" />\
                  <div class="form_error">$error_message</div>\
               </div>\
               <div class="form-row">\
                  <label for="theme_login_password">$password_label:</label><br />\
                  <input type="password" name="theme_login[password]" id="theme_login_password" />\
               </div>\
               <div class="form-row smarty_button">\
                  <button class="right" type="submit">$button_label</button>\
                  <a href="$this->themeReturnUrl">$return_label</a>\
                  <div class="clr"></div>\
               </div>\
            </form>\
         </div>\
      </div>\
   </div>');

   $('body').prepend(login);

   login.overlay({
      closeOnClick: false,
      closeOnEsc: false,
      top: '34%',
      speed: 'fast',
      mask: {
         color: '#444',
         loadSpeed: 'fast',
         opacity: 0.5,
         zIndex: 30000
      },                        
      load: true,
      onBeforeLoad: function() {

      }
   });
});         
JS;
      }
      else
      {
            $js =<<<JS
jQuery(function($) {
   var login = $('<div class="modal fade" id="myModal" tabindex="-1">\
      <div class="modal-dialog">\
         <div class="modal-content">\
            <div class="modal-header">\
               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>\
               <h4 class="modal-title">$login_title</h4>\
            </div>\
            <div class="modal-body">\
               <form action="$login_url" method="post">\
                  <div class="form-group">\
                     <label for="theme_login_login">$login_label:</label>\
                     <input class="form-control" type="text" name="theme_login[login]" value="$login" id="theme_login_login" />\
                  </div>\
                  <div class="form-group">\
                     <label for="theme_login_password">$password_label:</label>\
                     <input class="form-control" type="password" name="theme_login[password]" id="theme_login_password" />\
                  </div>\
               </form>\
            </div>\
            <div class="modal-footer">\
               <a class="btn btn-default" href="$this->themeReturnUrl">$return_label</a>\
               <button type="button" class="btn btn-primary">$button_label</button>\
            </div>\
         </div>\
      </div>');

   $('body').prepend(login);

   login.modal({
      backdrop: 'static',
      keyboard: false,
      show: true
   });

   login.on('click', '.modal-footer > button.btn-primary', function() {
      login.find('form').submit();
   });
});         
JS;
      }
         echo '<script type="text/javascript">'.$js.'</script>';

      }
	}

	public function smartyIncludeLess($params, &$smarty) 
	{
		if ($this->themeMode) 
		{
			echo minify_get_less($this->context->getResponse(), 'cache/less/_editor');
		} 
		else 
		{
			echo minify_get_less($this->context->getResponse());
		}
	}

	public function smartyIncludeMeta($params, &$smarty) 
	{
		$smarty->smartySet($params, $smarty);

		$response = $this->context->getResponse();

		foreach ($response->getHttpMetas() as $httpequiv => $value) 
		{
			echo tag('meta', array('http-equiv' => $httpequiv, 'content' => $value)) . "\n";
		}

		foreach ($response->getMetas() as $name => $content) 
		{
			if ($name == 'title' || empty($content)) 
			{
				continue;
			}

			echo tag('meta', array('name' => $name, 'content' => $content)) . "\n";
		}

		echo content_tag('title', $response->getTitle()) . "\n";

        foreach ($response->getLinks() as $options)
        {
            echo tag('link', $options);
        }
	}

	public function smartyThemeEdit($params, $content) 
	{
		$decorator = '';

		$decorator = st_drop_menu_load_view();

		$decorator .= st_drop_menu_load_config();

		if (SF_ENVIRONMENT == 'edit') 
		{
			$decorator .= st_get_component('stThemeFrontend', 'editThemeHead');
		} 
		else 
		{
			$decorator .= content_tag('a', '', array('id' => 'portal-block-list-link', 'name' => 'portal-block-list-link'));
		}

		$decorator .= $content;

		if (SF_ENVIRONMENT == 'edit') 
		{
			$decorator .= st_get_component('stThemeFrontend', 'editThemeFoot');
		} 
		else 
		{
			$decorator .= content_tag('div', content_tag('div', content_tag('div', '', array('id' => 'magazine1', 'class' => 'portal-column'))), array('id' => 'portal-column-block-list', 'style' => 'display:none'));
		}

		return $decorator;
	}

	public function renderLayout($content, $default_layout) 
	{
		$smarty = new stSmarty();

		if ($this->getTheme()->getVersion() >= 2 && $this->themeMode) 
		{
			sfLoader::loadHelpers('stPartial');

         $this->context->getI18N()->setCulture($this->themeCulture);

			$content .= st_get_partial('stThemeFrontend/theme_editor', array('theme' => $this->getTheme()->getTheme(), 'return_url' => $this->themeReturnUrl));

         $this->context->getI18N()->setCulture($this->context->getUser()->getCulture());
		}

      if ($this->getTheme()->getVersion() < 7)
      {
         sfLoader::loadHelpers('stUsersOnline');
         $smarty->assign('users_online', st_get_online_users());
         $smarty->assign('show_online_users', st_show_online_users());
   		$smarty->assignLinkTo('new_products_title', 'NOWOŚCI', 'product/list?new=1');
   		$smarty->assignLinkTo('promotion_products_title', 'PROMOCJE', 'product/list?group_id=1');
   		$smarty->assignComponent('stSearch', 'stSearchFrontend', 'searchBox');
   		$smarty->assignComponent('stPartner', 'stPartnerFrontend', 'checkHash');
   		$smarty->assignPartial('stNavigationShowLocation', 'stNavigationFrontend', 'showLocation');
   		$smarty->assignPartial('selectLanguage', 'stLanguageFrontend', 'showLanguages');
   		$smarty->assignComponent('header', 'stWebpageFrontend', 'groupWebpage', array('group_page' => 'HEADER'));
   		$smarty->assign('stBasketList', '<div id="basket_show">' . st_get_component('stBasket', 'show', array('cache_id' => stBasket::cacheId())) . '</div>');
   		$smarty->assignComponent('stCurrencyPickCurrency', 'stCurrencyFrontend', 'pickCurrency');
   		$smarty->assignComponent('footer', 'stWebpageFrontend', 'groupWebpage', array('group_page' => 'FOOTER'));
         $smarty->assign('theme', $this->getThemeConfiguration());
      }

      if (!$smarty->get_template_vars('homepage_url'))
      {
         $smarty->assign('homepage_url', $this->context->getController()->genUrl('stFrontendMain/index'));
      }
      
      $smarty->assign('content', $content);
		$smarty->assign('edit_environment', SF_ENVIRONMENT == 'edit' && sfConfig::get('sf_st_theme_clipboard'));
		$smarty->assign('open', stLicense::isOpen());

		$layout = $this->getTheme()->getLayoutName();

		return $smarty->fetch(($layout ? $layout : $default_layout) . '.html') . st_get_component('stFastCacheFrontend', 'cache');
	}

	public function smartyRenderLayout($source, $smarty) 
	{
		if (preg_match_all('/{render_layout default="([^"]+)"}/', $source, $matches)) 
		{

			$code = array();

			foreach ($matches[0] as $i => $search) 
			{
				$layout_name = $matches[1][$i];

				$code[] = sprintf('{php}$this->_tpl_vars[\'_layout_%1$s\'] = $this->_tpl_vars[\'view\']->renderLayout($this->_tpl_vars[\'content\'], \'%1$s\');{/php}', $layout_name);

				$source = str_replace($search, sprintf('{php}echo $this->_tpl_vars[\'_layout_%s\'];{/php}', $layout_name), $source);
			}

			return implode("\n", $code) . "\n" . $source;
		}

		return $source;
	}

	protected function decorate($content) 
	{
		return $this->decorator ? $this->decorateContent($content) : null;
	}

	protected function decorateContent($content) 
	{
		sfLoader::loadHelpers('SfMinify');

		$smarty = new stSmarty();

		$smarty->register_function('include_meta', array($this, 'smartyIncludeMeta'));

		$smarty->register_function('include_javascripts', array($this, 'smartyIncludeJavascripts'));

		$smarty->register_function('include_stylesheets', array($this, 'smartyIncludeStylesheets'));

		$smarty->register_function('include_less', array($this, 'smartyIncludeLess'));

		$smarty->register_prefilter(array($this, 'smartyRenderLayout'));

		$smarty->assign('content', $content);

		$smarty->assign('view', $this);

		$smarty->assign('lang', stLanguage::getLayoutLanguage());

		if ($this->getTheme()->getTheme()->getVersion() < 2) 
		{
			sfLoader::loadHelpers('stDropMenu');

			$smarty->register_block('theme_edit', array($this, 'smartyThemeEdit'));

			$smarty->register_function('include_theme_edit_stylesheets', 'st_drop_menu_extend_css');

			$this->getTheme()->useStylesheet('style.css', 'first');

			$this->getTheme()->useStylesheet($this->getTheme()->getLayoutName() . '.css', 'first');

			$this->getTheme()->useStylesheet($this->getTheme()->getThemeName() . '.css', 'last');
		} 
		else 
		{
			$theme = $this->getTheme()->getTheme();

         if ($this->themeMode)
         {
            $this->context->getResponse()->addJavascript('/jQueryTools/noty/js/jquery.noty.js', 'last');
            $this->getTheme()->addStylesheet('jquery.noty.css', 'last');
         }

         foreach ($this->getTheme()->getTheme()->getBaseThemes() as $current)
         {
            $this->getTheme()->useStylesheet($current->getTheme() . '.css', 'last');
         }

         $this->getTheme()->useStylesheet($theme->getTheme() . '.css', 'last');

			if ($this->themeMode) 
			{
				if ($this->getTheme()->getVersion() < 7 && is_file($theme->getEditorCssPath('preview_config.less', true))) 
				{
					$this->getTheme()->addLess('_editor/preview_config.less', 'last');
				}

				if (is_file($theme->getEditorCssPath('preview_style.css', true))) 
				{
					$this->getTheme()->useStylesheet('_editor/preview_style.css', 'last');
				}
			} 
			else 
			{
				if ($this->getTheme()->getVersion() < 7 && is_file($theme->getEditorCssPath('config.less', true))) 
				{
					$this->getTheme()->addLess('_editor/config.less', 'last');
				}

				if (is_file($theme->getEditorCssPath('style.css', true))) 
				{
					$this->getTheme()->useStylesheet('_editor/style.css', 'last');
				}
			}  
		}

		return $smarty->fetch('base.html');
	}

	protected function preRenderCheck() 
	{
		if ($this->template == null) 
		{
			// a template has not been set
			$error = 'A template has not been set';

			throw new sfRenderException($error);
		}

		$template = $this->directory . '/' . $this->template;

		if (!is_readable($template)) 
		{
			// the template isn't readable
			throw new sfRenderException(sprintf('The template "%s" does not exist in: %s', $template, $this->directory));
		}
	}

	protected function getThemeConfiguration() 
	{
		$this->config = stConfig::getInstance('stThemeBackend');

		stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stThemeView.themeConfig'));

		$tmp = array();

		$tmp['logo'] = array('name' => $this->config->get('logo_name_text', null, true), 'desc' => $this->config->get('logo_desc_text', null, true));

		return $tmp;
	}
}
