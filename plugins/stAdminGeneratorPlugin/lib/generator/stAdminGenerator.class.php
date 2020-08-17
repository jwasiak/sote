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
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stAdminGenerator.class.php 17572 2012-03-29 11:29:08Z marcin $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * Sote Admin generator.
 * This class extends sfPropelAdminGenerator.
 *
 * @package stAdminGeneratorPlugin
 * @subpackage generator
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 */
class stAdminGenerator extends sfPropelAdminGenerator
{

   /**
    * Instancja obiektu event dispatcher
    * @var sfEventDispatcher
    */
   protected $dispatcher = null;
   /**
    * Nazwa własnej akcji
    * @var string
    */
   protected $customAction = '';
   /**
    * Nazwa typu
    * @var string
    */
   protected $customType = '';


   public function getValueForParameter($param, $default = null)
   {
      return $this->getValueFromKey($param, $default);
   }

   public function setValueForParameter($param, $value = null)
   {
      $ref = &$this->params;

      $parts = explode('.', $param);

      foreach ($parts as $part)
      {
         if (!isset($ref[$part]))
         {
            $ref[$part] = array();
         }

         $ref = &$ref[$part];
      }

      $ref = $value;
   }

   public function getPrimaryKeyField($glue = '_', $prefix = '')
   {
      $params = array();

      foreach ($this->getPrimaryKey() as $pk)
      {
         $params[]  = $this->getColumnGetter($pk, true, $prefix);
      }

      return implode(".'$glue'.", $params);    
   } 

   public function getMethodParamsForPrimaryKey()
   {
      $method_params = array();

      foreach ($this->getPrimaryKey() as $pk)
      {
         $fieldName       = sfInflector::underscore($pk->getPhpName());
         $method_params[] = "\$$fieldName";
      }

      return implode(', ', $method_params);
   }  

   public function getRetrieveByPkParamsForAction($indent, $glue = ",\n")
   {
      $params = array();
      
      foreach ($this->getPrimaryKey() as $pk)
      {
         $params[] = "\$this->getRequestParameter('".sfInflector::underscore($pk->getPhpName())."')";
      }

      return implode($glue, $params);
   }      

   public function insertParameterBefore($key, $param)
   {
      return $this->insertParameterHelper($key, $param, 'before');
   }

   public function insertParameterAfter($key, $param)
   {
      return $this->insertParameterHelper($key, $param, 'after');
   }

   public function insertParameterHelper($key, $param, $type = 'after')
   {
      $parts = explode('.', $key);

      $last = array_pop($parts);

      $matches = array();

      $tmp = array();

      if (preg_match('/([^\[]+)\[([^\]]*)\]/', $last, $matches))
      {

         $last_param = $matches[1];

         $last_value = $matches[2];

         $parts[] = $last_param;

         $key = implode('.', $parts);



         $values = $this->getValueForParameter($key);

         foreach ($values as $v)
         {
            if ($type == 'after')
            {
               $tmp[] = $v;
            }

            if ($last_value == $v)
            {
               foreach ((array) $param as $p)
               {
                  $tmp[] = $p;
               }
            }

            if ($type == 'before')
            {
               $tmp[] = $v;
            }
         }
      }
      else
      {
         $key = implode('.', $parts);

         $values = $this->getValueForParameter($key);

         foreach ($values as $k1 => $v)
         {
            if ($type == 'after')
            {
               $tmp[$k1] = $v;
            }

            if ($k1 == $last)
            {
               foreach ((array) $param as $k2 => $p)
               {
                  if (isset($values[$k2]))
                  {
                     throw new sfConfigurationException(sprintf('Cannot insert a duplicated parameter "%s" in "%s"', $k2, $param));
                  }
                  $tmp[$k2] = $p;
               }
            }

            if ($type == 'before')
            {
               $tmp[$k1] = $v;
            }
         }
      }

      $this->setValueForParameter($key, $tmp);
   }

   /**
    * Gets a parameter value.
    *
    * @param   string      The                 key name
    * @param   mixed       The                 default value
    * @return  mixed       The parameter value
    */
   public function getParameterValue($key, $default = null, $add_prefix = true)
   {
      return parent::getParameterValue(($add_prefix ? $this->getCustomActionName('', '_') : '') . $key, $default);
   }

   public function getRecordListColSpan()
   {
      $object_actions = $this->getParameterValue('list.object_actions');

      return count($this->getColumns('list.display')) + isset($object_actions['_edit']) + 3;

      return $object_actions ? (count($this->getColumns('list.display')) + 2 + isset($object_actions['_edit']) + (bool) $this->getParameterValue('list.build_options.through_class')) : count($this->getColumns('list.display')) + 2 + (bool) $this->getParameterValue('list.build_options.through_class');
   }

   public function isObjectActionVisible()
   {
      return true;
   }

   /**
    * Ustawia globalny prefix dla metody getParameterValue
    *
    * @param   string      $prefix             Nazwa akcji bez typu (format underscored)
    */
   protected function setParameterValuePrefix($prefix)
   {
      $this->customAction = $prefix;

      $this->changeModelClass(isset($this->params[$prefix . '_model_class']) ? $this->params[$prefix . '_model_class'] : $this->params['model_class']);
   }

   /**
    * Zwraca nazwę akcji w formacie underscored
    *
    * @param   string      $prefix             wartość doklejona przed nazwą akcji (tylko jeśli akcja istnieje)
    * @param   string      $postfix            wartość doklejona za nazwą akcji (tylko jeśli akcja istnieje)
    * @param   string      $default            wartość domyślna w przypadku braku akcji
    * @return   string
    */
   protected function getCustomActionName($prefix = '', $postfix = '', $default = '')
   {
      return $this->customAction ? $prefix . $this->customAction . $postfix : $default;
   }

   /**
    * Zwraca nazwę akcji w formacie php (zamienia format wartosc1_wartosc2... na Wartosc1Wartosc2...)
    *
    * @param   string      $prefix             wartość doklejona przed nazwą akcji (tylko jeśli akcja istnieje)
    * @param   string      $postfix            wartość doklejona za nazwą akcji (tylko jeśli akcja istnieje)
    * @param   string      $default            wartość domyślna w przypadku braku akcji
    * @return   string
    */
   protected function getCustomActionPhpName($prefix = '', $postfix = '', $default = '')
   {
      $tmp = $this->getCustomActionName($prefix, $postfix, $default);

      if ($tmp != $default)
      {
         $tmp = sfInflector::camelize($tmp);
      }

      return $tmp;
   }

   /**
    * Zwraca nazwę akcji w formacie camelized (zamienia format wartosc1_wartosc2... na wartosc1Wartosc2...)
    *
    * @param   string      $prefix             wartość doklejona przed nazwą akcji (tylko jeśli akcja istnieje)
    * @param   string      $postfix            wartość doklejona za nazwą akcji (tylko jeśli akcja istnieje)
    * @param   string      $default            wartość domyślna w przypadku braku akcji
    * @return   string
    */
   protected function getCustomActionNameCamelized($prefix = '', $postfix = '', $default = '')
   {
      $tmp = $this->getCustomActionPhpName($prefix, $postfix, $default);

      if ($tmp != $default)
      {
         $tmp[0] = strtolower($tmp[0]);
      }

      return $tmp;
   }

   /**
    * Kończy konfigurację dla indywidualnej akcji
    */
   protected function resetParameterValuePrefix()
   {
      $this->customAction = '';

      $this->restoreModelClass();
   }

   /**
    * Zwraca listę akcji danego typu
    *
    * @param   string      $type               Typ akcji
    * @return  array       Lista akcji
    */
   protected function getAllActionsByType($type)
   {
      $actions = array('');

      if (is_array($type))
      {
         foreach ($type as $t)
         {
            if ($tmp = $this->getParameterValue('custom_actions.' . $t))
            {
               $actions = array_merge($actions, $tmp);
            }
         }
         $actions = array_unique($actions);
      }
      else
      {
         $actions = array_merge($actions, $this->getParameterValue('custom_actions.' . $type, array()));
      }

      return $actions;
   }

