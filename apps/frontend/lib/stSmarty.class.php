<?php

/**
 * SOTESHOP/stSMartyPlugin
 *
 * Ten plik należy do aplikacji stSmartyPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stSmartyPlugin
 * @subpackage  lib
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stSmarty.class.php 14787 2011-08-25 10:55:07Z marcin $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */

/**
 * Obsługa dodatkowych template'ów Smarty w Symfony.
 * @package stSmartyPlugin
 */
class stSmarty extends Smarty
{
   protected static $resourcePool = array();

   /**
    * Dispatcher instance
    *
    * @var stEventDispatcher
    */
   protected $dispatcher;

   /**
    * Response instance
    *
    * @var sfWebResponse
    */
   protected $response;

   /**
    * Module name
    *
    * @var string
    */
   protected $moduleName;

   /**
    * Instancja obiektu stTheme
    *
    * @var stTheme
    */
   protected $theme = null;

   /**
    * Context instance
    *
    * @var sfContext
    */
   protected $context = null;

   public static function translateBlock($namespace, $type, $theme_name, $default = null)
   {
      $value = sfContext::getInstance()->getI18N()->__($namespace.':'.$type, null, $theme_name);

      // echo $namespace.':'.$type.":".$theme_name;

      if ($value != $namespace.':'.$type)
      {
         return $value;
      }

      return $default;
   }
 

   public static function clearCache()
   {
      $theme = sfContext::getInstance()->getController()->getTheme();

      $files = glob(sfConfig::get('sf_root_cache_dir').DIRECTORY_SEPARATOR.'smarty_c'.DIRECTORY_SEPARATOR.$theme->getThemeName().DIRECTORY_SEPARATOR.'*');     
      
      foreach ($files as $file)
      {
         unlink($file);
      }
   }



   /**
    * Zwraca instancje obiektu stTheme
    *
    * @return stTheme
    */
   public function getTheme()
   {
      return $this->theme;
   }

