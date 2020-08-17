<?php

class sfSuperCacheListener
{
    public static function productConfigClearCache() 
    {
        if (sfContext::getInstance()->getRequest()->getMethod() == sfRequest::POST)
        {
            stFastCacheManager::clearCache();
        }
    }

	public static function clearCache()
	{
		stFastCacheManager::clearCache();
	}	
}