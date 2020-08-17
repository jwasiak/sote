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
 * @version     $Id: actions.class.php 8545 2010-10-01 09:01:58Z piotr $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa stProgressBarActions
 *
 * @package     stProgressBarPlugin
 * @subpackage  actions
 */
class stProgressBarActions extends sfActions
{
    /** 
     * Akcja Process
     */
    public function executeProcess()
    {
    	$this->msg = '';
    	$this->fatal_msg = '';
    	$this->title = '';
        $this->setLayout(false);
        $this->name = $this->getRequestParameter('name');

        $this->progressBarInformation = $this->getUser()->getAttribute($this->name, array(), 'soteshop/stProgressBarPlugin');
        
        if(!isset($this->progressBarInformation['class']) || !isset($this->progressBarInformation['method']) || !isset($this->progressBarInformation['steps'])) {
            $pbFile = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'progressBar_'.$this->name.'.yml';
            $data = sfYaml::load($pbFile);
            $this->class = $data['class'];
            $this->method = $data['method'];
            $this->steps = $data['steps'];
        } else {
            $this->class = $this->progressBarInformation['class'];
            $this->method = $this->progressBarInformation['method'];
            $this->steps = $this->progressBarInformation['steps'];
        }

        
        $this->step = $this->getRequestParameter('step',0);

        if ($this->steps == 0)
        {
            $this->complete = 100;
        }
        
        $class = new $this->class;

        if ($this->step == 0) {
            if (method_exists($class,"init"))
            {
                $class->{"init"}();
            }
        }

        if ($this->step < $this->steps)
        {
            $this->makeNextProgress = true;
            if (is_callable(array($class,$this->method)))
            {
                $this->step = $class->{$this->method}($this->step);
            } else {
                $this->step = $this->steps;
            }
        } else {
            $this->makeNextProgress = false;
            $this->step = $this->steps;
            if (method_exists($class,"close"))
            {
                $class->{"close"}();
            }
        }

        $this->complete = number_format(100*$this->step/$this->steps, 1);
        
        if (method_exists($class,"getMessage")) {
        	$this->msg = $class->{"getMessage"}();
        }

        if (method_exists($class,"getTitle")) {
            $this->title = $class->{"getTitle"}();
        }
        
        if (method_exists($class,"getFatalMessage")) {
        	$this->fatal_msg = $class->{"getFatalMessage"}();
        }
        
    }
}