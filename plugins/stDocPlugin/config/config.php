<?php

if (SF_APP == 'backend')
{
    stPluginHelper::addEnableModule('stDocBackend', 'backend');
    stPluginHelper::addRouting('stDocBackend', '/doc/:action', 'stDocBackend', 'index', 'backend');
}