   /**
    * Zwraca parametry w postaci wartosci tablicy ('parametr' => 'wartosc')
    *
    * @param   string      $key                Klucz zawierajacy parametry
    * @return   string
    */
   public function getComponentParameters($key)
   {
      $params = sfToolkit::stringToArray($this->getParameterValue($key), array());
      $array_string = '';
      foreach ($params as $name => $value)
      {
         if (strpos($value, 'forward_parameters.') !== false)
         {
            $array_string .= "'" . $name . "' => $" . str_replace('.', "['", $value) . "'], ";
         }
         else
         {
            $array_string .= "'" . $name . "' => '" . $value . "', ";
         }
      }

      return $array_string;
   }

   public function getForwardParameterBy($related_id_key, $prefix = '$', $use_quotes = true)
   {
      if ($forward_parameter = $this->getParameterValue($related_id_key))
      {
         if ($use_quotes)
         {
            return $prefix . str_replace('.', '[\'', $forward_parameter) . '\']';
         }
         else
         {
            return $prefix . str_replace('.', '[', $forward_parameter) . ']';
         }
      }
      else
      {
         return 'null';
      }
   }

   public function getMenuComponentBy($key)
   {
      $menu = $this->getParameterValue($key);

      if ($menu == 'none') 
      {
         return 'none';
      }

      if ($this->getParameterValue($menu . '.display', null, false))
      {
         $tmp = explode('.', $menu);
         return lcfirst(sfInflector::camelize($tmp[0])) . ucfirst($tmp[1]);
      }
      else
      {
         return null;
      }
   }

   /**
    * Inicjuj gereator
    *
    * @param   unknown_type $generatorManager
    */
   public function initialize($generatorManager)
   {
      $this->dispatcher = sfContext::getInstance()->getController()->getDispatcher();
      parent::initialize($generatorManager);
   }

   /**
    * Returns HTML code for a column in filter mode.
    *
    * @param   string      The                 column name
    * @param                   array       The                 parameters
    * @return  string      HTML code
    */
   public function getColumnFilterTag($column, $params = array())
   {
      if (isset($params['alternative_name']))
      {
         $control_name = $params['alternative_name'];

         unset($params['alternative_name']);
      }
      else
      {
         $control_name = $column->getName();
      }

      $user_params = $this->getParameterValue('list.filters.' . $control_name . '.params');
      $user_params = is_array($user_params) ? $user_params : sfToolkit::stringToArray($user_params);
      $params = $user_params ? array_merge($params, $user_params) : $params;

      $type = $column->getCreoleType();

      $default_value = "isset(\$filters['" . $control_name . "']) ? \$filters['" . $control_name . "'] : null";
      $default_value_from = "isset(\$filters['" . $control_name . "']['from']) ? \$filters['" . $control_name . "']['from'] : null";
      $default_value_to = "isset(\$filters['" . $control_name . "']['to']) ? \$filters['" . $control_name . "']['to'] : null";
      $unquotedName = 'filters[' . $control_name . ']';
      $name = "'$unquotedName'";

      $i18n_catalogue = $this->getParameterValue('list.fields.'.$control_name.'.i18n', $this->getModuleName());

      if ($column->isForeignKey())
      {
         $params = $this->getObjectTagParams($params, array('include_custom' => '---', 'related_class' => $this->getRelatedClassName($column), 'text_method' => '__toString', 'control_name' => $unquotedName));
         return "object_select_tag($default_value, null, $params)";
      }
      else if ($type == CreoleTypes::TIMESTAMP || $type == CreoleTypes::DATE)
      {
         $params = $this->getObjectTagParams($params, array('rich' => true, 'withtime' => $type == CreoleTypes::TIMESTAMP, 'calendar_button_img' => sfConfig::get('sf_admin_web_dir') . '/images/date.png', 'size' => 15));
         $datetime = "input_date_tag('{$unquotedName}[from]', $default_value_from, _parse_attributes($params)) . ' - ' . ";
         $datetime .= "input_date_tag('{$unquotedName}[to]', $default_value_to, _parse_attributes($params))";

         return $datetime;
      }
      else if ($type == CreoleTypes::BOOLEAN)
      {
         $defaultIncludeCustom = '---';

         $option_params = $this->getObjectTagParams($params, array('include_custom' => $defaultIncludeCustom));
         $params = $this->getObjectTagParams($params);

         $options = "options_for_select(array(1 => __('tak', array(), 'stAdminGeneratorPlugin'), 0 => __('nie', array(), 'stAdminGeneratorPlugin')), $default_value, $option_params)";

         return "select_tag($name, $options, $params)";
      }
      else if ($type == CreoleTypes::CHAR || $type == CreoleTypes::VARCHAR || $type == CreoleTypes::TEXT || $type == CreoleTypes::LONGVARCHAR || $type == CreoleTypes::MEDIUMTEXT)
      {
         if (!isset($params['size']))
         {
            $params['size'] = 10;
         }

         $params = $this->getObjectTagParams($params);

         return "input_tag($name, $default_value, $params)";
      }
      else if ($type == CreoleTypes::INTEGER || $type == CreoleTypes::TINYINT || $type == CreoleTypes::SMALLINT || $type == CreoleTypes::BIGINT ||
              $type == CreoleTypes::FLOAT || $type == CreoleTypes::DOUBLE || $type == CreoleTypes::DECIMAL || $type == CreoleTypes::NUMERIC || $type == CreoleTypes::REAL)
      {
         $is_float = $type == CreoleTypes::FLOAT || $type == CreoleTypes::DOUBLE || $type == CreoleTypes::DECIMAL || $type == CreoleTypes::NUMERIC || $type == CreoleTypes::REAL;
         $params = $this->getObjectTagParams($params, array('size' => 4, 'class' => $is_float ? 'float' : 'integer'));
         $number_field = "input_tag('{$unquotedName}[from]', $default_value_from, $params) . ' - ' . ";
         $number_field .= "input_tag('{$unquotedName}[to]', $default_value_to, $params)";
         return $number_field;
      }
      else
      {
         if (!isset($params['size']))
         {
            $params['size'] = 10;
         }

         $params = $this->getObjectTagParams($params, array('disabled' => true));

         return "input_tag($name, $default_value, $params)";
      }
   }

