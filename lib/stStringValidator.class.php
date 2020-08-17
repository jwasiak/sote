<?php
/** 
 * SOTESHOP/stBase 
 * 
 * Ten plik należy do aplikacji stBase opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stBase
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stStringValidator.class.php 7 2009-08-24 08:59:30Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa stStringValidator
 *
 * @package     stBase
 * @subpackage  libs
 */
class stStringValidator extends sfStringValidator
{
    /** 
     * Executes this validator.
     *
     * @param   mixed       A                   parameter value
     * @param   error       An                  error message reference
     * @return  bool        true, if this validator executes successfully, otherwise false
     */
    public function execute(&$value, &$error)
    {
        $decodedValue = sfToolkit::isUTF8($value) && function_exists('utf8_decode') ? utf8_decode($value) : $value;

        $min = $this->getParameterHolder()->get('min');
        if ($min !== null && strlen(trim($decodedValue)) < $min)
        {
            // too short
            $error = $this->getParameterHolder()->get('min_error');

            return false;
        }

        $max = $this->getParameterHolder()->get('max');
        if ($max !== null && strlen(trim($decodedValue)) > $max)
        {
            // too long
            $error = $this->getParameterHolder()->get('max_error');

            return false;
        }

        $values = $this->getParameterHolder()->get('values');
        if ($values !== null)
        {
            if ($this->getParameterHolder()->get('insensitive'))
            {
                $value = strtolower($value);
                $found = false;
                foreach ($values as $avalue)
                {
                    if ($value == strtolower($avalue))
                    {
                        $found = true;
                        break;
                    }
                }
                if (!$found)
                {
                    // can't find a match
                    $error = $this->getParameterHolder()->get('values_error');

                    return false;
                }
            }
            else
            {
                if (!in_array($value, (array) $values))
                {
                    // can't find a match
                    $error = $this->getParameterHolder()->get('values_error');

                    return false;
                }
            }
        }

        $allow_tags = $this->getParameterHolder()->get('allow_tags');
        $allow_tags = !is_array($allow_tags) ? array($allow_tags) : $allow_tags;
        if ($this->getParameterHolder()->get('check_tags'))
        {
            if (strip_tags($decodedValue, implode('',$allow_tags)) != $decodedValue)
            {
                // Incorrect tags
                $error = $this->getParameterHolder()->get('allow_tags_error');

                return false;
            }
        }

        if(eregi('script', $decodedValue))
        {
            // Incorrect tags
            $error = $this->getParameterHolder()->get('allow_tags_error');

            return false;
        }

        return true;
    }

    /** 
     * Initializes this validator.
     *
     * @param   string      The                 current application context
     * @param   array       An                  associative array of initialization parameters
     * @return  bool        true, if initialization completes successfully, otherwise false
     */
    public function initialize($context, $parameters = null)
    {
        // initialize parent
        parent::initialize($context);

        // set defaults
        $this->getParameterHolder()->set('insensitive',  false);
        $this->getParameterHolder()->set('max',          null);
        $this->getParameterHolder()->set('max_error',    'Input is too long');
        $this->getParameterHolder()->set('min',          null);
        $this->getParameterHolder()->set('min_error',    'Input is too short');
        $this->getParameterHolder()->set('values',       null);
        $this->getParameterHolder()->set('values_error', 'Invalid selection');
        $this->getParameterHolder()->set('values',       null);


        $this->getParameterHolder()->set('allow_tags_error', 'Incorrect tags in input');
        $this->getParameterHolder()->set('allow_tags',   null);


        $this->getParameterHolder()->add($parameters);

        return true;
    }
}