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
 * @version     $Id: stProducerMetaTagsGenerator.class.php 3628 2010-02-22 09:24:13Z michal $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/**
 * Klasa stProducerMetaTagsGenerator
 *
 * @package     stPositioningPlugin
 * @subpackage  libs
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */
class stProducerMetaTagsGenerator extends stMetaTagsGenerator
{
    /**
     * Generowanie meta tagów
     *
     * @param Producer $producer
     */
    public function generate($producer)
    {
        if (is_object($producer))
        {
            $producer->setCulture($this->culture);
            
            if ($this->positioning->getTitleManufacteur())
            {
                $this->title = str_replace("{NAME}", $producer->getName(), $this->positioning->getTitleManufacteur()); 
            }else{
                $this->title = $producer->getName();
            }

            $this->keywords = $producer->getName();
            
            if ($producer->getDescription())
            {
                $this->description = mb_substr(strip_tags($producer->getDescription()),0,170,'UTF-8');
            }else{
                $this->description = "";
            }
        }
    }

    
}