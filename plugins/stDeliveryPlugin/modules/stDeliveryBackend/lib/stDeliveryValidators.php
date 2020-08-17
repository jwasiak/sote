<?php
class stDeliveryAdditionalCostValidator extends sfValidator
{
/**
 * Executes this validator.
 *
 * @param string A parameter value
 * @param string An error message reference
 *
 * @return boolean true, if this validator executes successfully, otherwise false
 */
    public function execute(&$value, &$error)
    {
        $r = $this->getContext()->getRequest();

        if (empty($value) && $r->getParameter('delivery[section_cost_type]'))
        {
            $error = 'Musisz zdefiniować przynajmniej jeden koszt dodatkowy';
            
            return false;
        }

        $validator = new sfNumberValidator();

        $validator->initialize($this->getContext(), array(
            'min_error' => 'Wartości <b>Od</b> muszą być dodatnie i posiadać "." jako separator części dziesiętnej',
            'nan_error' => 'Wartości <b>Od</b> muszą być dodatnie i posiadać właściwy format przykład: 10.40',
            'min' => 0,
            'type' => 'any'
        ));

        $this->getContext()->getRequest()->setError('{test}', 'tescik!');

        $errors = array();

        foreach ($value as $k1 => $v1)
        {
            if (!$validator->execute($v1['from'], $error))
            {
                $errors[$error] = $error;
            }

            foreach ($value as $k2 => $v2)
            {
                if ($k1 != $k2 && floatval($v1['from']) == floatval($v2['from']))
                {
                    $errors['same'] = 'Wartości <b>Od</b> dla kosztów dodatkowych nie mogą być takie same';

                   

                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Initializes this validator.
     *
     * @param sfContext The current application context
     * @param array   An associative array of initialization parameters
     *
     * @return boolean true, if initialization completes successfully, otherwise false
     */
    public function initialize($context, $parameters = null)
    {
    // initialize parent
        parent::initialize($context);

        $this->getParameterHolder()->add($parameters);

        return true;
    }
}
?>
