<?php

class stAllegroImageValidator extends sfValidator {

    public function execute(&$value, &$error) {
        if (isset($value['selected']) && count($value['selected']) > 16) {
            $error = $this->getParameter('msg');
            return false;
        }
        return true;
    }

    public function initialize($context, $parameters = null) {
        parent::initialize($context);
        $this->getParameterHolder()->add($parameters);
        return true;
    }
}
