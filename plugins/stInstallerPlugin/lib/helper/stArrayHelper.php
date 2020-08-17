<?php
/** 
 * SOTESHOP/stInstallerPlugin 
 * 
 * Ten plik należy do aplikacji stInstallerPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stInstallerPlugin
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stArrayHelper.php 3782 2010-03-05 13:39:42Z marek $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */

/** 
 * Łączy 2 tablice, nadpisując powtarzające się klucze.
 * W wersji array_recursive_merge2 funkcja powielala wartosci dla kluczy liczbowych. Wersja 3 nie powtarza tych wartosci.
 *
 * @author felix dot ospald at gmx dot de
 * @author Marek jakubowicz <marek.jakubowicz@sote.pl
 * @see http://pl.php.net/manual/pl/function.array-merge-recursive.php
 */
function st_array_merge_recursive3($array1, $array2)
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
             if (is_array($value) && isset($ret[$key])) {
                 // if $ret[$key] is not an array you try to merge an scalar value with an array - the result is not defined (incompatible arrays)
                 // in this case the call will trigger an E_USER_WARNING and the $ret[$key] will be null.
                 $ret[$key] = st_array_merge_recursive3($ret[$key], $value);
             }
             else {               
                 $ret[$key] = $value;                           
                
                 
             }
         }    
     }

     return $ret;
}

/** 
 * Zwraca różnicę między 2 tablicami 1 wymiarowymi.
 *
 * @param         array       $dat1
 * @param         array       $dat2
 * @return  array       array('added'=>array(), 'changed'=>array(), 'deleted'=>array(), 'all'=>array())
 */
function st_array_diff($dat1, $dat2) 
{                                                     
    $added=array();$changed=array();$deleted=array(); $all=array();
    foreach ($dat2 as $key=>$val)
    {
        if (empty($dat1[$key])) { $added[]=$key; $all[]=$key; }
         elseif ($dat1[$key]!=$val) { $changed[]=$key; $all[]=$key; }
    }                                                                   
    
    foreach ($dat1 as $key=>$val)
    {
        if (empty($dat2[$key])) { $deleted[]=$key; $all[]=$key; }
    }      
                                                            
    return array("added"=>$added,"changed"=>$changed,"deleted"=>$deleted,"all"=>$all);
}
?>