   public function getAdvancedFilterTag($column, $params = array())
   {
      if (isset($params['alternative_name']))
      {
         $control_name = $params['alternative_name'];
         unset($params['alternative_name']);
      }
      else
      {
         $control_name = $column->getName();
      }

      $user_params = $this->getParameterValue('list.filters.' . $control_name . '.params');
      $user_params = is_array($user_params) ? $user_params : sfToolkit::stringToArray($user_params);
      $params = $user_params ? array_merge($params, $user_params) : $params;

      $type = $column->getCreoleType();

      $default_value = "isset(\$filters['" . $control_name . "']) ? \$filters['" . $control_name . "'] : null";
      $default_value_from = "isset(\$filters['" . $control_name . "']['from']) ? \$filters['" . $control_name . "']['from'] : null";
      $default_value_to = "isset(\$filters['" . $control_name . "']['to']) ? \$filters['" . $control_name . "']['to'] : null";
      $default_value_is_empty = "isset(\$filters['" . $control_name . "_is_empty']) ? \$filters['" . $control_name . "_is_empty'] : null";
      $unquotedName = 'filters[' . $control_name . ']';
      $name = "'$unquotedName'";

      $is_empty = $this->getParameterValue('list.filters.' . $control_name . '.empty');

      if (!$column->isNotNull() && ($is_empty === null || $is_empty))
      {
         $is_empty_field = ".' '.content_tag('span', checkbox_tag('filters[{$control_name}_is_empty]', true, $default_value_is_empty).label_for('filters[{$control_name}_is_empty]', __('niewypełnione', null, 'stAdminGeneratorPlugin')), array('class' => 'is_empty_field'))";
      }
      else
      {
         $is_empty_field = '';
      }

      if ($column->isForeignKey())
      {
         $params = $this->getObjectTagParams($params, array('include_custom' => '---', 'related_class' => $this->getRelatedClassName($column), 'text_method' => '__toString', 'control_name' => $unquotedName));
         return "object_select_tag($default_value, null, $params)";
      }
      else if ($type == CreoleTypes::TIMESTAMP || $type == CreoleTypes::DATE)
      {
         $params = $this->getObjectTagParams($params, array('rich' => true, 'withtime' => $type == CreoleTypes::TIMESTAMP, 'calendar_button_img' => sfConfig::get('sf_admin_web_dir') . '/images/date.png', 'size' => 15));
         $from = "input_date_tag('{$unquotedName}[from]', $default_value_from, $params)";
         $to = "input_date_tag('{$unquotedName}[to]', $default_value_to, $params)";
         return $from . ".' - '." . $to . $is_empty_field;
      }
      else if ($type == CreoleTypes::BOOLEAN)
      {
         $defaultIncludeCustom = '---';

         $option_params = $this->getObjectTagParams($params, array('include_custom' => $defaultIncludeCustom));
         $params = $this->getObjectTagParams($params);

         // little hack
         $option_params = preg_replace("/'" . preg_quote($defaultIncludeCustom) . "'/", $defaultIncludeCustom, $option_params);

         $options = "options_for_select(array(1 => __('tak', array(), 'stAdminGeneratorPlugin'), 0 => __('nie', array(), 'stAdminGeneratorPlugin')), $default_value, $option_params)";

         return "select_tag($name, $options, $params)";
      }
      else if ($type == CreoleTypes::CHAR || $type == CreoleTypes::VARCHAR || $type == CreoleTypes::TEXT || $type == CreoleTypes::LONGVARCHAR || $type == CreoleTypes::MEDIUMTEXT)
      {
         $params = $this->getObjectTagParams($params, array('size' => 15));

         $input = "input_tag($name, $default_value, $params)";

         return $input . $is_empty_field;
      }
      else if ($type == CreoleTypes::INTEGER || $type == CreoleTypes::TINYINT || $type == CreoleTypes::SMALLINT || $type == CreoleTypes::BIGINT ||
              $type == CreoleTypes::FLOAT || $type == CreoleTypes::DOUBLE || $type == CreoleTypes::DECIMAL || $type == CreoleTypes::NUMERIC || $type == CreoleTypes::REAL)
      {
         $is_float = $type == CreoleTypes::FLOAT || $type == CreoleTypes::DOUBLE || $type == CreoleTypes::DECIMAL || $type == CreoleTypes::NUMERIC || $type == CreoleTypes::REAL;

         $params = $this->getObjectTagParams($params, array('size' => 8, 'class' => $is_float ? 'float' : 'integer'));

         $from = "input_tag('{$unquotedName}[from]', $default_value_from, $params)";
         $to = "input_tag('{$unquotedName}[to]', $default_value_to, $params)";
         return $from . ".' - '." . $to . $is_empty_field;
      }
      else
      {
         $params = $this->getObjectTagParams($params, array('disabled' => true, 'size' => 15));

         return "input_tag($name, $default_value, $params)" . $is_empty_field;
      }
   }

  protected function getObjectTagParams($params, $default_params = array())
  {
    $params = array_merge($default_params, $params);

    $result = var_export($params, true);

    if (isset($params['include_custom']))
    {
      $result = preg_replace(
         '/'.preg_quote("'include_custom' => '".$params['include_custom']."'").'/', 
         "'include_custom' => __(\"".$params['include_custom']."\", null, 'stAdminGeneratorPlugin')",
         $result
      );
    }

    
    
    return $result;
  }

   /**
    * Returns HTML code for a column in edit mode.
    *
    * @param   string      The                 column name
    * @param                   array       The                 parameters
    * @return  string      HTML code
    */
   public function getColumnEditTag($column, $params = array())
   {
      if ($callback = $this->getParameterValue('edit.fields.' . $column->getName() . '.callback'))
      {
         $user_params = $this->getParameterValue('edit.fields.' . $column->getName() . '.params');

         $user_params = is_array($user_params) ? $user_params : sfToolkit::stringToArray($user_params);
   
         $params = $user_params ? array_merge($params, $user_params) : $params;

         $obj_params = var_export($params, true);

         return sprintf('%s(\'%s[%s]\', %s, %s)', $callback, $this->getSingularName(), $column->getName(), $this->getColumnGetter($column, true), $obj_params);
      }
      elseif ($column->isComponent())
      {
         $component = $column->getPhpName();
         $component[0] = strtolower($component[0]);
         return "st_get_component('" . $this->getParameterValue('edit.fields.' . $column->getName() . '.module', $this->getModuleName()) . "','" . $component . "', array('type' => 'edit', '{$this->getSingularName()}' => \${$this->getSingularName()}, 'forward_parameters' => \$forward_parameters, 'related_object' => \$related_object))";
      }
      else if ($column->isPartial())
      {
         return "st_get_partial('" . $this->getParameterValue('edit.fields.' . $column->getName() . '.module', $this->getModuleName()) . '/' . $column->getName() . "', array('type' => 'edit', '{$this->getSingularName()}' => \${$this->getSingularName()}, 'forward_parameters' => \$forward_parameters, 'related_object' => \$related_object))";
      }
      
      $postfix = $this->getParameterValue('edit.fields.' . $column->getName() . '.postfix');

      if ($this->getParameterValue('edit.fields.' . $column->getName() . '.support'))
      {
        $params['class'] = "support";
      } 

      return parent::getColumnEditTag($column, $params).($postfix ? ' .\'&nbsp;\'.__(\''.$postfix.'\');' : '');
   }

   public function getRelatedColumnEditTag($column, $related_column, $params = array())
   {
      // user defined parameters
      $user_params = $this->getParameterValue('edit.fields.' . $column->getName() . '.related_fields.' . $related_column->getName() . '.params');
      $user_params = is_array($user_params) ? $user_params : sfToolkit::stringToArray($user_params);
      $params = $user_params ? array_merge($params, $user_params) : $params;

      if ($column->isComponent())
      {
         $component = $related_column->getPhpName();
         $component[0] = strtolower($component[0]);
         return "st_get_component('" . $this->getParameterValue('edit.fields.' . $column->getName() . '.related_fields.' . $related_column->getName() . '.module', $this->getModuleName()) . "','" . $component . "', array('type' => 'edit', '{$this->getSingularName()}' => \${$this->getSingularName()}, 'forward_parameters' => \$forward_parameters, 'related_object' => \$related_object))";
      }
      else if ($column->isPartial())
      {

         return "st_get_partial('" . $this->getParameterValue('edit.fields.' . $column->getName() . '.related_fields.' . $related_column->getName() . '.module', $this->getModuleName()) . '/' . $column->getName() . "', array('type' => 'edit', '{$this->getSingularName()}' => \${$this->getSingularName()}, 'forward_parameters' => \$forward_parameters, 'related_object' => \$related_object))";
      }

      // default control name
      $params = array_merge(array('control_name' => $this->getSingularName() . '[' . $column->getName() . '][' . $related_column->getName() . ']'), $params);

      // default parameter values
      $type = $related_column->getCreoleType();
      if ($type == CreoleTypes::DATE)
      {
         $params = array_merge(array('rich' => true, 'calendar_button_img' => sfConfig::get('sf_admin_web_dir') . '/images/date.png'), $params);
      }
      else if ($type == CreoleTypes::TIMESTAMP)
      {
         $params = array_merge(array('rich' => true, 'withtime' => true, 'calendar_button_img' => sfConfig::get('sf_admin_web_dir') . '/images/date.png'), $params);
      }

      // user sets a specific tag to use
      if ($inputType = $this->getParameterValue('edit.fields.' . $column->getName() . '.related_fields.' . $related_column->getName() . '.type'))
      {
         if ($inputType == 'plain')
         {
            return $this->getColumnListTag($related_column, $params);
         }
         else
         {
            return $this->getPHPObjectHelper($inputType, $related_column, $params);
         }
      }

      // guess the best tag to use with column type
      return parent::getCrudColumnEditTag($related_column, $params);
   }

