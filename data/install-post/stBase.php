<?php
try {
    $limitsFile = sfConfig::get('sf_config_dir').'/limits.yml';
    $licenseFile = sfConfig::get('sf_root_dir').'/install/db/.license.reg';
    if (file_exists($limitsFile) && file_exists($licenseFile)) {

        $stLicense = new stLicense(file_get_contents($licenseFile));
        $limits = sfYaml::load($limitsFile);

        if($stLicense->getType() == stLicense::LICENSE_TYPE_OPEN)
            $limit = '7741544d';
        else
            $limit = '3d41444d7741544d';

        $newLimit = base64_encode(json_encode(array('limit' => stLimits::realLimit($limit), 'hash' => stLicenseExt::getShopIdByLicence($stLicense->getLicense()))));

        $hex = '';
        for ($i = 0; $i < mb_strlen($newLimit); $i += 1)
            $hex = dechex(ord(substr($newLimit, $i, 1))).$hex;
        $limits['limits']['Product'] = $hex;

        file_put_contents($limitsFile, Yaml::dump($limits));
    }
} catch(Exception $e) {}
