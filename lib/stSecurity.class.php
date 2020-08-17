<?php 
class stSecurity
{
    protected static $ssl = null;

    protected static $host = null;

    protected static $uri = null;

    public static function hasSSL()
    {
        return self::getSSL() !== false;
    }

    public static function getSSL($host = null)
    {
        if (null === self::$ssl)
        {
            $config = stConfig::getInstance('stSecurityBackend');

            if ($config->get('ssl'))
            {            
                $host = self::getHost();
                $uri = self::getUri();
                $ssl = $config->get('ssl') === '1' ? 'order' : $config->get('ssl');

                if ($ssl == 'order' && !in_array($host, $config->get('ssl_ignore_hosts', array())) || $ssl == 'shop' && !in_array($host, $config->get('ssl_ignore_hosts', array())) && !self::sslIgnoreUri($uri))
                {
                    self::$ssl = $ssl;
                }
                else
                {
                    $config->set('ssl', false);
                    self::$ssl = false;
                }
            }  
            else
            {
                self::$ssl = false;
            }
        }   

        return self::$ssl;   
    }

    public static function setHost($host)
    {
        self::$host = $host;
    }

    public static function setUri($uri)
    {
        self::$uri = $uri;
    }

    protected static function sslIgnoreUri($uri)
    {
        $ignore = false;

        foreach (stConfig::getInstance('stSecurityBackend')->get('ssl_ignore_uri', array()) as $current) 
        {
            if (strpos($uri, $current) !== false)
            {
                $ignore = true;
            }
        }
        
        return $ignore;      
    }

    protected static function getUri()
    {
        return null !== self::$uri ? self::$uri : $_SERVER['REQUEST_URI'];
    }

    protected static function getHost()
    {
        return null !== self::$host ? (function_exists('idn_to_utf8') ? idn_to_utf8($host) : $host) : $_SERVER['HTTP_HOST'];
    }
}
?>