   public function showConfigCulturePicker($type)
   {
      $fields = $this->getParameterValue($type . '.fields');

      foreach ($fields as $field => $params)
      {
         if (isset($params['is_i18n']))
         {
            return true;
         }
      }

      return false;
   }

   /**
    * Returns form control HTML code for a column in $type mode.
    *
    * @param   sfAdminColumn $column           column object
    * @param                 string      $type               mode
    * @param   array       $params             HTML parameters
    * @return         HTML        code
    */
   public function getColumnFormTag($column, $type, $params = array())
   {

      $i18n = sfContext::getInstance()->getI18N();

      $user_params = $this->getParameterValue($type . '.fields.' . $column->getName() . '.params');

      $user_params = is_array($user_params) ? $user_params : sfToolkit::stringToArray($user_params);

      $params = $user_params ? array_merge($params, $user_params) : $params;

      if ($this->getParameterValue($type.'.fields.' . $column->getName() . '.support'))
      {
        $params['class'] = "support";
      }       

      $name = "{$type}[{$column->getName()}]";

      $is_i18n = $this->getParameterValue($type . '.fields.' . $column->getName() . '.is_i18n', false);

      $value = sprintf('$%s->get(\'%s\', null, %s)', $type, $column->getName(), $is_i18n ? 'true' : 'false');

      if ($callback = $this->getParameterValue($type . '.fields.' . $column->getName() . '.callback'))
      {
         $obj_params = var_export($params, true);

         return sprintf('%s(\'%s\', %s, %s)', $callback, $name, $value, $obj_params);
      }
      elseif ($column->isComponent())
      {
         $component = strtolower(substr($column->getPhpName(), 0, 1)) . substr($column->getPhpName(), 1);
         return "st_get_component('" . $this->getParameterValue('edit.fields.' . $column->getName() . '.module', $this->getModuleName()) . "','" . $component . "', array('type' => '$type', '$type' => \$$type, 'forward_parameters' => \$forward_parameters))";
      }
      else if ($column->isPartial())
      {
         return "st_get_partial('" . $this->getParameterValue($type . '.fields.' . $column->getName() . '.module', $this->getModuleName()) . '/' . $column->getName() . "', array('type' => '$type', '$type' => \$$type, 'forward_parameters' => \$forward_parameters))";
      }

      $inputType = $this->getParameterValue($type . '.fields.' . $column->getName() . '.type');

      if ($inputType == 'date')
      {
         $params = array_merge(array('rich' => true, 'calendar_button_img' => sfConfig::get('sf_admin_web_dir') . '/images/date.png'), $params);
      }
      elseif ($inputType == 'datetime')
      {
         $params = array_merge(array('rich' => true, 'withtime' => true, 'calendar_button_img' => sfConfig::get('sf_admin_web_dir') . '/images/date.png'), $params);
      }

      $format = $this->getParameterValue($type . '.fields.' . $column->getName() . '.format');

      $postfix = $this->getParameterValue($type . '.fields.' . $column->getName() . '.postfix');

      if ($format) 
      {
         $params['data-format'] = $format;
      }

      $obj_params = var_export($params, true);

      if ($inputType)
      {
         if ($inputType == 'text')
         {
            return "input_tag('$name', $value, $obj_params)".($postfix ? " . ' <span style=\"vertical-align: middle\">' . __('$postfix') . '</span>' " : '');
         }

         if ($inputType == 'datetime' || $inputType == 'date')
         {

            return "input_date_tag('$name', $value, $obj_params)".($postfix ? ". ' <span style=\"vertical-align: middle\">' . __('$postfix') . '</span>' " : '');
         }

         if ($inputType == 'password')
         {
            return "input_password_tag('$name', $value, $obj_params)".($postfix ? ". ' <span style=\"vertical-align: middle\">' . __('$postfix') . '</span>' " : '');
         }

         if ($inputType == 'textarea')
         {
            return "textarea_tag('$name', $value, $obj_params)";
         }

         if ($inputType == 'checkbox')
         {
            if ($this->getParameterValue($type . '.fields.' . $column->getName() . '.checked', false))
            {
               $value = sprintf('$%s->get(\'%s\', true, %s)', $type, $column->getName(), $is_i18n ? 'true' : 'false');
            }

            return "checkbox_tag('$name', 1, $value, $obj_params)";
         }

         if ($inputType == 'select')
         {
            $select_options = array();

            if ($this->getParameterValue($type . '.fields.' . $column->getName() . '.display'))
            {

              $options = $this->getParameterValue($type . '.fields.' . $column->getName() . '.options');

               foreach ($this->getParameterValue($type . '.fields.' . $column->getName() . '.display') as $option)
               {
                  $opt_value = isset($options[$option]['value']) ? $options[$option]['value'] : $option;
                  $opt_name = isset($options[$option]['name']) ? $options[$option]['name'] : $option;

                  $i18nCatalogue = isset($options[$option]['i18n']) ? $options[$option]['i18n'] : $this->getModuleName();

                  $select_options[] = sprintf('\'%s\' => __(\'%s\', array(), \'%s\')', $opt_value, $opt_name, $i18nCatalogue);
               }

               $selected_column = $this->getParameterValue($type . '.fields.' . $column->getName() . '.selected');

               if ($selected_column)
               {
                  $selected = $this->getParameterValue($type . '.fields.' . $column->getName() . '.options.' . $selected_column . '.value', $selected_column);
               }
               else
               {
                  $selected = 0;
               }
            }
            return "select_tag('$name', options_for_select(array(" . implode(', ', $select_options) . "), $value ? $value : '$selected'), $obj_params)".($postfix ? ". ' <span style=\"vertical-align: middle\">' . __('$postfix') . '</span>' " : '');
         }

         return $this->getConfigObjectHelper($inputType, $column, $params);
      }
      else
      {
         return "input_tag('$name', $value, $obj_params)".($postfix ? ". ' <span style=\"vertical-align: middle\">' . __('$postfix') . '</span>' " : '');
      }
   }

   public function getConfigObjectHelper($helperName, $column, $params)
   {
      $params = $this->getObjectTagParams($params, array('control_name' => 'config[' . $column->getName() . ']'));

      return sprintf('object_%s($%s, \'%s\', %s)', $helperName, 'config', $column->getName(), $params);
   }   

   public function getHelp($column, $type = '')
   {
      $help = $this->getParameterValue($type . '.fields.' . $column->getName() . '.help');

      if ($help)
      {
         $i18n = $this->getParameterValue($type . '.fields.' . $column->getName() . '.i18n', $this->getModuleName());

         return "<div class=\"sf_admin_edit_help\">[?php echo __('" . trim($help) . "', array(), '$i18n') ?]</div>";
      }

      return '';
   }

   /**
    *
    * @param   string      The                 column name
    * @param                   array       The                 parameters
    * @return  string      HTML code
    */
   public function getColumnListTag($column, $params = array())
   {
      $custom_value = $this->getParameterValue('list.fields.' . $column->getName() . '.custom_value');

      if ($custom_value)
      {
         return $this->getI18NString(null, $custom_value, false);
      }

      $user_params = $this->getParameterValue('list.fields.' . $column->getName() . '.params');
      $user_params = is_array($user_params) ? $user_params : sfToolkit::stringToArray($user_params);
      $params = $user_params ? array_merge($params, $user_params) : $params;

      $type = $column->getCreoleType();

      $columnGetter = $this->getColumnGetter($column, true);

      if ($callback = $this->getParameterValue('list.fields.' . $column->getName() . '.callback'))
      {
         return "$callback(\${$this->getSingularName()}, null, '{$this->getColumnGetter($column, false)}');";
      }
      elseif ($column->isComponent())
      {

         return $this->getComponentFromColumn($column, $this->getParameterValue('list.fields.' . $column->getName() . '.module'));

         //            return "get_component('" . $module . "', '" . $component . "', array('type' => 'list', '{$this->getSingularName()}' => isset(\${$this->getSingularName()}) ? \${$this->getSingularName()} : null, 'forward_parameters' => \$forward_parameters))";
      }
      else if ($column->isPartial())
      {
         return $this->getPartialFromColumn($column, $this->getParameterValue('list.fields.' . $column->getName() . '.module'));
         //            return "get_partial('" . $this->getParameterValue('list.fields.' . $column->getName() . '.module', $this->getModuleName()) . '/' . $column->getName() . "', array('type' => 'list', '{$this->getSingularName()}' => isset(\${$this->getSingularName()}) ? \${$this->getSingularName()} : null, 'forward_parameters' => \$forward_parameters))";
      }
      else if ($type == CreoleTypes::DATE || $type == CreoleTypes::TIMESTAMP)
      {
         $format = isset($params['date_format']) ? $params['date_format'] : ($type == CreoleTypes::DATE ? 'dd-MM-yyyy' : 'dd-MM-yyyy, HH:mm');
         return "($columnGetter !== null && $columnGetter !== '') ? st_format_date($columnGetter, \"$format\") : ''";
      }
      elseif ($type == CreoleTypes::BOOLEAN)
      {
         return "$columnGetter ? image_tag('/images/backend/beta/icons/16x16/tick.png') : '&nbsp;'";
      }
      else
      {
         return "$columnGetter";
      }
   }

