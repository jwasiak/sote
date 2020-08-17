<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @author     Marek Jakubowicz <marek.jakubowicz@sote.pl> modifications
 * @version    SVN: $Id: sfSuperCacheFilter.class.php 9662 2010-12-01 09:46:34Z piotr $
 */
class sfSuperCacheFilter extends sfFilter
{
	public function execute ($filterChain)
	{		
		$filterChain->execute(); 
		
		$request = $this->getContext()->getRequest();
		
		if ($request->getCookie('fastcache') == 'disabled' || $request->getCookie('basket') || !stConfig::getInstance('stFastCache')->get('fast_cache_enabled') || $this->getContext()->getRequest()->hasParameter('query'))
		{
			return;
		}

		// only if cache is set for the entire page
		$cacheManager = $this->getContext()->getViewCacheManager();

		if (!is_object($cacheManager)  || $this->getContext()->getResponse()->getStatusCode() != 200)   return;
		
		$uri = sfRouting::getInstance()->getCurrentInternalUri();
		$cache_vary = $cacheManager->getVary($uri);
		
		if (!isset($cache_vary['fastcache']) || $cache_vary['fastcache']==0) return;
		//check if there is any content
		$content = $this->getContext()->getResponse()->getContent();
		
		if ($content && strpos($content, ' src="/stThumbnailPlugin.php?') === false)
		{
			if (sfConfig::get('sf_debug') && sfConfig::get('sf_logging_enabled'))
			{
				$timer = sfTimerManager::getTimer(sprintf('Fast Cache write'));
			}

			$path = stFastCacheManager::getUrlPath();

			stFastCacheManager::getInstance()->set($path, $content);

			if (sfConfig::get('sf_debug'))
			{
				$timer->addTime();
			}
		}
	}
}
