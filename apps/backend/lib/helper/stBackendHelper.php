<?php

use_helper('stUrl', 'stPartial', 'I18N');

function get_navbar_attributes($item)
{
   static $version = null;

   if (null === $version)
   {
      $version = stSoteshopVersion::getVersion();
   }

   $attributes = array();

   $items = sfConfig::get('app_navigation_bar_items');

   if (isset($items[$item]['version']) && constant('stSoteshopVersion::'.$items[$item]['version']) != $version) 
   {
      return false;
   }

   if (isset($items[$item]['route']))
   {
      $route = $items[$item]['route'];

      $attributes['is_external'] = strpos($route, "://") !== false;

      $attributes['route'] = $route;
   }
   else
   {
      $attributes['route'] = false;
   }


   if (isset($items[$item]['icon']))
   {
      $attributes['icon'] = $items[$item]['icon']{0} == '/' ? $items[$item]['icon'] : '/images/backend/main/icons/'.$items[$item]['icon'];
   }
   else
   {
      $attributes['icon'] = false;
   }

   if (isset($items[$item]['icon_path']))
   {
      $attributes['icon_path'] = $items[$item]['icon_path'];
   }

   $attributes['label'] = isset($items[$item]['label']) ? $items[$item]['label'] : $item;

   $attributes['i18n'] = isset($items[$item]['i18n']) ? $items[$item]['i18n'] : 'stBackend';

   return $attributes;
}

function get_gadget_source(DashboardGadget $gadget)
{
   $source = $gadget->isExternal() ? $gadget->getSource() : st_url_for($gadget->getSource());

   $query = strpos($source, '?') ? '&amp;' : '?';

   $params = array('culture='.sfContext::getInstance()->getUser()->getCulture());

   if (!$gadget->isExternal())
   {
      $params[] = 'gadget_id='.$gadget->getId();
      $params[] = 'dashboard_id='.$gadget->getDashboardId();
      
      if (sfConfig::get('sf_debug'))
      {
         $params[] = 'cache=0';
      }
   }

   $params[] = 'refreshed_at='.$gadget->getRefreshedAt();

   $min_height = $gadget->getMinHeight() ? $gadget->getMinHeight().'px' : 'auto';

   $max_height = $gadget->getMaxHeight() ? $gadget->getMaxHeight().'px' : 'auto';

   return '<iframe src="'.$source.$query.implode('&', $params).'" scrolling="no" frameborder="0" width="100%" style="min-height: '.$min_height.'; max-height: '.$max_height.'"></iframe>';
}

function get_gadget_layout(Dashboard $dashboard)
{
   if ($dashboard->getIsDefault())
   {
      $js = "jQuery('#dashboard > .menu a[href=#default]').hide();";
   }
   else
   {
      $js = "jQuery('#dashboard > .menu a[href=#default]').show();"; 
   }

   return st_get_fast_partial('stDashboard/'.$dashboard->getLayout(), array('dashboard' => $dashboard)).javascript_tag($js);
}

function get_gadgets(Dashboard $dashboard, $column)
{
   return st_get_fast_partial('stDashboard/gadgets', array('gadgets' => $dashboard->getGadgetsByColumn($column), 'column' => $column, 'dashboard' => $dashboard));
}

function get_gadget_column_id($dashboard, $column)
{
   return 'column-'.($dashboard instanceof Dashboard ? $dashboard->getId() : $dashboard).'-'.$column;
}

function gadget_color_tag($name, DashboardGadget $gadget)
{
   $colors = sfConfig::get('app_dashboard_gadget_colors');

   $html = '';

   $current = $gadget->getColor();

   $id = get_id_from_name($name);

   foreach ($colors as $color)
   {
      $color = '#'.$color;

      if ($color == $current)
      {
         $html .= '<li class="current"><a style="background-color: '.$color.'" href="'.$color.'"></a></li>';
      }
      else
      {
         $html .= '<li><a style="background-color: '.$color.'" href="'.$color.'"></a></li>';
      }
   }

   $js =<<<JS
   jQuery(function($) {
      var colors = $('#colors-$id a');
      colors.click(function(event) {
         var a = $(this);
         $('#$id').val(a.attr('href'));
         colors.parent().removeClass('current');
         a.parent().addClass('current');
         event.preventDefault();
      });
   });
JS;

   return '<div id="colors-'.$id.'" class="colors"><ul>'.$html.'</ul><div class="clr"></div>'.javascript_tag($js).input_hidden_tag($name, $current).'</div>';
}

