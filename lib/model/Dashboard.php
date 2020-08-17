<?php

/**
 * Subclass for representing a row from the 'st_dashboard' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Dashboard extends BaseDashboard
{
   protected static $lastModified = null;

	protected $gadgets = array();

   public function getLayout() 
   {
      if (null === $this->layout)
      {
			$layout = $this->getDefaultLayout();
			
			$this->setLayout($layout);
      }
      
      return $this->layout;
   }
	
	public function getDefaultLayout()
	{
      $config = sfConfig::get('app_dashboard_default');

		return $config['layout'];
	}

   public function getLayoutColumns()
   {
      $layouts = sfConfig::get('app_dashboard_layouts');

      return isset($layouts[$this->getLayout()]) ? $layouts[$this->getLayout()]['columns'] : null;
   }
   
   public function getGadgetsByColumn($column)
   {
		if (!isset($this->gadgets[$column]))
		{
			$c = new Criteria();

			$c->add(DashboardGadgetPeer::DASHBOARD_COLUMN_NO, $column);

			$c->addAscendingOrderByColumn(DashboardGadgetPeer::POSITION);

         $gadgets = $this->getDashboardGadgets($c);

         foreach ($gadgets as $gadget)
         {
            $gadget->setDashboard($this);
         }

			$this->gadgets[$column] = $gadgets;
		}

		return $this->gadgets[$column];
   }
   
	public function hasGadgetsByColumn($column)
	{
		return (bool)$this->getGadgetsByColumn($column);
	}

	public function delete($con = null)
	{
		$user_id = $this->sf_guard_user_id;

		$ret = parent::delete($con);

		$c = new Criteria();

		$c->addDescendingOrderByColumn(DashboardPeer::ID);

		$c->add(DashboardPeer::SF_GUARD_USER_ID, $user_id);

		$dashboard = DashboardPeer::doSelectOne($c);

      if (null !== $dashboard)
      {
         $dashboard->setIsDefault(true);

         $dashboard->save();
      }
      
		return $ret;
	}
   
	public function save($con = null)
	{
      if (!$this->isNew() && $this->isColumnModified(DashboardPeer::LAYOUT)) 
      {
         $layouts = sfConfig::get('app_dashboard_layouts');
         
         DashboardGadgetPeer::doColumnsUpdate($this->id, $layouts[$this->layout]['columns']);
      }
		
		if (null === $this->layout && $this->isNew())
		{
			$layout = $this->getDefaultLayout();
			
			$this->setLayout($layout);
		}
      
		if ($this->isColumnModified(DashboardPeer::IS_DEFAULT) && $this->is_default)
		{
			$con = Propel::getConnection();

			$select = new Criteria();

			$update = new Criteria();

			$select->add(DashboardPeer::IS_DEFAULT, true);

			$update->add(DashboardPeer::IS_DEFAULT, false);

			BasePeer::doUpdate($select, $update, $con);
		}

		return parent::save($con);
	}

   public function getUpdatedAt()
   {
      return max(parent::getUpdatedAt(), self::getLastModified());
   }

   public static function getLastModified()
   {
      if (null === self::$lastModified)
      {
         $history = sfConfig::get('sf_root_dir').'/install/db/.history.reg';

         self::$lastModified = is_file($history) ? filemtime($history) : 0; 
      }

      return self::$lastModified;
   }
}
