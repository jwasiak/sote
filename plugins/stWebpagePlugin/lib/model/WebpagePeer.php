<?php
/** 
 * SOTESHOP/stWebpagePlugin
 *
 * Ten plik należy do aplikacji stWebpagePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stWebpagePlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: WebpagePeer.php 16781 2012-01-19 08:48:13Z michal $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/** 
 * Klasa WebpagePeer
 *
 * @package     stWebpagePlugin
 * @subpackage  libs
 */
class WebpagePeer extends BaseWebpagePeer
{
    protected static $urlPool = array();

    public static function retrieveByUrl($url)
    {
        if (!isset(self::$urlPool[$url]) && !array_key_exists($url, self::$urlPool))
        {
            $c = new Criteria();
            $c->addSelectColumn(WebpageI18nPeer::ID);
            $c->add(WebpageI18nPeer::URL, $url);
            $c->setLimit(1);
            $rs = WebpageI18nPeer::doSelectRS($c);

            if ($rs->next())
            {  
                $row = $rs->getRow();
                $c = new Criteria();
                $c->add(self::ID, $row[0]);
                $c->setLimit(1);
                $tmp = self::doSelectWithI18n($c);     
                self::$urlPool[$url] = $tmp ? $tmp[0] : null;  
            }
        }

        return self::$urlPool[$url];
    } 
	
    /**
     * Przeciążenie metody pobierającej strony www w odpowiedniej wersji jezykowej
     *
     * @param Criteria $c Kryteria
     * @param mixed $culture Wersja językowa
     * @param CreoleConnection $con Połączenie z bazą danych
     * @return array Produkty
     */
    public static function doSelectWithI18n(Criteria $c, $culture = null, $con = null)
    {
        if ($culture === null)
        {
            $culture = stLanguage::getHydrateCulture();
        }

        return parent::doSelectWithI18n($c, $culture, $con);
    }


    public static function doCountWithI18n(Criteria $c, $con = null)
    {
        $c = clone $c;
        
        $c->addJoin(WebpageI18nPeer::ID, WebpagePeer::ID);

        $c->add(WebpageI18nPeer::CULTURE, stLanguage::getHydrateCulture());

        return self::doCount($c, $con);
    }

    public static function retrieveByState($state)
    {
        $c = new Criteria();
        $c->add(self::STATE, $state);
        return self::doSelectOne($c);        
    }

    public static function getPrivacyWebpage()
    {
        return self::retrieveByState("PRIVACY");
    }

    public static function getTermsWebpage()
    {
        return self::retrieveByState("TERMS");
    }

    public static function getShippingWebpage()
    {
        return self::retrieveByState("SHIPPING");
    }

    public static function getRight2CancelWebpage()
    {
    	return self::retrieveByState("RIGHT2CANCEL");
    }
    
    public static function getContactWebpage()
    {
        return self::retrieveByState("CONTACT");
    } 
    
    public static function getAppTermsWebpage()
    {
        return self::retrieveByState("APP_TERMS");
    } 
    
    public static function getAppPrivacyWebpage()
    {
        return self::retrieveByState("APP_PRIVACY");
    }
    
    public static function getAppRight2cancelWebpage()
    {
        return self::retrieveByState("APP_RIGHT2CANCEL");
    }  

    public static function clearCache()
    {
        if (sfContext::hasInstance())
        {
            stPartialCache::clear('stWebpageFrontend', '_footerWebpage', array('app' => 'frontend'));
            stPartialCache::clear('stWebpageFrontend', '_headerWebpage', array('app' => 'frontend'));
        }
    }

}
