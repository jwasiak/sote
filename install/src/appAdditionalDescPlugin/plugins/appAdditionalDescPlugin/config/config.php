<?php
/*
 * @author  Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

if (SF_APP == 'frontend')
{
stPluginHelper::addEnableModule('appAdditionalDescFrontend', 'frontend');
$dispatcher->connect('smarty.slot.append', array('appAdditionalDescPluginListener', 'append'));
}

if (SF_APP == 'backend')
{
stPluginHelper::addEnableModule('appAdditionalDescBackend', 'backend');
stPluginHelper::addRouting('appAdditionalDescPlugin', '/additional_desc/*', 'appAdditionalDescBackend', 'index', 'backend');
$dispatcher->connect('stAdminGenerator.generateStProduct', array('appAdditionalDescPluginListener', 'generate'));
stConfiguration::addModule('appAdditionalDescPlugin', 'group_2'); 
}