   public function getEditColumnListTag($column, $params = array())
   {
      $editable = $this->getParameterValue('list.editable.'.$column->getName());

      if ($callback = $this->getParameterValue('list.fields.' . $column->getName() . '.callback'))
      {
         return "$callback(\${$this->getSingularName()}, \$list_mode, '{$this->getColumnGetter($column, false)}');";
      }
      elseif ($column->isComponent())
      {
         return $this->getComponentFromColumn($column, $this->getParameterValue('list.fields.' . $column->getName() . '.module'), true);
      }
      else if ($column->isPartial())
      {
         return $this->getPartialFromColumn($column, $this->getParameterValue('list.fields.' . $column->getName() . '.module'), true);
      } 
      elseif (null !== $editable && $column->isReal())
      {
         $type = $column->getCreoleType();

         $column_getter = $this->getColumnGetter($column, true);

         $singular_name = $this->getSingularName();

         $column_name = $column->getName();

         $params = isset($editable['params']) ? sfToolkit::stringToArray($editable['params']) : array();

         if ($column->getCreoleType() != CreoleTypes::BOOLEAN)
         {
            return "input_tag('{$singular_name}['.\${$singular_name}->getPrimaryKey().'][$column_name]', \$sf_request->hasErrors() ? \$sf_request->getParameter('{$singular_name}['.\${$singular_name}->getPrimaryKey().'][$column_name]') : $column_getter, ".var_export($params, true).")";
         }
         elseif ($column->getCreoleType() == CreoleTypes::BOOLEAN)
         {
            return "st_admin_checkbox_tag('{$singular_name}['.\${$singular_name}->getPrimaryKey().'][$column_name]', true, \$sf_request->hasErrors() ? \$sf_request->getParameter('{$singular_name}['.\${$singular_name}->getPrimaryKey().'][$column_name]') : $column_getter, ".var_export($params, true).")";
         }
      }
      else
      {
         return $this->getColumnListTag($column);
      }
   }

   /**
    * Poprawka - poprawia wydajność podczas przechodzenia pomiędzy modelami bazy danych
    *
    * @author Marcin Butlak <marcin.butlak@sote.pl>
    */
   protected function loadMapBuilderClasses()
   {
      if (!$this->map)
      {
         parent::loadMapBuilderClasses();
      }
      else
      {
         $this->tableMap = $this->map->getDatabaseMap()->getTable(constant($this->className . 'Peer::TABLE_NAME'));
      }
   }

   /**
    * Poprawka - zapewnia poprawne ładowanie kluczy podczas przechodzenia pomiędzy modelami bazy danych
    *
    * @author Marcin Butlak <marcin.butlak@sote.pl>
    */
   protected function loadPrimaryKeys()
   {
      $this->primaryKey = array();
      parent::loadPrimaryKeys();
   }

   /**
    * Zmienia nazwę klasy modelu na podstawie której przebiega generowanie modułu
    *
    * @param        string      $modelClass
    */
   protected function changeModelClass($modelClass)
   {
      if ($this->getClassName() != $modelClass)
      {
         $this->setScaffoldingClassName($modelClass);

         // get some model metadata
         $this->loadMapBuilderClasses();

         // load all primary keys
         $this->loadPrimaryKeys();
      }
   }

   /**
    * Przywraca poprzednio ustawiony model
    */
   protected function restoreModelClass()
   {
      $this->changeModelClass(isset($this->params[$this->customAction . '_model_class']) ? $this->params[$this->customAction . '_model_class'] : $this->params['model_class']);
   }

   /**
    * Zwraca kolumne na podstawie jej nazwy PHP i nazwy modelu (opcjonalnie)
    *
    * @param   string      $phpName            Nazwa php
    * @param   string      $modelClass         Nazwa modelu (opcjonalna)
    * @return   sfAdminColumn
    */
   public function getColumnForPhpName($phpName, $modelClass = null)
   {

      $column = parent::getColumnForPhpName($phpName);
      $this->restoreModelClass();

      return $column;
   }

   public function changeModelClassFromField($field)
   {
      if (is_array($field))
      {
         $modelClass = $field[0];
      }
      else
      {
         $tmp = explode('.', $field);

         if (isset($tmp[1]))
         {
            $modelClass = sfInflector::camelize($tmp[0]);
         }
         else
         {
            $modelClass = null;
         }
      }

      $this->changeModelClass($modelClass ? $modelClass : $this->getClassName());
   }

   /**
    * Zwraca obiekt sfAdminColumn na podstawie nazwy pola
    *
    * @param   string      $field              Nazwa pola
    * @return   sfAdminColumn
    */
   public function getAdminColumnFromField($field, $modelClass = null)
   {
      if (is_array($field))
      {
         $modelClass = $field[0];
         $field = $field[1];
         $flags = '';
      }
      else
      {
         $tmp = explode('.', $field);

         if (isset($tmp[1]))
         {
            $modelClass = sfInflector::camelize($tmp[0]);
            $field = $tmp[1];
         }
         else
         {
            $field = $tmp[0];
         }

         list($field, $flags) = $this->splitFlag($field);
      }

      $this->changeModelClass($modelClass ? $modelClass : $this->getClassName());

      $column = $this->getAdminColumnForField($field, $flags);

      $this->restoreModelClass();

      return $column;
   }

   /**
    * Wygeneruj
    *
    * @param   unknown_type $params
    * @return   unknown
    */
   public function generate($params = array())
   {
      $this->params = $params;

      $required_parameters = array('model_class', 'moduleName');
      foreach ($required_parameters as $entry)
      {
         if (!isset($this->params[$entry]))
         {
            $error = 'You must specify a "%s"';
            $error = sprintf($error, $entry);

            throw new sfParseException($error);
         }
      }

      $modelClass = $this->params['model_class'];

      $module_name = $this->params['moduleName'];

      foreach ($this->params as $key => $val)
      {
         if (is_array($val) && key_exists('include_file', $val))
         {
            $app_yml = sfYaml::load(self::getAppYmlPath($val['include_file']));
            $module_yml = sfYaml::load(self::getModuleYmlPath($module_name, $val['include_file']));
            $plugin_yml = sfYaml::load(self::getPluginYmlPath($module_name, $val['include_file']));

            $this->params = self::array_merge_recursive($app_yml, $module_yml, $plugin_yml, $this->params);
         }
      }

      $this->dispatcher->notify(new sfEvent($this, 'stAdminGenerator.generate', array('moduleName' => $this->params['moduleName'])));

      $this->dispatcher->notify(new sfEvent($this, 'stAdminGenerator.generate' . ucfirst($this->params['moduleName'])));

      if (!class_exists($modelClass))
      {
         $error = 'Unable to scaffold unexistant model "%s"';
         $error = sprintf($error, $modelClass);

         throw new sfInitializationException($error);
      }

      $this->setScaffoldingClassName($modelClass);

      // generated module name
      $this->setGeneratedModuleName('auto' . ucfirst($this->params['moduleName']));
      $this->setModuleName($this->params['moduleName']);

      // get some model metadata
      $this->loadMapBuilderClasses();

      // load all primary keys
      $this->loadPrimaryKeys();

      // theme exists?
      $theme = isset($this->params['theme']) ? $this->params['theme'] : 'default';
      $themeDir = sfLoader::getGeneratorTemplate($this->getGeneratorClass(), $theme, '');
      if (!is_dir($themeDir))
      {
         $error = 'The theme "%s" does not exist.';
         $error = sprintf($error, $theme);
         throw new sfConfigurationException($error);
      }

      $this->setTheme($theme);
      $templateFiles = sfFinder::type('file')->name('*.php')->relative()->in($themeDir . '/templates');
      $configFiles = sfFinder::type('file')->name('*.yml')->relative()->in($themeDir . '/config');
      $libFiles = sfFinder::type('file')->name('*.php')->relative()->in($themeDir . '/lib');

      $data = $this->generatePhpFiles($this->generatedModuleName, $templateFiles, $configFiles, $libFiles);

      foreach ($this->getColumnCategories('custom_actions') as $category)
      {
         foreach ($this->getColumns('custom_actions', $category) as $column)
            $this->generatePhpTemplatesForCustomAction($this->generatedModuleName, $templateFiles, $column->getName(), $category);
      }

      return $data;
   }

