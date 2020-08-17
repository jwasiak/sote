<?php

class MobileDetect
{
    protected static $instance = null;
    protected $isMobile = null;

    public static function getInstance() 
    {
        if (null === self::$instance)
        {
            self::$instance = new MobileDetect();
        }

        return self::$instance;
    }

    public function isMobile()
    {
        if (null === $this->isMobile)
        {
            $this->isMobile = strpos($_SERVER['HTTP_USER_AGENT'], 'Mobi') !== false;
        }

        return $this->isMobile;
    }
}