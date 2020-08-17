<?php

class stAllegroStockValidator extends sfValidator {

    public function execute(&$value, &$error) {

        if (empty($value)) {
            $error = $this->getParameter('zero_msg');
            return false;
        }

        $auction = $this->getContext()->getRequest()->getParameter('allegro_auction', null);

        $product = ProductPeer::retrieveByPk($this->getContext()->getRequest()->getParameter('product_id', null));
        if (is_object($product)) {
            if ($product->getOptHasOptions() > 1) {
                if (!isset($auction['product_options'])) {
                    $error = $this->getParameter('null_options');
                    return false;
                }
                $ids = explode(',', $auction['product_options']);
                $options = ProductOptionsValuePeer::retrieveByPKs($ids);
                stNewProductOptions::updateProductBySelectedOptions($product, $options);
            }

            $stock = (int) $product->getStock();

            $productConfig = stConfig::getInstance('stProduct');
            if ($productConfig->get('depository_enabled'))
                if ($value > $stock) {
                    $error = $this->getParameter('stock_msg');
                    return false;    
                }
        }
                
        return true;
    }

    public function initialize($context, $parameters = null) {
        parent::initialize($context);
        $this->getParameterHolder()->add($parameters);
        return true;
    }
}