   protected function generatePhpTemplatesForCustomAction($generatedModuleName, $templateFiles = array(), $actionName, $actionType)
   {
      $ignore = array('_edit_header.php', '_edit_footer.php', '_edit_header_title.php', '_list_messages.php', '_edit_messages.php', '_custom_messages.php', '_config_messages.php');

      $this->setParameterValuePrefix($actionName);

      foreach ($templateFiles as $template)
      {
         if (in_array($template, $ignore)) continue;
         
         if (strpos($template, $actionType . 'Success.php') === 0)
         {
            $retval = $this->evalTemplate('templates/' . $template);

            // save template file
            $this->getGeneratorManager()->getCache()->set($this->getCustomActionNameCamelized() . ucfirst($template), $generatedModuleName . DIRECTORY_SEPARATOR . 'templates', $retval);
         }
         elseif (strpos($template, '_' . $actionType) === 0)
         {
            $retval = $this->evalTemplate('templates/' . $template);

            if ($template == sfInflector::underscore($template))
            {
               $this->getGeneratorManager()->getCache()->set($this->getCustomActionName('_') . $template, $generatedModuleName . DIRECTORY_SEPARATOR . 'templates', $retval);
            }
            else
            {
               $this->getGeneratorManager()->getCache()->set(($template[0] == '_' ? '_' : '').$this->getCustomActionNameCamelized() . ucfirst(ltrim($template, '_')), $generatedModuleName . DIRECTORY_SEPARATOR . 'templates', $retval);
            }
         }
      }

      $this->resetParameterValuePrefix();
   }

   /**
    * Wygeneruj pliki php
    *
    * @param   unknown_type $generatedModuleName
    * @param   unknown_type $templateFiles
    * @param   unknown_type $configFiles
    * @param   unknown_type $libFiles
    * @return   unknown
    */
   protected function generatePhpFiles($generatedModuleName, $templateFiles = array(), $configFiles = array(), $libFiles = array())
   {
      parent::generatePhpFiles($generatedModuleName, $templateFiles, $configFiles);
      $retval = $this->evalTemplate('actions/components.class.php');

      // save actions class
      $this->getGeneratorManager()->getCache()->set('components.class.php', $generatedModuleName . DIRECTORY_SEPARATOR . 'actions', $retval);
      // require generated action class
      $data = "require_once(sfConfig::get('sf_module_cache_dir').'/" . $generatedModuleName . "/actions/actions.class.php');\n";
      $data .= "require_once(sfConfig::get('sf_module_cache_dir').'/" . $generatedModuleName . "/actions/components.class.php');\n";

      // generate config files
      foreach ($libFiles as $lib)
      {
         // eval config file
         $retval = $this->evalTemplate('lib/' . $lib);

         // save config file
         $this->getGeneratorManager()->getCache()->set($lib, $generatedModuleName . DIRECTORY_SEPARATOR . 'lib', $retval);

         $data .= "require_once(sfConfig::get('sf_module_cache_dir').'/" . $generatedModuleName . "/lib/$lib');\n";
      }

      return $data;
   }

   public function replaceConstantsForMenu($value, $double_quoted = false)
   {
      // find %%xx%% strings
      preg_match_all('/%%([^%]+)%%/', $value, $matches, PREG_PATTERN_ORDER);

      $tmp = $this->getCustomActionName('', '_') . 'tmp';

      $this->params[$tmp]['display'] = array();
      foreach ($matches[1] as $name)
      {
         $this->params[$tmp]['display'][] = $name;
      }

      foreach ($this->getColumns('tmp.display') as $column)
      {
         $value = str_replace('%%' . $column->getName() . '%%', '" . (isset($forward_parameters[\'' . $column->getName() . '\']) ? $forward_parameters[\'' . $column->getName() . '\'] : ' . $this->getColumnGetter($column, true) . ') . "', $value);
      }

      if ($double_quoted)
      {
         $value = '"' . $value . '"';
      }

      return $value;
   }

   /**
    * Wraps a content for I18N.
    *
    * @param   string      The                 key name
    * @param   string      The                 defaul value
    * @return  string      HTML code
    */
   public function getI18NString($key, $default = null, $withEcho = true)
   {
      $i18n = $this->getParameterValue($key) ? $this->getModuleName() : 'stAdminGeneratorPlugin';

      $value = $this->escapeString($this->getParameterValue($key, $default));

      $tmp_index = $this->getCustomActionName('', '_tmp', 'tmp');

      // find %%xx%% strings
      preg_match_all('/%%([^%]+)%%/', $value, $matches, PREG_PATTERN_ORDER);
      $this->params[$tmp_index]['display'] = array();
      foreach ($matches[1] as $name)
      {
         $this->params[$tmp_index]['display'][] = $name;
      }

      $vars = array();
      foreach ($this->getColumns('tmp.display') as $column)
      {
         if ($column->isLink())
         {
            $vars[] = '\'%%' . $column->getName() . '%%\' => link_to(' . $this->getColumnListTag($column) . ', \'' . $this->getModuleName() . '/edit?' . $this->getPrimaryKeyUrlParams() . ')';
         }
         elseif ($column->isPartial())
         {
            $vars[] = '\'%%_' . $column->getName() . '%%\' => ' . '\'<i>\'.' . $this->getColumnListTag($column) . '.\'</i>\'';
         }
         else if ($column->isComponent())
         {
            $vars[] = '\'%%~' . $column->getName() . '%%\' => ' . '\'<i>\'.' . $this->getColumnListTag($column) . '.\'</i>\'';
         }
         else
         {
            $vars[] = '\'%%' . $column->getName() . '%%\' => ' . '\'<i>\'.' . $this->getColumnListTag($column) . '.\'</i>\'';
         }
      }

      // strip all = signs
      $value = preg_replace('/%%=([^%]+)%%/', '%%$1%%', $value);

      $i18n = '__(\'' . $value . '\', ' . "\n" . 'array(' . implode(",\n", $vars) . '), \''.$i18n.'\')';

      return $withEcho ? '[?php echo ' . $i18n . ' ?]' : $i18n;
   }

