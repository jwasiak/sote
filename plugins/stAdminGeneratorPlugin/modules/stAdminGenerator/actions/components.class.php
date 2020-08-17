<?php

class stAdminGeneratorComponents extends sfComponents
{
   public function executeMenu()
   {
        $this->items = $this->processMenuItems();

        $this->selected = $this->getUser()->getAttribute('selected', false, 'soteshop/component/menu');
   }

   protected function processMenuItems()
   {
      $internal_uri = sfRouting::getInstance()->getCurrentInternalUri();
      
      $controller = $this->getController();
      
      $current = $controller->genUrl($internal_uri);
      
      $items = array();
      
      foreach ($this->items as $route => $name)
      {
         $route = $controller->genUrl($route);
         
         if ($current == $route)
         {
            $this->getUser()->setAttribute('selected', $current, 'soteshop/component/menu');
         }
         
         $items[$route] = $name;
      }
      
      return $items;
   }

}
