<?php

class stAllegroSyncTask extends stTask
{
    const LIMIT = 50;

    /**
     * Kontroler
     *
     * @var sfWebController
     */
    protected $controller;

    public function initialize(): void
    {
        $this->controller = sfContext::getInstance()->getController();
    }

    public function count(): int
    {
        if (!stConfig::getInstance('stAllegroBackend')->get('access_token'))
        {
            return 0;
        }
        
        $c = $this->getCriteria();
        return AllegroAuctionPeer::doCount($c);
    }

    public function execute(int $offset): int
    {
        $c = $this->getCriteria();
        $c->setLimit(self::LIMIT);

        $publish = array();
        $unpublish = array();

        $api = stAllegroApi::getInstance();
        
        /**
         * @var AllegroAuction $auction
         */
        foreach (AllegroAuctionPeer::doSelect($c) as $auction)
        {
            $offerLink = $this->getOfferLink($auction->getAuctionId());
            
            try
            {
                if (null === $auction->getAuctionId() || null === $auction->getProduct())
                {
                    $auction->delete();
                    $offer = null;
                }
                else
                {       
                    try
                    {
                        $offer = $api->getOffer($auction->getAuctionId());
                    }
                    catch (stAllegroException $e)
                    { 
                        $errors = stAllegroApi::getLastErrors();

                        if ($errors[0]->code == 'NOT_FOUND')
                        {
                            $messages = array();

                            foreach ($errors as $error)
                            {
                                $messages[] = $error->userMessage;
                            }

                            $this->getLogger()->error("Wystąpił błąd podczas synchronizacji oferty %offer%:\n%error%", array(
                                "%offer%" => $offerLink,
                                "%error%" => implode("\n", $messages),
                            ));

                            $auction->delete();
                            $offer = null;
                        }
                    }
                }

                if ($offer)
                {
                    if ($offer->publication->status == 'ACTIVE' || $offer->publication->status == 'ENDED')
                    {
                        $auction->getProductOptionsArray();
                        $stock = $auction->getProduct()->getStock();
        
                        $config = stConfig::getInstance('stAllegroBackend');

                        $ok = true;

                        if ($stock > 0)
                        {
                            if ($config->get('offer_sync_product_price'))
                            {
                                $allegroCommission = new AllegroCommission();

                                $price = $allegroCommission->calculatePrice($auction->getProduct()->getPriceBrutto());
                    
                                $offer->sellingMode->price->amount = $price;
                            }

                            $offer->stock->available = $stock;

                            $this->getLogger()->info('Synchronizacja oferty %offer%', array('%offer%' => $offerLink));

                            $response = $api->updateOffer($auction->getAuctionId(), $offer);

                            if ($response->validation->errors)
                            {       
                                $ok = false;

                                $messages = array();

                                foreach ($response->validation->errors as $error)
                                {
                                    $messages[] = $error->userMessage;
                                }

                                $this->getLogger()->error("Wystąpił błąd podczas synchronizacji oferty %offer%:\n%error%", array(
                                    "%offer%" => $offerLink,
                                    "%error%" => implode("\n", $messages),
                                ));
                            }
                        }

                        if ($ok)
                        {
                            if ($offer->publication->status == 'ENDED' && $stock > 0)
                            {
                                $publish[$auction->getAuctionId()] = $offerLink;
                            } 
                            elseif ($offer->publication->status == 'ACTIVE' && !$stock)
                            {                        
                                $unpublish[$auction->getAuctionId()] = $offerLink;
                            }
                        }
                    }
                }
            }
            catch(Exception $e)
            {
                $messages = array();

                foreach (stAllegroApi::getLastErrors() as $error)
                {
                    $messages[] = $error->userMessage;
                }

                $this->getLogger()->error("Wystąpił błąd podczas synchronizacji oferty %offer%:\n%error%", array(
                    "%offer%" => $offerLink,
                    "%error%" => implode("\n", $messages),
                ));
            }


            
            if (!$auction->isDeleted())
            {
                $auction->setRequiresSync(false);
                $auction->save();
            }

            $offset++;

            usleep(250000);
        }

        if ($unpublish)
        {
            $this->getLogger()->info("Zakończenie ofert %offers% z powodu braku produktów na magazynie", array('%offers%' => implode(", ", $unpublish)));
            $api->publishOffers(array_keys($unpublish), false);
        }

        if ($publish)
        {
            $this->getLogger()->info("Wznowienie ofert %offers% z powodu ponownej dostępności produktów na magazynie", array('%offers%' => implode(", ", $publish)));
            $api->publishOffers(array_keys($publish), true);
        }

        sleep(1);

        return $offset;
    }

    private function getCriteria(): Criteria
    {
        $c = new Criteria();
        $c->add(AllegroAuctionPeer::REQUIRES_SYNC, true);
        return $c;
    }

    private function getOfferLink($offerId): string
    {
        $url = $this->controller->genUrl('@stAllegroPlugin?action=edit&id='.$offerId);

        return sprintf('<a href="%s">%s</a>', $url, $offerId);
    }
}