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
 * @version     $Id: stCategoryMetaTagsGenerator.class.php 1289 2009-10-09 07:27:59Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stCategoryMetaTagsGenerator
 *
 * @package     stPositioningPlugin
 * @subpackage  libs
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */
class stCategoryMetaTagsGenerator extends stMetaTagsGenerator
{
    /**
     * Generowanie meta tagów
     *
     * @param Category $category
     */
    public function generate($category)
    {
        if (is_object($category))
        {

            $category->setCulture($this->culture);

            $categories = "";
            foreach ($category->getPath() as $categoryPath) {
                $categoryPath->setCulture($this->culture);
                $categories.= ", ".$categoryPath->getName();
            }
            
             if ($this->positioning->getTitleCategory())
            {
                $this->title = str_replace("{NAME}", $category->getName(), $this->positioning->getTitleCategory()); 
            }else{
                $this->title = $category->getName();
            }

            $this->keywords = $category->getName().$categories;
            
            if ($category->getDescription())
            {
                $this->description = mb_substr(strip_tags($category->getDescription()),0,170,'UTF-8');
            }else{
                $this->description = "";
            }
            
            
        }
    }
}