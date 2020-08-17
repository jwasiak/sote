<?php

/**
 * SOTESHOP/stAdminGeneratorPlugin 
 * 
 * Ten plik należy do aplikacji stAdminGeneratorPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stAdminGeneratorPlugin
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stAdminGeneratorHelper.php 17502 2012-03-22 15:35:51Z marcin $
 */
use_helper('Tag', 'Asset', 'nifty', 'Validation', 'stBackend', 'stPrice');

/**
 * Tworzy zewnętrzny link do modułu
 *
 * @param   string      $name               Nazwa linku
 * @param   string      $internal_uri       Wewnętrzny adres linku (np. 'stDemo/list')
 * @param   array       $options            Dodatkowe parametry linku
 * @return       string      HTML
 */
function st_external_link_to($name = '', $internal_uri = '', $options = array())
{
   $options = _parse_attributes($options);

   $options['class'] = 'st_admin_external_link';

   $options['target'] = '_blank';

   return link_to($name, $internal_uri, $options);
}

function st_admin_checkbox_tag($name, $value = true, $checked = false, array $options = array())
{
   return checkbox_tag($name, $value, $checked, $options);
}

function st_replace_forward_parameters($value, $forward_parameters = array())
{
   foreach ($forward_parameters as $name => $forward_parameter)
   {
      $value = str_replace('%%forward_parameters.'.$name.'%%', $forward_parameter, $value);
   }

   return $value;
}

function st_get_admin_culture_picker($params = array())
{
   $languages = LanguagePeer::doSelectLanguages();

   $params['query_div'] = strpos($params['url'], '?') !== false ? '&' : '?';

   $params['url'] = st_url_for($params['url']);

   $content = '';

   foreach ($languages as $language)
   {
      if ($language->getOriginalLanguage() == $params['culture'])
      {
         $current = _culture_picker_flag($language, $params);
      }
      else
      {
         $content .= '<li>'._culture_picker_flag($language, $params).'</li>';
      }
   }

   return '<div class="language_picker">'.$current.'<ul>'.$content.'</ul></div><div style="clear: left"></div>';
}

function st_get_admin_culture_flag($culture = null)
{
   static $languages = array();

   if (!isset($languages[$culture]))
   {
      foreach (LanguagePeer::doSelectLanguages() as $language)
      {
         if ($language->getOriginalLanguage() == $culture)
         {
            $languages[$culture] = $language;

            break;
         }
      }
   }

   return _culture_picker_flag($languages[$culture], array('culture' => $culture));
}

function st_admin_optional_input($name, $value, $options)
{
    static $init = false;

    $content = checkbox_tag(null, 1, !$options['disabled'], array('style' => 'margin-right: 5px', 'class' => 'optional')).input_tag($name, $value, $options);

    if (!$init)
    {
        $content .= "
            <script>
                jQuery(function($) {
                    $(document).ready(function() {
                        $('.optional').change(function() {
                            var checkbox = $(this);
                            var input =  checkbox.next('input');
                            input.prop('disabled', !checkbox.prop('checked'));
                        });
                    });
                });
            </script>
        ";

        $init = true;
    }

    return $content;
}

function _culture_picker_flag(Language $language, $params)
{
   $culture = $language->getOriginalLanguage();

   $image = $language->getActiveImage() ? '<img src="/uploads/stLanguagePlugin/'.$language->getActiveImage().'" alt="" />' : $language->getShortcut();

   if ($culture == $params['culture'])
   {
      return '<span>'.$image.'</span>';
   }
   else
   {
      return '<a href="'.$params['url'].'/culture/'.$culture.'">'.$image.'</a>';
   }
}

/**
 * Zwraca HTML otwierający aplikację
 *
 * @param   mixed       $app_name           Nazwa aplikacji np. stOrder
 * @param   string      $title              Dodatkowy tytuł dla aplikacji
 * @param   array       $options            
 * @param   array       $applications       Lista aplikacji np. array('stOrder', 'stUser', ...) (deprecated use options instead)
 * @return       string      HTML
 */