function gadget_refresh_rates_tag($name, DashboardGadget $gadget)
{
   $options = array();
      
   foreach (sfConfig::get('app_dashboard_gadget_refresh_rates') as $rate => $attr)
   {
      $options[$rate] = __($attr['label'], null, 'stBackend');
   }
   
   return select_tag($name, options_for_select($options, $gadget->getRefreshBy()));
}

function get_dashboard_layout_tag($name, Dashboard $dashboard)
{
   $layouts = sfConfig::get('app_dashboard_layouts');

   $html = '';

   $current = $dashboard->getLayout();

   $id = get_id_from_name($name);

   foreach ($layouts as $layout => $params)
   {
      if ($layout == $current)
      {
         $html .= '<li class="current"><a href="#'.$layout.'"><img src="/images/backend/beta/gadgets/layouts/'.$layout.'.png" /></a></li>';
      }
      else
      {
         $html .= '<li><a href="#'.$layout.'"><img src="/images/backend/beta/gadgets/layouts/'.$layout.'.png" /></a></li>';
      }
   }

   $js =<<<JS
   jQuery(function($) {
      var layouts = $('#layouts-$id a');
      layouts.click(function(event) {
         var a = $(this);
         $('#$id').val(a.attr('href').slice(1));
         layouts.parent().removeClass('current');
         a.parent().addClass('current');
         event.preventDefault();
      });
   });
JS;

   return '<div id="layouts-'.$id.'" class="layouts"><ul>'.$html.'</ul><div class="clr"></div>'.javascript_tag($js).input_hidden_tag($name, $current).'</div>';
}


function backend_language_picker()
{
   if (stSoteshopVersion::getVersion() != stSoteshopVersion::ST_SOTESHOP_VERSION_INTERNATIONAL)
   {
      $culture = sfContext::getInstance()->getUser()->getCulture();

      if($culture == 'pl_PL')
      {
         echo image_tag('backend/stLanguagePlugin/polish_active.png');
         echo link_to(image_tag('backend/stLanguagePlugin/english_inactive.png'), 'language/changeLanguage?name=en');
      }
      elseif ($culture== 'en_US')
      {
         echo link_to(image_tag('backend/stLanguagePlugin/polish_inactive.png'), 'language/changeLanguage?name=pl');
         echo image_tag('backend/stLanguagePlugin/english_active.png');
      }
   }
}

function gadget_url_for($internal_url, $parameters = array())
{


   $request = sfContext::getInstance()->getRequest();

   $url_params = array(
      'gadget_id='.$request->getParameter('gadget_id'),
      'dashboard_id='.$request->getParameter('dashboard_id'),
      'cache=0'
   );

   foreach ($parameters as $name => $value)
   {
      $url_params[] = $name.'='.rawurlencode($value);
   }

   return st_url_for($internal_url).'?'.implode('&', $url_params);
}

function get_backend_header_text() 
{
   $host = sfContext::getInstance()->getRequest()->getHost();

   return sprintf('<a href="%s"><img src="/images/backend/main/icons/logo_sote_top.png" alt="home" />%s<br /><span>Sell Your Products in Poland and Europe</span></a>', st_url_for('@homepage'), $host);
}

function get_backend_version_information()
{
   $cache = new stFunctionCache('stBackend');

   return $cache->cacheCall('_backend_version_information', array('culture' => sfContext::getInstance()->getUser()->getCulture())); 
}

