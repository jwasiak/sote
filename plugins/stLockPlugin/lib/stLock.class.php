<?php

class stLock {

    protected static function getLockFilePath($app, $rootDir = null) {
        if (null === $rootDir)
        {
            $rootDir = SF_ROOT_DIR;
        }

        return $rootDir.'/web/uploads/stLock'.ucfirst($app).'.lck';
    }

    public static function check($app = SF_APP, $environment = SF_ENVIRONMENT) {
        if (!class_exists('stLicenseAbuse') && file_exists($file = SF_ROOT_DIR.'/lib/license/stLicenseAbuse.class.php'))
    include_once($file); 
    
        if (floatval(phpversion()) < 5.4 || floatval(phpversion()) >= 7.2)
        {
            return false;
        }

        if (class_exists('stLicenseAbuse') && stLicenseAbuse::isOff())
            return false;

        if ($environment == 'dev') 
            return true;
        
        if (isset($_REQUEST['open-key']) && $_REQUEST['open-key'] == md5_file(SF_ROOT_DIR.'/config/databases.yml'))
        	return true;

        if(file_exists(self::getLockFilePath($app))) 
            return false;

        return true; 
    }

    public static function lock($app = SF_APP, $rootDir = null) {
        file_put_contents(self::getLockFilePath($app, $rootDir), time());
    }
    
    public static function unlock($app = SF_APP, $rootDir = null) {
        $lockFile = self::getLockFilePath($app, $rootDir);

        if (file_exists($lockFile))
        {
            unlink($lockFile);
        }
    }

    public static function wait($app = SF_APP, $wait = 3)
    {
        $time = time();
        $lock_file = self::getLockFilePath($app);
        while(is_file($lock_file) && time() - $time <= $wait) { usleep(300000); }
        self::unlock($app);
    }
}
