<?php

if (version_compare($version_old, '7.4.0.8', '<'))
{
    $dispatcher = stEventDispatcher::getInstance();
    $dispatcher->connect('stInstallerTaks.onClose', array('stSearchOptimize', 'postInstall'));
}

