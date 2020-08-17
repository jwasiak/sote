<?php
class stImportExportLog {

    public static $FATAL = 1;
    public static $WARNING = 2;
    public static $NOTICE = 3;

    protected $handle = null;

    protected $filename = '';

    protected static $instance = null;

    protected $current_key = '';

    public function __construct($filename) {
        $this->filename =$filename ;
        self::$instance = $this;
    }

    public static function clearLogs($prefix = '*')
    {
        $finder = sfFinder::type('file');
        $importFiles = $finder->name($prefix.'_*.log')->in(sfConfig::get('sf_log_dir')) ;

        foreach ($importFiles as $file)
        {
            unlink($file);
        }
    }

    public function __destruct()
    {
        if ($this->handle)
        fclose($this->handle);
    }

    public function add($key, $msg, $type = 3)
    {
        if (empty($key)) $key = $this->getCurrentKey();
        if ($this->handle == null) {
            $this->handle = fopen($this->filename, 'a');
        }
        if (!empty($msg))
        {
            fputcsv($this->handle, array($key, $msg, $type), ';', '"');
        }
    }

    public function getLog()
    {
        if (file_exists($this->filename)) {
            
            $handle = fopen($this->filename, 'r');
            $log = array();
            while (($log[] = fgetcsv($handle, null, ';', '"')) !== FALSE);
            return $log;
        }
        return array();
    }

    public function hasLog()
    {
        if (file_exists($this->filename)) {
            return true;
        }
        return false;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public static function getActiveLogger()
    {
        return self::$instance;
    }

    public function getCurrentKey()
    {
        return $this->current_key;
    }

    public function setCurrentKey($key)
    {
        $this->current_key = $key;
    }
}