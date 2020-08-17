<?php

class stAllegroVariantsValidator extends sfValidator {

    public function execute(&$value, &$error) {

        $product = ProductPeer::retrieveByPk($this->getContext()->getRequest()->getParameter('product_id', null));

        $i18n = $this->getContext()->getI18n();

        $variant = null;
        foreach ($value['attributes'] as $attributeId => $attribute) {
            $attributeJson = json_decode($attribute['attribute'], true);
            if ($attributeJson['sellFormTitle'] == 'Rozmiar') {
                $variant = $attribute;
                break;
            }
        }

        if ($variant !== null) {
            $size = array_combine(explode('|', $attributeJson['sellFormOptsValues']), explode('|', $attributeJson['sellFormDesc']));
            if ($product->getOptHasOptions() > 1) {

                if (!isset($variant['value']) || empty($variant['value'])) {
                    $error = $i18n->__('<b>(Rozmiar)</b> - proszę wybrać minimuj jedną opcje.');
                    return false;
                }

                $variant['options'];
                foreach ($variant['value'] as $id) {
                    if (empty($variant['quantity'][$id])) {
                        $error = $i18n->__('<b>(Rozmiar: %size%)</b> - ilość produktów do wystawienia musi być większa od 0.', array('%size%' => $size[$id]));
                        return false;
                    }

                    if (!isset($variant['options'][$id]) && empty($variant['options'][$id])) {
                        $error = $i18n->__('<b>(Rozmiar: %size%)</b> - każda opcja musi mieć wybraną opcje produktów.', array('%size%' => $size[$id]));
                        return false;   
                    }

                    $options = ProductOptionsValuePeer::retrieveByPKs(explode(',', $variant['options'][$id]));
                    stNewProductOptions::updateProductBySelectedOptions($product, $options);

                    if ($variant['quantity'][$id] > $product->getStock()) {
                        $error = $i18n->__('<b>(Rozmiar: %size%)</b> - brak dostępnej ilości produktów w magazynie.', array('%size%' => $size[$id]));
                        return false;
                    }
                }
            } else {
                $sumStock = 0;
                foreach ($variant['quantity'] as $key => $quantity) {
                    if (isset($variant['value'][$key])) {
                        $sumStock += (int) $quantity;
                        if ((int) $quantity == 0) {
                            $error = $i18n->__('<b>(Rozmiar: %size%)</b> - ilość produktów do wystawienia musi być większa od 0.', array('%size%' => $size[$id]));
                            return false;
                        }
                    }
                }

                if ($sumStock > $product->getStock()) {
                    $error = $i18n->__('<b>(Rozmiar: %size%)</b> - brak dostępnej ilości produktów w magazynie.', array('%size%' => $size[$id]));
                    return false;
                }
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
