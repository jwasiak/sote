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
 * @version     $Id: stProductGroupMetaTagsGenerator.class.php 1289 2009-10-09 07:27:59Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stProductGroupMetaTagsGenerator
 *
 * @package     stPositioningPlugin
 * @subpackage  libs
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */
class stProductGroupMetaTagsGenerator extends stMetaTagsGenerator
{
    /**
     * Generowanie meta tagów
     *
     * @param ProductGroup $productGroup
     */
    public function generate($productGroup)
    {
        if (is_object($productGroup))
        {

            $productGroup->setCulture($this->culture);
            
            if ($this->positioning->getTitleProductGroup())
            {
                $this->title = str_replace("{NAME}", $productGroup->getName(), $this->positioning->getTitleProductGroup());
            }else{
                $this->title = $productGroup->getName();
            }
            
            $this->keywords = $productGroup->getName();
            
            $this->description = "";
        }
    }
}