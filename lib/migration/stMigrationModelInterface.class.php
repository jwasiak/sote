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
 * @version     $Id: stMigrationModelInterface.class.php 617 2009-04-09 13:02:31Z michal $
 */

/** 
 * Interfejs modelu danych
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @package     stMigration
 * @subpackage  libs
 */
interface stMigrationModelInterface
{
    public function preSave($object);
    
    public function postSave($object);
    
    public function postCreate($object);
    
    public function validateFillin($object, $data = array());
}
?>