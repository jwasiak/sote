<?php
/**
 * SOTESHOP/stPriceCompare
 *
 * Ten plik należy do aplikacji stPriceCompare opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPriceCompare
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stPriceCompareProductParser.class.php 10928 2011-02-09 12:10:58Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stPriceCompareProductParser
 *
 * @package    stPriceCompare
 * @subpackage libs
 */
class stPriceCompareProductParser
{
    /**
     * Obiekt produktu
     *
     * @var Product
     */
    protected $product = null;

    /**
     * Obiekt sfContext
     *
     * @var sfContext
     */
    protected $context = null;

    /**
     * Konstruktor
     *
     * @param Product $product obiekt produktu
     */
    public function __construct($product)
    {
        $this->product = $product;
        $this->product->setCulture('pl_PL');
        $this->context = sfContext::getInstance();
        $this->config = stConfig::getInstance('stPriceCompare');
    }

    /**
     * Sprawdzanie produktu
     *
     * @return bool
     */
    public function checkProduct()
    {
        if (!is_object($this->product)) return false;
        if (!is_object($this->product->getDefaultCategory())) return false;
        if ($this->product->getPointsOnly()) return false;
        if ($this->product->getPriceBrutto() <= 0) return false;
        return true;
    }

    /**
     * Metoda __call:
     *  - zwraca nie zmodyfikowane wartości z produktu
     *  - dodaje wywyłanie has np. $obj->hasName() 
     *
     * @param string $method nazwa wywoływanej metody 
     * @param array $args argumenty wywoływanej metody
     * @return bool
     */
    public function __call($method, $args = array())
    {
        if (!$this->checkProduct()) return false;
        if (method_exists($this->product, $method))
        {
            if (empty($args))
            {
                return $this->product->$method();
            } else {
                return $this->product->$method($args);
            }
        } else {
            if (strpos($method, 'has') === 0)
            {
                $getMethod = str_replace('has', 'get', $method);

                if (empty($args))
                {
                    $value = $this->product->$getMethod();
                } else {
                    $value = $this->product->$getMethod($args);
                }

                if (empty($value)) return false;
                return true;
            }
        }
    }

    /**
     * Pobieranie nazwy
     *
     * @return string
     */
    public function getName()
    {
        $name = $this->product->getName();

        $event = new sfEvent($this, 'stPriceComparePlugin.changeName', array());
        stEventDispatcher::getInstance()->notify($event);
        $changedName = $event->getReturnValue();

        if ($changedName != null) $name = $changedName;
        return $name;
    }

    /**
     * Pobieranie ceny
     *
     * @param int $decimals ilośc liczb po przecinku
     * @param string $decimalsPoint separator
     * @param string $thousandsSeparator separator tysiąca
     * @return string
     */
    public function getPrice($decimalsPoint = '.', $decimals = 2, $thousandsSeparator = '') {

        $price = $this->product->getPriceBrutto();

        $discount = DiscountPeer::doSelectOneByProductAndUser($this->product, null);
        if (is_object($discount))
            $price = stDiscount::apply($price, array(array('value' => $discount->getValue(), 'type' => $discount->getPriceType())), $this->product->getMaxDiscount());

        $event = new sfEvent($this, 'stPriceComparePlugin.changePrice', array());
        stEventDispatcher::getInstance()->notify($event);
        $changedPrice = $event->getReturnValue();
        if ($changedPrice != null) $price = $changedPrice;
            
        return number_format($price, $decimals, $decimalsPoint, $thousandsSeparator);
    }

    /**
     * Pobieranie adresu www
     *
     * @return string
     */
    public function getUrl()
    {
        
        if(stConfig::getInstance('stSecurityBackend')->get('ssl')=="shop"){
            $http_https = "https"; 
        } else {
            $http_https = "http";
        }
        
        return $http_https.'://'.$this->context->getRequest()->getHost().'/'.$this->product->getFriendlyUrl().'.html';
    }

    /**
     * Pobieranie ścieżki kategorii
     *
     * @param string $separator separator kategorii
     * @return string
     */
    public function getCategory($separator = '/', $htmlspecialchars = false) {
        $c = array();
        foreach ($this->product->getDefaultCategory()->getPath() as $categoryPath)
            $c[] = $categoryPath->getName();
        $c[] = $this->product->getDefaultCategory()->getName();

        if ($htmlspecialchars)
            foreach ($c as $k => $v)
                $c[$k] = htmlspecialchars($v);

        if ($this->config->get('category_root'))
            unset($c[0]);

        return implode($separator, $c);
    }

    /**
     * Pobieranie nazwy głównej kategorii
     *
     * @return string
     */
    public function getCategoryName()
    {
        return $this->product->getDefaultCategory()->getName();
    }

    /**
     * Pobieranie id głównej kategorii
     *
     * @return string
     */
    public function getCategoryId()
    {
        return $this->product->getDefaultCategory()->getId();
    }

    /**
     * Pobieranie adresu zdjęcia 
     *
     * @return string
     */
    public function getPhoto($showBlank = true)
    {
        return htmlspecialchars(st_product_image_path($this->product, 'full', $showBlank, false, true));
    }

    /**
     * Pobieranie producenta
     *
     * @return string
     */
    public function getProducer($htmlspecialchars = false)
    {
        if (!is_object($this->product->getProducer())) return false;
        if ($htmlspecialchars == true) return htmlspecialchars($this->product->getProducer()->getName());
        return $this->product->getProducer()->getName();
    }

    /**
     * Pobieranie opisu
     *
     * @param bool $stripTags czy ma wyrzucać tagi
     * @param string $stripTagsArray lista tagów do pozostawienia
     * @param bool $replaceEntity czy ma zamieniać znaki encji
     * @return string
     */
    public function getDescription($stripTags = false, $stripTagsArray = '', $replaceEntity = false)
    {
        $description = $this->product->getDescription();

        $event = new sfEvent($this, 'stPriceComparePlugin.changeDescription', array());
        stEventDispatcher::getInstance()->notify($event);
        $changedDescription = $event->getReturnValue();
        
        if ($changedDescription != null) $description = $changedDescription;

        if (!empty($description))
        {
            $description = preg_replace('/<script(.*)<\\/script>/sU', '', $description);
                
            if ($stripTags == true) $description = strip_tags($description, $stripTagsArray);

            if ($replaceEntity == true)
            {
                $search = array('&nbsp;', '&oacute;');
                $replace = array(' ', 'ó');
                $description = str_replace($search, $replace, $description);
            }
        }

        return $description;
    }

    /**
     * Pobieranie statusu dostępności
     *
     * @param object $priceCompareObject
     * @param int $default
     * @return int
     */
    public function getPriceCompareAvailability($priceCompareObject, $default = 0)
    {
        $availability = $this->product->getFrontendAvailability();
        

        if (is_null($availability))
        {
            return $default;
        } else {
            if (is_null($priceCompareObject->getConfig('availability_'.$availability->getId()))) return $default;
            return $priceCompareObject->getConfig('availability_'.$availability->getId());
        }
    }
    
    /**
     * Pobieranie obiektu Product
     * @return Product
     */
    public function getProduct() {
        return $this->product;
    }
}
