<?php

class appImageTagBackendComponents extends sfComponents 
{
	public function executeShowCategoryImageTags()
	{
        $this->tag = appCategoryImageTagPeer::retrieveByPK($this->category->getId());
	}
}