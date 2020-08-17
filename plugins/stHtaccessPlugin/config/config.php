<?php

if (SF_APP == 'backend') {
    stPluginHelper::addEnableModule('stHtaccessBackend', 'backend');
    stPluginHelper::addRouting('stHtaccessPlugin', '/htaccess', 'stHtaccessBackend', 'index', 'backend');
    stConfiguration::addModule('stHtaccessPlugin', 'group_1', 1);
}