function st_get_admin_head($app_name, $title = '', $options = array(), $shortcuts = array())
{
   $response = sfContext::getInstance()->getResponse();
   $routing = sfRouting::getInstance();

   if(sfContext::getInstance()->getModuleName()!='stReportBackend'){
      $response->addJavascript(sfConfig::get('sf_prototype_web_dir').'/js/prototype');
      $response->addJavascript(sfConfig::get('sf_prototype_web_dir').'/js/builder');
      $response->addJavascript(sfConfig::get('sf_prototype_web_dir').'/js/effects');    
   }
   

   if (is_array($options))
   {
      if (isset($options['shortcuts']))
      {
         $shortcuts = $options['shortcuts'];

         unset($options['shortcuts']);
      }
   }
   else
   {
      $options = array();
   }

   if (is_array($app_name) && $app_name[0] != $app_name[1])
   {
      list($route, $label) = $app_name;

      if (isset($app_name[2]))
      {
         $icon = $app_name[2];
      }
      else 
      {
         $icon = '/images/backend/main/icons/'.$route.'.png';
         $icon = get_app_icon($icon);
      }
   }
   else
   {
      if (is_array($app_name))
      {
         $app_name = $app_name[0];
      }
      
      if (stMenuModifier::hasHeadApplications($app_name))
      {
         $shortcuts = stMenuModifier::getHeadApplications($app_name, $shortcuts);
      }

      $route = $routing->hasRouteName($app_name.'Default') ? '@'.$app_name.'Default' : '@'.$app_name;

      $icon = '/images/backend/main/icons/'.$app_name.'.png';

      $icon = get_app_icon($icon);

      $route_info = $routing->getRouteByName($route);

      $label = sfContext::getInstance()->getI18N()->__(stApplication::getAppName($app_name), null, $route_info[4]['module']);  

      if (!is_file(sfConfig::get('sf_web_dir').$icon))
      {
         $icon = '/images/backend/main/icons/red/stDefaultApp.png';
      }          
   }

   $st_round_box_top = content_tag('div', '', array('class' => 'left')).content_tag('div', '', array('class' => 'right'));

   $header = st_get_partial('stAdminGenerator/application_shortcuts', array('route' => $route, 'icon' => $icon, 'shortcuts' => $shortcuts, 'label' => $label, 'title' => $title, 'options' => $options));

   $js =<<<JS
<script>
if(window.Prototype) {
   delete Object.prototype.toJSON;
   delete Array.prototype.toJSON;
   delete Hash.prototype.toJSON;
   delete String.prototype.toJSON;
}
</script>
JS;

   return tag('div', array('id' => 'sf_admin_container', 'class' => 'admin_container'), true).$header.$js;
}

/**
 * Zwraca HTML zamykający aplikację
 *
 * @return       string      HTML
 */
function st_get_admin_foot()
{
   return "
   </div>
   <script>
      jQuery(function($) {
         $('body').on('submit', '.admin_form', function() {
            $(document).trigger('preloader', 'show');
         });

         $('input[data-format]').change(function() {
            var input = $(this);
            var value = input.val();
            var format = input.data('format');
            var decimals = input.data('format-decimals') ? input.data('format-decimals') : 2;

            switch (format) {
               case 'price':
                  value = stPrice.fixNumberFormat(value, 2);
               break;

               case 'float':
               case 'decimal':
                  value = stPrice.fixNumberFormat(value, decimals);
               break;

               case 'integer':
                  value = stPrice.fixNumberFormat(value, 0);
               break;
            }

            input.val(value);
         });
         
         $('body').on('click', '[data-admin-confirm], [data-admin-action]' ,function(e) {
            var action = $(this);

            if (action.is('[data-admin-confirm]'))
            {
               if (action.data('admin-confirm').length) {
                  if (window.confirm(action.data('admin-confirm'))) {
                     $(document).trigger('preloader', 'show');
                     if (action.data('admin-action-url')) {
                        window.location = action.data('admin-action-url');
                     } else if (action.data('admin-action-post')) {
                        action.closest('form').submit();
                     } else {
                        window.location = action.attr('href');
                     }
                  }

                  return false;
               }

               return true;
            } else if (action.is('[data-admin-action]')) {
               if (!action.data('admin-confirm')) {
                  if (action.data('admin-action') == 'delete' || action.data('admin-action') == 'action-delete') {
                     $(document).trigger('preloader', 'show');
                  }

                  if (action.data('admin-action-url')) {
                     window.location = action.data('admin-action-url');
                  }
               }
            }
         });
      });
   </script>
   ";
}

function _st_head_menu_item($app_name)
{
   $routing = sfRouting::getInstance();

   $real_name = stApplication::getMenuElementName($app_name);

   $image_content = image_tag('backend/main/icons/'.$app_name.'.png', array('id' => 'app_'.$app_name, 'width' => '40px', 'height' => '40px'));

   $para_content = content_tag('p', $real_name);

   return content_tag('li', st_link_to($image_content, $routing->hasRouteName($app_name.'Default') ? '@'.$app_name.'Default' : '@'.$app_name).$para_content);
}

