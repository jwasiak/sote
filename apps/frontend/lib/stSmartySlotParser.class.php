<?php

class stSmartySlotParser
{

   protected $source = null;

   public function __construct($source = null)
   {
      $this->source = $source;
   }

   public function parse($callback)
   {
      if ($this->source && preg_match_all('/\{slot\s*(.+?)\}(.*?)\{\/slot\}/si', $this->source, $slots))
      {
         foreach ($slots[0] as $i => $replace)
         {
            $slot_attr = $this->parseAttributes($slots[1][$i]);

            if (!isset($slot_attr['name']))
            {
               throw new sfException('Smarty slot: parameter "name" is mandatory');
            }

            $components_attr = $this->parseComponents($slots[2][$i]);

            call_user_func($callback, $slot_attr, $components_attr, $replace);
         }
      }
   }

   public function setSource($source)
   {
      $this->source = $source;
   }

   public function getSource()
   {
      return $this->source;
   }



   protected function parseComponents($source)
   {
      $components_attr = array();

      if (preg_match_all('/\{(partial|component)\s*(.+?)\}/', $source, $content))
      {

         foreach ($content[1] as $j => $type)
         {
            $attr = $this->parseAttributes($content[2][$j]);

            if (!isset($attr['parameters']))
            {
               $attr['parameters'] = array();
            }
            else
            {
               $attr['parameters'] = self::parseParameters($attr['parameters']);
            } 

            // if (isset($attr['name']) && $attr['name'] == 'stBoxFrontend/boxGroup' && isset($attr['parameters']['box_group']))
            // {

            //    $components_attr = array_merge($components_attr, self::compileBoxComponents($attr['parameters']['box_group']));
            // }
            // else
            // {
               $components_attr[] = self::compileComponent($type, $attr);
            // }
         }
      }

      if (preg_match_all('/\{(content_block)\s*(.+?)\}(.*?){\/content_block}/s', $source, $content))
      {
         foreach ($content[1] as $j => $type)
         {
            $attr = $this->parseAttributes($content[2][$j]);

            if (!isset($attr['name']))
            {
               throw new sfException('Smarty slot '.$type.': parameter "name" is mandatory');
            }   

            $attr['content_type'] = $attr['type'];

            $attr['type'] = $type;

            $attr['is_active'] = true;

            if (!isset($attr['decorator']))
            {
               $attr['decorator'] = false;
            }

            $attr['content'] = trim($content[3][$j]);

            $components_attr[] = $attr;
         }
      }      
      
      return $components_attr;
   }

   protected function parseAttributes($content)
   {
      $attr = array();

      if (preg_match_all('/\s*([^=]+)="([^"]+)"\s*/', $content, $tmp))
      {
         foreach ($tmp[1] as $i => $name)
         {
            $attr[trim($name)] = trim($tmp[2][$i]);
         }
      }

      return $attr;
   }

   protected static function parseParameters($content)
   {
      $params = array();

      if (preg_match_all('/\s*([^:]+):\s+([^,]+),?\s*/', $content, $tmp))
      {
         foreach ($tmp[1] as $i => $name)
         {
            $params[trim($name)] = trim($tmp[2][$i]);
         }
      }

      return $params;
   }

   public static function compileComponent($type, $attr)
   {
      if (!isset($attr['name']))
      {
         throw new sfException('Smarty slot '.$type.': parameter "name" is mandatory');
      }            

      $attr['type'] = $type;

      if ($type == 'component')
      {
         list($attr['module'], $attr['component']) = explode('/', $attr['name']);
      }

      $attr['is_active'] = true;

      return $attr;
   }
}
