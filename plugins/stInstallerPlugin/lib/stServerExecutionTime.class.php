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
 * @version     $Id: stServerExecutionTime.class.php 3782 2010-03-05 13:39:42Z marek $
 * @author     Daniel Mendalka <daniel.mendalka@sote.pl>
 */
 
 /** 
  *
  * @package     stInstallerPlugin
  * @subpackage  libs
  */
class stServerExecutionTime
{
    
    /**
     * @var integer Ile czasu jest wymagane w sekundach.
     */
    var $max = 60;
                    
    /**
     * Ustawia wymagany czas do wykonania skryptu.
     *
     * @param integer
     */
    public function setMax($new_max)
    {
        $this->max = $new_max;
    }
       
    /**
     * Zwraca zapisany czasy wymagany do wykonania skryptu.
     *
     * @return integer
     */
    public function getMax()
    {
        return $this->max;
    }
    
    /**
     * Sprawdza czy wymagany czas wykonywania skryptu jest mnieszy
     * niż dozwolony na serwerze.
     *
     * @return boolen
     */
    public function check()
    {        
        if ($this->getServerTime() == 0) return true;
        return $this->getServerTime() >= $this->getMax();
    }
    
    /**
     * Zwraca dozwolony czas wykonywania skryptu na serwerze.
     *
     * @return integer
     */   
    public function getServerTime()
    {
        return ini_get('max_execution_time');
    }

}
 