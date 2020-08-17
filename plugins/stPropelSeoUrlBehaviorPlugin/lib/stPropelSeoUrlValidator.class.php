<?php
/**
 * SOTESHOP/stPropelSeoUrlBehaviorPlugin
 *
 * Ten plik należy do aplikacji stPropelSeoUrlBehaviorPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPropelSeoUrlBehaviorPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stPropelSeoUrlValidator.class.php 1286 2009-10-08 15:53:41Z marcin $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * Walidator sprawdzający poprawność wprowadzanych znaków zgodnie ze specyfikacją url
 *
 * @package     stPropelSeoUrlBehaviorPlugin
 * @subpackage  libs
 */
class stPropelSeoUrlValidator extends sfValidator
{
    public function execute(&$value, &$error)
    {
        $auto_fillin_field = $this->getParameterHolder()->get('auto_fillin_field');

        if (preg_match('/([^\]]+)\[([^\]]+)\]/', $auto_fillin_field, $matches))
        {
            $parent = $matches[1];
            $subname = $matches[2];

            $parent_param = $this->getContext()->getRequest()->getParameter($parent);
        }
        else
        {
            $parent = $auto_fillin_field;
        }


        $seo_error = $this->getParameterHolder()->get('seo_error');

        $value = trim($value);

        $prev = $value;

        $value = stPropelSeoUrlBehavior::makeSeoFriendly($value);

        if ($value != $prev)
        {
            $error = $seo_error;
            
            if (isset($parent_param))
            {
                $parent_param[$subname] = $value;
            }
            else
            {
                $parent_param = $value;
            }

            $this->getContext()->getRequest()->setParameter($parent, $parent_param);

            return false;
        }

        return true;
    }

    public function initialize($context, $parameters = null)
    {
        if (!isset($parameters['seo_error']))
        {
            $parameters['seo_error'] = 'Podana wartość została dostosowana do wymogów SEO. Kliknij na "Zapisz" aby zatwierdzić zmiany';
        }

        if (!isset($parameters['auto_fillin_field']))
        {
            throw new sfValidatorException('Musisz podać nazwę pola dla parametru "auto_fillin_field"');
        }

        return parent::initialize($context, $parameters);
    }
}