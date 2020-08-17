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
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 8827 2010-10-20 08:59:34Z piotr $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa stProgressBarComponents
 *
 * @package     stProgressBarPlugin
 * @subpackage  actions
 */
class stProgressBarComponents extends sfComponents
{
    /** 
     * Wyświetlanie paska postępu
     */
    public function executeProgressBar()
    {
    }
    
    /** 
     * Wywołanie paska postępu z helper'a
     */
    public function executeInitProgressBar() 
    {
        $parameters = array('class' => $this->class,
                            'method' => $this->method,
                            'steps' => $this->steps,
                            );

        $class = new $this->class;
        
        $this->msg = '';
        $this->title = '';
        
        //if (method_exists($class,"getMessage")) {
        //    $this->msg = $class->{"getMessage"}();
        //}

        if (method_exists($class,"getTitle")) {
            $this->title = $class->{"getTitle"}();
        }                                
                            
        $this->getUser()->getAttributeHolder()->remove($this->name, 'soteshop/stProgressBarPlugin');
        $this->getUser()->setAttribute($this->name, $parameters, 'soteshop/stProgressBarPlugin');
    }
}