function _st_head_application_icon($app_name, $params)
{
   $routing = sfRouting::getInstance();
   return content_tag('div', st_link_to(image_tag('backend/main/icons/'.$app_name.'.png'), $routing->hasRouteName($app_name.'Default') ? '@'.$app_name.'Default' : '@'.$app_name.$params), 'id=st_application-head-package');
}

function st_admin_sort_st_link_to($label, $field_name)
{
   $content = '';
   $sf_user = sfContext::getInstance()->getUser();
   if ($sf_user->getAttribute('sort', null, 'sf_admin/order/sort') == $field_name)
   {
      //        $content .= st_link_to($label, 'order/list?sort=' . $field_name . '&type=' . ($sf_user->getAttribute('type', 'asc', 'sf_admin/order/sort') == 'asc' ? 'desc' : 'asc'));
      $content .= $label;
      $content .= image_tag('/images/backend/icons/'.$sf_user->getAttribute('type', 'asc', 'sf_admin/order/sort').'.png', array('align' => 'absmiddle'));
   }
   else
   {
      //        $content .= st_link_to($label, 'order/list?sort=' . $field_name . '&type=asc');
      $content .= $label;
   }

   return $content;
}

function st_admin_row_highlight()
{
   static $i;
   return!fmod(++$i, 2);
}

/**
 * Zwraca HTML otwierający nagłówek dla komponentu
 * Postać zwracanego kodu
 * <div class="st_admin-component" $html_options>
 *  <h2>$label</h2>
 *  <br class="st_clear_all" />
 *
 * @param   string      $label              Tytuł nagłówka
 * @param   mixed       $html_options       opcje HTML
 * @return       string      HTML
 */
function st_get_admin_component_head($label, $html_options = array())
{
   $html_options = _parse_attributes($html_options);
   if (isset($html_options['class']))
   {
      $html_options['class'] = 'st_admin-component '.$html_options['class'];
   }
   else
   {
      $html_options['class'] = 'st_admin-component';
   }

   $content = tag('div', $html_options, true);
   $content .= content_tag('h2', $label);
   $content .= tag('br', array('class' => 'st_clear_all'));
   return $content;
}

/**
 * Zwraca HTML zamykający nagłówek dla komponentu
 * Postać zwracanego kodu
 * </div>
 *
 * @return   unknown
 */
function st_get_admin_component_foot()
{
   return '</div>';
}

/**
 * Zwraca HTML otwierający układ horyzontalny
 * Postać zwracanego kodu
 * <ul class="st_admin-horizontal-look" $html_options>
 *
 * @param   mixed       $html_options       opcje HTML
 * @return       string      HTML
 */
function st_get_admin_horizontal_look_head($html_options = array())
{
   $same_height = '';

   $html_options = _parse_attributes($html_options);

   if (isset($html_options['id']))
   {
      $same_height = javascript_tag(nifty_round_elements('ul#'.$html_options['id'].' > li', 'none same-height'));
   }

   if (isset($html_options['class']))
   {
      $html_options['class'] = 'st_admin-horizontal-look '.$html_options['class'];
   }
   else
   {
      $html_options['class'] = 'st_admin-horizontal-look';
   }

   return $same_height.tag('ul', $html_options, true);
}

/**
 * Zwraca HTML otwierający element dla układu horyzontalnego
 * Postać zwracanego kodu
 * <li $html_options>
 *
 * @param   mixed       $html_options       opcje HTML
 * @return       string      HTML
 */
function st_get_admin_horizontal_element_head($html_options = array())
{
   $html_options = _parse_attributes($html_options);
   if (isset($html_options['class']))
   {
      $html_options['class'] = 'st_admin-horizontal-look-element '.$html_options['class'];
   }
   else
   {
      $html_options['class'] = 'st_admin-horizontal-look-element';
   }

   return tag('li', $html_options, true);
}

/**
 * Zwraca HTML zamykający element dla układu horyzontalnego
 * Postać zwracanego kodu
 * </li>
 *
 * @return       string      HTML
 */
function st_get_admin_horizontal_element_foot()
{
   return '</li>';
}

/**
 * Zwraca HTML zamykający układ horyzontalny
 * Postać zwracanego kodu
 * </ul><br class="st_clear_all" />
 *
 * @return       string      HTML
 */