   /**
    * Konstruktor. Buduje konfiguracje Smarty - ogólną oraz dla modułów, pluginów.
    *
    * @param string $moduleName     nazwa modułu
    */
   public function __construct($moduleName = '')
   {
      $this->context = sfContext::getInstance();

      $this->response = $this->context->getResponse();

      $this->theme = $this->context->getController()->getTheme();
      $this->template_dir = '';
      $this->dispatcher = stEventDispatcher::getInstance();
      $this->config_dir = sfConfig::get('sf_app_template_dir').DIRECTORY_SEPARATOR."theme".DIRECTORY_SEPARATOR."config";

      $compile_dir = sfConfig::get('sf_root_cache_dir').DIRECTORY_SEPARATOR."smarty_c".DIRECTORY_SEPARATOR.$this->theme->getThemeName();

      if (!is_dir($compile_dir))
      {
         mkdir($compile_dir, 0755, true); 
      }

      $this->compile_dir = $compile_dir;

      $this->setModuleName($moduleName);

      $this->loadHelpers();

      $this->register_function("__", "smarty_lang");
      $this->register_function("image", "smarty_image");
      $this->register_function("link", "smarty_link");

      $this->register_function("tooltip", "smarty_tooltip");
      $this->register_function("init_tooltip", "init_tooltip");
      $this->register_function("edit_image_tooltip", "edit_image_tooltip");

      $this->register_function("include_st_component", "include_st_component");
      $this->register_function("include_file", "include_file");
      $this->register_function("include_content", "include_content");
      $this->register_function("st_category_image_tag", "smarty_st_category_image_tag");
      $this->register_function("st_category_image_path", "smarty_st_category_image_path");
      $this->register_block('st_link_to', 'smarty_st_link_to');
      $this->register_function("st_get_component", array($this, "getComponent"));
      $this->register_function("st_get_partial", array($this, "getPartial"));
      $this->register_function("urlfor", "smarty_urlfor");
      $this->register_function("url_for", "smarty_urlfor");
      $this->register_function('st_socket', 'smarty_st_socket');
      $this->register_function('image_path', 'smarty_image_path');
      $this->register_function('set', array($this, 'smartySet'));
      $this->register_function('stylesheet_tag', array($this, 'smartyStylesheetTag'));
      $this->register_function('use_javascript', array($this, 'smartyUseJavascript'));
      $this->register_function('use_stylesheet', array($this, 'smartyUseStylesheet'));
      $this->register_function('use_less', array($this, 'smartyUseLess'));
      $this->register_function('view_slot', 'smarty_view_slot');
      $this->register_postfilter('smarty_assign_filter');      
      $this->register_prefilter('smarty_slot_filter');
      $this->register_block('content_block', 'smarty_content_block_editable');
      $this->register_function('theme_content',  array($this, 'smartyThemeContent'));
      $this->register_function('basket_add_button', 'smarty_basket_add_button');
      $this->register_function('basket_add_link', 'smarty_basket_add_link');
      $this->register_function('basket_add_quantity', 'smarty_basket_add_quantity');
      $this->register_function('basket_product_options', 'smarty_basket_product_options');
      $this->register_function('paypal_checkout_express_add_link', 'smarty_paypal_checkout_express_add_link');
      $this->register_function('st_asset_image_path', 'smarty_st_asset_image_path');
      $this->register_modifier('format_price', array($this, 'smartyFormatPrice'));

      $this->assign('sf_context', $this->context);
      $this->assign('theme', $this->getTheme());
      $this->assign('sf_user', $this->context->getUser());
      $this->assign('sf_request', $this->context->getRequest());
      $this->assign('homepage_url', st_url_for('stFrontendMain/index'));
      $this->assign('shopinfo', stConfig::getInstance('stShopInfoBackend'));
      $this->assign('is_mobile', MobileDetect::getInstance()->isMobile());

      parent::Smarty();
   }
   /**
    * Sets module name
    *
    * @param string $moduleName Module name
    * @return void
    */
   public function setModuleName($moduleName)
   {
      $this->moduleName = $moduleName;

      if (!empty($moduleName))
      {
         $this->config_dir = $this->theme->getTemplateDir($moduleName).DIRECTORY_SEPARATOR.'config';
      }
   }

   /**
    * Returns module name
    *
    * @return string
    */
   public function getModuleName()
   {
      return $this->moduleName;
   }

   /**
    * Get context instance
    *
    * @return sfContext
    */
   public function getContext()
   {
      return $this->context;
   }

   public function smartyFormatPrice($price, $digits = 2)
   {
      return st_format_price($price, $digits);
   }

   public function smartyStylesheetTag($params, $smarty)
   {
      echo st_theme_stylesheet_tag($params['href']);
   }

   public function smartyUseJavascript($params, $smarty)
   {
      $this->response->addJavascript($params['src'], isset($params['position']) ? $params['position'] : '');
   }

   public function smartyUseStylesheet($params, $smarty)
   {
      if ($params['src'][0] == '/')
      {
         $this->response->addStylesheet($params['src'], isset($params['position']) ? $params['position'] : '');
      }
      else
      {
         $this->theme->addStylesheet($params['src'], isset($params['position']) ? $params['position'] : '');
      }
   }

   public function smartyThemeContent($params)
   {      
      return st_theme_get_content($params['id']);
   }
   
   public function smartyUseLess($params, $smarty)
   {
      $this->theme->addLess($params['src'], isset($params['position']) ? $params['position'] : '');
   }   

   public function smartySet($params, $smarty)
   {
      if (isset($params['meta_title']))
      {
         $this->response->setTitle($params['meta_title']);
      }

      if (isset($params['meta_keywords']))
      {
         $this->response->addMeta('keywords', $params['meta_keywords'], true);
      }

      if (isset($params['meta_description']))
      {
         $this->response->addMeta('description', $params['meta_description'], true);
      }

      if (isset($params['meta_robots']))
      {
         $this->response->addMeta('robotos', $params['meta_robots'], true);
      }

      if (isset($params['canonical_link']))
      {
         $this->response->setCanonicalLink($params['canonical_link']);
      }

      if (isset($params['layout']))
      {
         $this->theme->setLayoutName($params['layout']);
      }
   }

