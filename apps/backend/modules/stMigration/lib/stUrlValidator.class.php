<?php
/** 
 * SOTESHOP/stMigration 
 * 
 * Ten plik należy do aplikacji stMigration opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *  
 * @package     stMigration
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stUrlValidator.class.php 617 2009-04-09 13:02:31Z michal $
 */

/** 
 * Walidacja aplikacji stMigration
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @package     stMigration
 * @subpackage  libs
 */
class stUrlValidator extends sfUrlValidator 
{
    public function execute(&$value, &$error)
    {
        if (!parent::execute($value, $error))
        {
            return false;
        }
        
        $value = str_replace("http://", "", $value);

        if (gethostbyname($value) == $value)
        {
            $error = $this->getParameterHolder()->get('domain_error');
            
            return false;
        }
        
        return true;
    }
    
    public function initialize($context, $parameters = null)
    {
        parent::initialize($context, $parameters);
        
        $this->getParameterHolder()->set('domain_error', 'Podany adres nie istnieje');
        
        
        
        
    }
}
?>