function st_get_admin_horizontal_look_foot()
{
   return content_tag('li', '', 'class="st_clear_all"').'</ul>';
}

/**
 * Zwraca HTML otwierający listę
 * Postać zwracanego kodu
 * <ul class="st_admin-item-list">
 *
 * @param   mixed       $html_options       opcje HTML
 * @return       string      HTML
 */
function st_get_admin_item_list_head($html_options = array())
{
   $html_options = _parse_attributes($html_options);
   if (isset($html_options['class']))
   {
      $html_options['class'] = 'st_admin-item-list '.$html_options['class'];
   }
   else
   {
      $html_options['class'] = 'st_admin-item-list';
   }

   return tag('ul', $html_options, true);
}

/**
 * Zwraca HTML elementu listy
 * Postać zwracanego kodu:
 * <li $html_options>
 *  <span>$label</span>
 *  $value albo <strong>$value</strong> (gdy flaga is_imported jest ustawiona)
 * </li>
 *
 * @param   string      $label              Tytuł elementu
 * @param   string      $value              Wartość elementu
 * @param   bool        $is_important       Określa czy element ma być oznaczony jako ważny
 * @param   array       $html_options       opcje HTML
 * @return       string      HTML
 */
function st_get_admin_item_list_element($label, $value, $is_important = false, $html_options = array())
{
   $label_content = content_tag('span', $label.':');

   if ($is_important)
   {
      $value_content = content_tag('strong', $value);
   }
   else
   {
      $value_content = $value;
   }

   return content_tag('li', $label_content.$value_content, $html_options);
}

/**
 * Zwraca HTML zamykający listę
 * Postać zwracanego kodu:
 * </ul><br class="st_clear_all" />
 *
 * @return       string      HTML
 */
function st_get_admin_item_list_foot()
{
   return '</ul>'.tag('br', array('class' => 'st_clear_all'));
}

/**
 * Zwraca HTML otwierający separator zawartości
 * Postać zwracanego kodu:
 * <div class="st_admin-content-separator" $html_options>
 *
 * @param   mixed       $html_options       opcje HTML
 * @return       string      HTML
 */
function st_get_admin_content_separator_head($html_options = array())
{
   $html_options = _parse_attributes($html_options);
   if (isset($html_options['class']))
   {
      $html_options['class'] = 'st_admin-content-separator '.$html_options['class'];
   }
   else
   {
      $html_options['class'] = 'st_admin-content-separator';
   }

   return tag('div', $html_options, true);
}

/**
 * Zwraca HTML zamykający separator zawartości
 * Postać zwracanego kodu
 * </div>
 *
 * @return       string      HTML
 */
function st_get_admin_content_separator_foot()
{
   return '</div>';
}

/**
 * Zwraca HTML przycisku dla danej akcji
 *
 * @param   string      $type               Typ akcji (dostepne: save, save_and_add, save_and_list, delete, list, edit)
 * @param   string      $label              Etykieta przycisku
 * @param   string      $action             Akcja przycisku (np. category/index)
 * @param   mixed       $html_options       opcje HTML
 * @return       string      HTML
 */
function st_get_admin_action($type, $label, $action = null, $html_options = array())
{
   $html_options = _parse_attributes($html_options);

   if ($type == 'create' || $type == 'add')
   {
      $type = 'add';
   }
   elseif ($type == 'save_and_list' || $type == 'save_and_add' || $type == 'save')
   {
      $type = 'save';
   }

   if (isset($html_options['type']))
   {
      $type = $html_options['type'];

      unset($html_options['type']);
   }

   if ($type == 'edit')
   {
      $html_options['style'] = 'background-image: url(/images/backend/beta/icons/16x16/edit.png)';
   }
   else
   {
      $html_options['style'] = 'background-image: url(/images/backend/icons/'.$type.'.png)';
   }

   if (is_null($action))
   {
      $action_content = submit_tag($label, $html_options);
   }
   else
   {
      $action_content = st_button_to($label, $action, $html_options);
   }

   return content_tag('li', $action_content, array('class' => 'action-'.$type));
}

