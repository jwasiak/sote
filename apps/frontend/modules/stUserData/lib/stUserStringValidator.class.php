<?php
/** 
 * SOTESHOP/stUser 
 * 
 * Ten plik należy do aplikacji stUser opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stUser
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stUserStringValidator.class.php 617 2009-04-09 13:02:31Z michal $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/** 
 * Klasa przechowuje metody walidacji formularzy użytkownika.
 *
 * @author Bartosz Alejski <bartosz.alejski@sote.pl>
 *
 * @package     stUser
 * @subpackage  libs
 */
class stUserStringValidator extends sfStringValidator 
{
    /** 
     * Walidacja konta
     *
     * @param        string      $value
     * @param       integer     $error
     * @return   true
     */
    public function execute (&$value, &$error){
        
        
        $is_delivery = $this->getParameterHolder()->get('is_delivery');
        $is_required = $this->getParameterHolder()->get('is_required');
      
        if ($is_delivery && $this->getContext()->getRequest()->getParameter('different_delivery'))
        {
          
            if ($is_required && $value !== null && empty($value))
            {
                $error = $this->getParameterHolder()->get('required_error');
                return false;
            }
            
            return parent::execute($value, $error);
        }
        
        return true;

    }

    /** 
     * Inicjalizacja walidacji.
     *
     * @param        string      $context
     * @param        string      $parameters
     * @return   true
     */
    public function initialize ($context, $parameters = null){
        // Initialize parent
        parent::initialize($context);

        $this->getParameterHolder()->add($parameters);

        return true;
    }
}
