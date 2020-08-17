<?php 
stPluginHelper::addRouting('stFastCache', '/fastcache/:action/*', 'stFastCache', 'config', 'backend');
stPluginHelper::addRouting('stFastCacheSymfony', '/fastcache/:action/*', 'stFastCache', 'config', 'backend');