   public function assignComponent($name, $module, $component, $params = array())
   {
      $this->_tpl_vars['_assigns'][$name] = array('type' => 'component', 'module' => $module, 'component' => $component, 'params' => $params);
   }

   public function assignPartial($name, $module, $component, $params = array())
   {
      $this->_tpl_vars['_assigns'][$name] = array('type' => 'partial', 'module' => $module, 'partial' => $component, 'params' => $params);
   }

   public function assignUrlFor($name, $internal_url, $params = array())
   {
      $this->_tpl_vars['_assigns'][$name] = array('type' => 'url_for', 'internal_url' => $internal_url, 'params' => $params);
   }

   public function assignLinkTo($name, $label, $internal_url, $params = array())
   {
      $this->_tpl_vars['_assigns'][$name] = array('type' => 'link_to', 'label' => $label, 'internal_url' => $internal_url, 'params' => $params);
   }

   function getComponent($params, $smarty)
   {
      if (isset($params['params']))
      {
         $parameters = _parse_attributes($params['params']);
      }
      else
      {
         $parameters = $params;
         unset($parameters['module']);
         unset($parameters['component']);
      }

      return st_get_component($params['module'], $params['component'], $parameters);
   }

   function getPartial($params, $smarty)
   {
      if (isset($params['params']))
      {
         $parameters = _parse_attributes($params['params']);
      }
      elseif ($this->theme->getVersion() >= 7)
      {
         $parameters = $params;
         unset($parameters['partial']);
      }   

      return st_get_partial($params['partial'], $parameters);
   }   

   public function smartyProcessAssign($name)
   {
      switch ($this->_tpl_vars['_assigns'][$name]['type'])
      {
         case 'component':
            $this->_tpl_vars[$name] = st_get_component($this->_tpl_vars['_assigns'][$name]['module'], $this->_tpl_vars['_assigns'][$name]['component'], $this->_tpl_vars['_assigns'][$name]['params']);
            break;
         case 'partial':
            $this->_tpl_vars[$name] = st_get_partial($this->_tpl_vars['_assigns'][$name]['module'].'/'.$this->_tpl_vars['_assigns'][$name]['partial'], $this->_tpl_vars['_assigns'][$name]['params']);
            break;
         case 'url_for':
            $this->_tpl_vars[$name] = st_url_for($this->_tpl_vars['_assigns'][$name]['internal_url'], $this->_tpl_vars['_assigns'][$name]['is_absolute']);
            break;
         case 'link_to':
            $this->_tpl_vars[$name] = st_link_to($this->_tpl_vars['_assigns'][$name]['label'], $this->_tpl_vars['_assigns'][$name]['internal_url'], $this->_tpl_vars['_assigns'][$name]['params']);
            break;
      }
   }

   /**
    * Zwraca szablon smarty dla danego tematu. Jeśli nie ma plików tematu to zwracane są szablony z tematu 'default'.
    *
    * @param string $resource_name
    * @param string $cache_id
    * @param string $compile_id
    */
   function fetch($resource_name, $cache_id = null, $compile_id = null, $display = false)
   {
      $namespace = $this->moduleName ? $this->moduleName . '.' . $resource_name : $resource_name;

      if ($this->dispatcher->getListeners('stSmarty.render.' . $resource_name))
      {
         $this->dispatcher->notify(new sfEvent($this, 'stSmarty.render.' . $resource_name));
      }

      if ($this->dispatcher->getListeners('smarty.render.' . $namespace))
      {
         $value = $this->dispatcher->filter(new sfEvent($this, 'smarty.render.' . $namespace), $resource_name)->getReturnValue();

         if ($value)
         {
            $resource_name = $value;
         }
      }

      $resource_path = $this->findThemeResource($this->theme->getTheme(), $resource_name);

      return parent::fetch($resource_path, $cache_id, $compile_id, $display);
   }

