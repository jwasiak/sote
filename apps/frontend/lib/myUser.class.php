<?php
/** 
 * SOTESHOP/stFrontend 
 * 
 * Ten plik należy do aplikacji stFrontend opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stFrontend
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: myUser.class.php 9 2009-08-24 09:31:16Z michal $
 */

/** 
 * MyUser Class
 *
 * @package stFrontend
 * @author Marek Jakubowicz <marek.jakubowicz@sote.pl>
 * @todo sprawdzic z factory
 */
                                
$wrapper_dir=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'indep'.DIRECTORY_SEPARATOR;
if (file_exists($wrapper_dir.'stWrapper4stUser.php')) 
{                                                                      
    // ominiecie autoload
    // w plikach objetych autoload'em nie moga byc 2 klasy o tej samej nazwie, dlatego ladoana jest tu klasa z innej lokalizacji
    require_once ($wrapper_dir.'stWrapper4stUser.php');
} else {
    require_once ($wrapper_dir.'stWrapper4stFrontend.php');  
}                           
       
/** 
 *
 * @package     stFrontend
 * @subpackage  libs
 */
class myUser extends stWrapper4User
{
    
}                
