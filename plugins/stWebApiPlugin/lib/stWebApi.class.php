<?php
/**
 * SOTESHOP/stWebApiPlugin
 *
 * Ten plik należy do aplikacji stWebApiPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stWebApiPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stWebApi.class.php 12182 2011-04-13 10:27:21Z piotr $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stWebApi
 *
 * @package stWebApiPlugin
 */
class stWebApi
{
    /**
     * Sprawdzanie zablokowania API
     *
     * @return true/false - zablokowane/odblokowane
     */
    public static function isEnabled()
    {
        $webapiConfig = stConfig::getInstance(sfContext::getInstance(), 'stWebApiBackend');
        return $webapiConfig->get('webapi_on');

    }

    public static function getLogin($hash = '', $perm) {
        $c = new Criteria();
        $c->add(WebApiSessionPeer::HASH, $hash);

        $webapiConfig = stConfig::getInstance(sfContext::getInstance(), 'stWebApiBackend');
        $timeLimit = $webapiConfig->get('session_time');
        $updatedAt = time()-$timeLimit;
        
        // $c->add(WebApiSessionPeer::UPDATED_AT, $updatedAt, Criteria::GREATER_THAN);

        $session = WebApiSessionPeer::doSelectOne($c);
         
        if (!$session || strtotime($session->getUpdatedAt()) < $updatedAt) {
            throw new SoapFault("255", sfContext::getInstance()->getI18n()->__("Proszę się zalogować",'','stWebApiBackend'));
        } else {
            if (!$session->getSfGuardUser()->hasPermission($perm) && $perm!='') {
                if ($perm == 'webapi_read') throw new SoapFault("255", sfContext::getInstance()->getI18n()->__("Użytkownik nie ma praw odczytu.",'','stWebApiBackend'));
                if ($perm == 'webapi_write') throw new SoapFault("255", sfContext::getInstance()->getI18n()->__("Użytkownik nie ma praw zapisu.",'','stWebApiBackend'));
            }
            $session->setActive(1);
            $session->setUpdatedAt(time());
            $session->save();
            
            sfContext::getInstance()->getUser()->signIn($session->getSfGuardUser());
        }
    }

    public static function formatData($data, $type='string') {
        switch ($type) {
            case "string":
                            $data = preg_replace('/[\x00-\x08\x10\x0B\x0C\x0E-\x19\x7F]'.
                             '|[\x00-\x7F][\x80-\xBF]+'.
                             '|([\xC0\xC1]|[\xF0-\xFF])[\x80-\xBF]*'.
                             '|[\xC2-\xDF]((?![\x80-\xBF])|[\x80-\xBF]{2,})'.
                             '|[\xE0-\xEF](([\x80-\xBF](?![\x80-\xBF]))|(?![\x80-\xBF]{2})|[\x80-\xBF]{3,})/S',
                             '', $data );
                             
                            //reject overly long 3 byte sequences and UTF-16 surrogates and replace with ?
                            $data = preg_replace('/\xE0[\x80-\x9F][\x80-\xBF]'.
                             '|\xED[\xA0-\xBF][\x80-\xBF]/S','', $data ); 
                return $data; 
            break;
            case "integer": return (integer)$data; break;
            case "double": return (float)$data; break;
            case "dateTime":
                if (!empty($data))
                {
                    return date_format(date_create($data), DATE_ATOM);
                }
                else
                {
                    return date_format(date_create("1970-01-01 00:00:00"), DATE_ATOM);
                }
                break;
            default: return (string)$data; break;
        }
    }

}