<?php
/**
 * SOTESHOP/stTextPlugin 
 * 
 * Ten plik należy do aplikacji stTextPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stTextPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: Text.php 617 2009-04-09 13:02:31Z michal $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/**
 * Klasa Text
 *
 * @package     stTextPlugin
 * @subpackage  libs
 */
class Text extends BaseText
{
    /**
     * Pobieranie wartości `keyword`
     *
     * @return  string      wartość `keyword`  
     */
    public function __toString()
    {
        return $this->getKeyword();
    }

    /**
     * Pobiera zawartość przyciętą do określonej długości.
     * Funkcja nie dzieli słów.
     *
     * @param   integer     $length             Ilość znaków  
     * @return  string      Przycięty tekst  
     */
    public function getContentTrimed($length = 50)
    {
        $content = $this->getContent();
        $content = strip_tags($content);
        $contentLength = strlen($content);

        //sprawdzenie czy istnieje potrzeba przyciecia
        if($contentLength <= $length)
        {
            return strip_tags($this->getContent());
        }

        $content = trim(wordwrap($content, $length, "\n"));
        $table = explode("\n", $content);

        if(count($table) > 0)
        {
            return $table[0]."...";
        }
        return "";
    }
    
    /**
     * Przeciążenie hydrate
     *
     * @param ResultSet $rs
     * @param int $startcol
     * @return object
     */
    public function hydrate(ResultSet $rs, $startcol = 1)
    {
        $this->setCulture(stLanguage::getHydrateCulture());
        return parent::hydrate($rs, $startcol);
    }

    /**
     * Przeciążenie getName
     *
     * @return string
     */
    public function getName()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            return stLanguage::getDefaultValue($this, __METHOD__);   
        }   
        $v = parent::getName();
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $v;
    }
    
    /**
     * Przeciążenie setName
     * 
     * @param string $v
     */
    public function setName($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            stLanguage::setDefaultValue($this, __METHOD__, $v);
        }
        
        parent::setName($v);
    }
    
    /**
     * Przeciążenie getContent
     *
     * @return string
     */
    public function getContent()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            return stLanguage::getDefaultValue($this, __METHOD__);   
        }   
        $v = parent::getContent();
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $v;
    }
    
    /**
     * Przeciążenie setContent
     * 
     * @param string $v
     */
    public function setContent($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            stLanguage::setDefaultValue($this, __METHOD__, $v);
        }
        
        parent::setContent($v);
    }

    public function getIsSystemDefault()
    {
        return true;
    }

    public function save($con = null)
    {
        $result = parent::save($con);
        stPartialCache::clear('stFrontendMain', '_mainText', array('app' => 'frontend'));
        stFastCacheManager::clearCache();
        return $result;
    }
}