   /**
    * Pobierz przycisk do akcji
    *
    * @param   unknown_type $actionName
    * @param   unknown_type $params
    * @param   unknown_type $pk_link
    * @return   unknown
    */
   public function getButtonToAction($actionName, $params, $pk_link = false)
   {

      $i18n = sfContext::getInstance()->getI18N();
      $params = (array) $params;
      $options = isset($params['params']) ? $params['params'] : array();
      $method = 'button_to';
      $li_class = '';
      $only_for = isset($params['only_for']) ? $params['only_for'] : null;

      if (is_string($options))
      {
         $options = sfToolkit::stringToArray($options);
      }

      $force_submit = isset($options['force_submit']) ? $options['force_submit'] : false;
      // default values
      if ($actionName[0] == '_')
      {
         $actionName = substr($actionName, 1);
         $default_name = strtr($actionName, '_', ' ');
         $default_icon = '/images/backend/icons/' . $actionName . '.png';
         $default_action = $actionName;
         $default_class = 'sf_admin_action_' . $actionName;

         if ($actionName == 'save' || $actionName == 'save_and_add' || $actionName == 'save_and_list')
         {
            $method = 'submit_tag';

            $options['name'] = $actionName;
         }

         if ($actionName == 'delete')
         {
            if (!isset($options['confirm']))
            {
               $options['confirm'] = $i18n->__('Jesteś pewien?', null, 'stAdminGeneratorPlugin');
            }

            $only_for = 'edit';
         }
      }
      else
      {
         $default_name = strtr($actionName, '_', ' ');
         $default_icon = sfConfig::get('sf_admin_web_dir') . '/images/default_icon.png';
         $default_action = 'List' . sfInflector::camelize($actionName);
         $default_class = '';
      }



      $name = isset($params['name']) ? $params['name'] : $default_name;
      $icon = isset($params['icon']) ? $params['icon'] : $actionName;
      $action = isset($params['action']) ? $params['action'] : $default_action;

      if (isset($params['type']))
      {
         $options['type'] = $params['type'];
      }

      $url_params = array();

      if ($pk_link)
      {
         $url_params[] = $this->getPrimaryKeyUrlParams();
      }

      //        $url_params = $pk_link ? '?' . $this->getPrimaryKeyUrlParams() : '\'';

      if (!isset($options['class']))
      {
         if ($default_class)
         {
            //$options ['class'] = $default_class;
         }
         else
         {
            //$options ['style'] = 'background: #ffc url(' . $icon . ') no-repeat 3px 2px';
         }
      }

      //$li_class = $li_class ? ' class="' . $li_class . '"' : '';


      $html = '';

      if ($only_for == 'edit')
      {
         $html .= '[?php if (' . $this->getPrimaryKeyIsSet() . '): ?]' . "\n";
      }
      else if ($only_for == 'create')
      {
         $html .= '[?php if (!' . $this->getPrimaryKeyIsSet() . '): ?]' . "\n";
      }
      else if ($only_for !== null)
      {
         throw new sfConfigurationException(sprintf('The "only_for" parameter can only take "create" or "edit" as argument ("%s")', $only_for));
      }

      $i18n_catalogue = isset($params['i18n']) ? $params['i18n'] : 'stAdminGeneratorPlugin';
      
      $options['name'] = $actionName;
      
      $options_string = '';

      foreach ($options as $key => $value)
      {
         if ($key == 'confirm')
         {
            $options_string .= '"'.$key.'"' . ' => __("'.$value.'"),';
         }
         else
         {
            $options_string .= '"'.$key.'"' . ' => "'.$value.'",';
         }
      }
       

      if ($method == 'submit_tag' || $force_submit)
      {
         $html .= '[?php echo st_get_admin_action(\'' . $actionName . '\', __(\'' . $name . '\', null, \'' . $i18n_catalogue . '\'), null, array(' . $options_string . ')) ?]';
         //     $html .= '[?php echo submit_tag(__(\'' . $name . '\'), ' . var_export ( $options, true ) . ') ?]';
      }
      else
      {
         if ($action[0] == '@')
         {
            $action = $this->replaceConstantsForTemplate($action).'\'';
         }
         else
         {
            $related_id = $this->getParameterValue('list.build_options.related_id');

            if ($related_id)
            {
               $related_id = str_replace('forward_parameters.', '', $related_id);
               $url_params[] = "$related_id='." . $this->getForwardParameterBy('list.build_options.related_id');
            }
            $action = $action{0} == '/' ? $this->replaceConstantsForTemplate($action).'\'' : $this->getModuleName() . '/' . $action . ($url_params ? '?' . implode(".'&", $url_params) : '\'');
         }
         

         $html .= '[?php echo st_get_admin_action(\'' . $icon . '\', __(\'' . $name . '\', null, \'' . $i18n_catalogue . '\'), \'' . $action . ', array(' . $options_string . ')) ?]';

         //     $html .= '[?php echo button_to(__(\'' . $name . '\'), \'' . $this->getModuleName () . '/' . $action . $url_params . ', ' . $phpOptions . ') ?]';
      }

      if ($only_for !== null)
      {
         $html .= '[?php endif; ?]' . "\n";
      }

      //$html .= '</li>' . "\n";


      return $html;
   }

   /**
    * Returns HTML code for an action link.
    *
    * @param   string      The                 action name
    * @param                   array       The                 parameters
    * @param   boolean     Whether             to add a primary key link or not
    * @return  string      HTML code
    */
   public function getLinkToAction($actionName, $params, $pk_link = false, $type = 'list')
   {
      $i18n = sfContext::getInstance()->getI18N();

      $options = isset($params['params']) ? sfToolkit::stringToArray($params['params']) : array();

      // default values
      if ($actionName[0] == '_')
      {
         $actionName = substr($actionName, 1);
         
         $name = $actionName;
   
         if ($actionName == 'edit')
         {
            $icon = '/images/backend/beta/icons/16x16/edit.png';
         }         
         elseif ($actionName == 'delete')
         {
            $icon = '/images/backend/beta/icons/16x16/remove.png';
         }
         else
         {
            $icon = '/images/backend/icons/' . $actionName . '.gif';
         }

         $action = $actionName;

         if ($actionName == 'delete')
         {
            $options['post'] = true;
            if (!isset($options['confirm']))
            {
               $options['confirm'] = $i18n->__('Jesteś pewien?', null, 'stAdminGeneratorPlugin');
            }
         }
      }
      else
      {
         $name = isset($params['name']) ? $params['name'] : $actionName;
         $icon = isset($params['icon']) ? sfToolkit::replaceConstants($params['icon']) : '/images/backend/icons/default.png';
      }

      if ($icon[0] != '/')
      {
         $icon = '/images/'.$icon;
      }

      $action = isset($params['action']) ? $this->replaceConstantsForTemplate($params['action']) : 'list' . sfInflector::camelize($actionName);

      if ($action[0] == '@')
      {
         $url = 'url_for(\'' . $action . '\')';
      }
      else
      {
         if (strpos($action, '?') !== false)
         {
            $pk_link = false;
         }

         $url_params = $pk_link ? '?' . $this->getPrimaryKeyUrlParams() : '\'';

         $url_params .= ".'".$this->getForwardParametersForUrl('$', '&', $type);

         $url = $action[0] == '/' ? '\''.$action.'\'' : 'url_for(\'' . $this->getModuleName() . '/' . $action . $url_params.')'; 
      }

      if (isset($options['confirm']))
      {
         $confirm = '[?php echo __(\''.$options['confirm'].'\') ?]'; 
      }
      else
      {
         $confirm = '';
      }

      return '<li><a href="[?php echo '.$url.' ?]" data-admin-confirm="'.$confirm.'" data-admin-action="'.$actionName.'"><img src="'.$icon.'" title="[?php echo __(\''.$name.'\') ?]" class="tooltip" /></a></li>';
   }

   /**
    * Replaces constants in a string (this is a modified version for view layer)
    *
    * @param        string      $value
    * @return   string
    */
   public function replaceConstantsForTemplate($value)
   {
      // find %%xx%% strings
      preg_match_all('/%%([^%]+)%%/', $value, $matches, PREG_PATTERN_ORDER);

      $tmp = $this->getCustomActionName('', '_') . 'tmp';

      $this->params[$tmp]['display'] = array();
      foreach ($matches[1] as $name)
      {
         $this->params[$tmp]['display'][] = $name;
      }

      foreach ($this->getColumns('tmp.display') as $column)
      {
         $value = str_replace('%%' . $column->getName() . '%%', '\'.' . $this->getColumnGetter($column, true) . '.\'', $value);
      }

      return $value;
   }

