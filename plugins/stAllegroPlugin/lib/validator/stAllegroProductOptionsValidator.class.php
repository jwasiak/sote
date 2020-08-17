<?php

class stAllegroProductOptionsValidator extends sfValidator {

    public function execute(&$value, &$error) {
        $product = ProductPeer::retrieveByPk($this->getContext()->getRequest()->getParameter('product_id', null));

        if (is_object($product)) {
            if (empty($value) && $product->getOptHasOptions() > 1) {
                $error = $this->getParameter('msg');
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
