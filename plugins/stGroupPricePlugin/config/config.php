<?php
/** 
 * SOTESHOP/stGroupPricePlugin
 * 
 * 
 * @package     stGroupPricePlugin
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/**
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('stGroupPriceBackend', 'backend');

/**
 * Routingi
 */
if (SF_APP == 'backend')
{
stPluginHelper::addRouting('stGroupPricePlugin', '/groupPrice/:action/*', 'stGroupPriceBackend', 'list', 'backend');

stConfiguration::addModule('stGroupPricePlugin', 'group_2');

$dispatcher->connect('stAdminGenerator.generateStProduct', array('stGroupPricePluginListener', 'generateStProduct'));

stSocketView::addComponent('stGroupPriceBackend.configCustom.Content','stGroupPriceBackend','configContent');

stLicenseTypeHelper::addCommercialModule('stGroupPricePlugin');
}