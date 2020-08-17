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
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stDateHelper.php 6492 2010-07-15 12:14:08Z pawel $
 */

use_helper('Date');

function st_format_date($date, $format = 'dd-MM-yyyy, HH:mm', $additionalFormat = true)
{
    static $dateFormats = array();
    
    if (is_null($date))
    {
        return '';
    }

    if (is_string($date))
    {
        $date = strtotime($date);
    }
    
    $culture = sfContext::getInstance()->getUser()->getCulture();
    
    $charset = sfConfig::get('sf_charset');
    
    if (!isset($dateFormats[$culture]))
    {
        $dateFormats[$culture] = new sfDateFormat($culture);
    }
    
    $cdate = $dateFormats[$culture]->format($date, 'd');
    
    $tdate = $dateFormats[$culture]->format(time(), 'd');
    
    $ydate = $dateFormats[$culture]->format(time() - (3600 * 24), 'd');
    
    if ($additionalFormat)
    {
        if ($cdate == $tdate && $format == 'dd-MM-yyyy, HH:mm')
        {
            return __('Dzisiaj o', null, 'stAdminGeneratorPlugin') . ' ' . $dateFormats[$culture]->format($date, 't');
        }
        
        if ($cdate == $ydate && $format == 'dd-MM-yyyy, HH:mm')
        {
            return __('Wczoraj o', null, 'stAdminGeneratorPlugin') . ' ' . $dateFormats[$culture]->format($date, 't');
        }
    }
    
    return $dateFormats[$culture]->format($date, $format);
}
