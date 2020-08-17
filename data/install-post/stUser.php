<?php
try {
    if (stSoteshopVersion::getVersion() == stSoteshopVersion::ST_SOTESHOP_VERSION_INTERNATIONAL) {
        $config = stConfig::getInstance('stUser');
        $config->set('show_region', true);
        $config->set('show_address_more', true);
        $config->save(true);
    }
} catch(Exception $e) {
    // @todo: log this
}