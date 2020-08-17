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
 * @version     $Id: stBlogMetaTagsGenerator.class.php 1289 2009-10-09 07:27:59Z pawel $
 * @author      Pawel Byszewski <pawel.byszewski@sote.pl>
 */

/**
 * Klasa stBlogMetaTagsGenerator
 *
 * @package     stPositioningPlugin
 * @subpackage  libs
 * @author      Pawel Byszewski <pawel.byszewski@sote.pl>
 */
class stBlogMetaTagsGenerator extends stMetaTagsGenerator
{
    /**
     * Generowanie meta tagów
     *
     * @param Blog $blog
     */
    public function generate($blog)
    {
        if (is_object($blog))
        {
            $blog->setCulture($this->culture);

            if ($this->positioning->getTitleBlog())
            {
                $this->title = str_replace("{NAME}", $blog->getName(), $this->positioning->getTitleBlog());
            }else{
                $this->title = $blog->getName();
            }
            
            $this->keywords = $blog->getName();
            
            if ($blog->getLongDescription())
            {
                $this->description = mb_substr(strip_tags($blog->getLongDescription()),0,170,'UTF-8');
            }elseif($blog->getShortDescription()){
                $this->description = $blog->getShortDescription();
            }else{
                $this->description = "";
            }
           
        }
    }
}