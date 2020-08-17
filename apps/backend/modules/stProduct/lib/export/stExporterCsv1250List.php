<?php

class stExporterCsv1250List extends stExporterCsv1250
{
    public function getDataCount()
    {
    	$this->criteria->clearGroupByColumns();

        return call_user_func($this->model.'Peer::doCountWithI18n', $this->criteria, true);
    }

    protected function getData($offset = 0)
    {
    	if (!$this->criteria->getGroupByColumns())
    	{
    		$this->criteria->addGroupByColumn(ProductPeer::ID);
    	}

    	return parent::getData($offset);
    }

    protected function doSelect(Criteria $c)
    {
        return call_user_func($this->model.'Peer::doSelectWithI18n',$c);
    }

	protected function getCriteria(Criteria $criteria = null)
	{
		$criteria = sfContext::getInstance()->getUser()->getAttribute('criteria', null, 'soteshop/stProduct/export');
		/**
		 * Load Map Builders fix
		 */
		foreach (sfContext::getInstance()->getUser()->getAttribute('map_builders', array(), 'soteshop/stProduct/export') as $class)
		{
			BasePeer::getMapBuilder($class);
		}

		return parent::getCriteria($criteria); 
	}
}