function st_button_to($name, $internal_uri ='', $options = array())
{
   $html_options = _parse_attributes($options);
   $html_options['value'] = $name;

   if (isset($html_options['confirm']))
   {
      $html_options['data-admin-confirm'] = $html_options['confirm']; 
      unset($html_options['confirm']);
   }

   if (isset($html_options['post']) && $html_options['post'])
   {
      if (isset($html_options['popup']))
      {
         throw new sfConfigurationException('You can\'t use "popup" and "post" together');
      }
      $html_options['type'] = 'submit';
      unset($html_options['post']);
      $html_options = _convert_options_to_javascript($html_options);

      return form_tag($internal_uri, array('method' => 'post', 'class' => 'button_to')).content_tag('div', tag('input', $html_options)).'</form>';
   }

   $url = $internal_uri && $internal_uri{0} == '/' ? $internal_uri : url_for($internal_uri);
   if (isset($html_options['query_string']))
   {
      $url = $url.'?'.$html_options['query_string'];
      unset($html_options['query_string']);
   }

   $html_options['type'] = 'button';

   if (isset($html_options['popup']))
   {
      $url = "'".$url."'";
      $html_options = _convert_options_to_javascript($html_options, $url);
      unset($html_options['popup']);
   }
   else
   {
      $html_options['data-admin-action-url'] = $url;
   }

   $html_options['data-admin-action'] = isset($html_options['type']) ? $html_options['type'] : 'none';

   return tag('input', $html_options);
}

/**
 * Zwraca HTML otwierający definiowanie akcji
 *
 * @param   string      $html_options       opcje HTML
 * @return       string      HTML
 */
function st_get_admin_actions_head($html_options = array())
{
   $html_options = _parse_attributes($html_options);
   if (isset($html_options['class']))
   {
      $html_options['class'] = 'admin_actions '.$html_options['class'];
   }
   else
   {
      $html_options['class'] = 'admin_actions';
   }

   return tag('ul', $html_options, true);
}

/**
 * Zwraca HTML zamykający definiowanie akcji
 *
 * @return       string      HTML
 */
function st_get_admin_actions_foot()
{
   return '</ul><div class="clr"></div>';
}

function st_get_admin_actions($actions) 
{
   $html = st_get_admin_actions_head();

   foreach ($actions as $action)
   {
      if (!isset($action['type']))
      {
         throw new sfException('Parameter "type" is mandatory');
      }

      if (!isset($action['label']))
      {
         throw new sfException('Parameter "label" is mandatory');
      }      

      $html .= st_get_admin_action($action['type'], $action['label'], isset($action['action']) ? $action['action'] : null, isset($action['params']) ? $action['params'] : array());
   }

   return $html.st_get_admin_actions_foot();
}

function st_admin_get_filters_list($module, $action, $page)
{
   $user = sfContext::getInstance()->getUser();

   $c = new Criteria();

   $c->add(AdminGeneratorFilterPeer::MODULE_NAMESPACE, $module.'/'.$action);

   $c1 = $c->getNewCriterion(AdminGeneratorFilterPeer::GUARD_USER_ID, $user->getGuardUser()->getId());

   $c1->addOr($c->getNewCriterion(AdminGeneratorFilterPeer::IS_GLOBAL, true));

   $c->add($c1);

   $c->addAscendingOrderByColumn(AdminGeneratorFilterPeer::NAME);

   $filters = AdminGeneratorFilterPeer::doSelect($c);

   $options = array();

   foreach ($filters as $filter)
   {
      $options[$filter->getId()] = $filter->getName();
   }

   $selected = $user->getAttribute($action.'.filter', null, 'soteshop/stAdminGenerator/'.$module.'/config');

   $url = st_url_for($module.'/setFilter?for_action='.$action.'&page='.$page.'&id=');

   $js = <<<JS
<script type="text/javascript">
$('filter_control').observe('change', function() {
   window.location = '$url/' + this.options[this.selectedIndex].value;
});
</script>
JS;

   $label = label_for('filter_control', __('Aktywny filtr', null, 'stAdminGeneratorPlugin').':');

   $select = select_tag('filter_control', options_for_select($options, $selected ? $selected['id'] : null, array('include_custom' => '---')));

   return $label.$select.$js;
}

function st_admin_get_assigned_filter($filters)
{
   return select_tag('filters[assigned]', options_for_select(array(1 => __('tak', array(), 'stAdminGeneratorPlugin'), 0 => __('nie', array(), 'stAdminGeneratorPlugin')), isset($filters['assigned']) ? $filters['assigned'] : null, array(
                       'include_custom' => __("---"),
                   )));
}

function st_admin_get_current_filter($var, $module, $action)
{
   $selected = sfContext::getInstance()->getUser()->getAttribute($action.'.filter', null, 'soteshop/stAdminGenerator/'.$module.'/config');

   return isset($selected[$var]) ? $selected[$var] : null;
}

