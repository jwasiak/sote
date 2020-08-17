<?php 

class stPear {
    
    public static function getDependencies($packages) {
        $response = stPearCurl::get('dependencies.php', array('json' => json_encode(array('packages' => $packages, 'shopId' => stLicenseExt::getShopId()))));

        if(($dependencies = @json_decode($response, true)) !== NULL) {
            $installed = self::getInstalledPackages();

            if(is_array($dependencies) && is_array($installed))            
                foreach($dependencies as $name => $version)
                    foreach($installed as $iName => $iVersion)
                        if($name == $iName && version_compare($version, $iVersion, '<='))
                            unset($dependencies[$name]);

            return $dependencies;
        }

        return $response;
    }

    public static function getLatestVersion($package) {
        return stPearCurl::get('Chiara_PEAR_Server_REST/r/'.strtolower($package).'/latest.txt');
    }

    public static function getReleaseDate($package, $version) {
        $content = stPearCurl::get('Chiara_PEAR_Server_REST/r/'.strtolower($package).'/'.$version.'.xml');
        if (!empty($content)) {
            $xml = simplexml_load_string($content);
            $date = new DateTime((string)$xml->da);
            return $date->format('U');
        }

        return FALSE;
    }

    public static function runPearCommand($command, $responseMode = 'unserialize', $logResponse = false) {

        if ($responseMode === null) 
            $responseMode = 'unserialize';

        /**
         * Hack for PEAR stricts errors.
         */
        error_reporting(($errorsCode = error_reporting()) & ~E_STRICT & ~E_DEPRECATED);

        /**
         * Loading `stInstallerWeb` modules for setup.
         */
        if(!class_exists('stInstallerFrontendWeb'))
            require_once(sfConfig::get('sf_app_module_dir').'/stInstallerWeb/lib/stInstallerFrontendWeb.class.php');

        if(!class_exists('stPearFrontendWeb'))
            require_once(sfConfig::get('sf_app_module_dir').'/stInstallerWeb/lib/stPearFrontendWeb.class.php');

        if (is_array($command)) {
            $parameters = isset($command['parameters']) ? $command['parameters'] : null;
            $options = isset($command['options']) ? $command['options'] : null;
            $command = isset($command['command']) ? $command['command'] : null;
        } else {
            $parameters = null;
            $options = null;
        }

        if ($command === null)
            throw new Exception("command can't be null.", 1);
        ob_start();
        $installerWeb = new stInstallerFrontendWeb();     
        $installerWeb->command($command, $parameters, $options);
        $response = ob_get_clean(); 

        /**
         * Log response
         */
        if ($logResponse) {
            $logFile = sfConfig::get('sf_root_dir').'/log/stPear-'.$command.'.log';
            $logMessage = '['.date('Y/m/d H:i:s').'] Command "'.$command.'" ('.json_encode($parameters).'), ('.json_encode($options).'): '."\n".$response ."\n\n";
            file_put_contents($logFile, $logMessage, (file_exists($logFile) ? FILE_APPEND : 0));
        }

        $return = stPearFrontendWeb::getPearResult($response, $responseMode);

        /**
         * Hack for PEAR stricts errors.
         */
        error_reporting($errorsCode);

        return $return;
    }

    public static function getInstalledPackages() {
        $files = glob(sfConfig::get('sf_root_dir').'/install/src/.registry/.channel.pear.sote.pl/*.reg');

        $packages = array();
        foreach($files as $file)
            if(($information = @unserialize(file_get_contents($file))) !== FALSE)
                $packages[$information['name']] = $information['version']['release'];

        return $packages;
    }

    public static function getPackagesToUpgrade($pearFormat = FALSE) {
        if(($upgradeList = stPearCache::getCache('upgrade-list')) === stPearCache::CACHE_NOT_FOUND) {
            $upgradeList = stPearCurl::get('upgrade.php', array('json' => json_encode(array('packages' => self::getInstalledPackages(), 'shopId' => stLicenseExt::getShopId()))));
            stPearCache::saveCache('upgrade-list', $upgradeList);
        }

        if(($upgradeList = @json_decode($upgradeList, true)) !== NULL)
            if($pearFormat == TRUE) {
                $pearUpgradeList = array();
                $channel = stPearCurl::getChannel();
                foreach($upgradeList as $name => $version)
                    $pearUpgradeList[] = array('channel' => $channel, 'name' => $name, 'version' => $version);
                return $pearUpgradeList;
            } else 
                return $upgradeList;

        return $upgradeList;
    }
}

class stPearCurl {

    public static function get($url, $parameters = array()) {
        $cUrl = curl_init();
        curl_setopt($cUrl, CURLOPT_URL, 'http://'.self::getChannel().'/'.$url);
        curl_setopt($cUrl, CURLOPT_RETURNTRANSFER, TRUE);

        if(!empty($parameters))
            curl_setopt($cUrl, CURLOPT_POSTFIELDS, urldecode(http_build_query($parameters)));

        $response = curl_exec($cUrl);
        curl_close($cUrl);

        return $response;
    }

    public static function getChannel() {
        return stPearInfo::getInstance()->getDefaultChannel();
    }
}

class stPearCache {

    const CACHE_NOT_FOUND = 'CACHE_NOT_FOUND';

    public static function getCachePath($name) {
        return sfConfig::get('sf_root_dir').'/install/cache/stPear-'.$name.'.cache';
    }

    public static function getCache($command, $time = 3600) {
        $file = self::getCachePath($command);
        if(file_exists($file)) {
            if(filemtime($file) + $time > time())
                return file_get_contents($file);
            else
                unlink($file);
        }

        return self::CACHE_NOT_FOUND;
    }

    public static function saveCache($command, $content) {
        file_put_contents(self::getCachePath($command), $content);
    }

    public static function removeCache($command = NULL) {
        if ($command === NULL)
            foreach (glob(self::getCachePath('*')) as $file)
                unlink($file);
        else 
            if(file_exists(self::getCachePath($command)))
                unlink(self::getCachePath($command));
    }
}
