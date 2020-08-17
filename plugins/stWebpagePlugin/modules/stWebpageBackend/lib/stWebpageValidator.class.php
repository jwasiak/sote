<?php
/** 
 * SOTESHOP/stWebpagePlugin 
 * 
 * Ten plik należy do aplikacji stWebpagePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stWebpagePlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stWebpageValidator.class.php 392 2009-09-08 14:55:35Z michal $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/** 
 * Walidacja formularza do stWebpagePluginBackend.
 *
 * @author Daniel Mendalka <daniel.mendalka@sote.pl>
 *
 * @package     stWebpagePlugin
 * @subpackage  libs
 */
class stWebpageValidator extends sfValidator
{   
    /** 
     * Sprawdzenie czy pola są wypełnione gdy $value = true.
     *
     * @param        string      $value
     * @param       integer     $error
     * @return   bool
     */
    public function execute(&$value, &$error)
    {   
        
        if(ereg("http://", $value))
        {
            return true;
        }
        elseif(ereg("https://", $value))
        { 
            return true;
        }
        else{
             $error = $this->getParameterHolder()->get('domain_error');
            return false;
        }
    }
    
    /** 
     * Inicjalizacja walidacji.
     *
     * @param        string      $context
     * @param        string      $parameters
     * @return   true
     */
    public function initialize($context, $parameters = null)
    {
        parent::initialize($context);
        $this->getParameterHolder()->set('domain_error', 'Invalid domain');
        $this->getParameterHolder()->add($parameters);
        return true;
    }
}
