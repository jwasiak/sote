<?php
if (version_compare($version_old, '7.1.0.13', '<'))
{
    $config = stConfig::getInstance('stEserviceBackend');

    if ($config->get('client_id') && $config->get('password'))
    {
        $config->set('enabled', true);
        $config->save(true);
    }
}