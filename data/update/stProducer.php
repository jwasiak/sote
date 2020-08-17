<?php
if (version_compare($version_old, '1.0.4.11', '<'))
{
    $dispatcher = stEventDispatcher::getInstance();

    $dispatcher->connect('stInstallerTaks.onClose', array('stProducerListener', 'postInstall'));
}
