<?php

class stAppStats
{
    const URL = 'https://www.sote.pl/app-stats';

    protected static $version = null;

    public static function activate($name, array $params = array())
    {
        $params['name'] = $name;
        return self::apiCall('/activate', $params);
    }

    public static function deactivate($name, array $params = array())
    {
        $params['name'] = $name;
        return self::apiCall('/deactivate',$params);
    }

    public static function apiCall($url , array $body = array())
    {
        if (!isset($body['hash']))
        {
            $body['hash'] = stConfig::getInstance('stRegister')->get('shop_hash');
        }
        
        $body['version'] = self::getSoftwareVersion();

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::URL . $url);

        curl_setopt($ch, CURLOPT_VERBOSE, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);   
        
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , 'Authorization: Bearer '. $apiKey));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

        $response = curl_exec($ch);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch))
        {
            $result = array('error' => curl_error($ch)); 
        }
        else
        {
            $result = array('http_code' => $httpcode, 'response' => $response, 'url' => self::URL . $url); 
        }
   

        curl_close($ch);

        return $result;
    }

    protected function getSoftwareVersion()
    {
        if (null === self::$version)
        {
            $version = stRegisterSync::getPackageVersion('soteshop');

            if (stCommunication::getIsSeven())
            {
                list(, $y, $z) = explode('.', $version, 3);
                $version = '7.'.($y-3).'.'.$z;
            }  
            elseif (!$version) 
            {
                $version = stRegisterSync::getPackageVersion('soteshop_base');   
            }

            self::$version = $version;
        }

        return self::$version;
    }
}