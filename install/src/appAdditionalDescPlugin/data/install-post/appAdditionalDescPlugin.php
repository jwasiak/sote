<?php
try {
	$config = stConfig::getInstance(sfContext::getInstance(), 'appAdditionalDescBackend');
    $config->set('desc2_on', true);
    $config->save(true);
} catch(Exception $e) {
    // @todo: log this
}