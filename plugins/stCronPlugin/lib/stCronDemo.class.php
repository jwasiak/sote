<?php
/** 
 * SOTESHOP/stCronPlugin 
 * 
 * Ten plik należy do aplikacji stCronPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stCronPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stCronDemo.class.php 3018 2008-12-09 17:15:25Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa stCronDemo
 *
 * @package     stCronPlugin
 * @subpackage  libs
 */
class stCronDemo
{
    /** 
     * Testowa metoda
     */
    public function testFunction()
    {
        print "Time is: ".date('H:i:s')." <br />\nDate is: ".date('Y.m.d');
    }
}