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
 * @version     $Id: stTextHelper.php 7 2009-08-24 08:59:30Z michal $
 */

/** 
 * Skraca tekst o podaną ilość znaków
 *
 * @author Krzysztof Bebło krzysztof.beblo@sote.pl 
 * @param   string      $text               tekst do obcięcia 
 * @param   integer     $number_of_sign     ile znaków ma być w obciętym tekście 
 * @param   string      $end_sign           zakończenie obciętego tekstu 
 * @return  string      skrócony tekst 
 */
function st_truncate_text($text,$number_of_sign,$end_sign=null)
{
    $text=mb_substr(strip_tags($text),0,$number_of_sign,'UTF-8');
    if (($end_sign) && ($text))
    {
        $text.=$end_sign;
    }
    return $text;
}

/** 
 * Sprawdza ile dany tekst ma długości
 *
 * @param        string      $text
 * @return   integer
 */
function st_check_strlen($text)
{
    $lenght=mb_strlen($text); 
    return $lenght;   
}