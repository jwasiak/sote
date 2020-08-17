<?php

class AllegroAuction extends BaseAllegroAuction {
    protected $productPrice = null;

    protected $productOptionsArray = null;

    public function getProductOptionsArray()
    {
        if (null === $this->productOptionsArray)
        {
            $ids = array();

            if ($this->getProduct()->getOptHasOptions() > 1)
            {
                $selected =  $this->getProductOptions() ? explode(",", $this->getProductOptions()) : array();

                $values = array();

                $index = 0;

                foreach ($selected as $id)
                {
                    $option = ProductOptionsValuePeer::retrieveByPK($id);
                    
                    if ($option)
                    {
                        $values[$index][trim($option->getOptValue())] = true;
                    }

                    $index++;
                }
                
                $product = $this->getProduct();

                if (null === $this->productPrice)
                {
                    $this->productPrice = $product->getPriceBrutto();
                }

                $ids = stNewProductOptions::updateProduct($product, $ids, $values, false);

                $price = stPrice::computePriceModifiers($product, $this->productPrice, 'brutto');

                $product->setPriceBrutto($price);

                $product->resetModified();
            
                stNewProductOptions::clearStaticPool();
            }

            $this->productOptionsArray = $ids;
        }

        return $this->productOptionsArray;
    }

    public function setProductOptions($v)
    {
        parent::setProductOptions($v);

        $this->productOptionsArray = null;
    }

    public function addCommand($uuid, $type)
    {
        $commands = $this->getCommands() ? $this->getCommands() : array();

        $commands[$type] = $uuid;

        $this->setCommands($commands);
    }

    public function getCommands()
    {
        $commands = parent::getCommands();

        return $commands ? $commands : array();
    }

    public function getCommand($type)
    {
        $commands = $this->getCommands();

        return $commands && isset($commands[$type]) ? $commands[$type] : null;
    }

    public function getEnvironment()
    {
        return 'AllegroPl';
    }

    public function getAuctionLink()
    {
        return stAllegroApi::getOfferUrl($this->getAuctionId()); 
    }
}
