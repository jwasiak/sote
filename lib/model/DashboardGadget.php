<?php

/**
 * Subclass for representing a row from the 'st_dashboard_gadget' table.
 *
 * 
 *
 * @package lib.model
 */ 
class DashboardGadget extends BaseDashboardGadget
{
   protected $gadgetConfiguration = null;   
   
   public function isExternal()
   {
      return strpos($this->getSource(), 'http://') === 0;
   }
   
   public function save($con = null)
   {      
      if ($this->isNew())
      {
         DashboardGadgetPeer::moveDownFrom($this->position, $this->dashboard_column_no, $this->dashboard_id);
         
         if (!$this->refresh_by && $this->getConfigurationParameter('refresh'))
         {
            $refresh = $this->getConfigurationParameter('refresh');
            $this->setRefreshBy($refresh !== true ? $refresh : DashboardGadgetPeer::defaultRefreshRate());
         }
      }

      if ($this->isModified())
      {
         DashboardPeer::doRefreshById($this->getDashboardId());
      }
            
      return parent::save($con);     
   }

   public function refresh()
   {
      $this->setRefreshedAt(time());

      $this->save();
   }

   public function getRefreshedAt()
   {
      return max(parent::getRefreshedAt(), $this->getDashboard()->getUpdatedAt());
   }

   public function getColor()
   {
      return $this->color ? $this->color : '#FFFFFF';
   }
   
   public function delete($con = null)
   {
      DashboardGadgetPeer::moveUpFrom($this->position + 1, $this->dashboard_column_no, $this->dashboard_id);

      DashboardPeer::doRefreshById($this->getDashboardId());
      
      parent::delete($con);
   }
   
   public function getSource()
   {
      return $this->getConfigurationParameter('source');
   }
   
   public function getMaxHeight()
   {
      return $this->getConfigurationParameter('max_height');
   }

   public function getMinHeight()
   {
      return $this->getConfigurationParameter('min_height');
   }

   public function checkCredentials($credential)
   {
      $credentials = $this->getConfigurationParameter('credentials');

      $for = stLicense::isOpen() ? 'open' : 'commercial';

      if (!$credentials || !isset($credentials[$credential]))
      {
         return true;
      }

      return in_array($for, (array)$credentials[$credential]);
   }
   
   public function getConfigurationParameter($name, $default = null)
   {
      $gadget_directory = sfConfig::get('app_dashboard_gadget_directory');
      
      return isset($gadget_directory[$this->name][$name]) ? $gadget_directory[$this->name][$name] : $default;
   }

   public function getGadgetConfiguration()
   {
      if (null === $this->gadgetConfiguration)
      {
         $c = new Criteria();
         
         $c->add(DashboardGadgetConfigurationPeer::ID, $this->id);
         
         $gadget_configuration = DashboardGadgetConfigurationPeer::doSelectOne($c);
         
         if (null === $gadget_configuration)
         {
            $gadget_configuration = new DashboardGadgetConfiguration();
         }
         
         $gadget_configuration->setDashboardGadget($this);
                  
         $this->gadgetConfiguration = $gadget_configuration;
      }
      
      return $this->gadgetConfiguration;
   }

}
