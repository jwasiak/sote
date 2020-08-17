<?php

class appProductAttributeBackendComponents extends autoappProductAttributeBackendComponents
{
   public function executeEditMenu()  
   {
      parent::executeEditMenu();

      $type = $this->app_product_attribute->getType();

      if ($type == 'B')
      {
         end($this->items);

         $key = key($this->items);

         reset($this->items);

         unset($this->items[$key]);
      }
   } 
}