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
 * @version     $Id: stModuleWebApi.class.php 15190 2011-09-22 09:58:05Z piotr $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa stProducerWebApi
 *
 * @package     stWebApiPlugin
 * @subpackage  libs
 */
class StProducerWebApi extends autoStProducerWebApi {

    public function AddProducer($object) {
        if (isset($object->_culture))
            $this->__setCulture($object->_culture);

        stWebApi::getLogin($object->_session_hash, 'webapi_write');
        $this->TestAndValidateAddProducerFields($object);

        $item = new Producer();
        if ($item) {
            $this->setFieldsForAddProducer($object, $item);

            try {
                $item->save();

                if (isset($object->image) && isset($object->image_filename)) 
                    $this->setProducerImage($item, $object->image_filename, $object->image);

                if (isset($object->url)) {
                    $item->setUrl($object->url);
                    $item->save();
                }
            } catch (Exception $e) {
                throw new SoapFault('2', sprintf($this->__(WEBAPI_ADD_ERROR), $e->getMessage()));
            }
            
            $object = new StdClass();
            $this->getFieldsForAddProducer($object, $item);

            return $object;
        } else {
            throw new SoapFault('1', $this->__(WEBAPI_ADD_ERROR));
        }
    }  

    public function TestAndValidateAddProducerFields($object)
    {
        parent::TestAndValidateAddProducerFields($object);

        $this->validateProducerName($object);
    } 

    public function TestAndValidateUpdateProducerFields($object)
    {
        parent::TestAndValidateUpdateProducerFields($object);

        if (isset($object->name))
        {
            $this->validateProducerName($object);
        }
    } 

    public function UpdateProducer($object) {
        if (isset($object->_culture))
            $this->__setCulture($object->_culture);

        stWebApi::getLogin($object->_session_hash, 'webapi_write');
        $this->TestAndValidateUpdateProducerFields($object);

        $item = ProducerPeer::retrieveByPk($object->id);
        if (is_object($item)) {
            $this->setFieldsForUpdateProducer($object, $item);

            try {
                $item->save();

                if (isset($object->image) && isset($object->image_filename))
                    $this->setProducerImage($item, $object->image_filename,$object->image);

            } catch (Exception $e) {
                throw new SoapFault('2', sprintf($this->__(WEBAPI_UPDATE_ERROR), $e->getMessage()));
            }
            
            $object = new StdClass();
            $object->_update = 1;
            return $object;
        } else {
            throw new SoapFault( "1", $this->__(WEBAPI_INCORRECT_ID));
        }
    }

    public function GetProducer($object) {
        if (isset($object->_culture))
            $this->__setCulture($object->_culture);

        stWebApi::getLogin($object->_session_hash, 'webapi_read');
        $this->TestAndValidateGetProducerFields($object);

        $item = ProducerPeer::retrieveByPk($object->id);
        if ($item) {
            $object = new StdClass();
            $this->getFieldsForGetProducer($object, $item);

            if (is_object($item->getSfAsset())) {
                $object->image_filename = basename($item->getSfAsset()->getPath());
                $object->image = base64_encode(file_get_contents(sfConfig::get('sf_web_dir').'/'.$item->getSfAsset()->getPath()));
            }
 
            return $object;
        } else {
            throw new SoapFault('1', $this->__(WEBAPI_INCORRECT_ID));
        }
    }

    public function GetProducerList($object) {
        if (isset($object->_culture))
            $this->__setCulture($object->_culture);

        stWebApi::getLogin($object->_session_hash, 'webapi_read');
        $this->TestAndValidateGetProducerListFields($object);

        $c = new Criteria();

        if (isset($object->_modified_from) && isset($object->_modified_to)) {
            $criterion = $c->getNewCriterion(ProducerPeer::UPDATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
            $criterion->addAnd($c->getNewCriterion(ProducerPeer::UPDATED_AT, $object->_modified_to, Criteria::LESS_EQUAL));
            $c->add($criterion);
        } else {
            if (isset($object->_modified_from)) {
                $criterion = $c->getNewCriterion(ProducerPeer::UPDATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
                $c->add($criterion);
            }
            
            if (isset($object->_modified_to)) {
                $criterion = $c->getNewCriterion(ProducerPeer::UPDATED_AT, $object->_modified_to, Criteria::LESS_EQUAL);
                $c->add($criterion);
            }
        }

        if (!isset($object->_limit))
            $object->_limit = 20;

        $c->setLimit($object->_limit);
        $c->setOffset($object->_offset);

        $items = ProducerPeer::doSelect($c);

        if ($items) {
            $itemsArray = array();
            foreach ($items as $item) {
                $object = new StdClass();
                $this->getFieldsForGetProducerList($object, $item);

                if (is_object($item->getSfAsset())) {
                    $object->image_filename = basename($item->getSfAsset()->getPath());
                    $object->image = base64_encode(file_get_contents(sfConfig::get('sf_web_dir').'/'.$item->getSfAsset()->getPath()));
                }

                $itemsArray[] = $object;
            }
            return $itemsArray;
        } else {
            return array();
        }
    }  

    public function setProducerImage($item, $filename, $image) {
        $tmpFile = sfConfig::get('sf_cache_dir').'/webapi_producer.tmp';

        if (is_object($item->getSfAsset())) {
            $item->getSfAsset()->delete();
            $item->setSfAsset(null);
        }

        file_put_contents($tmpFile, base64_decode($image));
        $item->createAsset($item->getId().'.'.pathinfo($filename, PATHINFO_EXTENSION), $tmpFile);
        $item->save();
    }

    protected function validateProducerName($object)
    {
        $c = new Criteria();
        // $c->addJoin(ProducerPeer::ID, ProducerI18nPeer::ID);
    
        $c->add(ProducerI18nPeer::NAME, $object->name);
        $c->add(ProducerI18nPeer::CULTURE, $this->__getCulture());

        if (isset($object->id) && $object->id)
        {
            $c->add(ProducerI18nPeer::ID, $object->id, Criteria::NOT_EQUAL);
        }

        if (ProducerI18nPeer::doCount($c) > 0)
        {
            throw new SoapFault( "3", sprintf($this->__(WEBAPI_VALIDATE_UNIQUE_ERROR), 'name'));
        }        
    }
}
