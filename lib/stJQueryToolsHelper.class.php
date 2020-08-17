<?php
class stJQueryToolsHelper
{
   public static function parseTokensFromRequest($request, $returnOnlyIds = false)
   {
      $tokens = array();

      if ($request)
      {
         $tokens = json_decode($request, true);

         if ($tokens && $returnOnlyIds)
         {
            $tokens = array_map(function($value) {
               return $value['id'];
            }, $tokens);
         }
      }
      
      return $tokens;
   }

   public static function parsePluploadFromRequest($request)
   {
      return array(
         'delete' => $request['delete'] ? explode(',', $request['delete']) : array(),
         'modified' => $request['modified'] ? explode(',', $request['modified']) : array(),
         'dir' => sfConfig::get('sf_web_dir').'/uploads/plupload/'.$request['namespace'],
      );
   }

   public static function pluploadCopy($source, $dest, $move = false)
   {
      $dir = dirname($dest);
      
      if (!is_dir($dir))
      {
         $ret = mkdir($dir, 0755, true);
      }
      else
      {
         $ret = true;
      }

      if ($ret)
      {
         $ret = $move ? rename($source, $dest) : copy($source, $dest);
      }
      
      if ($ret && is_file($source.'.json'))
      {
         $ret = $move ? rename($source.'.json', $dest.'.json') : copy($source.'.json', $dest.'.json');
      }

      return $ret;
   }

   public static function pluploadCleanup($plupload)
   {
      if ($plupload['delete'] || $plupload['modified'])
      {
         foreach (glob($plupload['dir'].'/*') as $file)  
         {
            if (is_file($file))
            {
               unlink($file);
            }
         }
      }

      if (is_dir($plupload['dir']))
      {
         rmdir($plupload['dir']);
      }
   }

   public static function getJsTreeHtmlRow($id, $name, $params = array())
   {
      if (!isset($params['content']))
      {
         $params['content'] = '';
      }

      if (!isset($params['children']))
      {
         if (!isset($params['status']))
         {
            $params['status'] = 'leaf';
         }

         return '<li class="jstree-'.$params['status'].'" id="jstree-'.$id.'">'.$params['content'].'<a href="#">'.$name.'</a></li>';
      }
      else
      {
         if (!isset($params['status']))
         {
            $params['status'] = 'closed';
         }

         return '<li class="jstree-'.$params['status'].'" id="jstree-'.$id.'">'.$params['content'].'<a href="#">'.$name.'</a><ul>'.$params['children'].'</ul></li>';         
      }
   }

   public static function getJsTreeHtmlDefaultControl($name, $id, $checked, $disabled = false)
   {
      if ($disabled) 
      {
      	$disabled = ' disabled="disabled"';
      }
      else
      {
      	$disabled = '';
      }

      if ($checked)
      {
         return '<input name="'.$name.'_default" type="radio" value="'.$id.'"'.$disabled.' checked="checked" style="vertical-align: middle" />';
      }
      else
      {
         return '<input name="'.$name.'_default" type="radio" value="'.$id.'"'.$disabled.' style="vertical-align: middle" />';
      }     
   }

   public static function getJsTreeHtmlAssignedControl($name, $id, $checked, $disabled = false)
   {
      if ($disabled) 
      {
      	$disabled = ' disabled="disabled"';
      }
      else
      {
      	$disabled = '';
      }

      if ($checked) 
      {
         return '<input class="assigned" name="'.$name.'['.$id.']" type="checkbox" value="'.$id.'"'.$disabled.' checked="checked" /> ';
      }
      else
      {
         return '<input class="assigned" name="'.$name.'" type="checkbox" value="'.$id.'"'.$disabled.' /> ';
      }      
   }
}