<?php

class AllegroCommission
{
    protected $config;

    public function __construct()
    {
        $this->config = stConfig::getInstance('stAllegroBackend');
    }

    public function calculatePrice($price)
    {
        $commission = $this->config->get('offer_product_commission');

        if ($commission && $commission['commission'] > 0) 
        {
            $price = stPrice::calculate($price, $commission['commission']);

            if ($commission['round_type'] == 'full_buck')
            {
                $price = stPrice::round($price, 0);
            }
        }

        return stPrice::round($price);
    }
}