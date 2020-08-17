<?php
/**
 * SOTESHOP/stPositioningPlugin
 *
 * Ten plik należy do aplikacji stPositioningPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPositioningPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stWebpageMetaTagsGenerator.class.php 1289 2009-10-09 07:27:59Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stWebpageMetaTagsGenerator
 *
 * @package     stPositioningPlugin
 * @subpackage  libs
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */
class stWebpageMetaTagsGenerator extends stMetaTagsGenerator
{
    /**
     * Generowanie meta tagów
     *
     * @param Webpage $webpage
     */
    public function generate($webpage)
    {
        if (is_object($webpage))
        {
            
            $webpage->setCulture($this->culture);
            
            if ($this->positioning->getTitleWebpage())
            {
                $this->title = str_replace("{NAME}", $webpage->getName(), $this->positioning->getTitleWebpage()); 
            }else{
                $this->title = $webpage->getName();
            }
            
            $this->keywords = $webpage->getName();
            
            if ($webpage->getContent())
            {
                $this->description = mb_substr(strip_tags($webpage->getContent()),0,170,'UTF-8');
            }else{
                $this->description = "";
            }
           
        }
    }
}