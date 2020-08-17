<?php
/** 
 * SOTESHOP/stProgressBarPlugin 
 * 
 * Ten plik należy do aplikacji stProgressBarPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stProgressBarPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stProgressBarDemo.class.php 9 2009-08-24 09:31:16Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa stProgressBarDemo
 *
 * @package     stProgressBarPlugin
 * @subpackage  libs
 */
class stProgressBarDemo {
    
    /** 
     * Testowa metoda
     *
     * @param   integer     $step               numer wykonywanego kroku
     * @return  integer     numer kolejnego kroku
     */
    public function demo($step)
    {
        sleep(1);
        // if($step == 10)
        //        {
        //            $context = sfContext::getInstance();
        //            $context->getUser()->setAttribute('stProgressBar-stProgressBarDemo', 'test', 'symfony/flash');
        //        }  

        return $step+1;
    }
    
    public function getMessage() {
    	return "Testowy napis";
    }
}