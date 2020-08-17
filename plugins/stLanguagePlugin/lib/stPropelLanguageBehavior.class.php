<?php
/** 
 * SOTESHOP/stLanguagePlugin 
 * 
 * Ten plik należy do aplikacji stLanguagePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stLanguagePlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stPropelLanguageBehavior.class.php 9 2009-08-24 09:31:16Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stPropelLanguageBehavior
 * 
 * @package     stLanguagePlugin
 * @subpackage  libs
 */
class stPropelLanguageBehavior
{
    /**
     * Zmienna $doNothing
     * @var bool
     */
    protected $doNothing = false;
    
    /**
     * Funkcja addDoSelectRS
     * 
     * @param $objectName
     * @param $criteria
     * @param $con
     */
    public function addDoSelectRS($objectName, Criteria $criteria, $con = null)
    {
        if ($criteria->containsKey(constant($objectName.'::CULTURE')) && $this->doNothing == false)
        {
            $this->doNothing = true;

            $rs = call_user_func(array($objectName, 'doSelectRS'), $criteria, $con);
            
            $this->doNothing = false;

            if (!$rs->getRecordCount())
            {
                $criteria->add(constant($objectName.'::CULTURE'), 'pl_PL');
            }
        }
    }
}