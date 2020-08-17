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
 * @version     $Id: stMetaTagsGenerator.class.php 1611 2009-10-19 09:49:03Z piotr $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stMetaTagsGenerator
 *
 * @package     stPositioningPlugin
 * @subpackage  libs
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */
class stMetaTagsGenerator
{
    /**
     * Tytuł strony
     *
     * @var string
     */
    protected $title = '';

    /**
     * Słowa kluczowe strony
     *
     * @var string
     */
    protected $keywords = '';

    /**
     * Opis strony
     *
     * @var string
     */
    protected $description = '';

    protected $positioning = null;

    /**
     * Konstruktor
     */
    public function __construct()
    {
        $positioning = PositioningPeer::doSelectDefaultValues();

        $this->setCulture(SF_APP == "backend" ? sfContext::getInstance()->getRequest()->getParameter('culture', stLanguage::getOptLanguage()) : stLanguage::getHydrateCulture());

        if (is_object($positioning))
        {
         
            $positioning->setCulture($this->culture);
            $this->title = $positioning->getTitle();
            $this->keywords = $positioning->getKeywords();
            $this->description = $positioning->getDescription();
            $this->positioning = $positioning;
        }

    }

    public function setCulture($culture)
    {
        $this->culture = $culture;
    }
    
    /**
     * Pobieranie title, keywords, description
     *
     * @param string $method
     * @param array $args
     * @return string|bool
     */
    public function __call($method, $args = array())
    {
        $method = substr($method, 3);
        $method = lcfirst($method);
        if (isset($this->$method)) return $this->$method;
        return false;
    }
}
