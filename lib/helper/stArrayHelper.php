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
 * @version     $Id: stArrayHelper.php 7 2009-08-24 08:59:30Z michal $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */

/** 
 * Łączy 2 tablice, nadpisując powtarzające się klucze.
 *
 * @author felix dot ospald at gmx dot de
 * @see http://pl.php.net/manual/pl/function.array-merge-recursive.php
 */
function array_merge_recursive2($array1, $array2)
 {
     $arrays = func_get_args();
     $narrays = count($arrays);

     // check arguments
     // comment out if more performance is necessary (in this case the foreach loop will trigger a warning if the argument is not an array)
     for ($i = 0; $i < $narrays; $i ++) {
         if (!is_array($arrays[$i])) {
             // also array_merge_recursive returns nothing in this case
             trigger_error('Argument #' . ($i+1) . ' is not an array - trying to merge array with scalar! Returning null!', E_USER_WARNING);
             return;
         }
     }

     // the first array is in the output set in every case
     $ret = $arrays[0];

     // merege $ret with the remaining arrays
     for ($i = 1; $i < $narrays; $i ++) {
         foreach ($arrays[$i] as $key => $value) {
             if (((string) $key) === ((string) intval($key))) { // integer or string as integer key - append
                 $ret[] = $value;
             }
             else { // string key - megre
                 if (is_array($value) && isset($ret[$key])) {
                     // if $ret[$key] is not an array you try to merge an scalar value with an array - the result is not defined (incompatible arrays)
                     // in this case the call will trigger an E_USER_WARNING and the $ret[$key] will be null.
                     $ret[$key] = array_merge_recursive2($ret[$key], $value);
                 }
                 else {
                     $ret[$key] = $value;
                 }
             }
         }    
     }

     return $ret;
 }