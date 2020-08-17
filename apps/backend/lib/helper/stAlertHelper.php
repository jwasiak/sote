<?php
/** 
 * SOTESHOP/stBackend 
 * 
 * Ten plik należy do aplikacji stBackend opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stBackend
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stAlertHelper.php 9 2009-08-24 09:31:16Z michal $
 * @author      Łukasz Andrzejak <lukasz.andrzejak@sote.pl>
 */

/** 
 * Ładujemy komunikaty widoczne na głównej stronie, wedle modułu
 *
 * @param        string      $module
 * @return   string
 */
function stAlert($module)
{
    if (empty($module)) return;
    include(sfConfig::get('sf_app_module_dir').'/'.$module.'/lib/'.$module.'MainFunctions.class.php');
    if(class_exists($module.'MainFunctions')) {
        return call_user_func($module.'MainFunctions::alertMessage');
    } else return;
}