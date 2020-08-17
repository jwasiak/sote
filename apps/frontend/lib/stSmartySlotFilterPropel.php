<?php

class stSmartySlotFilterPropel extends stSmartySlotFilter
{
   protected $theme = null;
   
   public static function filter(Theme $theme, $source)
   {
      $parser = new stSmartySlotParser($source);

      $compiler = new stSmartySlotFilterPropel($parser, $theme);

      return $compiler->execute();
   }
   
   public function __construct(stSmartySlotParser $parser, Theme $theme)
   {
      parent::__construct($parser);
      
      $this->theme = $theme;
   }

   public function callback($slot, $components, $replace)
   {
      $components = $this->fetchComponents($slot, $components);

      $components = self::compileBoxComponents($components);  

      parent::callback($slot, $components, $replace);
   }

   public function fetchComponents($slot, $defaults = array())
   {
      $components = !isset($slot['hidden']) ? SmartySlotContentPeer::doSelectArrayBy($slot['name'], $this->theme, $defaults) : array();

      return $components;      
   }

   protected function componentsPrepend($slot)
   {
      $components = parent::componentsPrepend($slot);

      if ($components)
      {
         $components = $this->removeDuplicates($components);
      }

      return $components; 
   }

   protected function componentsAppend($slot)
   {
      $components = parent::componentsAppend($slot);

      if ($components)
      {
         $components = $this->removeDuplicates($components);
      }

      return $components;
   }

   protected function removeDuplicates($components)
   {
      $checksums = SmartySlotContentPeer::doSelectChecksumByTheme($this->theme);

      foreach($components as $key => $component)
      {
         $checksum = SmartySlotContent::generateContentChecksum($component);

         if (isset($checksums[$checksum]))
         {
            unset($components[$key]);
         }
      } 

      return $components;     
   }

   protected function compileBoxComponents($components) 
   {
      $checksums = SmartySlotContentPeer::doSelectChecksumByTheme($this->theme);

      $box_ids = array();

      $c = new Criteria();

      $c->addSelectColumn(BoxPeer::ID);
      
      $c->addJoin(BoxGroupPeer::ID, BoxPeer::BOX_GROUP_ID);
      
      $c->add(BoxPeer::ACTIVE, 1);       

      foreach ($components as $index => $component)
      {
         if ($component['name'] == 'stBoxFrontend/boxSingle')
         {
            $box_ids[$index] = isset($component['parameters']['id']) ? $component['parameters']['id'] : $component['parameters']['webmaster_id']; 
         }

         if ($component['name'] == 'stBoxFrontend/boxGroup')
         {  
            $c->add(BoxGroupPeer::BOX_GROUP, $component['parameters']['box_group']);

            $rs = BoxPeer::doSelectRs($c);

            $results = array();

            while($rs->next())
            {
               $row = $rs->getRow();

               $component = stSmartySlotParser::compileComponent('component', array(
                  'name' => 'stBoxFrontend/boxSingle',
                  'parameters' => array('id' => $row[0]),                   
               ));

               $checksum = SmartySlotContent::generateContentChecksum($component);

               $box_cheksums[$checksum] = true;

               if (!isset($checksums[$checksum]))
               {
                  $results[] = $component;
               } 
            }            
            
            if ($results)
            {
               array_splice($components, $index, 0, $results);
            }
         }
      }

      $ids = self::activeBoxIds();

      foreach ($box_ids as $index => $id)
      {
         if (!isset($ids[$id]))
         {
            unset($components[$index]);
         }
      }
      
      return $components;
   }  

   protected static function activeBoxIds()
   {
      static $ids = null;

      if (null === $ids)
      {
         $c = new Criteria();

         $c->addSelectColumn(BoxPeer::ID);

         $c->addSelectColumn(BoxPeer::WEBMASTER_ID);

         $c->add(BoxPeer::ACTIVE, 1);

         // $c->add(BoxPeer::BOX_GROUP_ID, 0, Criteria::NOT_EQUAL); 

         $rs = BoxPeer::doSelectRs($c);

         $results = array();

         while($rs->next())
         {
            list($id, $webmaster_id) = $rs->getRow();

            if ($webmaster_id) {
                $results[$webmaster_id] = $webmaster_id;        
            }

            $results[$id] = $id;
         }

         $ids = $results;
      }

      return $ids;
   } 

}