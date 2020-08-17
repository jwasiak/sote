<?php
stPluginHelper::addEnableModule('sfAsset', 'backend');
stPluginHelper::addRouting('sfAsset', '/sfAsset/:action/*', 'sfAsset', 'list', 'backend');
stPluginHelper::addRouting('stAssetImageConfiguration', '/image-configuration/:action/*', 'stAssetImageConfiguration', 'watermark', 'backend');
stPluginHelper::addRouting('stAssetImageConfigurationDefault', '/image-configuration/watermark', 'stAssetImageConfiguration', 'watermark', 'backend');
stPluginHelper::addEnableModule('stAssetImageConfiguration', 'backend');
stConfiguration::addModule(array('label' => 'Konfiguracja zdjęć', 'route' => '@stAssetImageConfigurationDefault', 'icon' => 'stAssetImageConfiguration'), 'Konfiguracja modułów');