<?php
try {
    $config = stConfig::getInstance('stBasket');
    $config->set('ajax', true);
    $config->save(true);
} catch(Exception $e) {
    // @todo: log this
}