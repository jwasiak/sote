<?php

/**
 * Subclass for representing a row from the 'st_dashboard_gadget_configuration' table.
 *
 * 
 *
 * @package lib.model
 */ 
class DashboardGadgetConfiguration extends BaseDashboardGadgetConfiguration
{
	public function setParameter($name, $value)
	{
		$configuration = $this->getConfiguration();
		
		$configuration[$name] = $value;
		
		$this->setConfiguration($configuration);
	}
	
	public function getParameter($name, $default = null)
	{
		$configuration = $this->getConfiguration();		
		
		return isset($configuration[$name]) ? $configuration[$name] : $default;
	}
	
	public function removeParameter($name)
	{
		$configuration = $this->getConfiguration();
		
		if (isset($configuration[$name]))
		{
			unset($configuration[$name]);
			
			$this->setConfiguration($configuration);
		}
	}
	
	public function hasParameter($name)
	{
		$configuration = $this->getConfiguration();		
		
		return isset($configuration[$name]);
	}

	public function getConfiguration()
	{
		return parent::getConfiguration() ? parent::getConfiguration() : array();
	}
	
	public function save($con = null)
	{
		if ($this->isModified() && null !== $this->aDashboardGadget)
		{
			$this->aDashboardGadget->refresh();
		}
		
		return parent::save($con);
	}
}
