<?php
/** 
 * SOTESHOP/stOrder 
 * 
 * Ten plik należy do aplikacji stOrder opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stOrder
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stOrderValidator.class.php 31 2009-08-24 13:59:34Z marcin $
 */

/** 
 * SOTESHOP/stOrder
 * Ten plik należy do aplikacji stOrder opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stOrder
 * @subpackage  libs
 */
class stOrderValidator extends sfValidator
{
    
    
    public function execute(&$value, &$error)
    {
        $constants = array('NUMER', 'DZIEN', 'MIESIAC', 'ROK');
        
        if (strpos($value, '{NUMER}') === false)
        {
            $error = 'Parametr {NUMER} jest wymagany...';
            return false;
        }
        
        if (preg_match('/[^a-zA-Z0-9{}_\/,. -]+/', $value))
        {
            $error = 'Format może zawierać wyłącznie litery alfabetu angielskiego (a-z), cyfry oraz znaki "/.,-"'; 
            return false;
        }
        
        preg_match_all('/{([^}]+)}/', $value, $matches, PREG_PATTERN_ORDER);
        
        foreach ($matches[1] as $name)
        {
            if (array_search($name, $constants) === false)
            {
                $error = 'Podany parametr {'.$name.'} nie istnieje...';
                return false;
            }
        }
        
        return true;
    }
}
?>