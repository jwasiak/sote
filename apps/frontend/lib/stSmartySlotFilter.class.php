<?php
class stSmartySlotFilter
{
   protected $parser = null;
   
   protected $data = null;
      
   public function __construct(stSmartySlotParser $parser)
   {
      $this->parser = $parser;
   }

   public function execute()
   {
      $this->data = $this->parser->getSource();
      
      $this->parser->parse(array($this, 'callback'));

      return $this->data;
   }

   public function callback($slot, $components, $replace)
   {          
      $prepend = $this->componentsPrepend($slot);

      if ($prepend) 
      {
         $components = array_merge($prepend, $components);
      }

      $append = $this->componentsAppend($slot);

      if ($append)
      {
         $components = array_merge($components, $append);
      }
      
      $this->replace($replace, $components, $slot);
   }

   protected function componentsPrepend($slot)
   {
      return stEventDispatcher::getInstance()->filter(new sfEvent($this, 'smarty.slot.prepend', array('slot' => $slot['name'])), array())->getReturnValue();
   }

   protected function componentsAppend($slot)
   {
      return stEventDispatcher::getInstance()->filter(new sfEvent($this, 'smarty.slot.append', array('slot' => $slot['name'])), array())->getReturnValue();
   }
   
   protected function replace($replace, $components = array(), $slot)
   {
      $slot_name = $slot['name'];

      $slot_orientation = $slot['orientation'];

      if (isset($slot['hidden']))
      {
         $content = array();

         foreach($components as $component)
         {
            if ($slot['orientation'] == 'horizontal')
            {
               $_name = strtr($component['name'], '/', '_');

               $content[] = '<div class="component_'.$_name.'" style="float: left">';
            }

            if ($component['type'] == 'component')
            {
               $content[] = "{php}echo st_get_component('".$component['module']."', '".$component['component']."', ".var_export($component['parameters'], true).");{/php}";
            }
            elseif ($component['type'] == 'partial')
            {
               $content[] = "{php}echo st_get_partial('".$component['name']."', ".var_export($component['parameters'], true).");{/php}";
            } 

            if ($this->_tpl_vars['_slots']['{$slot_name}_orientation'] == 'horizontal')
            {
               $content[] = "</div>";
            }             
         } 

         if ($slot['orientation'] == 'horizontal')
         {
            $content[] = '<div style="clear: left"></div>';
         }  

         $content = implode("\n", $content);       
      }
      else
      {
         $components = var_export($components, true);

         $content =<<<TWIG
         {php}
            \$this->_tpl_vars['_slots']['{$slot_name}_components'] = $components;
            \$this->_tpl_vars['_slots']['{$slot_name}_orientation'] = '$slot_orientation';
         {/php}
         {php}if (SF_ENVIRONMENT == 'theme'):{/php}
            <div class="smarty_slot smarty_orientation_{php}echo \$this->_tpl_vars['_slots']['{$slot_name}_orientation']{/php}" id="$slot_name">
         {php}
            \$json = array();

            foreach(\$this->_tpl_vars['_slots']['{$slot_name}_components'] as \$id => \$component)
            {
               \$_name = strtr(\$component['name'], '/', '_');

               if (!\$component['is_active'])
               {
                  echo '<div class="smarty_component smarty_disabled '.\$component['type'].'_type" component_'.\$_name.' id="$slot_name:'.\$id.'">';
               }
               else
               {
                  echo '<div class="smarty_component '.\$component['type'].'_type component_'.\$_name.'" id="$slot_name:'.\$id.'">';
               }

               if (\$component['name'] != 'stBoxFrontend/boxGroup')
               {
                  if (\$component['type'] == 'component')
                  {
                     echo st_get_component(\$component['module'], \$component['component'], \$component['parameters']);  
                  }
                  elseif (\$component['type'] == 'partial')
                  {
                     echo st_get_partial(\$component['name'], \$component['parameters']);
                  }
                  elseif (\$component['type'] == 'content_block')
                  {
                     echo smarty_content_block(\$component, \$component['content']);                
                  }
               }

               echo '</div>';
            }

            if (\$this->_tpl_vars['_slots']['{$slot_name}_orientation'] == 'horizontal')
            {
               echo '<div style="clear: left"></div>';
            }

            echo "<script type=\"text/javascript\">jQuery(function($) {\n";

            \$theme_name = stTheme::getInstance(sfContext::getInstance())->getThemeName();

            foreach (\$this->_tpl_vars['_slots']['{$slot_name}_components'] as \$id => \$component)
            {
               \$component['content'] = stSmarty::translateBlock(\$component['name'], 'content', \$theme_name, \$component['content']);
               echo "$(\"#$slot_name\\\\\:".\$id."\").data(\"smarty\", \"".addslashes(json_encode(\$component))."\");\n";   
            }

            echo "});</script>\n";
         {/php}
         </div>
         {php}else:{/php}
         {php}
            foreach(\$this->_tpl_vars['_slots']['{$slot_name}_components'] as \$component)
            {
               if (!\$component['is_active'] || \$component['name'] == 'stBoxFrontend/boxGroup') continue;

               if (\$this->_tpl_vars['_slots']['{$slot_name}_orientation'] == 'horizontal')
               {
                  \$_name = strtr(\$component['name'], '/', '_');

                  echo '<div class="component_'.\$_name.'" style="float: left">';
               }

               if (\$component['type'] == 'component')
               {
                  echo st_get_component(\$component['module'], \$component['component'], \$component['parameters']);
               }
               elseif (\$component['type'] == 'partial')
               {
                  echo st_get_partial(\$component['name'], \$component['parameters']);
               }
               elseif (\$component['type'] == 'content_block')
               {
                  echo smarty_content_block(\$component, \$component['content']);                
               }  

               if (\$this->_tpl_vars['_slots']['{$slot_name}_orientation'] == 'horizontal')
               {
                  echo "</div>";
               }             
            } 

            if (\$this->_tpl_vars['_slots']['{$slot_name}_orientation'] == 'horizontal')
            {
               echo '<div style="clear: left"></div>';
            }
         {/php}
         {php}endif{/php}
TWIG;
      }


      $this->data = str_replace($replace, $content, $this->data);

   }
      
   public function createComponent($module, $component, $params = array())
   {
      return $this->filterComponent($module, $component, $params);
   }
   
   public function createPartial($name, $params = array())
   {
      return $this->filterPartial($name, $params);
   }

   public function createContentBlock($name, $type, $content)
   {
      return $this->filterContentBlock($name, $type, $content);
   }   
   
   protected function filterComponent($module, $component, $params = array())
   {
      return array('type' => 'component', 'name' => $module.'/'.$component, 'module' => $module, 'component' => $component, 'is_active' => true, 'parameters' => $params);
   }

   protected function filterPartial($name, $params = array())
   {
      return array('type' => 'partial', 'name' => $name, 'is_active' => true, 'parameters' => $params);
   }

   protected function filterContentBlock($name, $type, $content)
   {
      return array('type' => 'content_block', 'name' => $name, 'content_type' => $type, 'is_active' => true, 'content' => trim($content));
   }   

}