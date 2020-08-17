<?php

if (version_compare($version_old, '7.1.0.14', '<'))
{
    $config = stConfig::getInstance('stPlatnosciPlBackend');

    if ($config->get('pos_id') && $config->get('md5_secound_key'))
    {
        $config->set('PLN', array(
            'enabled' => true,
            'pos_id' => $config->get('pos_id'),
            'md5_secound_key' => $config->get('md5_secound_key'),
        ));

        $config->set('configuration_check', true);
    }

    $config->save(true);
}

if (version_compare($version_old, '7.1.0.32', '<'))
{
    $file = sfConfig::get('sf_plugins_dir').'/stPlatnosciPlPlugin/modules/stPlatnosciPlBackend/validate/index.yml';

    if (is_file($file))
    {
        unlink($file);
    }
}