   protected function findThemeResource(Theme $theme, $resource_name)
   {
      $id = $this->moduleName.$resource_name;

      if (!isset(self::$resourcePool[$id]))
      {
         if (is_file($resource_path = $theme->getTemplateDir($this->moduleName ? $this->moduleName : null).'/'.$resource_name))
         {
            self::$resourcePool[$id] = $resource_path;
         } 
         elseif (is_file($resource_path = $theme->getTemplateDir().'/'.$resource_name))
         {
            self::$resourcePool[$id] = $resource_path;
         }
         elseif ($theme->hasBaseTheme())
         {
            return $this->findThemeResource($theme->getBaseTheme(), $resource_name);
         }  
         else
         {
            throw new Exception(__('Brakuje pliku template smarty: '.$this->moduleName.':'.$resource_name));
         }
      }

      return self::$resourcePool[$id];
   }

   /**
    * assigns values to template variables
    *
    * @param array|string $tpl_var the template variable name(s)
    * @param mixed $value the value to assign
    */
   function fc_assign($tpl_var, $value = null)
   {
      // 2010-11-23 m@sote.pl add $lang
      $context = sfContext::getInstance();
      $sf_user = $context->getUser();
      $lang = $sf_user->getCulture();
      // end

      if (is_array($tpl_var))
      {
         foreach ($tpl_var as $key => $val)
         {
            if ($key != '')
            {
               $this->_tpl_vars[$key] = $val;
            }
         }
      }
      else
      {
         if ($tpl_var != '')
         {
            if (ST_FAST_CACHE_SAVE_MODE == 1)
            {
               $value = stFastCacheCode::code($tpl_var, 'fc_assign', $lang);
            }
            elseif (ST_FAST_CACHE_DEFAULT_MODE == 1)
            {
               stFastCacheCode::save($tpl_var, $value, $lang); // 2010-11-23 m@sote.pl add $lang                       
            }
            else
            {
               // fast cache code, update assign information
               $context = sfContext::getInstance();
               $sf_user = $context->getUser();
               $sf_user->setAttribute($tpl_var, $value);
               // end                      
            }
            $this->_tpl_vars[$tpl_var] = $value;
         }
      }
   }

   protected function loadHelpers()
   {
      static $loaded = false;

      if (!$loaded) {
         sfLoader::loadHelpers(array('Helper', 'stBasket', 'stPaypalExpress', 'stUrl', 'stPartial', 'stAsset', 'stCurrency'));

         $loaded = true;
      }
   }

}

/**
 * Funkcja przypisana do {lang} w Smarty. Wyświetla tekst w odpowiednim języku w szablonach.
 *
 * @param array  $params
 * @param object $smarty
 */
function smarty_lang($params, &$smarty)
{
   $catalogue = 'messages';

   $text = $params['text'];

   if (isset($params['catalogue']))
   {
      $catalogue = $params['catalogue'];
      unset($params['catalogue']);
   }
   
   if (isset($params['langCatalogue']))
   {
      $catalogue = $params['langCatalogue'];
      unset($params['langCatalogue']);
   }

   if (isset($params['langAgrs']) && $params['langAgrs'])
   {
      $arguments = _parse_attributes($params['langAgrs']);
   }
   else
   {
      $arguments = $params ? $params : array();
   }
   
   return sfI18N::getInstance()->__($text, $arguments, $catalogue);
}

function smarty_view_slot($params)
{
   stEventDispatcher::getInstance()->notify(new sfEvent($params['subject'], $params['name']));
}

function smarty_assign_filter($compiled, &$smarty)
{
   static $already_assigned = array();
   
   $assign_content = array();

   if (preg_match_all('/\$this->_tpl_vars\[\'([^\']+)\'\]/', $compiled, $matches))
   {
      
      foreach ($matches[1] as $assign)
      {
         if (isset($already_assigned[$assign]))
         {
            continue;
         }
         
         $already_assigned[$assign] = true;
         
         $assign_content[] = sprintf('if (isset($this->_tpl_vars[\'_assigns\'][\'%s\']))', $assign);

         $assign_content[] = '{';

         $assign_content[] = sprintf('   $this->smartyProcessAssign(\'%s\');', $assign);

         $assign_content[] = '}';
      }
   }

   return $assign_content ? "<?php\n".implode("\n", $assign_content)."\n?>\n".$compiled : $compiled;
}

