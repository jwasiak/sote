<?php



stPluginHelper::addEnableModule('stOpenGraphFrontend', 'frontend');
stPluginHelper::addRouting('stOpenGraphPlugin', '/open_graph/*', 'stOpenGraphFrontend', 'show', 'frontend');



if (SF_APP == 'backend')
{
    stPluginHelper::addEnableModule('stOpenGraphBackend', 'backend');
    stPluginHelper::addRouting('stOpenGraphPlugin', '/open_graph/:action', 'stOpenGraphBackend', 'openGraphConfig', 'backend');
    stConfiguration::addModule('stOpenGraphPlugin', 'group_2');
}

$dispatcher->connect('smarty.slot.append', array('stOpenGraphListener', 'append'));