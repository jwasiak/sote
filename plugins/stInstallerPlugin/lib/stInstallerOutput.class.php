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
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stInstallerOutput.class.php 3782 2010-03-05 13:39:42Z marek $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */

/** 
 * Klasa abstrakcyjna definicująca wyświetlanie komuniakatów dla obiektów klasy stInstaller
 *
 * @package     stInstallerPlugin
 * @subpackage  libs
 */
abstract class stInstallerOutput
{   
    /** 
     * Wyświetla komunikat.
     *
     * @param        string      $message
     */
    abstract public function message($message='');                      
   
     /** 
      * Otwiera progressbar
      *
      * @param          data        $array
      */
     abstract public function progressBarStart($data=array());
     
     /** 
      * Zamyka progressbar
      */
     abstract public function progressBarEnd();
    
    /** 
     * Wywołuje kolejny krok w pasku postępu (progressbar)
     *
     * @param   array       $data               dane potrzebne do wyświetlenia paska postępu  
     */
    abstract public function progressBarStep($data=array());
        
    /** 
     * Otwiera listę wyników
     */
    abstract public function listStart();            
    
    /** 
     * Dodaje element do listy
     *
     * @param   array       $data               dane potrzebne do wyświetlenia elementu listy  
     */
    abstract public function listAddItem($data=array());

    /** 
     * Żamyka listę wyników
     */
    abstract public function listEnd(); 
    
}     