   public function replaceConstants($value)
   {
      // find %%xx%% strings
      preg_match_all('/%%([^%]+)%%/', $value, $matches, PREG_PATTERN_ORDER);

      $tmp = $this->getCustomActionName('', '_') . 'tmp';

      $this->params[$tmp]['display'] = array();
      foreach ($matches[1] as $name)
      {
         $this->params[$tmp]['display'][] = $name;
      }

      foreach ($this->getColumns('tmp.display') as $column)
      {
         $value = str_replace('%%' . $column->getName() . '%%', '{' . $this->getColumnGetter($column, true, 'this->') . '}', $value);
      }

      return $value;
   }

   /**
    * Dołącz plik admin generatora
    *
    * @param   unknown_type $module_name
    * @param   unknown_type $filename
    */
   public function attachAdminGeneratorFile($module_name, $filename)
   {
      $module_yml = sfYaml::load(self::getModuleYmlPath($module_name, $filename));
      $plugin_yml = sfYaml::load(self::getPluginYmlPath($module_name, $filename));
      $this->params = self::array_merge_recursive($this->params, $module_yml, $plugin_yml);
   }

   public function getForwardParametersForUrl($params_prefix = '$', $query_prefix = '&', $type = 'edit', $postfix = "'")
   {
      $params = '';

      foreach ($this->getParameterValue($type . '.forward_parameters', array()) as $parameter)
      {

         $params .= $parameter . "='.{$params_prefix}forward_parameters['$parameter'].'&";
      }

      return $params ? $query_prefix . rtrim($params, ".'&") : $postfix;
   }

   public function getEditActionUrl()
   {
      $for = $this->getModuleName().'/'.$this->getCustomActionNameCamelized('', 'Edit', 'edit');

      return "'".$for.'?'.$this->getPrimaryKeyUrlParams().$this->getForwardParametersForUrl('$', ".'&", 'edit', null);
   }

   /**
    * Returns full path to plugin yml generator file
    *
    * @param   string      $plugin_name        Plugin name
    * @param   string      $yml_file           yml File name with extension (example: menu.yml)
    * @return  string      Returns full path to yml file
    */
   public static function getPluginYmlPath($plugin_name, $yml_file)
   {
      return sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . $plugin_name . DIRECTORY_SEPARATOR . sfConfig::get('sf_app_config_dir_name') . DIRECTORY_SEPARATOR . 'generator' . DIRECTORY_SEPARATOR . $yml_file;
   }

   /**
    * Returns full path to module yml generator file
    *
    * @param   string      $module_name        Module name
    * @param   string      $yml_file           File name with extension (example: menu.yml)
    * @return  string      Returns full path to yml file
    */
   public static function getModuleYmlPath($module_name, $yml_file)
   {
      return sfConfig::get('sf_app_module_dir') . DIRECTORY_SEPARATOR . $module_name . DIRECTORY_SEPARATOR . sfConfig::get('sf_app_module_config_dir_name') . DIRECTORY_SEPARATOR . 'generator' . DIRECTORY_SEPARATOR . $yml_file;
   }

   /**
    * Enter description here...
    *
    * @param   string      $yml_file           File name with extension (example: menu.yml)
    * @return  string      Returns full path to yml file
    */
   public static function getAppYmlPath($yml_file)
   {
      return sfConfig::get('sf_app_config_dir') . DIRECTORY_SEPARATOR . 'generator' . $yml_file;
   }

   /**
    * An alternative to array_merge_recursive PHP function
    *
    * @param         array       $array1
    * @param         array       $array2
    * @param         array       [optional]
    * @return  array       Merge arrays
    */
   public static function array_merge_recursive($array1, $array2)
   {
      $arrays = func_get_args();
      $narrays = count($arrays);

      // check arguments
      // comment out if more performance is necessary (in this case the foreach loop will trigger a warning if the argument is not an array)
      for ($i = 0; $i < $narrays; $i++)
      {
         if (!is_array($arrays[$i]))
         {
            // also array_merge_recursive returns nothing in this case
            throw new sfException('Argument #' . ($i + 1) . ' is not an array - trying to merge array with scalar!');
         }
      }

      // the first array is in the output set in every case
      $ret = $arrays[0];

      // merege $ret with the remaining arrays
      for ($i = 1; $i < $narrays; $i++)
      {
         foreach ($arrays[$i] as $key => $value)
         {
            if (((string) $key) === ((string) intval($key)))
            { // integer or string as integer key - append
               $ret[] = $value;
            }
            else
            { // string key - megre
               if (is_array($value) && isset($ret[$key]) && !empty($value))
               {
                  // if $ret[$key] is not an array you try to merge an scalar value with an array - the result is not defined (incompatible arrays)
                  // in this case the call will trigger an E_USER_WARNING and the $ret[$key] will be null.
                  if ($key == 'display' && isset($ret[$key]['NONE']) && isset($value[0])) 
                  {
                     $ret[$key]['NONE'] = self::array_merge_recursive($ret[$key]['NONE'], $value);
                  }
                  else
                  {
                     $ret[$key] = self::array_merge_recursive($ret[$key], $value);
                  }
               }
               else
               {
                  $ret[$key] = $value;
               }
            }
         }
      }

      return $ret;
   }

   /**
    * Zwraca komponent na podstawie kolumny
    *
    * @param             sfAdminColumn $column           Kolumna
    * @return   string
    */
   public function getComponentFromColumn($column, $default_module = null, $editable = false)
   {
      $tmp = explode('.', $column->getName());

      if (isset($tmp[1]))
      {
         $module = lcfirst(sfInflector::camelize($tmp[0]));
         $component = lcfirst(sfInflector::camelize($tmp[1]));
      }
      else
      {
         $module = is_null($default_module) ? $this->getModuleName() : $default_module;
         $component = lcfirst(sfInflector::camelize($tmp[0]));
      }

      if ($editable)
      {
        return "st_get_component('" . $module . "', '" . $component . "', array('type' => 'list', '{$this->getSingularName()}' => isset(\${$this->getSingularName()}) ? \${$this->getSingularName()} : null, 'forward_parameters' => \$forward_parameters, 'list_mode' => \$list_mode))";        
      }
      else
      {
        return "st_get_component('" . $module . "', '" . $component . "', array('type' => 'list', '{$this->getSingularName()}' => isset(\${$this->getSingularName()}) ? \${$this->getSingularName()} : null, 'forward_parameters' => \$forward_parameters))";
      }
   }

   /**
    * Zwraca partial na podstawie kolumny
    *
    * @param             sfAdminColumn $column           Kolumna
    * @return   string
    */
   public function getPartialFromColumn($column, $default_module = null, $editable = false)
   {
      $tmp = explode('.', $column->getName());

      if (isset($tmp[1]))
      {
         $module = lcfirst(sfInflector::camelize($tmp[0]));
         $partial = $tmp[1];
      }
      else
      {
         $module = is_null($default_module) ? $this->getModuleName() : $default_module;
         $partial = $tmp[0];
      }

      if ($editable)
      {
        return "st_get_partial('" . $module . "/" . $partial . "', array('type' => 'list', '{$this->getSingularName()}' => isset(\${$this->getSingularName()}) ? \${$this->getSingularName()} : null, 'forward_parameters' => \$forward_parameters, 'list_mode' => \$list_mode))";
      }
      else
      {
        return "st_get_partial('" . $module . "/" . $partial . "', array('type' => 'list', '{$this->getSingularName()}' => isset(\${$this->getSingularName()}) ? \${$this->getSingularName()} : null, 'forward_parameters' => \$forward_parameters))";
      }
   }

   protected function getValueFromKey($key, $default = null)
   {
      $ref = & $this->params;
      $parts = explode('.', $key);
      $count = count($parts);
      for ($i = 0; $i < $count; $i++)
      {
         $partKey = $parts[$i];
         if (!isset($ref[$partKey]))
         {
            return $default;
         }

         if ($count == $i + 1)
         {
            if ($key == 'applications' && stMenuModifier::hasHeadApplications($this->getModuleName()))
            {
               return stMenuModifier::getHeadApplications($this->getModuleName(), $ref[$partKey]);
            }
            return $ref[$partKey];
         }
         else
         {
            $ref = & $ref[$partKey];
         }
      }

      return $default;
   }

}