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
 * @version     $Id: stEditPasswordValidator.class.php 617 2009-04-09 13:02:31Z michal $
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
class stEditPasswordValidator extends sfValidator
{   
    /** 
     * Zmiana hasła użytkownika.
     *
     * @param        string      $value
     * @param       integer     $error
     * @return   true
     */
    public function execute (&$value, &$error)
    {        
        if ($this->getContext()->getUser()->checkPassword($this->getParameter('user[oldpassword]')) == false)
        {
            $error = $this->getParameter('error_message');
            return false;    
        } 
        else 
        {
            return true;
        }
    }
    
    /** 
     * Inicjalizacja walidacji.
     *
     * @param        string      $context
     * @param        string      $parameters
     * @return   true
     */
    public function initialize ($context, $parameters = null)
    {
        // Initialize parent
        parent::initialize($context);

        $user = $context->getRequest()->getParameter('user');

        $this->setParameter('user', $user);

        $this->getParameterHolder()->add($parameters);

        return true;
    }
}