function st_admin_show_form_fields($fields, $values, $order)
{   
   foreach ($order as $name)
   {
      $attr = isset($fields[$name]['attr']) ? $fields[$name]['attr'] : array(); 
      
      $type = isset($fields[$name]['type']) ? $fields[$name]['type'] : 'input_tag';
      
      $value = isset($values[$name]) ? $values[$name] : null; 
      
      if ($type == 'select_tag')
      {
         $attr['selected'] = $value;
         
         $value = $fields[$name]['options'];
      }
      elseif ($type == 'checkbox_tag')
      {
         $attr['checked'] = $value;
         
         $value = $fields[$name]['value'];
      }
      
      echo st_admin_get_form_field($name, __($fields[$name]['label']), $value, $type, $attr); 
   }
}

function st_admin_get_form_field($name, $label, $value, $type = 'input_tag', $params = array())
{
   $label_params = array();

   if ($label)
   {
      $label = rtrim($label, ':');
   }

   if (isset($params['help']))
   {
      $label .= ' <a href="#" class="help" title="'.htmlspecialchars($params['help']).'"></a>';
   }

   if (isset($params['required'])) 
   {
      if ($params['required'])
      {
         $label_params['class'] = 'required';
      }

      unset($params['required']);
   }

   if (isset($params['clipboard']) && $params['clipboard']) 
   {
      $clipboard = true;
      unset($params['clipboard']);
   } 
   else
   {
      $clipboard = false;
   }

   if (isset($params['postfix']) && $params['postfix']) 
   {
      $postfix = ' '.$params['postfix'];
      unset($params['postfix']);
   } 
   else
   {
      $postfix = '';
   }

   $id = isset($params['id']) ? $params['id'] : get_id_from_name($name);

   switch ($type)
   {
      case 'checkbox_tag':
      case 'radiobutton_tag':
         if (array_key_exists('checked', $params))
         {
            $checked = $params['checked'];

            unset($params['checked']);
         }
         else
         {
            $checked = false;
         }

         $field_content = $type($name, $value, $checked, $params);
         break;
      case 'select_tag':
         if (array_key_exists('selected', $params))
         {
            $selected = $params['selected'];

            unset($params['selected']);
         }
         else
         {
            $selected = '';
         }

         if (isset($params['include_custom']))
         {
            $custom = array('include_custom' => $params['include_custom']);
            unset($params['include_custom']);
         }
         else
         {
            $custom = array();
         }

         $field_content = $type($name, options_for_select($value, $selected, $custom), $params);
         break;
      case 'select_number_tag':
         $field_content = $type($name, $value, $params, isset($params['html']) ? $params['html'] : array());
         break;
      case 'plain':
         $field_content = $value;
         break;
      default:
         if ($type[0] == '_')
         {
            $partial = substr($type, 1);

            $field_content = st_get_partial($partial, array('value' => $value, 'name' => $name, 'params' => $params));
         }
         else
         {
            $field_content = $type($name, $value, $params);

            if ($clipboard)
            {
               $field_content .= '<button type="button" class="clipboard-btn list_tooltip" data-clipboard-target="#'.$id.'" title="'.__('Kopiuj', null, 'stBackend').'"></button>';
            }
         }
   }

   $error_name = str_replace(array('[', ']'), array('{', '}'), $name);

   if ($label)
   {
      if (form_has_error($error_name))
      {
         $error_msg = content_tag('div', form_error($error_name), array('class' => 'form-error-msg'));

         $result = content_tag('div', label_for($name, $label, $label_params).content_tag('div', $error_msg.$field_content.$postfix.content_tag('div', '', array('class' => 'clr')), array('class' => 'field form-error')), array('class' => 'row '.$id));
      }
      else
      {
         $result = content_tag('div', label_for($name, $label, $label_params).content_tag('div', $field_content.$postfix.content_tag('div', '', array('class' => 'clr')), array('class' => 'field')), array('class' => 'row '.$id));
      }
   }
   else
   {
      $result = $field_content.$postfix;
   }

   $dispatcher =  stEventDispatcher::getInstance();
   $context = sfContext::getInstance();

   if ($dispatcher->getListeners("st_admin_get_form_field.{$context->getModuleName()}.$id"))
   {
      
      return $dispatcher->filter(new sfEvent($context, "st_admin_get_form_field.{$context->getModuleName()}.$id", array('label' => $label, 'name' => $name, 'id' => $id, 'value' => $value, 'params' => $params)), $result)->getReturnValue();
   }

   return $result;
}