function smarty_slot_filter($source, &$smarty)
{
   $theme = stTheme::getInstance(sfContext::getInstance())->getTheme();

   return stSmartySlotFilterPropel::filter($theme, $source);
}

/**
 * Funkcja przypisana do {image} w Smarty. Wyświetla zdjęcie.
 *
 * @param array  $params parametry <image>: 'src' 'alt'
 * @param object $smarty
 */
function smarty_image($params, &$smarty)
{
   return st_theme_image_tag($params['src'], $options = array('alt' => $params['alt']));
}

/**
 * Funkcja przypisania do {link}. Przypisanie otwarcia linku <a ...>.
 * Treść linku jest automatycznie tłumaczona. Funkcja weryfikuje czy dany routing, do którego kieruje link istnieje.
 *
 * @param array  $params
 * @param object $smarty
 */
function smarty_link($params, &$smarty)
{
   if (empty($params['langAgrs']))
      $params['langAgrs'] = array();
   if (empty($params['langCatalogue']))
      $params['langCatalogue'] = 'messages';


   return link_to(__($params['text'], $params['langAgrs'], $params['langCatalogue']), $params['uri']);
}

/**
 * Zalacza zawartość o danym id kontenera
 * @deprecated Metoda nie jest już używana w tematach od wersji 2.0 i powinna zostać usunięta w przyszłości
 * @param array $params
 * @param object $smarty
 */
function include_content($params, &$smarty)
{
}

/**
 * Zalacza plik o danym id
 *
 * @param array $params
 * @param object $smarty
 */
function include_file($params, &$smarty)
{
   $smarty->display($params['id'].'.html');
}

/**
 * Zwraca tooltip
 *
 * @deprecated since 7.0
 * @param array $params
 * @param object $smarty
 * @return HTML
 * @todo przeniesc do stTooltip
 */
function smarty_tooltip($params, &$smarty)
{
   return null;
}

/**
 * Zwraca tooltip
 *
 * @deprecated since 7.0
 * @param array $params
 * @param object $smarty 
 * @return HTML
 * @todo przeniesc do stTooltip
 */
function edit_image_tooltip($params, &$smarty)
{
   return '';
}

/**
 * @todo Przeniesc do stTooltip
 * @deprecated since 7.0
 */
function init_tooltip($params, &$smarty)
{
   return null;
}

/**
 * Załacza komponent
 *
 * @param array $params
 * @param object $smarty
 * @todo dodac obsluge logger'a
 */
function include_st_component($params, &$smarty)
{
   if (!empty($params['params']))
   {
      $params2 = array('params' => $params['params']);
   }
   else
      $params2=array();
   echo st_get_component($params['module'], $params['component'], $params2);
}

function smarty_st_category_image_tag($params, $smarty)
{
   return st_category_image_tag($params['category'], $params['image_type']);
}

function smarty_st_category_image_path($params, $smarty)
{
   return st_category_image_path($params['category'], $params['image_type']);
}

function smarty_st_link_to($params, $content, &$smarty, &$repeat)
{
   use_helper('stUrl');

   if (isset($params['uri']))
   {
      $uri = $params['uri'];
      unset($params['uri']);
   }

   return st_link_to($content, $uri, $params);
}

function smarty_compiler_content_block($tag_arg, $smarty)
{
   throw new sfException(var_export($tag_arg));
}

