<?php

if (SF_APP == 'backend')
{
   stConfiguration::addModule(array('label' => 'Atrybuty produktów', 'route' => '@appProductAttributesPlugin', 'icon' => 'appProductAttributesPlugin'), 'Konfiguracja modułów');
   $dispatcher->connect('stAdminGenerator.generateStProduct', array('appProductAttributeListener', 'generateStProduct'));
   $dispatcher->connect('stProductActions.postExecuteDuplicate', array('appProductAttributeListener', 'postExecuteDuplicate'));
   stPluginHelper::addEnableModule('appProductAttributeBackend', 'backend');
   stPluginHelper::addRouting('appProductAttributesPlugin', '/product-attributes/:action/*', 'appProductAttributeBackend', 'list', 'backend');
   stLicenseTypeHelper::addCommercialModule('appProductAttributeBackend');
}
elseif (SF_APP == 'frontend')
{
   stPluginHelper::addEnableModule('appProductAttributeFrontend', 'frontend');   
   stPluginHelper::addRouting('appProductAttributesPlugin', '/product-attributes/:action', 'appProductAttributeFrontend', 'filter', 'frontend');
   // $dispatcher->connect('stProductActions.preProductPagerInit', array('appProductAttributeListener', 'preProductPagerInit'));
   $dispatcher->connect('stProductActions.postExecuteFilter', array('appProductAttributeListener', 'postExecuteFilter'));
   $dispatcher->connect('stProductActions.postExecuteClearFilter', array('appProductAttributeListener', 'postExecuteClearFilter'));
}