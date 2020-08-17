<?php

class stPaczkomatyPack {

    const PACZKOMATY_URL = 'https://api.paczkomaty.pl/';
    const PACZKOMATY_SANDBOX_URL = 'https://sandbox-api.paczkomaty.pl/';

    public static function call($parameters, $postData = array(), $test_mode = null) {
        $config = stConfig::getInstance('stPaczkomatyBackend');

        if (null === $test_mode) {
            $test_mode = $config->get('test_mode');
        }
        
        $url = $test_mode ? self::PACZKOMATY_SANDBOX_URL : self::PACZKOMATY_URL;        

        $url = $url.(!empty($parameters) ? '?'.http_build_query($parameters, '', '&') : '');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        if ($postData) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

    public static function callAuth($parameters, $postData = array())
    {
        $config = stConfig::getInstance('stPaczkomatyBackend');

        $postData = array_merge(array('email' => $config->get('username'), 'password' => $config->get('password')), $postData);

        return self::call($parameters, $postData);
    }

    public static function getStatus($code) {
        $response = self::call(array('do' => 'getpackstatus', 'packcode' => $code));
        $xml = simplexml_load_string($response);
        if(isset($xml->status))
            return array('status' => (string)$xml->status, 'date' => (string)$xml->statusDate);
    }

    public static function checkAuth($login, $password, $test_mode)
    {
        $response = self::call(array('do' => 'pricelist'), array('email' => $login, 'password' => $password), $test_mode);

        $logger = sfConfig::get('sf_debug') ? sfLogger::getInstance() : null;

        if($response == false)
        {
            if ($logger) 
            {
                $logger->log('{stPaczkomaty} Connection problem', SF_LOG_ERR);
            }
            return false;
        }
         
        $xml = simplexml_load_string($response);  

        if ($logger && isset($xml->error)) 
        {
            $logger->log('{stPaczkomaty} '.$xml->error, SF_LOG_ERR);
        }      

        return !isset($xml->error);
    }

    public static function createPack(PaczkomatyPack $pack) {

        $config = stConfig::getInstance('stPaczkomatyBackend');

        $allegro = '';

        try
        {
            if ($pack->hasAllegroTransactionId())
            {
                $userId = stConfig::getInstance('stAllegroBackend')->get('seller_id');

                $transactionId = $pack->getAllegroTransactionId();

                $allegro = '<allegro><userId>'.$userId.'</userId><transactionId>'.$transactionId.'</transactionId></allegro>';
            }
        }
        catch (stAllegroException $e)
        {
            foreach (stAllegroApi::getLastErrors() as $error)
            {
                $messages[] = $error->userMessage;
            }

            $message = implode('<br>', $messages);
            
            return array('status' => false, 'error' => $message);
        }
   

        $xml = '
            <paczkomaty>
                <autoLabels>0</autoLabels>
                <selfSend>'.($pack->getUseSenderPaczkomat() ? 1 : 0).'</selfSend>
                <pack>
                    <id>'.$pack->getId().'</id>
                    <adreseeEmail>'.$pack->getCustomerEmail().'</adreseeEmail>
                    <senderEmail>'.$config->get('username').'</senderEmail>
                    <phoneNum>'.$pack->getCustomerPhone().'</phoneNum>
                    <boxMachineName>'.$pack->getCustomerPaczkomat().'</boxMachineName>'.
                    ($pack->getUseSenderPaczkomat() ? '<senderBoxMachineName>'.$pack->getSenderPaczkomat().'</senderBoxMachineName>' : '')
                    .'<packType>'.$pack->getPackType().'</packType>
                    <insuranceAmount>'.$pack->getInsurance().'</insuranceAmount>
                    <onDeliveryAmount>'.$pack->getCashOnDelivery().'</onDeliveryAmount>
                    <customerRef>'.$pack->getDescription().'</customerRef>
                    <senderAddress>
                        <companyName>'.$config->get('sender_company').'</companyName>
                        <name>'.$config->get('sender_name').'</name>
                        <surName>'.$config->get('sender_surname').'</surName>
                        <email>'.$config->get('sender_email').'</email>
                        <phoneNum>'.$config->get('sender_phone').'</phoneNum>
                        <street>'.$config->get('sender_street').'</street>
                        <buildingNo>'.$config->get('sender_building_no').'</buildingNo>
                        <flatNo>'.$config->get('sender_flat_no').'</flatNo>
                        <town>'.$config->get('sender_town').'</town>
                        <zipCode>'.$config->get('sender_zip_code').'</zipCode>
                        <province>'.$config->get('sender_province').'</province>
                    </senderAddress>
                    '.$allegro.'
                </pack>
            </paczkomaty>';            

        $post = array('content' => $xml);
        $response = self::callAuth(array('do' => 'createdeliverypacks'), $post);

        if($response == false)
            return array('status' => false, 'error' => 'Błąd połączenia z serwerem API Paczkomaty.');

        $xml = simplexml_load_string($response);
        if(isset($xml->pack->error))
            return array('status' => false, 'error' => (string)$xml->pack->error);

        if(isset($xml->error))
            return array('status' => false, 'error' => (string)$xml->error);

        if(isset($xml->pack->packcode)) {
            $pack->setCode((string)$xml->pack->packcode);
            $pack->setCustomerDeliveringCode((string)$xml->pack->customerdeliveringcode);
            $pack->save();
        }

        return array('status' => true);
    }

    public static function getSticker($code) {
        $config = stConfig::getInstance('stPaczkomatyBackend');

        $post = array('packcode' => $code, 'labelType' => $config->get('label_type'));
        $response = self::callAuth(array('do' => 'getsticker'), $post);

        if (strpos($response, 'PDF'))
            return array('status' => true, 'pdf' => $response);

        $xml = simplexml_load_string($response);
        if(isset($xml->error))
            return array('status' => false, 'error' => (string)$xml->error);
    }

    public static function payForPack($code) {
        $config = stConfig::getInstance('stPaczkomatyBackend');

        $post = array('packcode' => $code);
        $response = self::callAuth(array('do' => 'payforpack'), $post);

        if ($response == '1')
            return array('status' => true);

        $xml = simplexml_load_string($response);
        if(isset($xml->error))
            return array('status' => false, 'error' => (string)$xml->error);
    }
}
