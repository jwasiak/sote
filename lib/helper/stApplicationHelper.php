<?php
use_helper('stUrl');

/** 
 * SOTESHOP/stApplication 
 * 
 * Ten plik należy do aplikacji stApplication opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stApplication
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stApplicationHelper.php 3123 2008-12-10 13:29:11Z marek $
 * @author      Marcin Olejniczak <marcin.olejniczak@sote.pl>
 */

/** 
 * Helper obsługujący aplikacje
 */
function getApplicationName($module_name)
{
    $applications = stApplication::getApps();
    foreach ($applications as $application)
    {
        if ($application==stApplication::getAppName($module_name))
        {
            $is_main=true;
            break;
        }
        else
        {
            $is_main=false;
        }
    }
    if ($is_main)
    {
        return stApplication::getAppName($module_name);
    } 
}