function _backend_version_information()
{

   $lang = sfContext::getInstance()->getUser()->getCulture();

   $content = array();

   if (stLicense::isOpen()) 
   {
   $content[] = '<a href="http://www.sote.pl/open" target="sote" style="text-decoration: none; color: #555;">'.__('Darmowy sklep internetowy SOTESHOP OPEN', null, 'stBackendMain').'</a>';
   } else {
      if ($lang == 'pl_PL') 
      {
         $content[] = '<a href="https://www.sote.pl/" target="_blank" rel="noopener" style="text-decoration: none; color: #555;">'.__('SOTESHOP', null, 'stBackendMain').'</a>';
      } else {
         $content[] = '<a href="https://www.soteshop.com/" target="_blank" rel="noopener" style="text-decoration: none; color: #555;">'.__('SOTESHOP', null, 'stBackendMain').'</a>';
      }
   }

   $version = stRegisterSync::getPackageVersion('soteshop');

   if (stCommunication::getIsSeven())
   {

      list(, $y, $z) = explode('.', $version, 3);
      $content[] = '7.'.($y-3).'.'.$z;

   }  
   else  
   {
      $content[] = $version ? $version : stRegisterSync::getPackageVersion('soteshop_base');   
   }

   if (stDevelState::isBeta())
   {
      $content[] = '(Beta)';
   }

   // if (stLicense::isOpen()) 
   // {
   //    $text_order = __('Zamów wersję komercyjną', null, 'stBackendMain');
   //    if ($lang == 'pl_PL') 
   //    {
   //       $content[] = '<a target="sote" href="http://www.sote.pl/licencja-soteshop.html">'.$text_order.'</a>';
   //    } else {
   //       $content[] = '<a target="sote" href="http://www.soteshop.com/soteshop-license.html">'.$text_order.'</a>';
   //    }
   // }

   return implode(' ', $content);
}

function already_called($namespace)
{
   static $called = array();

   if (isset($called[$namespace]))
   {
      return true;
   }

   $called[$namespace] = true;

   return false;
}

function init_tooltip($selector = ".tooltip", $options = array())
{  
   static $selectors = array();

   $uniqid = md5($selector);

   if (!isset($selectors[$uniqid]))
   {
      $selectors[$uniqid] = true;
   }
   else
   {
      return;
   }

   if (isset($options['width']))
   {
      $width = $options['width'];

      unset($options['width']);
   }      
   else
   {
      $width = '300px';
   }

   $id = 'jquery_tooltip_'.$uniqid;

   $html = '<div id="'.$id.'" class="jquery_tooltip" style="width: '.$width.'"></div>';

   $options['tip'] = '#'.$id;
   
   if (!isset($options['delay']))
   {
     $options['delay'] = 0;
   }
   
   if (!isset($options['position']))
   {
      $options['position'] = 'bottom right';
   }
   
   if (!isset($options['offset']))
   {
      $options['offset'] = array(0, 10);
   }  
   
   $options = json_encode($options);
   
   $js =<<<JS
   jQuery(function($) {
      $(document).ready(function() {     
        $('$selector').tooltip($options);
      });      
   });   
JS;

   echo $html.javascript_tag($js);
}

function get_service_information()
{
   $cache = new stFunctionCache('stBackend');

   $cache->removeAll();

   return $cache->cacheCall('_service_information', array('culture' => sfContext::getInstance()->getUser()->getCulture())); 
}

