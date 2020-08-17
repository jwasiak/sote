<?php
if (SF_APP == 'backend') {
$dispatcher = stEventDispatcher::getInstance();
$dispatcher->connect('autostProductActions.preExecuteConfig', array('sfSuperCacheListener', 'productConfigClearCache'));
$dispatcher->connect('autostProductActions.preExecutePresentationConfig', array('sfSuperCacheListener', 'productConfigClearCache'));
$dispatcher->connect('autostWebpageBackendActions.postExecuteWebpageGroupRemoveGroup', array('sfSuperCacheListener', 'productConfigClearCache'));
$dispatcher->connect('autostWebpageBackendActions.postExecuteWebpageGroupAddGroup', array('sfSuperCacheListener', 'productConfigClearCache'));
}
//mixery do usuwania cachu podczas zapisywnia
sfMixer::register('BaseProduct:save:post', array('sfSuperCacheListener', 'clearCache'));
sfMixer::register('BaseCategory:save:post', array('sfSuperCacheListener', 'clearCache'));
sfMixer::register('BaseProducer:save:post', array('sfSuperCacheListener', 'clearCache'));
sfMixer::register('BaseTheme:save:post', array('sfSuperCacheListener', 'clearCache'));
sfMixer::register('BaseThemeLayout:save:post', array('sfSuperCacheListener', 'clearCache'));
sfMixer::register('BaseBox:save:post', array('sfSuperCacheListener', 'clearCache'));
sfMixer::register('BaseLanguage:save:post', array('sfSuperCacheListener', 'clearCache'));
sfMixer::register('BaseWebpage:save:post', array('sfSuperCacheListener', 'clearCache'));
sfMixer::register('BaseWebpageGroup:save:post', array('sfSuperCacheListener', 'clearCache'));
sfMixer::register('BaseWebpageGroupHasWebpage:save:post', array('sfSuperCacheListener', 'clearCache'));

//mixery do usuwania cachu podczas usuwania
sfMixer::register('BaseProduct:delete:post', array('sfSuperCacheListener', 'clearCache'));
sfMixer::register('BaseCategory:delete:post', array('sfSuperCacheListener', 'clearCache'));
sfMixer::register('BaseProducer:delete:post', array('sfSuperCacheListener', 'clearCache'));
sfMixer::register('BaseTheme:delete:post', array('sfSuperCacheListener', 'clearCache'));
sfMixer::register('BaseThemeLayout:delete:post', array('sfSuperCacheListener', 'clearCache'));
sfMixer::register('BaseBox:delete:post', array('sfSuperCacheListener', 'clearCache'));
sfMixer::register('BaseLanguage:delete:post', array('sfSuperCacheListener', 'clearCache'));
sfMixer::register('BaseWebpage:delete:post', array('sfSuperCacheListener', 'clearCache'));
sfMixer::register('BaseWebpageGroup:delete:post', array('sfSuperCacheListener', 'clearCache'));
sfMixer::register('BaseWebpageGroupHasWebpage:delete:post', array('sfSuperCacheListener', 'clearCache'));
