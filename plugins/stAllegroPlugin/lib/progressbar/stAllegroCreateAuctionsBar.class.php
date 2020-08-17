<?php

class stAllegroCreateAuctionsBar {

    protected $i18n;

    protected $msg = null;

    protected $auctionIds = array();

    public function __construct() {
        $this->i18n = sfContext::getInstance()->getI18n();
        $this->auctionIds = sfContext::getInstance()->getUser()->getAttribute('auctionsIds', array(), 'stAllegroPlugin');
    }

    public function init() {
        sfContext::getInstance()->getUser()->setAttribute('auctionsInformations', array(), 'stAllegroPlugin');
    }

    public function getTitle() {
        return $this->i18n->__('Wystawianie aukcji w serwisie aukcyjnym', null, 'stAllegroBackend');
    }

    public function getMessage() {
        return $this->msg;
    }

    public function createAuction($step = 0) {
        if (isset($this->auctionIds[$step])) {
            $auction = AllegroAuctionPeer::retrieveByPK($this->auctionIds[$step]);

            if (is_object($auction)) {
                $this->msg = $this->i18n->__('Wystawianie aukcji', null, 'stAllegroBackend').': '.$auction->getName();

                if (!$auction->getAuctionId()) {
                    try {
                        $stAllegro =stAllegro::getInstance($auction->getEnvironment()); 
                        $response = $stAllegro->createAuction($auction);
                        if ($response === false)
                            $response = $stAllegro->getLastError();
                    } catch(Exception $e) {
                        $response = $e->getMessage();
                    }
                } else {
                    $response = $this->i18n->__('Aukcja została wystawiona wcześniej. Proszę utworzyć kopie aukcji i wystawić ją ponownie.', null, 'stAllegroBackend');
                }

                $messages = sfContext::getInstance()->getUser()->getAttribute('auctionsInformations', array(), 'stAllegroPlugin');
                $messages[$auction->getId()] = $response;
                sfContext::getInstance()->getUser()->setAttribute('auctionsInformations', $messages, 'stAllegroPlugin');
            }
        }

        return ($step+1);
    }

    public function close() {
        sfLoader::loadHelpers(array('Helper', 'stPartial', 'stAdminGenerator'));
        $this->msg = st_get_partial('stAllegroBackend/createManyAuction', array('messages' => sfContext::getInstance()->getUser()->getAttribute('auctionsInformations', array(), 'stAllegroPlugin')));
    }
}
