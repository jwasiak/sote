<?php
if (version_compare($version_old, '7.0.4.0', '<')) {
	try {
		$config = stConfig::getInstance('stGoogleShoppingBackend');
        $pcConfig = stConfig::getInstance('stPriceCompare');
        $config->set('stock', (bool)$pcConfig->get('stock'));
        $config->save(true);
	} catch (Exception $e) {
		// do nothing
	}
}


if (version_compare($version_old, '7.0.6.2', '<')) {
	try {
		$config = stConfig::getInstance('stGoogleShoppingBackend');
        $config->save(true);
	} catch (Exception $e) {
		// do nothing
	}
}

