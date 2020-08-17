<?php
if (SF_APP == 'frontend')
{
    stPluginHelper::addEnableModule('appImageTagFrontend', 'frontend');
    $dispatcher->connect('smarty.slot.prepend', array('appImageTagListener', 'prepend'));
}
elseif (SF_APP == 'backend')
{
    stPluginHelper::addRouting('appImageTagBackend', '/app-image-tags/:action/*', 'appImageTagBackend', 'showCategoryImageTags', 'backend');
    stPluginHelper::addEnableModule('appImageTagBackend', 'backend');
    $dispatcher->connect('stAdminGenerator.generateStCategory', array('appImageTagListener', 'generateStCategory'));
    $dispatcher->connect('autoStCategoryActions.postSave', array('appImageTagListener', 'postSaveCategory'));
}