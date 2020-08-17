<?php
if (!function_exists('ereg')) {
    function ereg($pattern, $string, &$args = null) 
    {
        return preg_match($pattern, $string, $args);
    }

    require_once(dirname(__FILE__).'/php7/mysql.php');
}

if (!function_exists('split')) {
    function split($pattern, $subject, $limit = -1)
    {
        return preg_split($pattern, $subject, $limit);
    }
}

if (!function_exists('getallheaders')) {
    function getallheaders() 
    {
        $headers = array();

        foreach ($_SERVER as $name => $value) 
        {
            if (substr($name, 0, 5) == 'HTTP_') 
            {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        
        return $headers;
    }
}

$root_dir = dirname(__FILE__).'/..';

$phpversion = floatval(phpversion());
$php7switch = is_file($root_dir . '/data/.php7switch');

if ($phpversion >= 7 && !$php7switch)
{
    touch($root_dir . '/data/.php7switch');

    if (!class_exists('stLock'))
    {
        require_once $root_dir . '/plugins/stLockPlugin/lib/stLock.class.php';
    }

    stLock::lock('frontend');
    stLock::lock('backend');

    $databases = file_get_contents($root_dir . '/config/databases.yml');

    if (false === strpos($databases, 'phptype: mysqli'))
    {
        $databases = str_replace("phptype: mysql", "phptype: mysqli", $databases);
        file_put_contents($root_dir . '/config/databases.yml', $databases);
    }

    $propelIni = file_get_contents(SF_ROOT_DIR . '/config/propel.ini');
    $propelIni = str_replace("mysql://", "mysqli://", $propelIni);
    file_put_contents($root_dir . '/config/propel.ini', $propelIni);
    
    $cleanup = array(
        $root_dir . '/cache/frontend/'.SF_ENVIRONMENT.'/config/*.php',
        $root_dir . '/cache/backend/'.SF_ENVIRONMENT.'/config/*.php',
        $root_dir . '/cache/update/'.SF_ENVIRONMENT.'/config/*.php'
    );

    foreach ($cleanup as $dir)
    {
        foreach (glob($dir) as $file)
        {
            unlink($file);
        }
    }

    stLock::unlock('frontend');
    stLock::unlock('backend');
} 

// symfony directories
$sf_symfony_lib_dir  = dirname(__FILE__).'/../lib/symfony';
$sf_symfony_data_dir = dirname(__FILE__).'/../data/symfony';
