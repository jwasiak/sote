<?php
if (SF_APP == 'frontend')
{
   $dispatcher->connect('stActions.preExecute', array('stThemeListener', 'validate'));
   stPluginHelper::addEnableModule('stThemeFrontend', 'frontend');
   stPluginHelper::addEnableModule('sfGuardAuth', 'frontend');   
}
elseif (SF_APP == 'backend')
{
   stPluginHelper::addEnableModule('stThemeBackend', 'backend');
   stPluginHelper::addRouting('stThemePlugin', '/theme/:action/*', 'stThemeBackend', 'index', 'backend');
   $dispatcher->connect('stActions.postExecute', array('stThemeListener', 'postExecute'));
}