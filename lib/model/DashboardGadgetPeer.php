<?php

/**
 * Subclass for performing query and update operations on the 'st_dashboard_gadget' table.
 *
 * 
 *
 * @package lib.model
 */ 
class DashboardGadgetPeer extends BaseDashboardGadgetPeer
{
   protected static $defaultRefreshRate = null;   
   
   public static function moveDownFrom($position, $column_no, $dashboard_id, $by = 1)
   {
      $con = Propel::getConnection();
            
      $sql = sprintf('UPDATE %1$s SET %2$s = %2$s + ? WHERE %2$s >= ? AND %3$s = ? AND %4$s = ?', DashboardGadgetPeer::TABLE_NAME, DashboardGadgetPeer::POSITION, DashboardGadgetPeer::DASHBOARD_COLUMN_NO, DashboardGadgetPeer::DASHBOARD_ID);
      
      $ps = $con->prepareStatement($sql);
      
      $ps->setInt(1, $by);
      
      $ps->setInt(2, $position);
      
      $ps->setInt(3, $column_no);
      
      $ps->setInt(4, $dashboard_id);
      
      $ps->executeQuery();      
   }
  
   public static function moveUpFrom($position, $column_no, $dashboard_id, $by = 1)
   {
      $con = Propel::getConnection();
            
      $sql = sprintf('UPDATE %1$s SET %2$s = %2$s - ? WHERE %2$s >= ? AND %3$s = ? AND %4$s = ?', DashboardGadgetPeer::TABLE_NAME, DashboardGadgetPeer::POSITION, DashboardGadgetPeer::DASHBOARD_COLUMN_NO, DashboardGadgetPeer::DASHBOARD_ID);
      
      $ps = $con->prepareStatement($sql);
      
      $ps->setInt(1, $by);
      
      $ps->setInt(2, $position);
      
      $ps->setInt(3, $column_no);
      
      $ps->setInt(4, $dashboard_id);
      
      $ps->executeQuery();    
   }   
   
   public static function doColumnsUpdate($dashboard_id, $max_columns)
   {
      $c = new Criteria();
      
      $c->add(self::DASHBOARD_ID, $dashboard_id);
      
      $c->add(self::DASHBOARD_COLUMN_NO, $max_columns, Criteria::GREATER_THAN);
      
      $c->addAscendingOrderByColumn(self::POSITION);
      
      $gadgets = self::doSelect($c);
      
      if ($gadgets)
      {
         self::moveDownFrom(1, $max_columns, $dashboard_id, count($gadgets));
         
         $position = 1;
         
         foreach ($gadgets as $gadget)
         {
            $gadget->setPosition($position);
            
            $gadget->setDashboardColumnNo($max_columns);
            
            $gadget->save();
         }
      }
   }
   
   public static function defaultRefreshRate()
   {
      foreach (sfConfig::get('app_dashboard_gadget_refresh_rates') as $rate => $attr)
      {
         if ($attr['default'])
         {
            self::$defaultRefreshRate = $rate;
            
            break;
         }
      }
      
      return self::$defaultRefreshRate;
   }

   public static function doCreate($name, $dashboard_id, $options = array())
   {
      $gadgets = sfConfig::get('app_dashboard_gadget_directory');

      $current = $gadgets[$name];

      $gadget = new DashboardGadget();

      $gadget->setName($name);

      $gadget->setTitle(isset($options['title']) ? $options['title'] :$current['title']);

      $gadget->setDashboardColumnNo(isset($options['column']) ? $options['column'] : 1);
      
      $gadget->setPosition(isset($options['position']) ? $options['position'] : 1);

      $gadget->setDashboardId($dashboard_id);

      return $gadget;      
   }   
}