function _service_information()
{
   $lang = sfContext::getInstance()->getUser()->getCulture();

   if (stLicense::isOpen()) {
      if ($lang == 'pl_PL')
         $url = 'https://www.sote.pl/licencja-soteshop.html';
      else 
         $url = 'https://www.soteshop.com/soteshop-license.html';

      return '<a target="sote" href="'.$url.'" style="color: #E01111;">'.__('Zamów wersję komercyjną', null, 'stBackendMain').'</a>';
   }

   $license = new stLicense();

   $communication = stCommunication::getLicenseInfo();

   $iwt_till = $communication['support'];

   $upgrade_exp_date = $communication['guarantee'];

   $current_date = date("Y-m-d");

   $seven = stCommunication::getIsSeven();

   if ($lang == 'pl_PL') {

      $update7 = '<a target="sote" href="https://www.sote.pl/dostep-do-aktualizacji.html" style="color: #E01111;">aktualizacji sklepu</a>';
   
   } else {

      $update7 = '<a target="sote" href="https://www.soteshop.com/access-to-update.html" style="color: #E01111;">shop update</a>';
  
   }

   $link7 = '<a target="sote" href="'.get_7_link().'" style="color: #E01111;">SOTESHOP 7</a>';

   $renew_link = $lang == 'pl_PL' ? 'https://www.sote.pl/category/zamow' : 'https://www.soteshop.com/category/order';
   

   if ($seven) {
      
      if (is_null($upgrade_exp_date)) {

         return __('Serwis i aktualizacje aktywne', null, 'stBackendMain');

      } elseif ($current_date <= $upgrade_exp_date && $upgrade_exp_date >= $iwt_till) {

         return __('Serwis i aktualizacje ważne do', null, 'stBackendMain').' '.$upgrade_exp_date;

      } elseif ($current_date < '2015-07-31' && $current_date < $iwt_till) {

         return __('Serwis i aktualizacje ważne do', null, 'stBackendMain').' '.$iwt_till;

      } elseif ($current_date > $iwt_till && $current_date > $upgrade_exp_date) {

         if ($communication['type'] == 'ROK' || $communication['type'] == 'MIESIĄC')
         {
            $days = 14 - round((time() - strtotime($upgrade_exp_date . ' 23:59:59')) / 86400);
            $message = stCommunication::blockSite() ? __('Przedłuż usługę korzystania z SOTESHOP', null, 'stBackendMain') : __('Przedłuż usługę korzystania z SOTESHOP. Twój sklep będzie zablokowany za %days% dni', array('%days%' => $days), 'stBackendMain');
            return '<div style="color: #E01111;">'.$message.' <form action="'.$renew_link.'" method="post"><button type="submit">'.__('Zamów', null, 'stBackendMain').'</button></form></div>';
         }
         else
         {
            return '<span style="color: #E01111;">'.__('Zamów dostęp do', null, 'stBackendMain').' '.$update7.'</span>';
         }
      }

   } else {

      if ($current_date < $iwt_till && $current_date > $upgrade_exp_date)
      {
         
         return __('Serwis i aktualizacje ważne do końca', null, 'stBackendMain').' '.$iwt_till;

      } elseif ($current_date <= $iwt_till && $current_date < $upgrade_exp_date && $iwt_till >= $upgrade_exp_date) {
         
         return __('Serwis i aktualizacje ważne do końca', null, 'stBackendMain').' '.$iwt_till; 
      
      } elseif ($current_date < $iwt_till && $current_date < $upgrade_exp_date && $iwt_till < $upgrade_exp_date) {

         return __('Serwis i aktualizacje ważne do końca', null, 'stBackendMain').' '.$upgrade_exp_date; 

      } elseif ($current_date < $upgrade_exp_date && $current_date > $iwt_till) {

         return __('Serwis i aktualizacje ważne do końca', null, 'stBackendMain').' '.$upgrade_exp_date; 
      
      } elseif ($current_date > $iwt_till && $current_date > $upgrade_exp_date) {
         if ($communication['type'] == 'ROK' || $communication['type'] == 'MIESIĄC')
         {
            $days = 14 - round((time() - strtotime($upgrade_exp_date . ' 23:59:59')) / 86400);
            $message = stCommunication::blockSite() ? __('Przedłuż usługę korzystania z SOTESHOP', null, 'stBackendMain') : __('Przedłuż usługę korzystania z SOTESHOP. Twój sklep będzie zablokowany za %days% dni', array('%days%' => $days), 'stBackendMain');
            return '<div style="color: #E01111;">'.$message.' <form action="'.$renew_link.'" method="post"><button type="submit">'.__('Zamów', null, 'stBackendMain').'</button></form></div>';         
         }
         else
         {
            return '<div style="color: #E01111;">'.__('Zamów aktualizację do wersji', null, 'stBackendMain').' '.$link7.'</div>';
         }

      }

   }

}

function get_7_link()
{

   $lang = sfContext::getInstance()->getUser()->getCulture();

   if ($lang == 'pl_PL') {

      $link_7 = 'https://www.sote.pl/aktualizacja-soteshop-z-wersji-6-do-7.html';
   
   } else {

      $link_7 = 'https://www.soteshop.com/soteshop-update-from-version-6-to-7.html';
  
   }

   return $link_7;

}

function get_app_icon($icon_path)
{
   if ($icon_path[0] == '/' && false === strpos($icon_path, '/images/backend/main/'))
   {
      return $icon_path;
   }

   $icon_file = basename($icon_path);   
   $sf_web_dir = sfConfig::get('sf_web_dir');

   if ($icon_file != "logo_sote_top.png")
   {
      $dir_new = $sf_web_dir.'/images/backend/main/icons/red_new/'.$icon_file;
      $dir =  $sf_web_dir.'/images/backend/main/icons/red/'.$icon_file;

      if (file_exists($dir_new))
      {
      $icon_path = '/images/backend/main/icons/red_new/'.$icon_file;
      }elseif (file_exists($dir)){
      $icon_path = '/images/backend/main/icons/red/'.$icon_file;
      }else{
      $icon_path = '/images/backend/main/icons/'.$icon_file; 
      }

   }
   return $icon_path;
}