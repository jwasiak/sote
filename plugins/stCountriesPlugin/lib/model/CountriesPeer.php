<?php

/**
 * SOTESHOP/stCountriesPlugin
 *
 * Ten plik należy do aplikacji stCountriesPlugin opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stCountriesPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: CountriesPeer.php 10420 2011-01-21 13:20:27Z michal $
 * @author      Marcin Olejniczak <marcin.olejniczak@sote.pl>
 */

/**
 * Klasa CountriesPeer
 *
 * @package     stCountriesPlugin
 * @subpackage  libs
 */
class CountriesPeer extends BaseCountriesPeer
{
	protected static $countriesCached = array();
	/**
	 *
	 * Zwraca listę aktywnych krajów
	 *
	 * @param Criteria $c Kryteria
	 * @param CreoleConnection $con Połączenie propel
	 * @return array Of Countries
	 */
	public static function doSelectActive(Criteria $c, $con = null)
	{
		$criteria = clone $c;

		$culture = sfContext::getInstance()->getUser()->getCulture();

		$criteria->addAscendingOrderByColumn(sprintf('IFNULL(%s, %s)', CountriesI18nPeer::NAME, CountriesPeer::OPT_NAME));

		$criteria->add(CountriesPeer::IS_ACTIVE, true);

		return self::doSelectWithI18n($criteria, $culture, $con);
	}

	public static function doSelectActiveCached($type = 'objects')
	{
		$culture = sfContext::getInstance()->getUser()->getCulture();

		if (!isset(self::$countriesCached[$culture]))
		{
			$fc = stFunctionCache::getInstance('stCountriesPlugin');
			self::$countriesCached[$culture] = $fc->cacheCall(array('CountriesPeer', 'doSelectActiveHelper'), array($culture));
		}

		return $type ? self::$countriesCached[$culture][$type] : self::$countriesCached[$culture];
	}

	public static function retrieveByIsoA2($iso)
	{
		$cache = self::doSelectActiveCached(null);
		return isset($cache['iso_a2'][$iso]) ? $cache['objects'][$cache['iso_a2'][$iso]] : null;
	}

	public static function retrieveByOptName($name)
	{
		$c = new Criteria();
		$c->add(self::OPT_NAME, $name);
		return self::doSelectOne($c);
	}

	public static function retrieveByIsoA3($iso)
	{
		$cache = self::doSelectActiveCached(null);
		return isset($cache['iso_a3'][$iso]) ? $cache['objects'][$cache['iso_a3'][$iso]] : null;
	}

	public static function retrieveById($id)
	{
		$cache = self::doSelectActiveCached(null);
		return isset($cache['id'][$id]) ? $cache['objects'][$cache['id'][$id]] : null;
	}

	public static function doSelectActiveHelper()
	{
		$result = array('objects' => array(), 'iso_a2' => array(), 'id' => array());

		foreach (self::doSelectActive(new Criteria()) as $index => $country)
		{
			$result['objects'][$index] = $country;
			$result['iso_a2'][$country->getIsoA2()] = $index;
			$result['iso_a3'][$country->getIsoA3()] = $index;
			$result['id'][$country->getId()] = $index; 
		}

		return $result;
	}

	public static function doSelectDefault(Criteria $c, $con = null)
	{
		$criteria = clone $c;

		$criteria->add(self::IS_DEFAULT, true);

		return self::doSelectOne($criteria, $con);
	}

	/**
	 *
	 * Zwraca listę aktywnych krajów
	 *
	 * @param Criteria $c Kryteria
	 * @param CreoleConnection $con Połączenie propel
	 * @return array Of Countries
	 */
	public static function doSelectActiveBackend(Criteria $c, $con = null)
	{
		$criteria = clone $c;

		$criteria->add(CountriesPeer::IS_ACTIVE, true);

		$criteria->addAscendingOrderByColumn(self::OPT_NAME . ' COLLATE utf8_unicode_ci');

		return self::doSelect($criteria, $con);
	}

	public static function doCountActive(Criteria $c, $con = null)
	{
		$criteria = clone $c;

		$criteria->add(CountriesPeer::IS_ACTIVE, true);

		return self::doCount($criteria, false, $con);
	}

	/**
	 * Przeciążenie metody pobierającej kraje w odpowiedniej wersji jezykowej
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
		$c->addJoin(CountriesI18nPeer::ID, CountriesPeer::ID);

		$c->add(CountriesI18nPeer::CULTURE, stLanguage::getHydrateCulture());

		return self::doCount($c, $con);
	}
}