<?php
class stLicenseExt {
    
    public static function getShopId() {
        $license = stConfig::getInstance('stRegister')->get('license');

        if (empty($license)) {
            $file = sfConfig::get('sf_root_dir').'/install/db/.license.reg';
            if (file_exists($file))
                $license = file_get_contents($file);
        }

        return self::getShopIdByLicence($license);
    }

    public static function getShopIdByLicence($license){
        return md5(trim($license));   
    }
}
