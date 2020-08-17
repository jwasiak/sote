<?php
try {
    if (version_compare($version_old, '1.1.0.11', '<'))
       if (is_file(sfConfig::get('sf_lib_dir').DIRECTORY_SEPARATOR.'stFunctionCache.class.php'))
            unlink(sfConfig::get('sf_lib_dir').DIRECTORY_SEPARATOR.'stFunctionCache.class.php');

    if (version_compare($version_old, '7.0.0.2', '<')) {
        $limitsFile = sfConfig::get('sf_config_dir').'/limits.yml';
        if (file_exists($limitsFile)) {
            $limits = sfYaml::load($limitsFile);

            if(isset($limits['limits']['Product']) && in_array($limits['limits']['Product'], array('3d41444d7741544d', '3d41444d77416a4d', '3d41444d77497a4d')))
                $limit = $limits['limits']['Product'];
            else
                if(stLicense::isOpen())
                    $limit = '7741544d';
                else
                    $limit = '3d41444d7741544d';

            $newLimit = base64_encode(json_encode(array('limit' => stLimits::realLimit($limit), 'hash' => stLicenseExt::getShopId())));

            $hex = '';
            for ($i = 0; $i < mb_strlen($newLimit); $i += 1)
                $hex = dechex(ord(substr($newLimit, $i, 1))).$hex;
            $limits['limits']['Product'] = $hex;

            file_put_contents($limitsFile, Yaml::dump($limits));
        }
    }
} catch (Exception $e) {}

try {
	if (version_compare($version_old, '7.2.0.0', '<=')) {
		$file = sfConfig::get('sf_web_dir').'/404_image.php';
		if (file_exists($file))
			@unlink($file);
	}
} catch (Exception $e) {
	// @todo: log $e->getMessage();
}
