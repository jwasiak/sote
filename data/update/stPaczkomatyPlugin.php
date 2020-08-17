<?php
if (version_compare($version_old, '7.5.0.6', '<')) {
    $config = stConfig::getInstance('stPaczkomatyBackend');
    $config->set('enabled', $config->get('enable'));
    $config->set('sandbox', $config->get('test_mode'));
    $config->save(true); 
    stTheme::clearSmartyCache(true);
}