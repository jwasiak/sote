<?php

class stCommunicationCache {

    protected static $cacheIndex = null;

    const CACHE_NOT_FOUND = 'CACHE_NOT_FOUND';

    protected static $disabled = false;

    public static function disableCache() {
        self::$disabled = true;
    }

    public static function enableCache() {
        self::$disabled = false;
    }

    protected static function getIndexPath() {
        return sfConfig::get('sf_root_dir').'/install/communication/cache.index';
    }

    protected static function getIndex() {
        if (null === self::$cacheIndex) {
            if (file_exists(self::getIndexPath()) && filesize(self::getIndexPath()) > 0)
                self::$cacheIndex = json_decode(file_get_contents(self::getIndexPath()), true);
        }
        return null !== self::$cacheIndex ? self::$cacheIndex : array();
    }

    protected static function setIndex($content) {
        self::$cacheIndex = $content;
        return file_put_contents(self::getIndexPath(), json_encode($content));
    }

    protected static function getCacheFilePath($index) {
        return sfConfig::get('sf_root_dir').'/install/communication/cache/'.$index.'.cache';
    }

    protected static function setCacheContent($index, $content) {
        return file_put_contents(self::getCacheFilePath($index), json_encode($content));
    }

    protected static function getCacheContent($index) {
        if(file_exists(self::getCacheFilePath($index)))
            return json_decode(file_get_contents(self::getCacheFilePath($index)), true);
        return self::CACHE_NOT_FOUND;
    }

    public static function processCache($command, $time = 86400, $namespace = 'default') {
        if (self::$disabled === true)
            return self::CACHE_NOT_FOUND;

        $cache = self::getIndex();
        if(isset($cache[$namespace][$command]) && $cache[$namespace][$command]['time'] + $time > time())
            return self::getCacheContent($cache[$namespace][$command]['index']);

        return self::CACHE_NOT_FOUND;
    }

    public static function saveCache($command, $content, $namespace = 'default') {
        $index = md5($command.$namespace.time());

        $cache = self::getIndex();
        $cache[$namespace][$command] = array(
            'time' => time(),
            'index' => $index,
        );

        if (self::setIndex($cache) && self::setCacheContent($index, $content)) {
            if (date('j') % 2) self::cleanCacheIndexAndDirectory();
            return true;
        }

        return false;
    }

    protected static function cleanCacheIndexAndDirectory() {
        $index = self::getIndex();
        $indexes = array();
        foreach (self::getIndex() as $namespace => $commands) {
            foreach ($commands as $command => $v) {
                if (!file_exists(self::getCacheFilePath($v['index']))) 
                    unset($index[$namespace][$command]);
                $indexes[] = $v['index'];
            }
        }

        $files = glob(sfConfig::get('sf_root_dir').'/install/communication/cache/*.cache');
        foreach ($files as $file) {
            if (!in_array(basename($file, '.cache'), $indexes))
                unlink($file);
        }
    }
}
