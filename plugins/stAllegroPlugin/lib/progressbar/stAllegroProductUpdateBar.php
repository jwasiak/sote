<?php

class stAllegroProductUpdateBar {

    protected $i18n;

    protected $msg;

    public function __construct() {
        $this->i18n = sfContext::getInstance()->getI18n();
    }

    public function execute($offset = 0) {
        $c = new Criteria();
        $c->setOffset($offset);
        $c->setLimit(5);

        $api = stAllegroApi::getInstance();

        foreach (AllegroAuctionPeer::doSelect($c) as $auction)
        {
            try {
                //    throw new Exception("test");
                $offer = $api->getOffer($auction->getAuctionId());

                        // throw new Exception("test");

                $offer->external = stAllegroApi::arrayToObject(array(
                    'id' => $auction->getProductId(),
                ));

                $api->updateOffer($offer->id, $offer);
            }
            catch(stAllegroException $e)
            {

            }

            $auction->setName($offer->name);

            $auction->save();
 
            $offset++;
        }

        sleep(1);

        return $offset;
    }

    public function getTitle() {
        return $this->i18n->__('Aktualizacja ofert - Proszę czekać');
    }

    public function getMessage() {
        return $this->msg;
    }

    public function close() {
        $message = $this->i18n->__('Wszystie oferty zostały zaktualizowane pomyślnie', null, 'stAllegroBackend');
        $link = $this->i18n->__('Przejdź do ofert');
       
        $html =<<<HTML
            <p style="text-align: center">$message</p>
            <p style="text-align: center"><a href="#" onclick="location.reload(); return false">$link</a></p>
HTML;
        $this->msg = $html;

        $config = stConfig::getInstance('stAllegroBackend');

        $config->set('offers_updated', true);

        $config->save(true);
    }
}
