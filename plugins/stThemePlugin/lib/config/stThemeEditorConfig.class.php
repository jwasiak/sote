<?php

class stThemeEditorConfig extends stThemeConfig
{
   public function getMedia()
   {
      return isset($this->config['editor_config']['media']) ? $this->config['editor_config']['media'] : array('xs' => null);
   }
   
   public function getGraphicCategories()
   {
      return array_keys($this->config['editor_config']['graphic']);
   }
   
   public function getGraphicFields($category)
   {      
      return is_array($category) ? $this->config['editor_config']['graphic'][$category[0]]['display'][$category[1]] : $this->config['editor_config']['graphic'][$category]['display'];
   }
   
   public function hasGraphicFieldType($category, $field, $type)
   {
      return $this->getGraphicFieldParameter($category, $field, 'type') == $type; 
   }
   
   public function getGraphicCategoryLabel($category)
   {
      return $this->config['editor_config']['graphic'][$category]['label'];
   }
   
   public function hasGraphicFieldProperty($category, $field, $property)
   {
       $value = $this->getGraphicFieldParameter($category, $field, 'property');
       
       return is_array($value) ? array_search($property, $value) : $value == $property;
   }
   
   public function isGraphicFieldRelated($category, $field)
   {
      if (isset($this->config['editor_config']['graphic'][$category]['fields'][$field]['default'])) 
      {
         $value = $this->config['editor_config']['graphic'][$category]['fields'][$field]['default'];
         
         return $value && $value{0} == '@';
      }
      
      return false;
   }

   public function getGraphicGenerated($category, $field)
   {
      if (isset($this->config['editor_config']['graphic'][$category]['generated'][$field]))
      {
         return $this->config['editor_config']['graphic'][$category]['generated'][$field];
      }

      return array();
   }
   
   public function getGraphicFieldParameter($category, $field, $parameter, $default = null)
   {
      if (isset($this->config['editor_config']['graphic'][$category]['fields'][$field][$parameter]))
      {
         $value = $this->config['editor_config']['graphic'][$category]['fields'][$field][$parameter];
         
         if ($parameter == 'default' && $value && $value{0} == '@')
         {
            $name = substr($value, 1);
            
            $value = $this->themeConfig->getLess($name);
            
            if (null === $value)
            {
               $value = $this->getGraphicFieldParameter('_less', $name, 'default');
            }
            
            if ($filter = $this->getGraphicFieldParameter($category, $field, 'filter'))
            {
               $value = call_user_func(array('stThemeLess', $filter[0]), $value, $filter[1]);
            }
         }
         
         return is_array($value) ? $value : ltrim($value, '#');
      }
      
      return $default;
   }


}