function smarty_content_block_editable($params, $org_content, $smarty, $repeat)
{
   if (!$repeat)
   {
      $content = smarty_content_block($params, $org_content);

      if (SF_ENVIRONMENT == 'theme')
      {
         $name = $params['name'];

         $id = uniqid();

         $params['content'] = trim($org_content);

         $params['content_type'] = $params['type'];

         $params['type'] = 'content_block';

         $js = "\n<script type=\"text/javascript\">jQuery(\"#$name\\\:".$id."\").data(\"smarty\", \"".addslashes(json_encode($params))."\");</script>";

         return '<div class="smarty_component content_block_type" id="'.$name.':'.$id.'">'.$content.'</div>'.$js;
      }

      return $content;
   }
}

function smarty_content_block($params, $content)
{
   static $context = null, $culture = null, $cache = null;

   if (null === $context)
   {
      $context = sfContext::getInstance();

      $culture = $context->getUser()->getCulture();

      $cache = sfConfig::get('sf_cache') ? new stFunctionCache('SmartyContentBlock') : null;
   }

   $namespace = $params['name'];

   if ($cache && $cache->has($culture, $namespace))
   {
      $block_content = $cache->get($culture, $namespace);

      if ($block_content)
      {
         $content = $block_content;
      }
   }
   else 
   {
      $block = SmartyContentBlockPeer::retrieveByName($namespace, $culture);

      $theme_name = stTheme::getInstance($context)->getThemeName();

      if (null === $block && $culture != stLanguage::getOptLanguage())
      {
         $block = SmartyContentBlockPeer::retrieveByName($namespace, stLanguage::getOptLanguage());
      }
   
      $block_content = null !== $block ? $block->getContent() : array();
      
      if (isset($params['decorator']) && $params['decorator'])
      {
         switch($params['decorator'])
         {
            case 'box':
               if (!isset($block_content['title']) || !$block_content['title'])
               {
                  if (isset($params['title']))
                  {
                     $block_content['title'] = $params['title'];
                  }

                  $block_content['title'] = stSmarty::translateBlock($namespace, 'title', $theme_name, $block_content['title']);
               }

               if (!isset($block_content['content']) || !$block_content['content'])
               {
                  $block_content['content'] = stSmarty::translateBlock($namespace, 'content', $theme_name);
               }      

               $content = '<div class="box roundies"><h3 class="head">'.$block_content['title'].'</h3><div class="content">'.$block_content['content'].'</div></div>';
            break;

            default:
               if (isset($block_content['content']) && $block_content['content'])
               {
                  $content = $block_content['content'];
               }
            break;
         } 
      }
      elseif (!isset($block_content['content']))
      {
         $content = stSmarty::translateBlock($namespace, 'content', $theme_name, $content);
      }
      else
      {
         $content = $block_content['content'];
      }

      if ($cache)
      {
         $cache->set($culture, $namespace, $content);
      }
   }  

   return $content;
}

function smarty_urlfor($params)
{
   return isset($params['secure']) && $params['secure'] ? st_secure_url_for($params['internal']) : st_url_for($params['internal'], isset($params['absolute']) && $params['absolute']);
}

function smarty_st_socket($params, $smarty)
{
   $name = $params['name'];
   $type = $params['type'];

   unset($params['name']);
   unset($params['type']);

   return stSocketView::open($type, $name, $params);
}

function smarty_image_path($params)
{
   return _st_get_image_path($params['image']);
}

function smarty_basket_add_button($params)
{
    return st_basket_add_button($params['namespace'], $params['product'], $params);
}

function smarty_basket_add_link($params)
{
    return st_basket_add_link($params['namespace'], $params['product'], $params);
}

function smarty_basket_add_quantity($params)
{
    return st_basket_add_quantity($params['namespace'], $params['product'], $params);
}

function smarty_basket_product_options($params)
{
    return st_basket_product_options($params['namespace'], $params['product']);
}

function smarty_paypal_checkout_express_add_link($params)
{
    return st_paypal_checkout_express_add_link($params['namespace'], $params['product']);
}

function smarty_st_asset_image_path($params)
{   
   return st_asset_image_path($params['image'], $params['type'], $params['for'], false, isset($params['absolute']) && $params['absolute']);
}