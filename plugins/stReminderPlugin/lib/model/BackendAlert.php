<?php

/**
 * Subclass for representing a row from the 'st_backend_alert' table.
 *
 *
 *
 * @package plugins.stReminderPlugin.lib.model
 */
class BackendAlert extends BaseBackendAlert
{
	/**
	 * Przeciążenie hydrate
	 *
	 * @param ResultSet $rs
	 * @param int $startcol
	 * @return object
	 */
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		$this->setCulture(stLanguage::getHydrateCulture());
		return parent::hydrate($rs, $startcol);
	}
	 
	/**
	 * Przeciążenie getName
	 *
	 * @return string
	 */
	public function getName()
	{
		if ($this->getCulture() == 'pl_PL')
		{
			return stLanguage::getDefaultValue($this, __METHOD__);
		}

		$v = parent::getName();

		if (is_null($v))
		{
			$v = stLanguage::getDefaultValue($this, __METHOD__);
		}

		return $v;
	}

	/**
	 * Przeciążenie setName
	 *
	 * @param string $v Nazwa producenta
	 */
	public function setName($v)
	{
		if ($this->getCulture() == 'pl_PL')
		{
			stLanguage::setDefaultValue($this, __METHOD__, $v);
		}

		parent::setName($v);
	}
	
   /**
    * Przeciążenie getDescription
    *
    * @return string
    */
   public function getDescription()
   {
      if ($this->getCulture() == 'pl_PL')
      {
         return stLanguage::getDefaultValue($this, __METHOD__);
      }

      $v = parent::getDescription();

      if (is_null($v))
      {
         $v = stLanguage::getDefaultValue($this, __METHOD__);
      }

      return $v;
   }

   /**
    * Przeciążenie setDescription
    *
    * @param string $v
    */
   public function setDescription($v)
   {
      if ($this->getCulture() == 'pl_PL')
      {
         stLanguage::setDefaultValue($this, __METHOD__, $v);
      }

      parent::setDescription($v);
   }	
}
