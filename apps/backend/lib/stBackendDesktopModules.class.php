<?php

class stBackendDesktopModule
{
   protected
      $route = null,
      $name = null,
      $icon = null,
      $valid = true,
      $label = null;

   public function  __construct($routing, $params)
   {
      static $packages = null;

      if (is_array($params))
      {
         $this->route = $params['route'];

         $this->label = $params['label'];

         
         if (isset($params['icon']) && $params['icon'])
         {
            $tmp = pathinfo($params['icon']);

            $this->icon = !isset($tmp['extension']) || !$tmp['extension'] ? $params['icon'].'.png' : $params['icon'];
         } 
         else
         {
            $this->icon = 'stDefaultApp.png';
         }
         
         if (isset($params['name']))
         {

            $this->name = $params['name'];
         }
      }
      else
      {
         if (null === $packages)
         {
            $packages = stApplication::getApps();
         }

         if ($routing->hasRouteName($params))
         {
            $this->route = '@'.$params;
         }
         else
         {
            $this->route = '@'.$params.'Default';
         }


         $this->icon = $params.'.png';

         if (isset($packages[$params]))
         {
            $this->label = $packages[$params];
         }
         else
         {
            $this->label = $params;

            $this->valid = false;
         }
      }

      try
      {
         if (null === $this->name)
         {
            if ($this->route[0] == '@')
            {
               list($name) = explode('?', $this->route);
               $route = $routing->getRouteByName($name);

               $this->name = $route[4]['module'];
            }
            else
            {
               list($this->name) = explode('/', $this->route);
            }
         }
      }
      catch(sfConfigurationException $e)
      {
         $this->valid = false;
      }
   }

   public function isValid()
   {
      return $this->valid;
   }

   public function getName()
   {
      return $this->name;
   }

   public function getRoute()
   {
      return $this->route;
   }

   public function getLabel()
   {
      return sfI18N::getInstance()->__($this->label, null, $this->name);
   }

   public function getIcon()
   {
      return $this->icon;
   }

   public function getIconPath()
   {
      if ($this->icon[0] == '/')
      {
         $icon_path = $this->icon;
      }
      else
      {
         $icon_path = 'backend/main/icons/'.$this->icon;
      }

      $extension = pathinfo($icon_path, PATHINFO_EXTENSION);

      if (!in_array($extension, array('jpg', 'png', 'gif', 'jpeg')))
      {
         return $icon_path . '.png';
      }

      return $icon_path;
   }
}