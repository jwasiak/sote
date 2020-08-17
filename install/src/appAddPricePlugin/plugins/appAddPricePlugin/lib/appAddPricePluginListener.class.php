<?php

/** 
 * SOTESHOP/stAddPricePlugin
 * 
 * 
 * @package     stAddPricePlugin
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

class appAddPricePluginListener {

	protected static $currency = null;

	protected static $enabled = false;

    public static function generateStProduct(sfEvent $event) {
       
        $event -> getSubject() -> attachAdminGeneratorFile('appAddPricePlugin', 'stProduct.yml');
       
    }

    public static function generateStGroupPrice(sfEvent $event) {
       
        $event -> getSubject() -> attachAdminGeneratorFile('appAddPricePlugin', 'stGroupPrice.yml');
       
    }

    public static function postGetAddPriceOrCreate(sfEvent $event) {
        $event['modelInstance'] -> setId($event -> getSubject() -> forward_parameters['product_id']);
    }

    public static function postGetAddGroupPriceOrCreate(sfEvent $event) {
        $event['modelInstance'] -> setId($event -> getSubject() -> forward_parameters['group_price_id']);
    }

    public static function postUpdateAddPriceFromRequest(sfEvent $event) {

        $add_price = $event -> getSubject() -> getRequestParameter('add_price');

        // print_r($event['modelInstance']);
        // print_r($add_price);
        // die();

        if (isset($add_price['currency_id'])) {
            $event['modelInstance'] -> setCurrencyId($add_price['currency_id']);
        }

        if (isset($add_price['tax_id'])) {
            $c = new Criteria();
            $c -> add(TaxPeer::ID, $add_price['tax_id']);
            $vat = TaxPeer::doSelectOne($c);

            $event['modelInstance'] -> setOptVat($vat -> getVat());
        }

        if (isset($add_price['price_netto'])) {
            $event['modelInstance'] -> setPriceNetto($add_price['price_netto']);
        }

        if (isset($add_price['price_brutto'])) {
            $event['modelInstance'] -> setPriceBrutto($add_price['price_brutto']);
        }

        if (isset($add_price['old_price_netto'])) {
            $event['modelInstance'] -> setOldPriceNetto($add_price['old_price_netto']);
        }

        if (isset($add_price['old_price_brutto'])) {
            $event['modelInstance'] -> setOldPriceBrutto($add_price['old_price_brutto']);
        }

        if (isset($add_price['wholesale']['a']['netto'])) {
            $event['modelInstance'] -> setWholesaleANetto($add_price['wholesale']['a']['netto']);
        }

        if (isset($add_price['wholesale']['a']['brutto'])) {
            $event['modelInstance'] -> setWholesaleABrutto($add_price['wholesale']['a']['brutto']);
        }

        if (isset($add_price['wholesale']['b']['netto'])) {
            $event['modelInstance'] -> setWholesaleBNetto($add_price['wholesale']['b']['netto']);
        }

        if (isset($add_price['wholesale']['b']['brutto'])) {
            $event['modelInstance'] -> setWholesaleBBrutto($add_price['wholesale']['b']['brutto']);
        }

        if (isset($add_price['wholesale']['c']['netto'])) {
            $event['modelInstance'] -> setWholesaleCNetto($add_price['wholesale']['c']['netto']);
        }

        if (isset($add_price['wholesale']['c']['brutto'])) {
            $event['modelInstance'] -> setWholesaleCBrutto($add_price['wholesale']['c']['brutto']);
        }

    }

    public static function postUpdateAddGroupPriceFromRequest(sfEvent $event) {

        $add_group_price = $event -> getSubject() -> getRequestParameter('add_group_price');

        // print_r($event['modelInstance']);
        // print_r($add_price);
        // die();

        if (isset($add_group_price['currency_id'])) {
            $event['modelInstance'] -> setCurrencyId($add_group_price['currency_id']);
        }

        if (isset($add_group_price['tax_id'])) {
            $event['modelInstance'] -> setOptVat($event['modelInstance']->getTax()->getVat());
        }

        if (isset($add_group_price['price_netto'])) {
            $event['modelInstance'] -> setPriceNetto($add_group_price['price_netto']);
        }

        if (isset($add_group_price['price_brutto'])) {
            $event['modelInstance'] -> setPriceBrutto($add_group_price['price_brutto']);
        }

        if (isset($add_group_price['old_price_netto'])) {
            $event['modelInstance'] -> setOldPriceNetto($add_group_price['old_price_netto']);
        }

        if (isset($add_group_price['old_price_brutto'])) {
            $event['modelInstance'] -> setOldPriceBrutto($add_group_price['old_price_brutto']);
        }

        if (isset($add_group_price['wholesale']['a']['netto'])) {
            $event['modelInstance'] -> setWholesaleANetto($add_group_price['wholesale']['a']['netto']);
        }

        if (isset($add_group_price['wholesale']['a']['brutto'])) {
            $event['modelInstance'] -> setWholesaleABrutto($add_group_price['wholesale']['a']['brutto']);
        }

        if (isset($add_group_price['wholesale']['b']['netto'])) {
            $event['modelInstance'] -> setWholesaleBNetto($add_group_price['wholesale']['b']['netto']);
        }

        if (isset($add_group_price['wholesale']['b']['brutto'])) {
            $event['modelInstance'] -> setWholesaleBBrutto($add_group_price['wholesale']['b']['brutto']);
        }

        if (isset($add_group_price['wholesale']['c']['netto'])) {
            $event['modelInstance'] -> setWholesaleCNetto($add_group_price['wholesale']['c']['netto']);
        }

        if (isset($add_group_price['wholesale']['c']['brutto'])) {
            $event['modelInstance'] -> setWholesaleCBrutto($add_group_price['wholesale']['c']['brutto']);
        }

    }

    public static function addAddPriceFiltersCriteria(sfEvent $event) {
        $event['criteria']->add(AddPricePeer::ID, $event -> getSubject() -> getRequestParameter('product_id'));
    }

    public static function productPostAddSelectColumns(sfEvent $event)
    {
    	if (self::getCurrency())
    	{
    		self::$enabled = true;

    		$c = $event->getSubject();

			$c->addSelectColumn(AddPricePeer::PRICE_BRUTTO);

			$c->addSelectColumn(AddPricePeer::OLD_PRICE_BRUTTO);

			$c->addSelectColumn(AddPricePeer::WHOLESALE_A_BRUTTO);

			$c->addSelectColumn(AddPricePeer::WHOLESALE_B_BRUTTO);

			$c->addSelectColumn(AddPricePeer::WHOLESALE_C_BRUTTO);

			$c->addSelectColumn(AddPricePeer::TAX_ID);

			$c->addSelectColumn(AddPricePeer::OPT_VAT);			
    	}
    	else
    	{
    		self::$enabled = false;
    	}
    }

    public static function preDoSelectRs(sfEvent $event)
    {
    	if (self::$enabled)
    	{
            AddPricePeer::addJoinCriteria($event->getSubject(), self::getCurrency());
	    	self::$enabled = false;
    	}
    }

    public static function productPostHydrate(sfEvent $event)
    {
    	if (self::getCurrency())
    	{
    		$product = $event->getSubject();

    		$parameters = $event->getParameters();

    		$row = $parameters['resultset']->getRow();

    		$startcol = $parameters['startcol'] - 1;

    		if ($product->getCurrencyId() != self::getCurrency()->getId() && $row[$startcol] !== null)
    		{
                $product->setTaxId((float)$row[$startcol + 5]);

                $product->setOptVat((float)$row[$startcol + 6]);

                $product->setCurrencyId(self::getCurrency()->getId());

                $product->setHasFixedCurrency(false);

                if (!self::getCurrency()->getIsSystemCurrency())
                {
    	    		$product->setCurrencyPrice((float)$row[$startcol]);

    	    		$product->setCurrencyOldPrice((float)$row[$startcol + 1]);

    	    		$product->setCurrencyWholesaleA((float)$row[$startcol + 2]);

    	    		$product->setCurrencyWholesaleB((float)$row[$startcol + 3]); 

    	    		$product->setCurrencyWholesaleC((float)$row[$startcol + 4]);
                }
                else
                {
                    $product->setPriceBrutto((float)$row[$startcol]);  
                    $product->setOldPriceBrutto((float)$row[$startcol + 1]);
                    $product->setWholesaleABrutto((float)$row[$startcol + 2]);
                    $product->setWholesaleBBrutto((float)$row[$startcol + 3]); 
                    $product->setWholesaleCBrutto((float)$row[$startcol + 4]);                  
                }

	    		$product->_previousCurrencyExchange = $product->getCurrencyExchange();

	    		$product->setCurrencyExchange(self::getCurrency()->getExchange());    		

	    		$product->resetModified();
    		}

    		$event->offsetSet('startcol', $startcol + 8);
    	}
    }

    public static function addAddGroupPriceFiltersCriteria(sfEvent $event) 
    {
        $event['criteria']->add(AddGroupPricePeer::ID, $event->getSubject()->getRequestParameter('group_price_id'));
    }

    public static function productOptionsValuePostHydrate(sfEvent $event)
    {
        if (self::getCurrency() && $event->getSubject()->getProduct() && isset($event->getSubject()->getProduct()->_previousCurrencyExchange))
        {
            $option = $event->getSubject();

            if (strpos($option->getPrice(), '%') === false) 
            {
                $exchange = $option->getProduct()->_previousCurrencyExchange;

                if ($option->getPrice() != 0)
                {
                    $price = $option->getPrice();

                    $prefix = $price[0] == '+' || $price[0] == '-' ? $price[0] : '';

                    $price = $exchange != 1 ? stCurrency::calculateCurrencyPrice(floatval($price), $exchange, true) : floatval($price);

                    $option->setPrice($prefix.stCurrency::calculateCurrencyPrice($price, $option->getProduct()->getCurrencyExchange()));
                }

                if ($option->getOldPrice() > 0)
                {

                    $price = $exchange != 1 ? stCurrency::calculateCurrencyPrice($option->getOldPrice(), $exchange, true) : $option->getOldPrice();

                    $option->setOldPrice(stCurrency::calculateCurrencyPrice($price, $option->getProduct()->getCurrencyExchange()));
                }

                $option->resetModified();
            }
        }
    }

    protected static function getCurrency()
    {
    	if (null === self::$currency)
    	{
    		self::$currency =  stCurrency::getInstance(sfContext::getInstance())->get();
    	}

    	return self::$currency;
    }
}
