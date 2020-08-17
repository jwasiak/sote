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
 * @version     $Id: stSessionStorage.php 7 2009-08-24 08:59:30Z michal $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/** 
 * Klasa rozszerzająca obsługe sesji w symfony - separacja sesji pomiędzy aplikacjami
 *
 * @package     stBase
 * @subpackage  libs
 */
class stSessionStorage extends sfSessionStorage
{
    /** 
     * Reads data from this storage.
     * The preferred format for a key is directory style so naming conflicts can be avoided.
     *
     * @param   string      A                   unique key identifying your data
     * @return  mixed       Data associated with the key
     */
    public function &read($key)
    {
        return parent::read(SF_APP . '/' . $key);
    }
    
    /** 
     * Removes data from this storage.
     * The preferred format for a key is directory style so naming conflicts can be avoided.
     *
     * @param   string      A                   unique key identifying your data
     * @return  mixed       Data associated with the key
     */
    public function &remove($key)
    {
        return parent::remove(SF_APP . '/' . $key);
    }
    
    /** 
     * Writes data to this storage.
     * The preferred format for a key is directory style so naming conflicts can be avoided.
     *
     * @param   string      A                   unique key identifying your data
     * @param   mixed       Data                associated with your key
     */
    public function write($key, &$data)
    {
        parent::write(SF_APP . '/' . $key, $data);
    }
}