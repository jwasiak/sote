<?php
class stLanguageDomainValidator extends sfValidator
{
    public function execute(&$value, &$error)
    {        
        if ($value == gethostbyname($value) && (!function_exists('idn_to_ascii') || $value == gethostbyname(idn_to_ascii($value))))
        {
            $error = $this->getParameterHolder()->get('domain_error');
            return false;
        }

        return true;
    }

    public function initialize($context, $parameters = null)
    {
        parent::initialize($context);

        $this->getParameterHolder()->set('domain_error', 'Invalid domain');
        $this->getParameterHolder()->add($parameters);
        return true;
    }
}