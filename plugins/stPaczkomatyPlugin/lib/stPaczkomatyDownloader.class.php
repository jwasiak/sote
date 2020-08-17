<?php

class stPaczkomatyDownloader {

    protected static $instance = array();
    protected $namespace = null;

    public static function getInstance($namespace) {
        if (!isset(self::$instance[$namespace])) {
            $className = __CLASS__;
            self::$instance[$namespace] = new $className();
            self::$instance[$namespace]->initialize($namespace);
        }

        return self::$instance[$namespace];
    }

    public function initialize($namespace) {
        $this->namespace = $namespace;
    }

    public function get($parameters = array(), $force = false) {
        if ($force === false && ($cache = $this->getCache()) !== false)
            return $cache;

        $response = $this->download($parameters);
        $this->saveCache($response);
        return $response;
    }

    public function download($parameters = array()) {
        return stPaczkomatyPack::call($parameters);
    }

    public function saveCache($content) {
        file_put_contents($this->getCacheFileName(), $content);
    }

    public function getCache($time = 86400) {
        if (file_exists($this->getCacheFileName()))
            if (filemtime($this->getCacheFileName()) + $time > time())
                return file_get_contents($this->getCacheFileName());
            else
                unlink($this->getCacheFileName());
        return false;
    }

    public function getCacheFileName() {
        $cacheDir = sfConfig::get('sf_root_dir').'/cache/frontend/'.SF_ENVIRONMENT.'/stPaczkomatyPlugin';
        if (!file_exists($cacheDir))
            mkdir($cacheDir, 0777, true);

        $config = stConfig::getInstance('stPaczkomatyBackend');

        return $cacheDir.'/'.$this->namespace.($config->get('test_mode') ? '.test' : '').'.cache';
    }
}

class stPaczkomatyMachines {

    protected static function parseCsv($csv) {
        $content = explode("\n", $csv);
        if(is_array($content))
            unset($content[0]);
        $keyList = array('number', 'street', 'house', 'postCode', 'city', 'latitude', 'longitude', 'cod', 'hours', 'description', 'paymentDescription', 'partnerId', '?', '??', '???', '????');
        foreach ($content as $key => $value)
            $content[$key] = array_combine($keyList, explode(";", $value));
        return $content;
    }

    public static function getListOfMachines($force = false) {
        $downloader = stPaczkomatyDownloader::getInstance('machines');

        if ($force === false && ($cache = $downloader->getCache()) !== false) {
            $list = json_decode($cache, true);
            if (!empty($list))
                return $list;
        }

        $response = $downloader->download(array('do' => 'listmachines_csv'));
        $parsedResponse = self::parseCsv($response, true);
        $downloader->saveCache(json_encode($parsedResponse));

        stPaczkomatyCites::createCitiesList($parsedResponse);

        return $parsedResponse;
    }

    public static function getListOfMachinesByParam($params = array()) {
        $downloader = stPaczkomatyDownloader::getInstance('machines_by_param');

        $response = $downloader->download(array_merge(array('do' => 'listmachines_csv'), $params));
        $parsedResponse = self::parseCsv($response, true);
        
        return $parsedResponse;        
    }

    public static function getListOfCodMachines() {
        return self::parseCsv(stPaczkomatyDownloader::getInstance('machines_cod')->get(array('do' => 'listmachines_csv', 'paymentavailable' => 't')));
    }

    public static function getListOfDeliveryPoints($force = false)
    {
        $downloader = stPaczkomatyDownloader::getInstance('delivery_points');

        if ($force === false && ($cache = $downloader->getCache()) !== false) {
            $list = json_decode($cache, true);
            if (!empty($list))
                return $list;
        }

        $response = $downloader->download(array('do' => 'listmachines_csv', 'pickuppoint' => 't'));
        $parsedResponse = self::parseCsv($response, true);
        $downloader->saveCache(json_encode($parsedResponse));

        return $parsedResponse;
    }

    public static function getMachine($number) {
        $content = self::getListOfMachines();

        foreach ($content as $machine)
            if ($number == $machine['number'])
                return $machine;

        $content = self::getListOfDeliveryPoints();

        foreach ($content as $machine)
            if ($number == $machine['number'])
                return $machine;

        return null;
    }

    public static function getMachineByPostCode($postCode) {
        $xml = stPaczkomatyDownloader::getInstance('machine')->download(array('do' => 'findnearestmachines', 'postcode' => $postCode));

        $data = simplexml_load_string($xml);

        $machine = array();
        if(isset($data->machine[0]))
            foreach ($data->machine[0] as $key => $value)
                $machine[$key] = (string) $value;
        else 
            return array();

        return $machine;
    }

    public static function get3MachinesByPostCode($postCode) {
        return self::getMachinesByPostCode($postCode, 3);
    }

    public static function getMachinesByPostCode($postCode, $limit = 100) {
        $xml = stPaczkomatyDownloader::getInstance('machine')->download(array('do' => 'findnearestmachines', 'postcode' => $postCode, 'limit' => $limit));

        $data = simplexml_load_string($xml);

        $machines = array();
        if(isset($data->machine[0])) {
            $i = 0;
            foreach ($data->machine as $k => $m) {
                foreach ($m as $key => $value)
                    $machines[$i][$key] = (string) $value;
                $i++;
            }
        } else 
            return array();

        return $machines;        
    }
}

class stPaczkomatyCites {

    public static function getListofCities($force = false) {
        $downloader = stPaczkomatyDownloader::getInstance('cities');

        if ($force === false && ($cache = $downloader->getCache()) !== false) {
            $list = json_decode($cache, true);
            if (!empty($list))
                return $list;
        }


        return self::createCitiesList(stPaczkomatyMachines::getListOfMachines());
    }

    public static function createCitiesList($machines, $namespace = 'cities') {
        $cities = array();
        foreach ($machines as $machine)
            $cities[] = $machine['city'];

        $cities = array_unique($cities);
        sort($cities);

        $citiesDownloader = stPaczkomatyDownloader::getInstance($namespace);
        $citiesDownloader->saveCache(json_encode($cities));

        return $cities;
    }
}
