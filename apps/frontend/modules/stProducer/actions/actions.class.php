<?php
/**
 * SOTESHOP/stProducer
 *
 * Ten plik należy do aplikacji stProducer opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stProducer
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 883 2009-04-28 13:34:48Z marcin $
 * @author      Krzysztof Beblo <krzysztof.beblo@sote.pl>
 */

/**
 * Klasa stProducerActions
 *
 * @package     stProducer
 * @subpackage  actions
 */
class stProducerActions extends stActions
{

    /**
     * Zmiana globalnego producenta w sklepie
     *
     * @author Marcin Butlak <marcin.butlak@sote.pl>
     *
     * @return unknown
     */
    public function executeChoose()
    {
        // disable Fast Cache when producer is changed
        stFastCacheController::disable();
        
        $this->smarty = new stSmarty($this->getModuleName());

        $this->id = $this->getRequestParameter('id');
        if ($this->id=='lang')
        {
            $this->id='';
        }

        if ($this->id)
        {
            stProducer::setSelectedProducerId($this->id);
            $this->producer = ProducerPeer::retrieveByPK($this->id);

            sfLoader::loadHelpers(array('Helper','stUrl'));
            $redirect = array();
            $redirect['module'] = 'stProduct';
            $redirect['action'] = 'producerList';
            $redirect['url'] = $this->producer->getFriendlyUrl();
            stProducer::setSelectedProducerId($this->producer->getId());
            $this->redirect($redirect , 301);
        }
        else
        {
            stProducer::clearSelectedProducerId();
            return $this->redirect('@homepage');
        }       
    
        return $this->redirect('@homepage');
    
    }
}

